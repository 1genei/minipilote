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

use Auth;
use Crypt;

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
        
        $request->validate([
            'numero_devis' => 'required|unique:devis',
        ]);
    // dd($request->all());
        $params = $request->all();
        unset($params["numero_devis"]);
        unset($params["nom_devis"]);
        unset($params["type_reduction_globale"]) ;
        unset($params["reduction_globale"]) ;
        unset($params["client_prospect_id"]) ;
        unset($params["voiture"]) ;
        unset($params["categorie"]) ;
        unset($params["circuit"]) ;
        unset($params["produit"]) ;
        unset($params["_token"]) ;
      
        $palier = array_chunk($params, 6);

        $type_reduction_globale = $request->input('type_reduction_globale');
        $reduction_globale = $request->input('reduction_globale');
        
        // Calcul du montant HT, TTC, TVA et net à payer
        $montant_ht = 0;
        $montant_ttc = 0;
        $montant_tva = 0;
        $net_a_payer = 0;
        $montant_remise = 0;
        $montant_remise_total = 0;
        $tab_produits = [];
        $tab = [];
        // 0 = id_produit, 1 = quantité, 2 = prix_unitaire ht, 3 = id_tva, 4 = type_remise, 5 = remise
        
        foreach($palier as $ligne){
            
            $quantite = $ligne[1];
            $prix_unitaire_ht = $ligne[2];
            $tva_id = $ligne[3];
            $type_remise = $ligne[4];
            $remise = $ligne[5];
            $montant_remise_total += $remise;
            
            $tva = 0 ;
            if($tva_id != null){
                $tva = Tva::where('id', $tva_id)->first();
                $tva = $tva->taux;
            }
            
            $montant_ht += $quantite * $prix_unitaire_ht;
            $montant_ttc += $quantite * $prix_unitaire_ht * (1 + $tva/100);
            $montant_tva += $quantite * $prix_unitaire_ht * $tva/100;
            
            
            if($type_remise == 'montant'){
                $montant_remise += $remise;
            }
            else if($type_remise == 'pourcentage'){
                $montant_remise += ($quantite * $prix_unitaire_ht * (1 + $tva/100)) * $remise/100;
            }
            
            $tab["produit"] = Produit::where('id', $ligne[0])->first();
            $tab["quantite"] = $quantite;
            $tab["prix_unitaire_ht"] = $prix_unitaire_ht;
            $tab["prix_unitaire_ht_total"] = $quantite * $prix_unitaire_ht;
            $tab["tva"] = $tva;
            $tab["type_remise"] = $type_remise;
            $tab["remise"] = $remise;
            
            
            $tab_produits[] = $tab;
            
        }
        
        if($type_reduction_globale == 'montant'){
            $montant_remise += $reduction_globale;
        }
        else if($type_reduction_globale == 'pourcentage'){
            $montant_remise += ($montant_ttc) * $reduction_globale/100;
        }
        
        $montant_remise_total += $montant_remise;
        $net_a_payer = $montant_ttc - $montant_remise_total;
        
        // dd($montant_ht." ".$montant_ttc." ".$montant_tva." ".$montant_remise." ".$net_a_payer);        

        
        $palier = json_encode($palier);
        
        
    
        
        
        $devis = new Devi();
        
        
        $devis->numero_devis = $request->numero_devis;
        $devis->nom_devis = $request->nom_devis;
        $devis->date_devis = date('Y-m-d');
        $devis->duree_validite = 30;
        $devis->montant_ht = $montant_ht;
        $devis->montant_ttc = $montant_ttc;
        $devis->montant_tva = $montant_tva;
        $devis->net_a_payer = $net_a_payer;
        $devis->montant_remise = $montant_remise;
        $devis->montant_remise_total = $montant_remise_total;
        $devis->type_remise = $request->type_reduction_globale;
        $devis->remise = $request->reduction_globale;
        $devis->collaborateur_id = Auth::user()->id;
        $devis->client_prospect_id = $request->client_prospect_id;

        $devis->palier = $palier;
        $devis->save();
        
        $this->generer_pdf_devis($devis->id, $tab_produits);

        
        return redirect()->route('devis.index')->with('success', 'Devis ajouté avec succès');
        
        
        
        
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
        
        $devis = Devi::where('id', Crypt::decrypt($devis_id))->first();
        $params = $request->all();
        
        unset($params["numero_devis"]);
        unset($params["nom_devis"]);
        unset($params["type_reduction_globale"]) ;
        unset($params["reduction_globale"]) ;
        unset($params["client_prospect_id"]) ;
        unset($params["voiture"]) ;
        unset($params["categorie"]) ;
        unset($params["circuit"]) ;
        unset($params["produit"]) ;
        unset($params["_token"]) ;
      
        
        $palier = array_chunk($params, 6);
        
        $type_reduction_globale = $request->input('type_reduction_globale');
        $reduction_globale = $request->input('reduction_globale');
        
        // Calcul du montant HT, TTC, TVA et net à payer
        $montant_ht = 0;
        $montant_ttc = 0;
        $montant_tva = 0;
        $net_a_payer = 0;
        $montant_remise = 0;
        // 0 = id_produit, 1 = quantité, 2 = prix_unitaire ht, 3 = id_tva, 4 = type_remise, 5 = remise
        
        $tab_produits = [];
        $tab = [];
        $montant_remise_total = 0;
        
        foreach($palier as $ligne){
            
            $quantite = $ligne[1];
            $prix_unitaire_ht = $ligne[2];
            $tva_id = $ligne[3];
            $type_remise = $ligne[4];
            $remise = $ligne[5];
            $montant_remise_total += $remise;
            
            $tva = 0 ;
            if($tva_id != null){
                $tva = Tva::where('id', $tva_id)->first();
                $tva = $tva->taux;
            }
            
            $montant_ht += $quantite * $prix_unitaire_ht;
            $montant_ttc += $quantite * $prix_unitaire_ht * (1 + $tva/100);
            $montant_tva += $quantite * $prix_unitaire_ht * $tva/100;
            
            
            if($type_remise == 'montant'){
                $montant_remise += $remise;
            }
            else if($type_remise == 'pourcentage'){
                $montant_remise += ($quantite * $prix_unitaire_ht * (1 + $tva/100)) * $remise/100;
            }
            
            $tab["produit"] = Produit::where('id', $ligne[0])->first();
            $tab["quantite"] = $quantite;
            $tab["prix_unitaire_ht"] = $prix_unitaire_ht;
            $tab["prix_unitaire_ht_total"] = $quantite * $prix_unitaire_ht;
            $tab["tva"] = $tva;
            $tab["type_remise"] = $type_remise;
            $tab["remise"] = $remise;
            
            
            $tab_produits[] = $tab;
            
        }
        

        if($type_reduction_globale == 'montant'){
            $montant_remise += $reduction_globale;
        }
        else if($type_reduction_globale == 'pourcentage'){
            $montant_remise += ($montant_ttc) * $reduction_globale/100;
        }
        
        $montant_remise_total += $montant_remise;
        $net_a_payer = $montant_ttc - $montant_remise_total;
        
        // dd($montant_ht." ".$montant_ttc." ".$montant_tva." ".$montant_remise." ".$net_a_payer);
        
        
        $palier = json_encode($palier);
        
        $devis->numero_devis = $request->numero_devis;
        $devis->nom_devis = $request->nom_devis;
        $devis->date_devis = date('Y-m-d');
        $devis->duree_validite = 30;
        $devis->montant_ht = $montant_ht;
        $devis->montant_ttc = $montant_ttc;
        $devis->montant_tva = $montant_tva;
        $devis->net_a_payer = $net_a_payer;
        $devis->montant_remise = $montant_remise;
        $devis->montant_remise_total = $montant_remise_total;
        $devis->type_remise = $request->type_reduction_globale;
        $devis->remise = $request->reduction_globale;
        $devis->collaborateur_id = Auth::user()->id;
        $devis->client_prospect_id = $request->client_prospect_id;
        
        $devis->palier = $palier;
        $devis->save();
        
        $this->generer_pdf_devis($devis->id, $tab_produits);
        
        return redirect()->route('devis.index')->with('success', 'Devis modifié avec succès');
        
        
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
