<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametre;
use App\Models\Typecontact;
use App\Models\Categorieproduit;
use App\Models\Poste;


class ParametreController extends Controller
{
    
    /**
    *   affichage de la page des paramètres
    */
    public function index(){
        
        $parametre = Parametre::first();
        // dd($parametre);
  
        return view('parametres.index', compact('parametre'));
    
    }
    
    /**
    *   affichage de la page des paramètres des contacts
    */
    public function contact(){

        $types = Typecontact::all();
        $postes = Poste::all();
       
        return view('parametres.contact.index', compact('types', 'postes'));
    
    }
    
    /**
    *   affichage de la page des paramètres des produits
    */
    public function produit(){
        
        // catégorie, type, famille
        $categories = Categorieproduit::all();
        
        return view('parametres.produit.index', compact('categories'));
    
    }
    
   
    
    
    /**
    *   affichage de la page des paramètres
    */
    public function update(Request $request){
        
        $parametre = Parametre::first();
        

        
        if($parametre != null){
        
            $parametre->seuil_alerte = $request->seuil_alerte;
            $parametre->heure_delais_achat = $request->heure_delais_achat;
            $parametre->heure_ouverture = $request->heure_ouverture;
            $parametre->heure_fermeture = $request->heure_fermeture;
            $parametre->heure_fixe_achat = $request->heure_fixe_achat;
            $parametre->heure_fixe_vente = $request->heure_fixe_vente;
            $parametre->heure_cloture_titre = $request->heure_cloture_titre;
        
        }else{
        
            Parametre::create([
                "seuil_alerte" => $request->seuil_alerte,
                "heure_delais_achat" => $request->heure_delais_achat,
                "heure_ouverture" => $request->heure_ouverture,
                "heure_fermeture" => $request->heure_fermeture,
                "heure_fixe_achat" => $request->heure_fixe_achat,
                "heure_fixe_vente" => $request->heure_fixe_vente,
                "heure_cloture_titre" => $request->heure_cloture_titre,
            ]);
        }
        
        
        return redirect()->route('parametre.index')->with('ok', 'Vos paramètres ont été ajouté');
    
    }
    
}
