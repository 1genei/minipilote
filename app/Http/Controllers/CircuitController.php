<?php

namespace App\Http\Controllers;

use App\Models\Circuit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CircuitController extends Controller
{
    /**
     * Afficher les circuits.
     */
    public function index()
    {
        $circuits = Circuit::where('archive', false)->get();
        return view('parametres.circuit.index', compact('circuits'));
    }

    /**
    * Affiche les archives
    */
    public function archives()
    {
        $circuits = Circuit::where('archive', true)->get();
        return view('parametres.circuit.archive', compact('circuits'));
    }
    
    
    
   
    /**
     * Entrepose un nouveau circuit .
    */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|unique:circuits,nom',
        ]);
        Circuit::create($request->all());
        return redirect()->route('circuit.index')->with('success', 'Circuit créé avec succès.');
    }

    /**
     * Afficher le détail d'un circuit.
     */
    public function show(Circuit $circuit)
    {
        //
    }

  

    /**
     * Modifier un circuit.
     */
    public function update(Request $request, $circuit_id)
    {
        $circuit = Circuit::where('id', Crypt::decrypt($circuit_id))->first();
        $request->validate([
            'nom' => 'required|unique:circuits,nom,'.$circuit->id,
        ]);
        $circuit->update($request->all());
        return redirect()->route('circuit.index')->with('success', 'Circuit modifié avec succès.');
    }

    
        /**
     * Archiver une circuit.
     */
    public function archiver($circuit_id)
    {
        $circuit = Circuit::where('id', Crypt::decrypt($circuit_id))->first();
        $circuit->archive = true;
        $circuit->save();
        return true ;
    }
    
    /**
     * Désarchiver une circuit.
     */
    public function desarchiver($circuit_id)
    {
        $circuit = Circuit::where('id', Crypt::decrypt($circuit_id))->first();
        $circuit->archive = false;
        $circuit->save();
        return true ;
    }
}
