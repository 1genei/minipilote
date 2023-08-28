<?php

namespace App\Http\Controllers;

use App\Models\Categorieproduit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

class CategorieproduitController extends Controller
{
    public function store(Request $request){

        try {
            $this->validate($request, [
                'nom' => 'string|required',
                'parent_id' => 'string|nullable',
                'description' => 'string|nullable'
            ]);
        } catch (ValidationException $e) {
            return redirect()->route('parametre.produit')->withErrors(['categorie' => $e->validator->errors()]);
        }

        $niveau = 1;
        $archive = false;

        if ($request->parent_id != null) {
            $request->parent_id = (int) $request->parent_id;
            $parent = Categorieproduit::where('id', $request->parent_id)->first();
            $niveau += $parent->niveau;
            $archive = $parent->archive;
        }

        Categorieproduit::create([
            "nom" => $request->nom,
            "parent_id" => $request->parent_id,
            "description" => $request->description,
            "niveau" => $niveau,
            "archive" => $archive,
        ]);

        return redirect()->route('parametre.produit')->with('message', 'Nouvelle catégorie ajoutée');
    }

    public function update(Request $request, $categorieId){

        $categorie = Categorieproduit::where('id', Crypt::decrypt($categorieId))->first();
        $request->validate([
            'nom' => 'string|required',
            'parent_id' => 'string|nullable',
            'description' => 'string|nullable'
        ]);
    
        $niveau = 1;
        $archive = $categorie->archive;
    
        if ($request->parent_id != null) {
            $request->parent_id = (int) $request->parent_id;
            $parent = Categorieproduit::where('id', $request->parent_id)->first();
            if ($parent->estFils($categorie) || $parent->id == $categorie->id) {
                return redirect()->route('parametre.produit')->withErrors(['categorie' => 'Catégorie parent invalide']);
            }
            $niveau += $parent->niveau;
            $archive = $parent->archive || $archive;
        }
        
        $categorie->nom = $request->nom;
        $categorie->parent_id = $request->parent_id;
        $categorie->description = $request->description;
        $categorie->niveau = $niveau;
        $categorie->archive = $archive;
        $categorie->update();

        $this->updateSsCategorie($categorie);
      
        return redirect()->route('parametre.produit')->with('message', 'Catégorie modifiée');
    }    

    protected function updateSsCategorie($categorie) {
        foreach ($categorie->sscategories as $sscategorie) {
            $sscategorie->niveau = $categorie->niveau + 1;
            $sscategorie->save();
            $this->archiveSscategorie($sscategorie);
        }
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
