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
        
        return view('devis.add', compact('produits', 'tvas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
