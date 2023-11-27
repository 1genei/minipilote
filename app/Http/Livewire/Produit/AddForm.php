<?php

namespace App\Http\Livewire\Produit;
use Livewire\WithFileUploads;

use Livewire\Component;

class AddForm extends Component
{
    use WithFileUploads;


public $nom;
public $description;
public $images;
public $categories;
public $categories_id = [];

public $fiche_technique;
public $reference;
public $marque;
public $type;
public $nature;
public $marques;
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
        $this->type = "simple";
        $this->nature = "Matériel";
        return view('livewire.produit.add-form');
    }
    
    
    /**
    * Validation des champs
    */
    public function rules()
    {

        return [
            'nom' => 'required|string|unique:produits',
            'reference' => 'required|string|unique:produits',
            'type' => 'required',
            'nature' => 'required',
            'prix_vente_ht' => 'required',
            'prix_vente_ttc' => 'required',                
            'categories_id' => 'required',
          
        ];

    

    }

    public function submit()
    {

        $this->validate();
    }
}
