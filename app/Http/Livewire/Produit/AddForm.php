<?php

namespace App\Http\Livewire\Produit;
use Livewire\WithFileUploads;

use Livewire\Component;

class AddForm extends Component
{

public $type;
public $nom;
public $description;
public $images;
public $categories;
public $categories_id = [];

public $fiche_technique;
public $marque;
public $prix_vente_ht;
public $prix_vente_ttc;
public $prix_vente_max_ht;
public $prix_vente_max_ttc;
public $prix_achat_ht;
public $prix_achat_ttc;
public $prix_achat_commerciaux_ht;
public $prix_achat_commerciaux_ttc;

public $quantite;
public $quantite_min_vente;
public $gerer_stock;
public $seuil_alerte_stock;

    
    public function render()
    {
   
        return view('livewire.produit.add-form');
    }
    
    
    /**
    * Validation des champs
    */
    public function rules()
    {
    
// dd($this->categories_id);

        if ($this->type == "simple") {

            return [
                'type' => 'required',
                'nom' => 'required|string|unique:produits',
                'prix_vente_ht' => 'required',
                'prix_vente_ttc' => 'required',                
                'categories_id' => 'required',
              
            ];

        } else {

            return [
                'type' => 'required',
                'nom' => 'required|string|unique:produits',
                'prix_vente_ht' => 'required',
                'prix_vente_ttc' => 'required',                
                'categories_id' => 'required',
                
            ];

        }

    }

    public function submit()
    {

        $this->validate();
    }
}
