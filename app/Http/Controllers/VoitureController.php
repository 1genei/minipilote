<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use App\Models\Modelevoiture;
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
        $modeles = Modelevoiture::where('archive', false)->get();
        return view('parametres.voiture.index', compact('voitures', 'modeles'));
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
            'nom' => 'required|string|max:255',
            'modelevoiture_id' => 'nullable|exists:modelevoitures,id',
            // 'cout_kilometrique' => 'required|numeric|min:0',
            // 'coefficient_prix' => 'required|numeric|min:0',
            // 'seuil_alerte_km_pneu' => 'nullable|numeric|min:0',
            // 'seuil_alerte_km_vidange' => 'nullable|numeric|min:0',
            // 'seuil_alerte_km_revision' => 'nullable|numeric|min:0',
            // 'seuil_alerte_km_courroie' => 'nullable|numeric|min:0',
            // 'seuil_alerte_km_frein' => 'nullable|numeric|min:0',
            // 'seuil_alerte_km_amortisseur' => 'nullable|numeric|min:0',
        ]);

        $voiture = Voiture::create([
            'nom' => $request->nom,
            'modelevoiture_id' => $request->modelevoiture_id,
            // 'cout_kilometrique' => $request->cout_kilometrique,
            // 'coefficient_prix' => $request->coefficient_prix,
            // 'prix_vente_kilometrique' => $request->cout_kilometrique * $request->coefficient_prix,
            // 'seuil_alerte_km_pneu' => $request->seuil_alerte_km_pneu,
            // 'seuil_alerte_km_vidange' => $request->seuil_alerte_km_vidange,
            // 'seuil_alerte_km_revision' => $request->seuil_alerte_km_revision,
            // 'seuil_alerte_km_courroie' => $request->seuil_alerte_km_courroie,
            // 'seuil_alerte_km_frein' => $request->seuil_alerte_km_frein,
            // 'seuil_alerte_km_amortisseur' => $request->seuil_alerte_km_amortisseur,
        ]);

        return redirect()->back()->with('ok', 'Voiture créée avec succès');
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
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'nom' => 'required|string|max:255',
            'modelevoiture_id' => 'nullable|exists:modelevoitures,id',
            // 'cout_kilometrique' => 'required|numeric|min:0',
            // 'coefficient_prix' => 'required|numeric|min:0',
            // 'seuil_alerte_km_pneu' => 'nullable|numeric|min:0',
            // 'seuil_alerte_km_vidange' => 'nullable|numeric|min:0',
            // 'seuil_alerte_km_revision' => 'nullable|numeric|min:0',
            // 'seuil_alerte_km_courroie' => 'nullable|numeric|min:0',
            // 'seuil_alerte_km_frein' => 'nullable|numeric|min:0',
            // 'seuil_alerte_km_amortisseur' => 'nullable|numeric|min:0',
        ]);

        $voiture = Voiture::findOrFail($id);
        $voiture->update([
            'nom' => $request->nom,
            'modelevoiture_id' => $request->modelevoiture_id,
            // 'cout_kilometrique' => $request->cout_kilometrique,
            // 'coefficient_prix' => $request->coefficient_prix,
            // 'prix_vente_kilometrique' => $request->cout_kilometrique * $request->coefficient_prix,
            // 'seuil_alerte_km_pneu' => $request->seuil_alerte_km_pneu,
            // 'seuil_alerte_km_vidange' => $request->seuil_alerte_km_vidange,
            // 'seuil_alerte_km_revision' => $request->seuil_alerte_km_revision,
            // 'seuil_alerte_km_courroie' => $request->seuil_alerte_km_courroie,
            // 'seuil_alerte_km_frein' => $request->seuil_alerte_km_frein,
            // 'seuil_alerte_km_amortisseur' => $request->seuil_alerte_km_amortisseur,
        ]);

        return redirect()->back()->with('ok', 'Voiture modifiée avec succès');
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
