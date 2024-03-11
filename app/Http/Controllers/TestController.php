<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contactx;
use App\Models\Individux;
use App\Models\Entitex;

use App\Models\Contact;
use App\Models\Individu;
use App\Models\Entite;
use App\Models\TypeContact;

class TestController extends Controller
{
    
    
    /**
    * Page index 
    */
    public function index(){   
        $individus = Individu::all();
        $entites = Entite::all();
        
        foreach ($individus as $individu) {
        
            if($individu->telephone_fixe){              
                         
                $individu->indicatif_fixe = "+33";
            }else{
                $individu->indicatif_fixe = null;
            }
            
            if($individu->telephone_mobile){    
                         
                $individu->indicatif_mobile = "+33";
            }else{
                $individu->indicatif_mobile = null;
            }
            
            
            $individu->update();
        }
        
        
        foreach ($entites as $entite) {
            
            if($entite->telephone_fixe){              
                         
                $entite->indicatif_fixe = "+33";
            }else{
                $entite->indicatif_fixe = null;
            }
            
            if($entite->telephone_mobile){    
                         
                $entite->indicatif_mobile = "+33";
            }else{
                $entite->indicatif_mobile = null;
            }
            
            $entite->update();
        }
        return view('index_test');
    
    }
    
    
    /**
    * Import de contacts depuis minipilote 
    */
    public function importContact(){   
        
        $contactxs = Contactx::all();
        $entitexs = Entitex::all();
        $individuxs = Individux::all();
        
       
        
        foreach ($contactxs as $contactx) {
            
            
            $contact = Contact::create([            
                "user_id" => 1,
                "type" => $contactx->type == "individu" ? "individu" : "entite" ,
                "nature" => $contactx->type == "individu" ? "Personne physique" : "Personne morale",   
                "created_at" => $contactx->created_at,        
                "updated_at" => $contactx->updated_at,    
            ]);
            
            if($contactx->est_client){
                $contact->typeContacts()->attach(2);
            }
            if($contactx->est_prospect){
                $contact->typeContacts()->attach(1);
            }
            if($contactx->est_fournisseur){
                $contact->typeContacts()->attach(3);
            }
           
            
            
        }
        
        
        foreach ($entitexs as $entitex) {
        
            $entite = Entite::create([            
                "type" => $entitex->type,
                "email" => $entitex->email,
                "nom" => $entitex->nom,
                "telephone_fixe" => $entitex->contact1,
                "telephone_mobile" => $entitex->contact2,
                "numero_voie" => $entitex->numero_voie,
                "nom_voie" => $entitex->adresse,
                "code_postal" => $entitex->code_postal,
                "ville" => $entitex->ville,
                "pays" => "France",               
                
                "forme_juridique" => $entitex->forme_juridique,
                "raison_sociale" => $entitex->nom,                
                "contact_id" => $entitex->contact_id,        
                "created_at" => $entitex->created_at,        
                "updated_at" => $entitex->updated_at,        
            ]);
        }
        
        
        foreach ($individuxs as $individux) {
        
            $individu = Individu::create([            
                "email" => $individux->email,
                "contact_id" => $individux->contact_id,
                "nom" => $individux->nom,
                "prenom" => $individux->prenom,
                
                "telephone_fixe" => $individux->contact1,
                "telephone_mobile" => $individux->contact2,
                "numero_voie" => $individux->numero_voie,
                "nom_voie" => $individux->adresse,
                "code_postal" => $individux->code_postal,
                "ville" => $individux->ville,
                "pays" => "France",  
                "created_at" => $individux->created_at,        
                "updated_at" => $individux->updated_at,    
                
            ]);
            
            
            
            
        }
        return view('index_test');
    
    }
}
