<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Commande;
use App\Models\Contact;
use App\Models\Devi;
use App\Models\Evenement;
use App\Models\Prestation;
use App\Models\Depense;
use App\Models\Tva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
        $type = $request->get('type', 'client');
        $commandeId = $request->get('commande_id');
        $commande = null;
        $prochain_numero = Facture::getProchainNumeroFactureClient(); 
   

        if ($commandeId) {
            $commande = Commande::findOrFail(Crypt::decrypt($commandeId));
        }
        
        $clients = Contact::where('archive', false)->get();
        $fournisseurs = Contact::where('archive', false)->get();
        $commandes = Commande::where('archive', false)
            ->whereDoesntHave('factures')
            ->get();
        $tvas = Tva::where('archive', false)->get();
        
            
        return view('facture.add', compact('type', 'commande', 'clients', 'fournisseurs', 'commandes', 'prochain_numero', 'tvas'));
    }

    /**
     * Créer une facture depuis une commande
     */
    public function createFromCommande($commandeId)
    {
        $commande = Commande::findOrFail(Crypt::decrypt($commandeId));
        
        // Préremplir les données de la facture
        $facture = new Facture();
        $facture->numero = $facture->genererNumero();
        $facture->date = now();
        $facture->type = 'client';
        $facture->client_id = $commande->client_id;
        $facture->commande_id = $commande->id;
        $facture->montant_ht = $commande->montant_ht;
        $facture->montant_tva = $commande->montant_tva;
        $facture->montant_ttc = $commande->montant_ttc;
        $facture->net_a_payer = $commande->montant_ttc;
        $facture->montant_restant_a_payer = $commande->montant_ttc;
        $facture->palier = $commande->palier;
        $facture->description = "Facture pour la commande N°" . $commande->numero_commande;
        $facture->user_id = Auth::id();
        $facture->calculerMontants();
        $facture->save();
        
        return redirect()->route('facture.show', Crypt::encrypt($facture->id))
            ->with('success', 'Facture créée avec succès');
    }

    /**
     * Créer une facture multiple depuis plusieurs commandes
     */
    public function createMultiple(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:contacts,id',
            'commandes' => 'required|array|min:1',
            'commandes.*' => 'exists:commandes,id'
        ]);
        
        $commandes = Commande::whereIn('id', $request->commandes)->get();
        $totalHT = $commandes->sum('montant_ht');
        $totalTVA = $commandes->sum('montant_tva');
        $totalTTC = $commandes->sum('montant_ttc');
        
        $facture = new Facture();
        $facture->numero = $facture->genererNumero();
        $facture->date = now();
        $facture->type = 'client';
        $facture->client_id = $request->client_id;
        $facture->montant_ht = $totalHT;
        $facture->montant_tva = $totalTVA;
        $facture->montant_ttc = $totalTTC;
        $facture->net_a_payer = $totalTTC;
        $facture->montant_restant_a_payer = $totalTTC;
        
        // Créer les lignes de la facture multiple
        $lignes = [];
        foreach ($commandes as $commande) {
            $lignes[] = [
                'commande_id' => $commande->id,
                'numero' => $commande->numero_commande,
                'montant' => $commande->montant_ttc,
                'description' => "Commande N°" . $commande->numero_commande
            ];
        }
        
        $facture->palier = $lignes;
        $facture->commandes_liees = collect($commandes)->map(function($commande) {
            return ['commande_id' => $commande->id, 'montant' => $commande->montant_ttc];
        })->toArray();
        $facture->description = "Facture multiple pour " . count($commandes) . " commande(s)";
        $facture->user_id = Auth::id();
        $facture->calculerMontants();
        $facture->save();
        
        return redirect()->route('facture.show', Crypt::encrypt($facture->id))
            ->with('success', 'Facture multiple créée avec succès');
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
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $facture = Facture::findOrFail(Crypt::decrypt($id));
        $clients = Contact::where('archive', false)->get();
        $fournisseurs = Contact::where('archive', false)->get();
        
        return view('facture.edit', compact('facture', 'clients', 'fournisseurs'));
    }

    /**
     * Mettre à jour une facture
     */
    public function update(Request $request, $id)
    {
        $facture = Facture::findOrFail(Crypt::decrypt($id));
        
        $request->validate([
            'date' => 'required|date',
            'montant_ht' => 'required|numeric|min:0',
            'montant_tva' => 'required|numeric|min:0',
            'montant_ttc' => 'required|numeric|min:0',
        ]);
        
        $facture->date = $request->date;
        $facture->montant_ht = $request->montant_ht;
        $facture->montant_tva = $request->montant_tva;
        $facture->montant_ttc = $request->montant_ttc;
        $facture->description = $request->description;
        $facture->notes = $request->notes;
        
        if ($facture->type === 'client' && $request->client_id) {
            $facture->client_id = $request->client_id;
        } elseif ($facture->type === 'fournisseur' && $request->fournisseur_id) {
            $facture->fournisseur_id = $request->fournisseur_id;
            $facture->numero_origine = $request->numero_origine;
        }
        
        $facture->calculerMontants();
        $facture->save();
        
        return redirect()->route('facture.show', Crypt::encrypt($facture->id))
            ->with('success', 'Facture mise à jour avec succès');
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
     * Générer le PDF d'une facture
     */
    public function generatePDF($id)
    {
        $facture = Facture::findOrFail(Crypt::decrypt($id));
        
        // Ici tu peux utiliser une librairie comme DomPDF ou Snappy
        // pour générer le PDF de la facture
        
        return response()->json(['success' => true, 'message' => 'PDF généré']);
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
