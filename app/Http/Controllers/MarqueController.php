<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marque;
use Illuminate\Support\Facades\Crypt;

class MarqueController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'nom' => 'required|string',
        ]);
        Marque::create([
            'nom' => $request->nom,
            'archive' => false
        ]);

        return redirect()->route('parametre.produit')->with('message', 'Marque ajoutée');
    }

    public function update(Request $request, $marqueId){
        $request->validate([
            'nom' => 'required|string',
        ]);
        $marque = Marque::where('id', Crypt::decrypt($marqueId))->first();
        
        $marque->nom = $request->nom;
        $marque->update();
        
        return redirect()->route('parametre.produit')->with('message', 'Marque modifiée');
    }

    public function archive($marqueId) {
        $marque = Marque::where('id', Crypt::decrypt($marqueId))->first();
        $marque->archive = true;
        $marque->update();
        return redirect()->route('parametre.produit')->with('message', 'Marque archivée');
    }

    public function unarchive($marqueId) {
        $marque = Marque::where('id', Crypt::decrypt($marqueId))->first();
        $marque->archive = false;
        $marque->update();
        return redirect()->route('parametre.produit')->with('message', 'Marque restaurée');
    }
}
