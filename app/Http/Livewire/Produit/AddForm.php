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
public $tvas;
public $tva_id;
public $tva;
public $tva_valeur;

public $quantite;
public $quantite_min_vente;
public $gerer_stock;
public $seuil_alerte_stock;
public $caracteristiques;
    
    public function render()
    {
        // $this->type = "simple";
        $this->nature = "Prestation de service";
        $this->tva= \App\Models\Tva::where('est_principal',1)->first();
        $this->tva_id = $this->tva->id;
        $this->tva_valeur = $this->tva->taux;
        
       
        return view('livewire.produit.add-form');
    }
    
    
    /**
    * Validation des champs
    */
    public function rules()
    {
        
        if($this->type == "declinaison"){
        
            return [
                'nom' => 'required|string|unique:produits',
                'type' => 'required',
                'nature' => 'required',                             
                'categories_id' => 'required',              
            ];
        
        }else{
        
           
            return [
                'nom' => 'required|string|unique:produits',
                'type' => 'required',
                'nature' => 'required',
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
