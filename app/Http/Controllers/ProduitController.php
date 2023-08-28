<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Stock;
use App\Models\Categorieproduit;

use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $produits = Produit::where('archive', false)->get();


        return view('produit.index');
        // return view('produit.index', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
        $categories = Categorieproduit::whereNull('parent_id')->get();
    
 
        return view('produit.add', compact('categories'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        dd($request->all());
        $produit = Produit::create([
        "nom" => $request->nom,
          "description" => $request->description,
          "type" => $request->type,
          "marque_id" => $request->marque,
          "prix_vente_ht" => $request->prix_vente_ht,
          "prix_vente_ttc" => $request->prix_vente_ttc,
          "prix_vente_max_ht" => $request->prix_vente_max_ht,
          "prix_vente_max_ttc" => $request->prix_vente_max_ttc,
          "prix_achat_ht" => $request->prix_achat_ht,
          "prix_achat_ttc" => $request->prix_achat_ttc,
          "prix_achat_commerciaux_ht" => $request->prix_achat_commerciaux_ht,
          "prix_achat_commerciaux_ttc" => $request->prix_achat_commerciaux_ttc,
         
        ]);
        
        if($request->categories_id){
            
            foreach ($$request->categories_id as $categories_id) {
                Categorieproduit::create([
                    
                ]);
            }
        }
        
        
        if($request->type != "simple"){
        
            // variations
        }
        
        // fiche technique categorie stock
        
        $stock = Stock::create([
            "produit_id" => $produit->id,
            "quantite" => $request->quantite,
            "quantite_min" => $request->quantite_min_vente,
            "seuil_alerte" => $request->seuil_alerte_stock,
        ]);
        
        
        
        return redirect()->back()->with('ok', 'Nouveau produit ajouté');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        //
    }
}
