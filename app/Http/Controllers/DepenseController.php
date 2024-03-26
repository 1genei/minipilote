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
            "type" => "required",
            "libelle" => "required",
            "montant" => "required",
        ]);
        
        $depense = new depense();
        $depense->type = $request->type;
        $depense->evenement_id = $request->evenement_id;
        $depense->libelle = $request->libelle;
        $depense->montant = $request->montant;
        $depense->description = $request->description;
        $depense->date_depense = $request->date;
        $depense->user_id = Auth::user()->id;
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
        $depense = depense::findOrFail($depense_id);
        $depense->type = $request->type;
        $depense->libelle = $request->libelle;
        $depense->montant = $request->montant;
        $depense->description = $request->description;
        $depense->date_depense = $request->date;
        $depense->save();
        
        return redirect()->back()->with('ok', 'Depense modifiée.');
        
    }

 
}
