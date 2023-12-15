<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devi;
use App\Models\Produit;
use App\Models\Tva;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produits = Produit::where('archive', false)->get();
        $tvas = Tva::where('archive', false)->get();
        $prochain_numero_devis = Devi::max('numero_devis') + 1;
        
        return view('devis.add', compact('produits', 'tvas', 'prochain_numero_devis'));
    }

    /**
     * Créer un devis.
     */
    public function store(Request $request)
    {
        
    
        
        // dd($request->all());
        $params = $request->all();
        unset($params["type_reduction_globale"]) ;
        unset($params["reduction_globale"]) ;
        unset($params["_token"]) ;
      
    //   dd($params);
        $palier = array_chunk($params, 6);
        
        dd($palier);
        $palier = json_encode($palier);
        
            $type_reduction_globale = $request->input('type_reduction_globale');
        $reduction_globale = $request->input('reduction_globale');
        
        $devis = new Devi();
        
        $devis->numero_devis = $request->numero_devis;
        $devis->nom_devis = $request->nom_devis;
        $devis->date_devis = $request->date_devis;
        $devis->duree_validite = $request->duree_validite;
        $devis->montant_ht = $request->montant_ht;
        $devis->montant_ttc = $request->montant_ttc;
        $devis->montant_tva = $request->montant_tva;
        $devis->type_remise = $request->type_remise;
        $devis->remise = $request->remise;
        $devis->collaborateur_id = Auth::user()->id;
        $devis->client_prospect_id = $request->client_prospect_id;

        $devis->palier = $palier;
        $devis->save();
        
        
            // $table->string('numero_devis');
            // $table->string('nom_devis')->nullable();
            // $table->date('date_devis')->nullable();
            // $table->integer('duree_validite')->nullable();
            // $table->string('statut')->nullable();
            // $table->string('type')->nullable();
            // $table->double('montant_ht')->nullable();
            // $table->double('montant_ttc')->nullable();
            // $table->double('montant_tva')->nullable();
            // $table->double('remise')->nullable();
            // $table->double('taux_remise')->nullable();
            // $table->integer('collaborateur_id')->nullable();
            // $table->integer('client_prospect_id')->nullable();
        
        
        
        
    }

    /**
     * Display the specified resource.
    */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
