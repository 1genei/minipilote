<?php

namespace App\Http\Controllers;

use App\Models\Caracteristique;
use App\Models\Valeurcaracteristique;

use Illuminate\Http\Request;
use Crypt;

class CaracteristiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        $caracteristiques = Caracteristique::all();
        return view('caracteristiques.index', compact('caracteristiques'));
    }

    public function archives()
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nom" => "required|unique:caracteristiques"
        ]);
        
        Caracteristique::create([
            "nom" => $request->nom
        ]);
        
        return redirect()->back()->with('ok','Nouvelle caractéristique ajoutée, vous pouvez ajouter ses valaurs');
     
    }

    /**
     * Display the specified resource.
     */
    public function show($caracteristique_id)
    {
        $caracteristique = Caracteristique::where('id', Crypt::decrypt($caracteristique_id))->first();
        
        return view('caracteristiques.show', compact('caracteristique'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Caracteristique $caracteristique)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $caracteristique_id)
    {
        $caracteristique = Caracteristique::where('id', Crypt::decrypt($caracteristique_id))->first();
        
        if($request->nom != $caracteristique->nom){
            $request->validate([
                "nom" => "required|unique:caracteristiques"
            ]);
            
        }else{
            $request->validate([
                "nom" => "required"
            ]);
            
        }
        
        
        $caracteristique->nom = $request->nom;
        $caracteristique->update();
        
        return redirect()->back()->with('ok','Caractéristique modifiée');
        
    }

    /**
     * Suppression de la caractéristique
     */
    public function destroy($caracteristique_id)
    {
        $caracteristique = Caracteristique::where('id', Crypt::decrypt($caracteristique_id))->first();
        
        $caracteristique->destroy();
        
        return "ok";
    }
    
     /**
     * Archivage de la caractéristique
     */
    public function archive($caracteristique_id)
    {
        $caracteristique = Caracteristique::where('id', Crypt::decrypt($caracteristique_id))->first();
        $caracteristique->archive = true;
        $caracteristique->update();
        
        return redirect()->back()->with('ok','Caractéristique archivée');

    }
    
    /**
     * Désarchivage de la caractéristique
     */
    public function unarchive($caracteristique_id)
    {
        $caracteristique = Caracteristique::where('id', Crypt::decrypt($caracteristique_id))->first();
        $caracteristique->archive = false;
        $caracteristique->update();
        
        return redirect()->back()->with('ok','Caractéristique désarchivée');

    }
    
    
    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store_valeur(Request $request)
    {
        $request->validate([
            "nom" => "required"
        ]);
        
        Valeurcaracteristique::create([
            "caracteristique_id" => $request->caracteristique_id,
            "nom" => $request->nom,
            "valeur" => $request->valeur
        ]);
        
        return redirect()->back()->with('ok','Nouvelle valeur ajoutée');
     
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update_valeur(Request $request, $valeur_id)
    {
        $valeur = Valeurcaracteristique::where('id', Crypt::decrypt($valeur_id))->first();
        
        $request->validate([
            "nom" => "required"
        ]);
  
        
        
        $valeur->nom = $request->nom;
        $valeur->valeur = $request->valeur;
        
        $valeur->update();
        
        return redirect()->back()->with('ok','Valeur modifiée');
        
    }

    /**
     * Suppression de la caractéristique
     */
    public function destroy_valeur($caracteristique_id)
    {
        $caracteristique = Caracteristique::where('id', Crypt::decrypt($caracteristique_id))->first();
        
        $caracteristique->destroy();
        
        return "ok";
    }
    
     /**
     * Archivage de la caractéristique
     */
    public function archive_valeur($caracteristique_id)
    {
        $caracteristique = Valeurcaracteristique::where('id', Crypt::decrypt($caracteristique_id))->first();
        $caracteristique->archive = true;
        $caracteristique->update();
        
        return redirect()->back()->with('ok','Valeur archivée');

    }
    
    /**
     * Désarchivage de la caractéristique
     */
    public function unarchive_valeur($caracteristique_id)
    {
        $caracteristique = Valeurcaracteristique::where('id', Crypt::decrypt($caracteristique_id))->first();
        $caracteristique->archive = false;
        $caracteristique->update();
        
        return redirect()->back()->with('ok','Valeur désarchivée');

    }
}
