<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Contact;
use App\Models\Produit;
use App\Models\Tva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\Categorieproduit;
use App\Models\Voiture;
use App\Models\Circuit;
use App\Models\Devi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\EnvoyerCommande;
use Illuminate\Support\Facades\Mail;

class CommandeController extends Controller
{
    /**
     * Affichage des commandes
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Statistiques pour les widgets
        $now = now();
        $debut_mois = $now->startOfMonth();
        $fin_mois = $now->copy()->endOfMonth();
        
        // Commandes du mois
        $commandes_mois = Commande::whereBetween('date_commande', [$debut_mois, $fin_mois])
            ->where('archive', false)
            ->get();
            
        $commandes_mois_count = $commandes_mois->count();
        $commandes_mois_total = $commandes_mois->sum('montant_ttc');
        
        // Commandes en cours
        $commandes_en_cours = Commande::where('statut_commande', 'en_cours')
            ->where('archive', false)
            ->count();
            
        // Commandes non payées
        $commandes_non_payees = Commande::whereIn('statut_paiement', ['attente paiement', 'partiellement payée'])
            ->where('archive', false)
            ->get();
            
        $commandes_non_payees_count = $commandes_non_payees->count();
        $montant_non_paye = $commandes_non_payees->sum('net_a_payer');
        
        // Commandes archivées sur 12 mois
        $commandes_archivees = Commande::where('archive', true)
            ->where('date_commande', '>=', now()->subMonths(12))
            ->count();

        return view('commande.index', compact(
            'commandes_mois_count',
            'commandes_mois_total',
            'commandes_en_cours',
            'commandes_non_payees',
            'montant_non_paye',
            'commandes_archivees'
        ));
    }
    /**
     * Affichage des commandes archivées
     * @return \Illuminate\View\View
     */
    public function archives()
    {
        return view('commande.archives');
    }

