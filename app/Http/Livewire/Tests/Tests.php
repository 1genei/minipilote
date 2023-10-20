<?php

namespace App\Http\Livewire\Tests;

use Livewire\Component;
use App\Models\Produit;
use Livewire\WithPagination;

class Tests extends Component
{
    use WithPagination;

public $titre ;
public $description;


public function afficher_produit($id){
        
    $produit = Produit::where('id', $id)->first();
    $this->titre = $produit->nom;
    $this->description = $produit->description;
}

    public function render()
    {
    
        $produits = Produit::where([['archive', false],['type','simple']])->paginate(1);
    
        return view('livewire.tests.tests')->with([
            "produits" => $produits,
            "titre" => $this->titre,
            "description" => $this->description
        ]);
    }
    
   
}
