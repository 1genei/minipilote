<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Societe;
use Illuminate\Support\Facades\Crypt;

class SocieteController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'raison_sociale' => 'required|string',
            'numero_siret' => 'required|string',
            //'logo' => 'string|nullable',
            'capital' => 'required|string',
            'gerant' => 'required|string',
            'numero_tva' => 'required|string',
            'email' => 'required|string',
            'telephone' => 'required|string',
            
            'numero_voie' => 'string',
            'nom_voie' => 'string',
            'complement_voie' => 'string',
            'code_postal' => 'string',
            'ville' => 'string',
            'pays' => 'string',
            'code_insee' => 'string',
            'code_cedex' => 'string',
            'numero_cedex' => 'string',
            'boite_postale' => 'string',
            'residence' => 'string',
            'batiment' => 'string',
            'escalier' => 'string',
            'etage' => 'string',
            'porte' => 'string',
        ]);
        Societe::create([
            'raison_sociale' => $request->raison_sociale,
            'numero_siret' => $request->numero_siret,
            //'logo' => $request->logo,
            'capital' => $request->capital,
            'gerant' => $request->gerant,
            'numero_tva' => $request->numero_tva,
            'email' => $request->email,
            'telephone' => $request->telephone,
            "numero_voie" => $request->numero_voie,
            "nom_voie" => $request->nom_voie,
            "complement_voie" => $request->complement_voie,
            "code_postal" => $request->code_postal,
            "ville" => $request->ville,
            "pays" => $request->pays,
            "code_insee" => $request->code_insee,
            "code_cedex" => $request->code_cedex,
            "numero_cedex" => $request->numero_cedex,
            "boite_postale" => $request->boite_postale,
            "residence" => $request->residence,
            "batiment" => $request->batiment,
            "escalier" => $request->escalier,
            "etage" => $request->etage,
            "porte" => $request->porte, 
            'est_societe_principale' => false,
            'archive' => false
        ]);

        return redirect()->route('parametre.index')->with('message', 'Société ajoutée');
    }

    public function update(Request $request, $societeId){
        $request->validate([
            'raison_sociale' => 'required|string',
            'numero_siret' => 'required|string',
            //'logo' => 'string|nullable',
            'capital' => 'required|string',
            'gerant' => 'required|string',
            'numero_tva' => 'required|string',
            'email' => 'required|string',
            'telephone' => 'required|string',
            'numero_voie' => 'string',
            'nom_voie' => 'string',
            'complement_voie' => 'string',
            'code_postal' => 'string',
            'ville' => 'string',
            'pays' => 'string',
            'code_insee' => 'string',
            'code_cedex' => 'string',
            'numero_cedex' => 'string',
            'boite_postale' => 'string',
            'residence' => 'string',
            'batiment' => 'string',
            'escalier' => 'string',
            'etage' => 'string',
            'porte' => 'string',
        ]);
        $societe = Societe::where('id', Crypt::decrypt($societeId))->first();
        
        $societe->raison_sociale = $request->raison_sociale;
        $societe->numero_siret = $request->numero_siret;
        //$societe->logo = $request->logo;
        $societe->capital = $request->capital;
        $societe->gerant = $request->gerant;
        $societe->numero_tva = $request->numero_tva;
        $societe->email = $request->email;
        $societe->telephone = $request->telephone;
        $societe->numero_voie = $request->numero_voie;
        $societe->nom_voie = $request->nom_voie;
        $societe->complement_voie = $request->complement_voie;
        $societe->code_postal = $request->code_postal;
        $societe->ville = $request->ville;
        $societe->pays = $request->pays;
        $societe->code_insee = $request->code_insee;
        $societe->code_cedex = $request->code_cedex;
        $societe->numero_cedex = $request->numero_cedex;
        $societe->boite_postale = $request->boite_postale;
        $societe->residence = $request->residence;
        $societe->batiment = $request->batiment;
        $societe->escalier = $request->escalier;
        $societe->etage = $request->etage;
        $societe->porte = $request->porte;
        $societe->update();
        
        return redirect()->route('parametre.index')->with('message', 'Société modifiée');
    }

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

    public function archive($societeId) {
        $societe = Societe::where('id', Crypt::decrypt($societeId))->first();
        $societe->archive = true;
        $societe->update();
        return redirect()->route('parametre.index')->with('message', 'Société archivée');
    }

    public function unarchive($societeId) {
        $societe = Societe::where('id', Crypt::decrypt($societeId))->first();
        $societe->archive = false;
        $societe->update();
        return redirect()->route('parametre.index')->with('message', 'Société restaurée');
    }
}