    /**
     * Affichage du formulaire d'enregistrement d'une commande
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $clients = Contact::whereHas('typecontacts', function($query) {
            $query->whereIn('type', ['Client', 'Prospect']);
        })->where('archive', false)->get();
        
        $produits = Produit::where([['archive', false],['a_declinaison', 0]])->get();
        $tvas = Tva::where('archive', false)->get();
        
        $categories = Categorieproduit::where('archive', false)->get();
        $voitures = Voiture::where('archive', false)->get();
        $circuits = Circuit::where('archive', false)->get();

        $produits = Produit::where('archive', false)->get();
        $numero_commande = Commande::genererNumero();
        return view('commande.add', compact('clients', 'tvas', 'produits', 'numero_commande', 'categories', 'voitures', 'circuits'));
    }

    /**
     * Enregistrement d'une commande
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // dd($request->all());
            // Validation des données
            $request->validate([
                'numero_commande' => 'required|unique:commandes,numero_commande',
                'date_commande' => 'required|date',
                'mode_paiement' => 'required',
            ]);

            // Initialisation des totaux
            $montant_ht_total = 0;
            $montant_ttc_total = 0;
            $montant_tva_total = 0;
            $montant_remise_total = 0;

    
            $devi_id = $request->devi_id;
            // Création de la commande
            $commande = Commande::create([
                'numero_commande' => $request->numero_commande,
                'date_commande' => $request->date_commande,
                'client_prospect_id' => $request->client_prospect_id,
                'date_realisation_prevue' => $request->date_realisation_prevue,
                'mode_paiement' => $request->mode_paiement,
                'sans_tva' => $request->has('no_tva'),
                'type_remise' => $request->type_reduction_globale,
                'remise' => $request->reduction_globale,
                'statut_commande' => $request->statut,
                'statut_paiement' => $request->statut_paiement,
                'origine_commande' => $request->provenance,
                'numero_origine' => $request->numero_commande_provenance,
                'date_origine_commande' => $request->date_commande_provenance,
                'devi_id' => $devi_id
            ]);
           
            // Traitement des produits
            $i = 1;

            while($i <= 30) {
                if($request->{"produit$i"} != null) {
                    $quantite = $request->{"quantite$i"};
                    $prix_unitaire = $request->{"prix_ht$i"};
                    $taux_tva = TVA::where('id', $request->{"tva$i"})->first()->taux;
                    
                    // Calcul montant HT avant remise
                    $montant_ht = $quantite * $prix_unitaire;
                    
                    // Calcul remise produit si applicable
                    $remise = 0;
                    $taux_remise = 0;
                    if($request->{"type_reduction$i"} && $request->{"reduction$i"}) {
                        $taux_remise = $request->{"type_reduction$i"} === 'pourcentage' 
                            ? $request->{"reduction$i"} 
                            : ($request->{"reduction$i"} * 100 / $montant_ht);
                        $remise = $request->{"type_reduction$i"} === 'pourcentage'
                            ? $montant_ht * $request->{"reduction$i"} / 100
                            : $request->{"reduction$i"};
                    }

                    // Montant HT après remise
                    $montant_ht_final = $montant_ht - $remise;
                    
                    // Calcul TVA si applicable
                    $montant_tva = !$request->has('no_tva') ? $montant_ht_final * ($taux_tva / 100) : 0;
                    $montant_ttc = $montant_ht_final + $montant_tva;

                    $beneficiaire_id = $request->{"beneficiaire$i"} == null ? $request->client_prospect_id : $request->{"beneficiaire$i"};
                    // Ajout à la table pivot
                    $commande->produits()->attach($request->{"produit$i"}, [
                        'quantite' => $quantite,
                        'prix_unitaire' => $prix_unitaire,
                        'montant_ht' => $montant_ht_final,
                        'montant_ttc' => $montant_ttc,
                        'montant_tva' => $montant_tva,
                        'taux_tva' => $taux_tva,
                        'remise' => $remise,
                        'taux_remise' => $taux_remise,
                        'beneficiaire_id' => $beneficiaire_id
                    ]);

                    // Mise à jour des totaux
                    $montant_ht_total += $montant_ht_final;
                    $montant_ttc_total += $montant_ttc;
                    $montant_tva_total += $montant_tva;
                    $montant_remise_total += $remise;
                }
                $i++;
            }

            // Application de la remise globale si applicable
            $montant_remise_globale = 0;
            if($request->type_reduction_globale && $request->reduction_globale) {
                $montant_remise_globale = $request->type_reduction_globale === 'pourcentage'
                    ? $montant_ht_total * $request->reduction_globale / 100
                    : $request->reduction_globale;
                    
                $montant_ht_total -= $montant_remise_globale;
                $montant_tva_total = !$request->has('no_tva') 
                    ? $montant_ht_total * ($taux_tva / 100) 
                    : 0;
                $montant_ttc_total = $montant_ht_total + $montant_tva_total;
            }

            // Mise à jour des totaux de la commande
            $commande->update([
                'montant_ht' => $montant_ht_total,
                'montant_ttc' => $montant_ttc_total,
                'montant_tva' => $montant_tva_total,
                'montant_remise' => $montant_remise_total + $montant_remise_globale,
                'net_a_payer' => $montant_ttc_total
            ]);

            // génerer le PDF
            $this->generer_pdf_commande($commande->id);

            DB::commit();
            return redirect()->route('commande.index')->with('ok', 'Commande créée avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
           
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création de la commande : ' . $e->getMessage());
        }
    }
    /**
     * Affichage d'une commande
     * @param int $commandeId
     * @return \Illuminate\View\View
     */
    public function show($commandeId)
    {
        $commande = Commande::findOrFail(Crypt::decrypt($commandeId));
        return view('commande.show', compact('commande'));
    }

