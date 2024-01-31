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
            'cout_kilometrique' => 'required',
            'coefficient_prix' => 'required',
            
        ]);
        
        Voiture::create([
            "nom" => $request->nom,
            "cout_kilometrique" => $request->cout_kilometrique,
            "coefficient_prix" => $request->coefficient_prix,
            "prix_vente_kilometrique" => round($request->cout_kilometrique * $request->coefficient_prix, 2),
            "seuil_alerte_km_pneu" => $request->seuil_alerte_km_pneu,
            "seuil_alerte_km_vidange" => $request->seuil_alerte_km_vidange,
            "seuil_alerte_km_revision" => $request->seuil_alerte_km_revision,
            "seuil_alerte_km_courroie" => $request->seuil_alerte_km_courroie,
            "seuil_alerte_km_frein" => $request->seuil_alerte_km_frein,
            "seuil_alerte_km_amortisseur" => $request->seuil_alerte_km_amortisseur
            
        ]);
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
            'cout_kilometrique' => 'required',
            'coefficient_prix' => 'required',
        ]);
        
        $voiture->update($request->all());
        $voiture->prix_vente_kilometrique = round($voiture->cout_kilometrique * $voiture->coefficient_prix, 2);
        $voiture->save();
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
