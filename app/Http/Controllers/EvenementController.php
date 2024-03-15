<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Evenement;
use  App\Models\Circuit;
use  App\Models\Prestation;
use  App\Models\Contact; 
use Crypt;


class EvenementController extends Controller
{
    /*
    * Liste des évènements
    */
    public function index()
    {
        $evenements = Evenement::where('archive', 0)->get();
        return view('evenement.index', compact('evenements'));
    }
    
    /*
    * Archive des évènements
    */
    public function archive()
    {
        $evenements = Evenement::where('archive', 1)->get();
        return view('evenement.archive', compact('evenements'));
    }
    
    /*
    * Afficher un evenement
    */
    public function show($evenement_id)
    {
        $evenement = Evenement::find(Crypt::decrypt($evenement_id));
        
        $derniere_prestation = Prestation::orderBy('created_at', 'desc')->first();
        $prochain_numero_prestation = $derniere_prestation->numero + 1;
        $beneficiaires = Contact::where([['archive', false], ['type', 'individu']])->get();
        $contactclients = Contact::where('archive', false)->get();
        
        return view('evenement.show', compact('evenement', 'prochain_numero_prestation','beneficiaires', 'contactclients'));
    }
    
    /*
    * Créer un évènement
    */
    public function create()
    {
        $circuits = Circuit::where('archive', 0)->get();
        return view('evenement.add', compact('circuits'));
    }
    
    /*
    * Modifier un evenement
    */
    public function edit($evenement_id)
    {
        $circuits = Circuit::where('archive', 0)->get();
        $evenement = Evenement::find(Crypt::decrypt($evenement_id));
        return view('evenement.edit', compact('evenement', 'circuits'));
    }
    
    /*
    * Enregistrer un nouvel évènement
    */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            
        ]);
        
        $evenement = new Evenement();
        $evenement->nom = $request->input('nom');
        $evenement->circuit_id = $request->input('circuit_id');
        $evenement->date_debut = $request->input('date_debut');
        $evenement->date_fin = $request->input('date_fin');
        $evenement->description = $request->input('description');
        
        $evenement->save();
        return redirect()->route('evenement.index')->with('ok', 'Evenement enregistré avec succes.');
    }
    
    /*
    * Mettre à jour un evenement
    */
    public function update(Request $request, $evenement_id)
    {
        $evenement = Evenement::find(Crypt::decrypt($evenement_id));
        $evenement->nom = $request->input('nom');
        $evenement->circuit_id = $request->input('circuit_id');
        $evenement->date_debut = $request->input('date_debut');
        $evenement->date_fin = $request->input('date_fin');
        $evenement->description = $request->input('description');        
        $evenement->save();
        return redirect()->route('evenement.index')->with('ok', 'Evenement mis à jour avec succes.');
        
    }
}