    /**
     * Affichage du formulaire de modification d'une commande
     * @param int $commandeId
     * @return \Illuminate\View\View
     */
    public function edit($commandeId)
    {
        $commande = Commande::findOrFail(Crypt::decrypt($commandeId));
   
        $produits = Produit::where('archive', false)->get();

        $clients = Contact::whereHas('typecontacts', function($query) {
            $query->whereIn('type', ['Client', 'Prospect']);
        })->where('archive', false)->get();
        
        // $produits = Produit::where([['archive', false],['a_declinaison', 0]])->get();
        $tvas = Tva::where('archive', false)->get();
        
        $categories = Categorieproduit::where('archive', false)->get();
        $voitures = Voiture::where('archive', false)->get();
        $circuits = Circuit::where('archive', false)->get();


        return view('commande.edit', compact('commande', 'clients', 'tvas', 'produits', 'categories', 'voitures', 'circuits'));
    }

    /**
     * Modification d'une commande
     * @param Request $request
     * @param int $commandeId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $commandeId)
    {
        try {
            DB::beginTransaction();

            $commande = Commande::findOrFail(Crypt::decrypt($commandeId));

            // Validation des données
            $request->validate([
                'numero_commande' => 'required|unique:commandes,numero_commande,' . $commande->id,
                'date_commande' => 'required|date',
                'mode_paiement' => 'required',
            ]);

            // Initialisation des totaux
            $montant_ht_total = 0;
            $montant_ttc_total = 0;
            $montant_tva_total = 0;
            $montant_remise_total = 0;

            // Mise à jour des informations de la commande
            $commande->update([
                'numero_commande' => $request->numero_commande,
                'date_commande' => $request->date_commande,
                'client_prospect_id' => $request->client_prospect_id,
                'date_realisation_prevue' => $request->date_realisation_prevue,
                'mode_paiement' => $request->mode_paiement,
                'sans_tva' => $request->has('no_tva'),
                'type_remise' => $request->type_reduction_globale,
                'remise' => $request->reduction_globale,
                'statut_commande' => $request->statut,
                'statut_paiement' => $request->statut_paiement,
                'origine_commande' => $request->provenance,
                'numero_origine' => $request->numero_commande_provenance,
                'date_origine_commande' => $request->date_commande_provenance
            ]);

            // Suppression des anciens produits
            $commande->produits()->detach();
        
            // Traitement des produits
            $i = 1;

            while($i <= 30) {
                if($request->{"produit$i"} != null) {
                    $quantite = $request->{"quantite$i"};
                    $prix_unitaire = $request->{"prix_ht$i"};
                    $taux_tva = TVA::where('id', $request->{"tva$i"})->first()->taux;
                    
                    // Calcul montant HT avant remise
                    $montant_ht = $quantite * $prix_unitaire;
                    
                    // Calcul remise produit si applicable
                    $remise = 0;
                    $taux_remise = 0;
                    if($request->{"type_reduction$i"} && $request->{"reduction$i"}) {
                        $taux_remise = $request->{"type_reduction$i"} === 'pourcentage' 
                            ? $request->{"reduction$i"} 
                            : ($request->{"reduction$i"} * 100 / $montant_ht);
                        $remise = $request->{"type_reduction$i"} === 'pourcentage'
                            ? $montant_ht * $request->{"reduction$i"} / 100
                            : $request->{"reduction$i"};
                    }

                    // Montant HT après remise
                    $montant_ht_final = $montant_ht - $remise;
                    
                    // Calcul TVA si applicable
                    $montant_tva = !$request->has('no_tva') ? $montant_ht_final * ($taux_tva / 100) : 0;
                    $montant_ttc = $montant_ht_final + $montant_tva;

                    $beneficiaire_id = $request->{"beneficiaire$i"} == null ? $request->client_prospect_id : $request->{"beneficiaire$i"};

                    // Ajout à la table pivot
                    // Récupération de la ligne commande_produit correspondante
                    
               
                    if($request->{"beneficiaire$i"} != null){
                        $commande->produits()->attach($request->{"produit$i"}, [
                            'quantite' => $quantite,
                            'prix_unitaire' => $prix_unitaire,
                            'montant_ht' => $montant_ht_final,
                            'montant_ttc' => $montant_ttc,
                            'montant_tva' => $montant_tva,
                            'taux_tva' => $taux_tva,
                            'remise' => $remise,
                            'taux_remise' => $taux_remise,
                            'beneficiaire_id' => $request->{"beneficiaire$i"} ?? null
                        ]);
                    }
                    else{
                        if($request->{"exist_beneficiaire_id$i"} != null){
                            $commande->produits()->attach($request->{"produit$i"}, [
                                'quantite' => $quantite,
                                'prix_unitaire' => $prix_unitaire,
                                'montant_ht' => $montant_ht_final,
                                'montant_ttc' => $montant_ttc,
                                'montant_tva' => $montant_tva,
                                'taux_tva' => $taux_tva,
                                'remise' => $remise,
                                'taux_remise' => $taux_remise,
                                'beneficiaire_id' => $beneficiaire_id
                            ]);
                        }else{
                            $commande->produits()->attach($request->{"produit$i"}, [
                                'quantite' => $quantite,
                                'prix_unitaire' => $prix_unitaire,
                                'montant_ht' => $montant_ht_final,
                                'montant_ttc' => $montant_ttc,
                                'montant_tva' => $montant_tva,
                                'taux_tva' => $taux_tva,
                                'remise' => $remise,
                                'taux_remise' => $taux_remise,
                            ]);
                        }
                    }

                    // Mise à jour des totaux
                    $montant_ht_total += $montant_ht_final;
                    $montant_ttc_total += $montant_ttc;
                    $montant_tva_total += $montant_tva;
                    $montant_remise_total += $remise;
                }
                $i++;
            }

            // Application de la remise globale si applicable
            $montant_remise_globale = 0;
            if($request->type_reduction_globale && $request->reduction_globale) {
                $montant_remise_globale = $request->type_reduction_globale === 'pourcentage'
                    ? $montant_ht_total * $request->reduction_globale / 100
                    : $request->reduction_globale;
                    
                $montant_ht_total -= $montant_remise_globale;
                $montant_tva_total = !$request->has('no_tva') 
                    ? $montant_ht_total * ($taux_tva / 100) 
                    : 0;
                $montant_ttc_total = $montant_ht_total + $montant_tva_total;
            }

            // Mise à jour des totaux de la commande
            $commande->update([
                'montant_ht' => $montant_ht_total,
                'montant_ttc' => $montant_ttc_total,
                'montant_tva' => $montant_tva_total,
                'montant_remise' => $montant_remise_total + $montant_remise_globale,
                'net_a_payer' => $montant_ttc_total
            ]);

            // régénerer le PDF
            $this->generer_pdf_commande($commande->id);
            DB::commit();
            return redirect()->route('commande.index')->with('ok', 'Commande modifiée avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
           
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la modification de la commande : ' . $e->getMessage());
        }
    }

    /**
     * Archiver une commande
     * @param string $commande_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function archiver($commande_id)
    {
        try {
            $commande = Commande::findOrFail(Crypt::decrypt($commande_id));
            $commande->update(['archive' => true]);
            
            if(request()->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return redirect()->route('commande.index')
                ->with('ok', 'La commande a été archivée avec succès');
                
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'archivage de la commande : ' . $e->getMessage());
            
            if(request()->ajax()) {
                return response()->json(['error' => 'Une erreur est survenue lors de l\'archivage.'], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'archivage de la commande.');
        }
    }

    /**
     * Désarchiver une commande
     * @param string $commande_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function desarchiver($commande_id)
    {
        try {
            $commande = Commande::findOrFail(Crypt::decrypt($commande_id));
            $commande->update(['archive' => false]);
            
            if(request()->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return redirect()->route('commande.archives')
                ->with('ok', 'La commande a été désarchivée avec succès');
                
        } catch (\Exception $e) {
            Log::error('Erreur lors du désarchivage de la commande : ' . $e->getMessage());
            
            if(request()->ajax()) {
                return response()->json(['error' => 'Une erreur est survenue lors du désarchivage.'], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors du désarchivage de la commande.');
        }
    }

    /**
     * Générer le PDF de la commande
     */
    public function generer_pdf_commande($commande_id)
    {
        
        try {
            $commande = Commande::findOrFail($commande_id);
            
            $path = storage_path('app/public/commandes');
            
            if(!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
                
            $pdf = PDF::loadView('commande.commande_pdf', compact('commande'));
            $filename = 'commande_'.$commande->numero_commande.'.pdf';
            $fullPath = $path.'/'.$filename;
            
            $pdf->save($fullPath);
            
            $commande->url_pdf = $fullPath;
            $commande->save();
            
            return $fullPath;
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération du PDF : ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Télécharger le PDF de la commande
     */
    public function telecharger($commande_id)
    {
        try {
            $commande = Commande::findOrFail(Crypt::decrypt($commande_id));
            // $this->generer_pdf_commande($commande->id);
            // Générer le PDF s'il n'existe pas ou si le fichier n'existe plus
            if (!$commande->url_pdf || !File::exists($commande->url_pdf)) {
                $pdfPath = $this->generer_pdf_commande($commande->id);
                if (!$pdfPath) {
                    return redirect()->back()->with('error', 'Impossible de générer le PDF de la commande.');
                }
            }
            
            if (!File::exists($commande->url_pdf)) {
                return redirect()->back()->with('error', 'Le fichier PDF est introuvable.');
            }
            
            return response()->download(
                $commande->url_pdf, 
                'commande_'.$commande->numero_commande.'.pdf',
                ['Content-Type: application/pdf']
            );
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du téléchargement du PDF : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors du téléchargement du PDF.');
        }
    }

    /**
     * Envoyer la commande par email
     */
    public function envoyer_mail(Request $request, $commande_id)
    {
        $commande = Commande::findOrFail(Crypt::decrypt($commande_id));
        
        // Générer le PDF s'il n'existe pas
        if (!$commande->url_pdf || !File::exists($commande->url_pdf)) {
            $this->generer_pdf_commande($commande->id);
        }
        
        $contact = $commande->client;
        
        Mail::to($request->email)
            ->send(new EnvoyerCommande($commande, $contact, $request->message));
        
        return redirect()->back()->with('ok', 'Commande envoyée avec succès');
    }

    /**
     * Affichage du formulaire de création d'une commande à partir d'un devis
     * @param string $devis_id
     * @return \Illuminate\View\View
     */
    public function createfromdevis($devis_id)
    {
        $devis = Devi::findOrFail(Crypt::decrypt($devis_id));
        $numero_commande = Commande::genererNumero();

      
        $clients = Contact::whereHas('typecontacts', function($query) {
            $query->whereIn('type', ['Client', 'Prospect']);
        })->where('archive', false)->get();
        
        $produits = Produit::where([['archive', false],['a_declinaison', 0]])->get();
        $tvas = Tva::where('archive', false)->get();
        
        $categories = Categorieproduit::where('archive', false)->get();
        $voitures = Voiture::where('archive', false)->get();
        $circuits = Circuit::where('archive', false)->get();

        $produits = Produit::where('archive', false)->get();
        
        return view('commande.add_from_devis', compact('devis', 'numero_commande', 'clients', 'produits', 'tvas', 'categories', 'voitures', 'circuits'));
    }

    /**
     * Enregistrement d'une commande à partir d'un devis
     * @param Request $request
     * @param string $devis_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storefromdevis(Request $request, $devis_id)
    {
        try {
            DB::beginTransaction();

            $devis = Devi::findOrFail(Crypt::decrypt($devis_id));

            // Validation des données
            $request->validate([
                'numero_commande' => 'required|unique:commandes,numero_commande',
                'date_commande' => 'required|date',
                'mode_paiement' => 'required',
            ]);

            // Initialisation des totaux
            $montant_ht_total = 0;
            $montant_ttc_total = 0;
            $montant_tva_total = 0;
            $montant_remise_total = 0;

            // Création de la commande
            $commande = Commande::create([
                'numero_commande' => $request->numero_commande,
                'date_commande' => $request->date_commande,
                'client_prospect_id' => $request->client_prospect_id,
                'date_realisation_prevue' => $request->date_realisation_prevue,
                'mode_paiement' => $request->mode_paiement,
                'sans_tva' => $request->has('no_tva'),
                'type_remise' => $request->type_reduction_globale,
                'remise' => $request->reduction_globale,
                'statut_commande' => $request->statut,
                'statut_paiement' => $request->statut_paiement,
                'origine_commande' => $request->provenance,
                'numero_origine' => $request->numero_commande_provenance,
                'date_origine_commande' => $request->date_commande_provenance,
                'devis_id' => $devis->id
            ]);
           
            // Traitement des produits
            $i = 1;

            while($i <= count($devis->produits)) {
                if($request->{"produit$i"} != null) {
                    $quantite = $request->{"quantite$i"};
                    $prix_unitaire = $request->{"prix_ht$i"};
                    $taux_tva = TVA::where('id', $request->{"tva$i"})->first()->taux;
                    
                    // Calcul montant HT avant remise
                    $montant_ht = $quantite * $prix_unitaire;
                    
                    // Calcul remise produit si applicable
                    $remise = 0;
                    $taux_remise = 0;
                    if($request->{"type_reduction$i"} && $request->{"reduction$i"}) {
                        $taux_remise = $request->{"type_reduction$i"} === 'pourcentage' 
                            ? $request->{"reduction$i"} 
                            : ($request->{"reduction$i"} * 100 / $montant_ht);
                        $remise = $request->{"type_reduction$i"} === 'pourcentage'
                            ? $montant_ht * $request->{"reduction$i"} / 100
                            : $request->{"reduction$i"};
                    }

                    // Montant HT après remise
                    $montant_ht_final = $montant_ht - $remise;
                    
                    // Calcul TVA si applicable
                    $montant_tva = !$request->has('no_tva') ? $montant_ht_final * ($taux_tva / 100) : 0;
                    $montant_ttc = $montant_ht_final + $montant_tva;

                    // Ajout à la table pivot
                    $commande->produits()->attach($request->{"produit$i"}, [
                        'quantite' => $quantite,
                        'prix_unitaire' => $prix_unitaire,
                        'montant_ht' => $montant_ht_final,
                        'montant_ttc' => $montant_ttc,
                        'montant_tva' => $montant_tva,
                        'taux_tva' => $taux_tva,
                        'remise' => $remise,
                        'taux_remise' => $taux_remise
                    ]);

                    // Mise à jour des totaux
                    $montant_ht_total += $montant_ht_final;
                    $montant_ttc_total += $montant_ttc;
                    $montant_tva_total += $montant_tva;
                    $montant_remise_total += $remise;
                }
                $i++;
            }

            // Application de la remise globale si applicable
            $montant_remise_globale = 0;
            if($request->type_reduction_globale && $request->reduction_globale) {
                $montant_remise_globale = $request->type_reduction_globale === 'pourcentage'
                    ? $montant_ht_total * $request->reduction_globale / 100
                    : $request->reduction_globale;
                    
                $montant_ht_total -= $montant_remise_globale;
                $montant_tva_total = !$request->has('no_tva') 
                    ? $montant_ht_total * ($taux_tva / 100) 
                    : 0;
                $montant_ttc_total = $montant_ht_total + $montant_tva_total;
            }

            // Mise à jour des totaux de la commande
            $commande->update([
                'montant_ht' => $montant_ht_total,
                'montant_ttc' => $montant_ttc_total,
                'montant_tva' => $montant_tva_total,
                'montant_remise' => $montant_remise_total + $montant_remise_globale,
                'net_a_payer' => $montant_ttc_total
            ]);

            // Génération du PDF
            $this->generer_pdf_commande($commande->id);

            DB::commit();
            return redirect()->route('commande.show', Crypt::encrypt($commande->id))->with('ok', 'Commande créée avec succès à partir du devis');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création de la commande : ' . $e->getMessage());
        }
    }
}
