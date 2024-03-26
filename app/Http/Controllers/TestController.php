<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    
    

}
