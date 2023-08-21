<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poste;
use Illuminate\Support\Facades\Crypt;

class PosteController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'poste' => 'string|required|unique:postes,nom',
        ]);

        $types = Poste::all();
        Poste::create([
            "nom" => $request->poste
        ]);

        return redirect()->route('parametre.contact')->with('message', 'Nouveau poste ajouté');
    }

    public function update(Request $request, $posteId){

        $poste = Typecontact::where('id', Crypt::decrypt($posteId))->first();
        if($poste->nom != $request->poste){
            $request->validate([
                'poste' => 'string|required|unique:typecontacts,type',
            ]);
        }
        
        $poste->nom = $request->poste;
        $poste->update();
      
        return redirect()->route('parametre.contact')->with('message', 'Poste modifié');
    }

    public function archive($poste_id) {

        $poste = Poste::where('id', Crypt::decrypt($poste_id))->first();
        $poste->archive = true;
        $poste->update();
        
        return "200";
    }

    public function unarchive($poste_id) {

        $poste = Poste::where('id', Crypt::decrypt($poste_id))->first();
        $poste->archive = false;
        $poste->update();
        
        return "200";
    }
}
