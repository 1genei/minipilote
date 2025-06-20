<?php

namespace App\Http\Controllers;

use App\Models\Modelevoiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ModelevoitureController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'cout_kilometrique' => 'required|numeric|min:0',
            'coefficient_prix' => 'required|numeric|min:0',
            'seuil_alerte_km_pneu' => 'nullable|numeric|min:0',
            'seuil_alerte_km_vidange' => 'nullable|numeric|min:0',
            'seuil_alerte_km_revision' => 'nullable|numeric|min:0',
            'seuil_alerte_km_courroie' => 'nullable|numeric|min:0',
            'seuil_alerte_km_frein' => 'nullable|numeric|min:0',
            'seuil_alerte_km_amortisseur' => 'nullable|numeric|min:0',
        ]);

        Modelevoiture::create([
            'nom' => $request->nom,
            'cout_kilometrique' => $request->cout_kilometrique,
            'coefficient_prix' => $request->coefficient_prix,
            'prix_vente_kilometrique' => $request->cout_kilometrique * $request->coefficient_prix,
            'seuil_alerte_km_pneu' => $request->seuil_alerte_km_pneu,
            'seuil_alerte_km_vidange' => $request->seuil_alerte_km_vidange,
            'seuil_alerte_km_revision' => $request->seuil_alerte_km_revision,
            'seuil_alerte_km_courroie' => $request->seuil_alerte_km_courroie,
            'seuil_alerte_km_frein' => $request->seuil_alerte_km_frein,
            'seuil_alerte_km_amortisseur' => $request->seuil_alerte_km_amortisseur,
        ]);

        return redirect()->back()->with('ok', 'Modèle de voiture créé avec succès');
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'nom' => 'required|string|max:255',
            'cout_kilometrique' => 'required|numeric|min:0',
            'coefficient_prix' => 'required|numeric|min:0',
            'seuil_alerte_km_pneu' => 'nullable|numeric|min:0',
            'seuil_alerte_km_vidange' => 'nullable|numeric|min:0',
            'seuil_alerte_km_revision' => 'nullable|numeric|min:0',
            'seuil_alerte_km_courroie' => 'nullable|numeric|min:0',
            'seuil_alerte_km_frein' => 'nullable|numeric|min:0',
            'seuil_alerte_km_amortisseur' => 'nullable|numeric|min:0',
        ]);

        $modele = Modelevoiture::findOrFail($id);
        $modele->update([
            'nom' => $request->nom,
            'cout_kilometrique' => $request->cout_kilometrique,
            'coefficient_prix' => $request->coefficient_prix,
            'prix_vente_kilometrique' => $request->cout_kilometrique * $request->coefficient_prix,
            'seuil_alerte_km_pneu' => $request->seuil_alerte_km_pneu,
            'seuil_alerte_km_vidange' => $request->seuil_alerte_km_vidange,
            'seuil_alerte_km_revision' => $request->seuil_alerte_km_revision,
            'seuil_alerte_km_courroie' => $request->seuil_alerte_km_courroie,
            'seuil_alerte_km_frein' => $request->seuil_alerte_km_frein,
            'seuil_alerte_km_amortisseur' => $request->seuil_alerte_km_amortisseur,
        ]);

        return redirect()->back()->with('ok', 'Modèle de voiture modifié avec succès');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $modele = Modelevoiture::findOrFail($id);
        $modele->delete();

        return redirect()->back()->with('ok', 'Modèle de voiture supprimé avec succès');
    }
}
