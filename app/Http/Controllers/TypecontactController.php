<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Typecontact;
use Illuminate\Support\Facades\Crypt;

class TypecontactController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'type' => 'string|required|unique:typecontacts,type',
        ]);

        Typecontact::create([
            "type" => $request->type
        ]);

        return redirect()->route('parametre.contact')->with('message', 'Nouveau type de contact ajouté');
    }

    public function update(Request $request, $typeId){

        $type = Typecontact::where('id', Crypt::decrypt($typeId))->first();
        if($type->type != $request->type){
            $request->validate([
                'type' => 'string|required|unique:typecontacts,type',
            ]);
        }
        
        $type->type = $request->type;
        $type->update();
      
        return redirect()->route('parametre.contact')->with('message', 'Type de contact modifié');
    }

    public function archive($type_id) {

        $type = Typecontact::where('id', Crypt::decrypt($type_id))->first();
        $type->archive = true;
        $type->update();
        
        return "200";
    }

    public function unarchive($type_id) {

        $type = Typecontact::where('id', Crypt::decrypt($type_id))->first();
        $type->archive = false;
        $type->update();
        
        return "200";
    }
}
