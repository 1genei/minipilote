<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class VoitureController extends Controller
{
    /**
     * Afficher les voitures.
     */
    public function index()
    {
        $voitures = Voiture::where('archive', false)->get();
        return view('parametres.voiture.index', compact('voitures'));
    }

    /**
    * Affiche les archives
    */
    public function archives()
    {
        $voitures = Voiture::where('archive', true)->get();
        return view('parametres.voiture.archive', compact('voitures'));
    }
    
    
    
   
    /**
     * Entrepose une nouvelle voiture .
    */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|unique:voitures,nom',
        ]);
        Voiture::create($request->all());
        return redirect()->route('voiture.index')->with('success', 'Voiture créée avec succès.');
    }

    /**
     * Afficher le détail d'une voiture.
     */
    public function show(Voiture $voiture)
    {
        //
    }

  

    /**
     * Modifier une voiture.
     */
    public function update(Request $request, $voiture_id)
    {
        $voiture = Voiture::where('id', Crypt::decrypt($voiture_id))->first();
        $request->validate([
            'nom' => 'required|unique:voitures,nom,'.$voiture->id,
        ]);
        $voiture->update($request->all());
        return redirect()->route('voiture.index')->with('success', 'Voiture modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voiture $voiture)
    {
        //
    }
    
    /**
     * Archiver une voiture.
     */
    public function archiver($voiture_id)
    {
        $voiture = Voiture::where('id', Crypt::decrypt($voiture_id))->first();
        $voiture->archive = true;
        $voiture->save();
        return true ;
    }
    
    /**
     * Désarchiver une voiture.
     */
    public function desarchiver($voiture_id)
    {
        $voiture = Voiture::where('id', Crypt::decrypt($voiture_id))->first();
        $voiture->archive = false;
        $voiture->save();
        return true ;
    }
}
