<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devi;
use App\Models\Produit;
use App\Models\Tva;
use App\Models\Contact;
use App\Models\Categorieproduit;
use App\Models\Voiture;
use App\Models\Circuit;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Mail\EnvoyerDevis;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;


class DeviController extends Controller
{
    /**
     * Affichage des devis
     */
    public function index()
    {
        $devis = Devi::where('archive', false)->get();
        
        return view('devis.index', compact('devis'));
    }

    /**
     * Affichage des devis archivés
     */
    public function archives()
    {
        $devis = Devi::where('archive', true)->get();
        
        return view('devis.archives', compact('devis'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produits = Produit::where([['archive', false],['a_declinaison', 0]])->get();
        $tvas = Tva::where('archive', false)->get();
        $prochain_numero_devis = Devi::max('numero_devis') + 1;
        $contactclients = Contact::where('archive', false)->get();
        
        $categories = Categorieproduit::where('archive', false)->get();
        $voitures = Voiture::where('archive', false)->get();
        $circuits = Circuit::where('archive', false)->get();
        
        
        return view('devis.add', compact('produits', 'tvas', 'prochain_numero_devis', 'contactclients','categories', 'voitures', 'circuits'));
    }

    /**
     * Créer un devis.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validation des données
            $request->validate([
                'numero_devis' => 'required|unique:devis,numero_devis',
                'client_prospect_id' => 'required',
            ]);

            // Initialisation des totaux
            $montant_ht_total = 0;
            $montant_ttc_total = 0;
            $montant_tva_total = 0;
            $montant_remise_total = 0;

            // Création du devis
            $devis = Devi::create([
                'numero_devis' => $request->numero_devis,
                'nom_devis' => $request->nom_devis,
                'date_devis' => date('Y-m-d'),
                'duree_validite' => 30,
                'client_prospect_id' => $request->client_prospect_id,
                'collaborateur_id' => Auth::user()->id,
                'sans_tva' => $request->has('no_tva'),
                'type_remise' => $request->type_reduction_globale,
                'remise' => $request->reduction_globale,
            ]);

            // Traitement des produits
            $i = 1;
            $tab_produits = [];
            while($i <= 30) {
                if($request->{"produit$i"} != null) {
                    $quantite = $request->{"quantite$i"};
                    $prix_unitaire = $request->{"prix_ht$i"};
                    $taux_tva = Tva::where('id', $request->{"tva$i"})->first()->taux;
                    
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

                    // Préparation des données pour le PDF
                    $tab["produit"] = Produit::where('id', $request->{"produit$i"})->first();
                    $tab["quantite"] = $quantite;
                    $tab["prix_unitaire_ht"] = $prix_unitaire;
                    $tab["prix_unitaire_ht_total"] = $montant_ht_final;
                    $tab["tva"] = $taux_tva;
                    $tab["type_remise"] = $request->{"type_reduction$i"};
                    $tab["remise"] = $remise;
                    $tab_produits[] = $tab;

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

            // Mise à jour des totaux du devis
            $devis->update([
                'montant_ht' => $montant_ht_total,
                'montant_ttc' => $montant_ttc_total,
                'montant_tva' => $montant_tva_total,
                'montant_remise' => $montant_remise_total,
                'montant_remise_total' => $montant_remise_total + $montant_remise_globale,
                'net_a_payer' => $montant_ttc_total
            ]);

            // Génération du PDF
            $this->generer_pdf_devis($devis->id, $tab_produits);

            DB::commit();
            return redirect()->route('devis.show', Crypt::encrypt($devis->id))->with('success', 'Devis ajouté avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création du devis : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
    */
    public function show(string $devis_id)
    {
        $devis = Devi::where('id', Crypt::decrypt($devis_id))->first();
        $paliers = json_decode($devis->palier);
        
        $produits = Produit::where('archive', false)->get();        
        $tvas = Tva::where('archive', false)->get();
        $prochain_numero_devis = Devi::max('numero_devis') + 1;
        
        $contactclients = Contact::where('archive', false)->get();
        $tab_produits = [];
        foreach($produits as $produit){
            $tab_produits[$produit->id] = $produit;
        }
        
        $tab_tvas = [];
        foreach($tvas as $tva){
            $tab_tvas[$tva->id] = $tva->taux;
        }
        
        $contact = $devis->client_prospect(); 
         
        return view('devis.show', compact('devis', 'produits', 'tvas','paliers','tab_produits', 'contact', 'tab_tvas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($devis_id)
    {
        $devis = Devi::where('id', Crypt::decrypt($devis_id))->first();
        $paliers = json_decode($devis->palier);
         
        $produits = Produit::where([['archive', false],['a_declinaison', 0]])->get();
        
        $tvas = Tva::where('archive', false)->get();
        $prochain_numero_devis = Devi::max('numero_devis') + 1;
        
        $categories = Categorieproduit::where('archive', false)->get();
        $voitures = Voiture::where('archive', false)->get();
        $circuits = Circuit::where('archive', false)->get();
        
        $contactclients = Contact::where('archive', false)->get();
        $tab_produits = [];
        foreach($produits as $produit){
            $tab_produits[$produit->id] = $produit;
        }
        
        $tab_tvas = [];
        foreach($tvas as $tva){
            $tab_tvas[$tva->id] = $tva->taux;
        }
        return view('devis.edit', compact('devis', 'produits', 'tvas', 'contactclients','prochain_numero_devis', 'paliers','tab_produits', 'tab_tvas', 'categories', 'voitures', 'circuits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $devis_id)
    {
        try {
            DB::beginTransaction();

            $devis = Devi::where('id', Crypt::decrypt($devis_id))->first();
            
            // Validation des données
            $request->validate([
                'numero_devis' => 'required|unique:devis,numero_devis,'.$devis->id,
                'client_prospect_id' => 'required',
            ]);

            // Initialisation des totaux
            $montant_ht_total = 0;
            $montant_ttc_total = 0;
            $montant_tva_total = 0;
            $montant_remise_total = 0;

            // Mise à jour des informations de base du devis
            $devis->update([
                'numero_devis' => $request->numero_devis,
                'nom_devis' => $request->nom_devis,
                'client_prospect_id' => $request->client_prospect_id,
                'collaborateur_id' => Auth::user()->id,
                'sans_tva' => $request->has('no_tva'),
                'type_remise' => $request->type_reduction_globale,
                'remise' => $request->reduction_globale,
            ]);
       
            // Suppression des anciens produits
            $devis->produits()->detach();

            // Traitement des produits
            $i = 1;
            $tab_produits = [];

            // dd($request->all());

            while($i <= 30) {
                if($request->{"produit$i"} != null) {
                    $quantite = $request->{"quantite$i"};
                    $prix_unitaire = $request->{"prix_ht$i"};
                    $taux_tva = Tva::where('id', $request->{"tva$i"})->first()->taux;
                    
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

                    
                    // Préparation des données pour le PDF
                    $tab["produit"] = Produit::where('id', $request->{"produit$i"})->first();
                    $tab["quantite"] = $quantite;
                    $tab["prix_unitaire_ht"] = $prix_unitaire;
                    $tab["prix_unitaire_ht_total"] = $montant_ht_final;
                    $tab["tva"] = $taux_tva;
                    $tab["type_remise"] = $request->{"type_reduction$i"};
                    $tab["remise"] = $remise;
                    $tab_produits[] = $tab;

                    // ajout des produits au devis
                    $devis->produits()->attach($request->{"produit$i"}, [
                        'quantite' => $quantite,
                        'prix_unitaire' => $prix_unitaire,
                        'montant_ht' => $montant_ht_final,
                        'montant_ttc' => $montant_ttc,
                        'montant_tva' => $montant_tva,
                        'taux_tva' => $taux_tva,
                        'remise' => $remise,
                        'taux_remise' => $taux_remise,
                    ]);

                 
                    // dd($devis->produits, $tab_produits);

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

            // Mise à jour des totaux du devis
            $devis->update([
                'montant_ht' => $montant_ht_total,
                'montant_ttc' => $montant_ttc_total,
                'montant_tva' => $montant_tva_total,
                'montant_remise' => $montant_remise_total,
                'montant_remise_total' => $montant_remise_total + $montant_remise_globale,
                'net_a_payer' => $montant_ttc_total
            ]);

            // Génération du PDF
            $this->generer_pdf_devis($devis->id, $tab_produits);

            DB::commit();
            return redirect()->route('devis.index')->with('success', 'Devis modifié avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la modification du devis : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
    /**
     * Modifier statut devis
     */     
     public function modifierStatut($devis_id, $statut){
        
        
        $devis = Devi::where('id', $devis_id)->first();
        $devis->statut = $statut;
        $devis->save();
        
        return "ok";
        
        
     }
     
    /**
    * Archiver le devis
    */
    public function archiver($devis_id){
        
        $devis = Devi::where('id', Crypt::decrypt($devis_id))->first();
        $devis->archive = true;
        $devis->save();
        
        return "ok";
        
    }
    
    /**
    * Désarchiver le devis
    */
    public function desarchiver($devis_id){
        
        $devis = Devi::where('id', Crypt::decrypt($devis_id))->first();
        $devis->archive = false;
        $devis->save();
        
        return "ok";
        
    }
    
    /**
    * Télécharger le devis
    */
    public function telecharger($devis_id){
        
        $devis = Devi::where('id', Crypt::decrypt($devis_id))->first();
        return response()->download($devis->url_pdf);
        
    }
    /**
    * Générer le pdf du devis
    */
    public function generer_pdf_devis($devis_id, $tab_produits){
        
        $devis = Devi::where('id',$devis_id)->first();
        $paliers = json_decode($devis->palier);
        
      
        $montant_ht = $devis->montant_ht;
        $montant_tva = $devis->montant_tva;
        $montant_ttc = $devis->montant_ttc;
        $montant_remise = $devis->montant_remise;
        $montant_remise_total = $devis->montant_remise_total;
        $net_a_payer = $devis->net_a_payer;
        
        
        $path = storage_path('app/public/devis');
        
        if(!File::exists($path))
            File::makeDirectory($path, 0755, true);
            
        
        $pdf = PDF::loadView('devis.devis_pdf',compact(['devis','paliers', 'tab_produits', 'montant_ht', 'montant_tva', 'montant_ttc', 'montant_remise','montant_remise_total', 'net_a_payer']));
        $path = $path.'/devis_'.$devis->numero_devis.'.pdf';
        $pdf->save($path);
        
        $devis->url_pdf = $path;
        $devis->save();
        
        return true;
    }
    
    
    /**
    * Envoyer le devis par mail
    */
    public function envoyer_mail(string $devis_id){
    
        $devis = Devi::where('id', Crypt::decrypt($devis_id))->first();
        $contact = $devis->client_prospect();
        
        $email = $contact->type == "individu" ? $contact->individu?->email : $contact->entite?->email;

        mail::to($email)->send(new EnvoyerDevis($devis, $contact));
        
        return redirect()->back()->with('ok', 'Devis envoyé avec succès');

    }
}
