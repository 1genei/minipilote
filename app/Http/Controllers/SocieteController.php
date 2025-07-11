<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Societe;
use Illuminate\Support\Facades\Crypt;

class SocieteController extends Controller
{

    /**
    * Enregistrer une société
    */
    public function store(Request $request){
        
       
        $request->validate([
            'raison_sociale' => 'required|string',
            'email' => 'required|string',          
           
        ]);
        
    
        Societe::create([
            'raison_sociale' => $request->raison_sociale,
            'numero_siret' => $request->numero_siret,
            //'logo' => $request->logo,
            'forme_juridique' => $request->forme_juridique,
            'capital' => $request->capital,
            'gerant' => $request->gerant,
            'numero_tva' => $request->numero_tva,
            'email' => $request->email,
            'indicatif' => $request->indicatif,
            'telephone' => $request->telephone,
            "numero_voie" => $request->numero_voie,
            "nom_voie" => $request->nom_voie,
            "complement_voie" => $request->complement_voie,
            "code_postal" => $request->code_postal,
            "ville" => $request->ville,
            "pays" => $request->pays,
            "notes" => $request->notes,
            'banque' => $request->banque,
            'iban' => $request->iban,
            'bic' => $request->bic,
            'rib' => $request->rib,
            'numero_rcs' => $request->numero_rcs,
            'ville_rcs' => $request->ville_rcs,
            'est_societe_principale' => false,
            'archive' => false
        ]);

        return redirect()->route('parametre.index')->with('message', 'Société ajoutée');
    }


    /**
    * Modifier une société
    */
    public function update(Request $request, $societeId){
    
        $request->validate([
            'raison_sociale' => 'required|string',
            'email' => 'required|string',
    
        ]);
        $societe = Societe::where('id', Crypt::decrypt($societeId))->first();
        
        $societe->raison_sociale = $request->raison_sociale;
        $societe->numero_siret = $request->numero_siret;
        $societe->forme_juridique = $request->forme_juridique;
        //$societe->logo = $request->logo;
        $societe->capital = $request->capital;
        $societe->gerant = $request->gerant;
        $societe->numero_tva = $request->numero_tva;
        $societe->email = $request->email;
        $societe->indicatif = $request->indicatif;
        $societe->telephone = $request->telephone;
        $societe->numero_voie = $request->numero_voie;
        $societe->nom_voie = $request->nom_voie;
        $societe->complement_voie = $request->complement_voie;
        $societe->code_postal = $request->code_postal;
        $societe->ville = $request->ville;
        $societe->pays = $request->pays;
        $societe->notes = $request->notes;
        $societe->banque = $request->banque;
        $societe->iban = $request->iban;
        $societe->bic = $request->bic;
        $societe->rib = $request->rib;
        $societe->numero_rcs = $request->numero_rcs;
        $societe->ville_rcs = $request->ville_rcs;
        $societe->update();
        
        return redirect()->route('parametre.index')->with('message', 'Société modifiée');
    }



    /**
    * Ajouter une société comme société principale
    */
    public function setPrincipale(Request $request, $societeId) {
        $principale = Societe::where('est_societe_principale', true)->first();
        $societe = Societe::where('id', Crypt::decrypt($societeId))->first();
        if ($societe->archive) {
            return redirect()->route('parametre.index')->withErrors(['societe' => 'La catégorie sélectionnée est archivée']);
        }
        $principale->est_societe_principale = false;
        $principale->update();

        $societe->est_societe_principale = true;
        $societe->update();

        return redirect()->route('parametre.index')->with('message', 'Société principale changée');
    }


    /**
    * Archiver une société
    *
    */
    public function archive($societeId) {
        $societe = Societe::where('id', Crypt::decrypt($societeId))->first();
        $societe->archive = true;
        $societe->update();
        return redirect()->route('parametre.index')->with('message', 'Société archivée');
    }

    /**
    * Desarchiver une société
    *
    */
    public function unarchive($societeId) {
        $societe = Societe::where('id', Crypt::decrypt($societeId))->first();
        $societe->archive = false;
        $societe->update();
        return redirect()->route('parametre.index')->with('message', 'Société restaurée');
    }
}
