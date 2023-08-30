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
            'logo' => 'required|string',
            'capital' => 'required|integer',
            'gerant' => 'required|string',
            'numero_tva' => 'required|string',
            'email' => 'required|string',
            'telephone' => 'required|string',
            'adresse' => 'required|string',
            'complement_adresse' => 'required|string|nullable',
            'ville' => 'required|string',
            'code_postal' => 'required|string',
            'pays' => 'required|string',
        ]);
        Societe::create([
            'raison_sociale' => $request->raison_sociale,
            'numero_siret' => $request->numero_siret,
            'logo' => $request->logo,
            'capital' => $request->capital,
            'gerant' => $request->gerant,
            'numero_tva' => $request->numero_tva,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'complement_adresse' => $request->complement_adresse,
            'ville' => $request->ville,
            'code_postal' => $request->code_postal,
            'pays' => $request->pays,
            'est_societe_principale' => false,
            'archive' => false
        ]);

        return redirect()->route('parametere.index')->with('message', 'Société ajoutée');
    }

    public function update(Request $request, $societeId){
        $request->validate([
            'raison_sociale' => 'required|string',
            'numero_siret' => 'required|string',
            'logo' => 'required|string',
            'capital' => 'required|integer',
            'gerant' => 'required|string',
            'numero_tva' => 'required|string',
            'email' => 'required|string',
            'telephone' => 'required|string',
            'adresse' => 'required|string',
            'complement_adresse' => 'required|string|nullable',
            'ville' => 'required|string',
            'code_postal' => 'required|string',
            'pays' => 'required|string',
        ]);
        $societe = Societe::where('id', Crypt::decrypt($societeId))->first();
        
        $societe->raison_sociale = $request->raison_sociale;
        $societe->numero_siret = $request->numero_siret;
        $societe->logo = $request->logo;
        $societe->capital = $request->capital;
        $societe->gerant = $request->gerant;
        $societe->numero_tva = $request->numero_tva;
        $societe->email = $request->email;
        $societe->telephone = $request->telephone;
        $societe->adresse = $request->adresse;
        $societe->complement_adresse = $request->complement_adresse;
        $societe->ville = $request->ville;
        $societe->code_postal = $request->code_postal;
        $societe->pays = $request->pays;
        $societe->update();
        
        return redirect()->route('parametre.index')->with('message', 'Société modifiée');
    }

    public function setPrincipale(Request $request, $societeId) {
        $principale = Societe::where('est_societe_principale', true)->first();
        $societe = Societe::where('id', $societeId)->first();
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
