<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Commande;
use App\Models\Contact;
use App\Models\Tva;
use App\Models\Societe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class FactureController extends Controller
{
    /**
     * Afficher la liste des factures
     */
    public function index()
    {
        return view('facture.index');
    }

    /**
     * Afficher les factures archivées
     */
    public function archives()
    {
        return view('facture.archives');
    }

    /**
     * Afficher le formulaire de création de facture
     */
    public function create(Request $request)
    {
        // Nettoyer les données de prévisualisation expirées
        $this->cleanExpiredPreviewData();
        
        $type = $request->get('type', 'client');
        $commande = null;
        
        // Vérifier s'il y a des données de prévisualisation à restaurer
        $restoredData = null;
        if ($request->has('restore_preview')) {
            $restoredData = $this->getRestoredPreviewData();
        }
        
        if ($request->has('commande_id')) {
            $commande = Commande::find(Crypt::decrypt($request->commande_id));
        }

        $tvas = Tva::all();
        $prochain_numero = Facture::getProchainNumeroFactureClient();

        return view('facture.add', compact(
            'type', 
            'commande', 
            'tvas', 
            'prochain_numero',
            'restoredData'
        ));
    }

    /**
     * Récupérer les données de prévisualisation à restaurer
     */
    private function getRestoredPreviewData()
    {
        $previewId = session('current_preview_id');
        if (!$previewId) {
            return null;
        }

        $previewData = session('facture_preview_data');
        if (!$previewData) {
            return null;
        }

        // Nettoyer les données de session après restauration
        session()->forget(['current_preview_id', 'facture_preview_data', 'facture_preview_pdf']);
        
        return $previewData;
    }

    /**
     * Nettoyer les données de prévisualisation expirées
     */
    private function cleanExpiredPreviewData()
    {
        $previewData = session('facture_preview_data');
        if ($previewData) {
            // Vérifier si les données ont plus de 30 minutes
            $createdAt = session('facture_preview_created_at');
            if ($createdAt && (time() - $createdAt) > 1800) { // 30 minutes
                session()->forget(['facture_preview_data', 'facture_preview_pdf', 'current_preview_id', 'facture_preview_created_at']);
            }
        }
    }


    /**
     * Enregistrer une nouvelle facture
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:client,fournisseur,directe',
            'date' => 'required|date',
            'montant_ht' => 'required|numeric|min:0',
            'montant_ttc' => 'required|numeric|min:0',
        ]);
        
        $facture = new Facture();
        $facture->numero = $request->numero ?? Facture::getProchainNumeroFactureClient();
        $facture->date = $request->date;
        $facture->type = $request->type;
        $facture->statut = 'brouillon';
        $facture->statut_paiement = 'attente paiement';
        
        // Remplir selon le type
        if ($request->type === 'client') {
            $request->validate(['client_id' => 'required|exists:contacts,id']);
            $facture->client_id = $request->client_id;
        } elseif ($request->type === 'fournisseur') {
            $request->validate(['fournisseur_id' => 'required|exists:contacts,id']);
            $facture->fournisseur_id = $request->fournisseur_id;
            $facture->numero_origine = $request->numero_origine;
        }
        
        $facture->montant_ht = $request->montant_ht;
        
        // Gestion de la TVA
        if ($request->has('soumis_tva') && $request->soumis_tva) {
            $facture->montant_tva = $request->montant_tva ?? 0;
            if ($request->tva_id) {
                $tva = Tva::find($request->tva_id);
                if ($tva) {
                    $facture->montant_tva = $request->montant_ht * ($tva->taux / 100);
                }
            }
        } else {
            $facture->montant_tva = 0;
        }
        
        $facture->montant_ttc = $request->montant_ttc;
        $facture->net_a_payer = $request->montant_ttc;
        $facture->montant_restant_a_payer = $request->montant_ttc;
        $facture->description = $request->description;
        $facture->notes = $request->notes;
        $facture->user_id = Auth::id();
        
        // Gérer les fichiers pour les factures fournisseurs
        if ($request->type === 'fournisseur' && $request->hasFile('fichier')) {
            $path = $request->file('fichier')->store('factures-fournisseurs', 'public');
            $facture->url_image = $path;
        }
        
        $facture->calculerMontants();
        $facture->save();
        
        return redirect()->route('facture.show', Crypt::encrypt($facture->id))
            ->with('success', 'Facture créée avec succès');
    }

    /**
     * Afficher une facture
     */
    public function show($id)
    {
        $facture = Facture::findOrFail(Crypt::decrypt($id));
        return view('facture.show', compact('facture'));
    }


    /**
     * Archiver une facture
     */
    public function archive($id)
    {
        $facture = Facture::findOrFail(Crypt::decrypt($id));
        $facture->delete();
        
        return response()->json(['success' => true]);
    }

    /**
     * Restaurer une facture archivée
     */
    public function restore($id)
    {
        $facture = Facture::withTrashed()->findOrFail(Crypt::decrypt($id));
        $facture->restore();
        
        return redirect()->route('facture.index')
            ->with('success', 'Facture restaurée avec succès');
    }

    /**
     * Supprimer définitivement une facture
     */
    public function destroy($id)
    {
        $facture = Facture::withTrashed()->findOrFail(Crypt::decrypt($id));
        
        // Supprimer le fichier associé s'il existe
        if ($facture->url_image) {
            Storage::disk('public')->delete($facture->url_image);
        }
        
        $facture->forceDelete();
        
        return redirect()->route('facture.archives')
            ->with('success', 'Facture supprimée définitivement');
    }

    /**
     * Marquer une facture comme payée
     */
    public function marquerPayee(Request $request, $id)
    {
        $facture = Facture::findOrFail(Crypt::decrypt($id));
        
        $request->validate([
            'montant' => 'required|numeric|min:0',
            'mode_paiement' => 'required|string',
            'date_paiement' => 'required|date'
        ]);
        
        $paiement = [
            'date' => $request->date_paiement,
            'montant' => $request->montant,
            'mode' => $request->mode_paiement
        ];
        
        $paiements = $facture->paiements;
        $paiements[] = $paiement;
        $facture->paiements = $paiements;
        
        // Mettre à jour le statut de paiement
        $montantPaye = $facture->montantPaye();
        if ($montantPaye >= $facture->net_a_payer) {
            $facture->statut_paiement = 'payee';
        } else {
            $facture->statut_paiement = 'partiellement_payee';
        }
        
        $facture->calculerMontants();
        $facture->save();
        
        return redirect()->route('facture.show', Crypt::encrypt($facture->id))
            ->with('success', 'Paiement enregistré avec succès');
    }

    /**
     * Générer un PDF de prévisualisation
     */
    public function previewPDF(Request $request)
    {
        try {
            // Variable pour indiquer que c'est une prévisualisation
            $preview = true;
            
            // Créer une facture temporaire pour la prévisualisation
            $facture = new Facture();
            $facture->numero = $request->get('numero', Facture::getProchainNumeroFactureClient());
            $facture->date = $request->get('date');
            $facture->type = $request->get('type');
            $facture->statut = 'brouillon';
            $facture->statut_paiement = 'attente paiement';
            
            // Remplir selon le type
            if ($request->get('type') === 'client') {
                $facture->client_id = $request->get('client_id');
                $client = Contact::find($request->get('client_id'));
                if ($client) {
                    $facture->setRelation('client', $client);
                }
            } elseif ($request->get('type') === 'fournisseur') {
                $facture->fournisseur_id = $request->get('fournisseur_id');
                $facture->numero_origine = $request->get('numero_origine');
                $fournisseur = Contact::find($request->get('fournisseur_id'));
                if ($fournisseur) {
                    $facture->setRelation('fournisseur', $fournisseur);
                }
            }
            
            $facture->montant_ht = $request->get('montant_ht', 0);
            
            // Gestion de la TVA
            if ($request->get('soumis_tva')) {
                $facture->montant_tva = $request->get('montant_tva', 0);
                if ($request->get('tva_id')) {
                    $tva = Tva::find($request->get('tva_id'));
                    if ($tva) {
                        $facture->montant_tva = $request->get('montant_ht', 0) * ($tva->taux / 100);
                    }
                }
            } else {
                $facture->montant_tva = 0;
            }
            
            $facture->montant_ttc = $request->get('montant_ttc', 0);
            $facture->net_a_payer = $request->get('montant_ttc', 0);
            $facture->montant_restant_a_payer = $request->get('montant_ttc', 0);
            $facture->description = $request->get('description', '');
            $facture->notes = $request->get('notes', '');
            $facture->user_id = Auth::id();
            
            $facture->calculerMontants();
            $societePrincipale = Societe::where('est_societe_principale', true)->first();
            // Gestion des factures multiples
            $previewType = $request->get('preview_type', 'simple');
            if ($previewType === 'multiple') {
                $commandesIds = json_decode($request->get('commandes', '[]'), true);
                $commandes = Commande::whereIn('id', $commandesIds)->get();
                
                // Calculer les totaux des commandes
                $totalHT = $commandes->sum('montant_ht');
                $totalTVA = $commandes->sum('montant_tva');
                $totalTTC = $commandes->sum('montant_ttc');
                
                $facture->montant_ht = $totalHT;
                $facture->montant_tva = $totalTVA;
                $facture->montant_ttc = $totalTTC;
                $facture->net_a_payer = $totalTTC;
                $facture->montant_restant_a_payer = $totalTTC;
                $facture->description = "Facture multiple pour " . count($commandes) . " commande(s)";
                
                // Sauvegarder les commandes en session pour la prévisualisation
                session(['facture_preview_commandes' => $commandes]);
                
                // Générer le PDF avec le template multiple
                $pdf = PDF::loadView('facture.pdf_multiple', compact('facture', 'commandes', 'preview', 'societePrincipale'));
            } else {
                // Générer le PDF avec le template simple
                $pdf = PDF::loadView('facture.pdf', compact('facture', 'preview', 'societePrincipale'));
            }
            
            $pdf->setPaper('a4');
            
            // Sauvegarder temporairement le PDF
            $tempPath = 'temp/factures/preview-' . time() . '.pdf';
            Storage::disk('public')->put($tempPath, $pdf->output());
            
            // Sauvegarder les données en session pour la prévisualisation
            session([
                'facture_preview_data' => $request->all(),
                'facture_preview_pdf' => $tempPath,
                'facture_preview_created_at' => time()
            ]);
            
            return response()->json([
                'success' => true,
                'preview_url' => route('facture.preview.show'),
                'pdf_url' => asset('storage/' . $tempPath)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération du PDF : ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Afficher la page de prévisualisation
     */
    public function showPreview()
    {
        if (!session('facture_preview_data')) {
            return redirect()->route('facture.create')->with('error', 'Aucune prévisualisation disponible');
        }

        $previewData = session('facture_preview_data');
        $pdfUrl = asset('storage/' . session('facture_preview_pdf'));
        
        // Générer un identifiant unique pour cette prévisualisation
        $previewId = uniqid('preview_');
        session(['current_preview_id' => $previewId]);
        // $facture = Facture::find(14);
        // return view('facture.pdf', compact('facture',  'previewData'));
        $societePrincipale = Societe::where('est_societe_principale', true)->first();
        return view('facture.preview', compact('previewData', 'pdfUrl', 'previewId'));
    }

    /**
     * Valider et créer la facture depuis la prévisualisation
     */
    public function validatePreview(Request $request)
    {
        if (!session('facture_preview_data')) {
            return redirect()->route('facture.create')->with('error', 'Aucune prévisualisation disponible');
        }

        $previewData = session('facture_preview_data');
        $previewType = $previewData['preview_type'] ?? 'simple';
        
        if ($previewType === 'multiple') {
            return $this->createMultipleFromPreview($previewData);
        } else {
            return $this->createSimpleFromPreview($previewData);
        }
    }

    /**
     * Créer une facture simple depuis la prévisualisation
     */
    private function createSimpleFromPreview($previewData)
    {
        // Créer la facture avec les données de prévisualisation
        $facture = new Facture();
        $facture->numero = $previewData['numero'] ?? Facture::getProchainNumeroFactureClient();
        $facture->date = $previewData['date'];
        $facture->type = $previewData['type'];
        $facture->statut = 'brouillon';
        $facture->statut_paiement = 'attente paiement';
        
        // Remplir selon le type
        if ($previewData['type'] === 'client') {
            $facture->client_id = $previewData['client_id'];
        } elseif ($previewData['type'] === 'fournisseur') {
            $facture->fournisseur_id = $previewData['fournisseur_id'];
            $facture->numero_origine = $previewData['numero_origine'] ?? null;
        }
        
        $facture->montant_ht = $previewData['montant_ht'];
        
        // Gestion de la TVA
        if (isset($previewData['soumis_tva']) && $previewData['soumis_tva']) {
            $facture->montant_tva = $previewData['montant_tva'] ?? 0;
            if (isset($previewData['tva_id']) && $previewData['tva_id']) {
                $tva = Tva::find($previewData['tva_id']);
                if ($tva) {
                    $facture->montant_tva = $previewData['montant_ht'] * ($tva->taux / 100);
                }
            }
        } else {
            $facture->montant_tva = 0;
        }
        
        $facture->montant_ttc = $previewData['montant_ttc'];
        $facture->net_a_payer = $previewData['montant_ttc'];
        $facture->montant_restant_a_payer = $previewData['montant_ttc'];
        $facture->description = $previewData['description'] ?? '';
        $facture->notes = $previewData['notes'] ?? '';
        $facture->user_id = Auth::id();
        
        $facture->calculerMontants();
        $facture->save();
        $societePrincipale = Societe::where('est_societe_principale', true)->first();

        // Régénérer le PDF final avec preview = false
        try {
            $pdf = PDF::loadView('facture.pdf', [
                'facture' => $facture,
                'preview' => false, // Facture validée
                'societePrincipale' => $societePrincipale
            ]);
            $pdf->setPaper('A4');
            
            $finalPdfPath = 'factures/facture-' . $facture->id . '.pdf';
            Storage::disk('public')->put($finalPdfPath, $pdf->output());
            $facture->url_pdf = $finalPdfPath;
            $facture->save();
        } catch (\Exception $e) {
            // En cas d'erreur, on continue sans le PDF
            Log::error('Erreur lors de la génération du PDF final : ' . $e->getMessage());
        }

        // Nettoyer la session
        session()->forget(['facture_preview_data', 'facture_preview_pdf', 'facture_preview_created_at']);

        return redirect()->route('facture.show', Crypt::encrypt($facture->id))
            ->with('success', 'Facture créée avec succès');
    }

    /**
     * Créer une facture multiple depuis la prévisualisation
     */
    private function createMultipleFromPreview($previewData)
    {

        $commandesIds = json_decode($previewData['commandes'], true);
        $commandes = Commande::whereIn('id', $commandesIds)->get();
        
        if ($commandes->isEmpty()) {
            return redirect()->route('facture.create')->with('error', 'Aucune commande trouvée');
        }

        // Créer la facture multiple
        $facture = new Facture();
        $facture->numero = Facture::getProchainNumeroFactureClient();
        $facture->date = $previewData['date'] ?? now();
        $facture->type = 'client';
        $facture->statut = 'brouillon';
        $facture->statut_paiement = 'attente paiement';
        $facture->client_id = $previewData['client_id'];
        
        // Calculer les totaux
        $totalHT = $commandes->sum('montant_ht');
        $totalTVA = $commandes->sum('montant_tva');
        $totalTTC = $commandes->sum('montant_ttc');
        
        $facture->montant_ht = $totalHT;
        $facture->montant_tva = $totalTVA;
        $facture->montant_ttc = $totalTTC;
        $facture->net_a_payer = $totalTTC;
        $facture->montant_restant_a_payer = $totalTTC;
        $facture->description = "Facture multiple pour " . count($commandes) . " commande(s)";
        $facture->user_id = Auth::id();
        
        $facture->calculerMontants();
        $facture->save();

        // Lier les commandes à la facture
        foreach ($commandes as $commande) {
            $commande->facture_id = $facture->id;
            $commande->save();
        }
        $societePrincipale = Societe::where('est_societe_principale', true)->first();
        // Régénérer le PDF final avec preview = false
        try {
            $pdf = PDF::loadView('facture.pdf_multiple', [
                'facture' => $facture,
                'commandes' => $commandes,
                'preview' => false, // Facture validée
                'societePrincipale' => $societePrincipale
            ]);
            $pdf->setPaper('A4');
            
            $finalPdfPath = 'factures/facture-' . $facture->id . '.pdf';
            Storage::disk('public')->put($finalPdfPath, $pdf->output());
            $facture->url_pdf = $finalPdfPath;
            $facture->save();
        } catch (\Exception $e) {
            // En cas d'erreur, on continue sans le PDF
            Log::error('Erreur lors de la génération du PDF final multiple : ' . $e->getMessage());
        }

        // Nettoyer la session
        session()->forget(['facture_preview_data', 'facture_preview_pdf', 'facture_preview_created_at', 'facture_preview_commandes']);

        return redirect()->route('facture.show', Crypt::encrypt($facture->id))
            ->with('success', 'Facture multiple créée avec succès');
    }

    /**
     * Générer le PDF d'une facture
     */
    public function generatePDF($id)
    {
        $facture = Facture::findOrFail(Crypt::decrypt($id));
        $societePrincipale = Societe::where('est_societe_principale', true)->first();
        try {
            // Déterminer le template à utiliser selon le type de facture
            if ($facture->type === 'multiple' || !empty($facture->palier)) {
                // Facture multiple
                $pdf = PDF::loadView('facture.pdf_multiple', [
                    'facture' => $facture,
                    'preview' => false, // Facture validée
                    'societePrincipale' => $societePrincipale
                ]);
            } else {
                // Facture simple
                $pdf = PDF::loadView('facture.pdf', [
                    'facture' => $facture,
                    'preview' => false, // Facture validée
                    'societePrincipale' => $societePrincipale
                ]);
            }
            
            $pdf->setPaper('A4');
            
            // Générer le nom du fichier
            $filename = 'facture-' . $facture->numero . '.pdf';
            
            // Sauvegarder le PDF
            $pdfPath = 'factures/' . $filename;
            Storage::disk('public')->put($pdfPath, $pdf->output());
            
            // Mettre à jour l'URL du PDF dans la base de données
            $facture->url_pdf = $pdfPath;
            $facture->save();
            
            return response()->json([
                'success' => true, 
                'message' => 'PDF généré avec succès',
                'pdf_url' => asset('storage/' . $pdfPath)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération du PDF : ' . $e->getMessage()
            ]);
        }
    }

    /**
     * API pour récupérer les commandes non facturées d'un client
     */
    public function getCommandesNonFacturees($clientId)
    {
        $commandes = Commande::where('client_prospect_id', $clientId)
            ->where('archive', false)
            ->whereDoesntHave('factures')
            ->get(['id', 'numero_commande', 'montant_ttc', 'date_commande']);
        
        return response()->json($commandes);
    }
}
