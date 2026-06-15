<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use Auth;
use Crypt;

class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Enregistrer les dépenses
     */
    public function store(Request $request)
    {
       
        
        $request->validate([
            "type"       => "required",
            "libelle"    => "required",
            "montant_ht" => "required|numeric",
        ]);

        $soumis = $request->has('soumis_tva');
        $ht     = (float) $request->montant_ht;
        $taux   = $soumis ? (float) $request->taux_tva : 0;
        $tva    = $soumis ? round($ht * $taux / 100, 2) : 0;
        $ttc    = round($ht + $tva, 2);

        $depense = new Depense();
        $depense->type        = $request->type;
        $depense->evenement_id = $request->evenement_id;
        $depense->libelle     = $request->libelle;
        $depense->description = $request->description;
        $depense->date_depense = $request->date;
        $depense->soumis_tva  = $soumis;
        $depense->taux_tva    = $soumis ? $taux : null;
        $depense->montant_ht  = $ht;
        $depense->montant_tva = $tva;
        $depense->montant_ttc = $ttc;
        $depense->user_id     = Auth::user()->id;
        $depense->save();
        
        $evenement_id = $request->evenement_id;
        
        if($evenement_id){
            return redirect()->route('evenement.show', Crypt::encrypt($evenement_id))->with('ok', 'Depense enregistrée.');
        }
        
        return redirect()->back()->with('ok', 'Depense enregistrée.');
       
        
        
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $depense_id)
    {
    
        $depense_id = Crypt::decrypt($depense_id);
        $depense = Depense::findOrFail($depense_id);

        $soumis = $request->has('soumis_tva');
        $ht     = (float) $request->montant_ht;
        $taux   = $soumis ? (float) $request->taux_tva : 0;
        $tva    = $soumis ? round($ht * $taux / 100, 2) : 0;
        $ttc    = round($ht + $tva, 2);

        $depense->type        = $request->type;
        $depense->libelle     = $request->libelle;
        $depense->description = $request->description;
        $depense->date_depense = $request->date;
        $depense->soumis_tva  = $soumis;
        $depense->taux_tva    = $soumis ? $taux : null;
        $depense->montant_ht  = $ht;
        $depense->montant_tva = $tva;
        $depense->montant_ttc = $ttc;
        $depense->save();
        
        return redirect()->back()->with('ok', 'Depense modifiée.');
        
    }

 
}
