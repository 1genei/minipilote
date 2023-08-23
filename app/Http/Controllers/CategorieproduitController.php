<?php

namespace App\Http\Controllers;

use App\Models\Categorieproduit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CategorieproduitController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'nom' => 'string|required',
        ]);

        Categorieproduit::create([
            "type" => $request->type
        ]);

        return redirect()->route('parametre.contact')->with('message', 'Nouveau type de contact ajouté');
    }

    public function update(Request $request, $categorieId){

        $type = Categorieproduit::where('id', Crypt::decrypt($categorieId))->first();
        if($type->type != $request->type){
            $request->validate([
                'type' => 'string|required',
            ]);
        }
        
        $type->type = $request->type;
        $type->update();
      
        return redirect()->route('parametre.contact')->with('message', 'Type de contact modifié');
    }

    public function archive($categorie_id) {
        $categorie = Categorieproduit::find(Crypt::decrypt($categorie_id));
    
        if (!$categorie) {
            return response(404);
        }
    
        $this->archiveSsCategorie($categorie);
    
        return response(200);
    }
    
    protected function archiveSsCategorie($category) {
        $category->archive = true;
        $category->save();
    
        foreach ($category->sscategories as $sscategorie) {
            $this->archiveSscategorie($sscategorie);
        }
    }

    public function unarchive($categorie_id) {
        $categorie = Categorieproduit::find(Crypt::decrypt($categorie_id));
    
        if (!$categorie) {
            return response(404);
        }

        if ($categorie->parent && $categorie->parent->archive) {
            return response(400);
        }
    
        $this->unarchiveSsCategorie($categorie);
    
        return response(200);
    }

    protected function unarchiveSsCategorie($categorie) {
        $categorie->archive = false;
        $categorie->save();
    
        foreach ($categorie->sscategories as $sscategorie) {
            $this->unarchiveSsCategorie($sscategorie);
        }
    }
}
