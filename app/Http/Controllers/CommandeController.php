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
use Illuminate\Support\Facades\DB;
class CommandeController extends Controller
{
    /**
     * Affichage des commandes
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('commande.index');
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
                'date_origine_commande' => $request->date_commande_provenance
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
                        'beneficiaire_id' => $request->{"beneficiaire$i"} ?? null
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
                                'beneficiaire_id' => $request->{"exist_beneficiaire_id$i"}
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

            DB::commit();
            return redirect()->route('commande.index')->with('ok', 'Commande modifiée avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
           
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la modification de la commande : ' . $e->getMessage());
        }
    }

    public function archiver($commandeId)
    {
        $commande = Commande::findOrFail(Crypt::decrypt($commandeId));
        $commande->update(['archive' => true]);
        return redirect()->route('commande.index')->with('ok', 'Commande archivée avec succès');
    }

    public function desarchiver($commandeId)
    {
        $commande = Commande::findOrFail(Crypt::decrypt($commandeId));
        $commande->update(['archive' => false]);
        return redirect()->route('commande.archives')->with('ok', 'Commande désarchivée avec succès');
    }
}
