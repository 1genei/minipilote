<?php

namespace App\Http\Livewire\Produit;
use Livewire\WithFileUploads;

use Livewire\Component;

class EditForm extends Component
{
    use WithFileUploads;

    public $type;
    public $nature;
    public $nom;
    public $reference;
    public $description;
    public $images;
    public $categories;
    public $categories_id = [];
    
    public $fiche_technique;
    public $marque;
    public $marques;
    public $a_declinaison;
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
    public $produit;
    public $caracteristiques;
    public $modelevoitures;
    public $circuits;
        
    public function mount(){
    
        $this->type = $this->produit->type;
        $this->nature = $this->produit->nature;
        $this->reference = $this->produit->reference;
        $this->nom = $this->produit->nom;
        $this->description = $this->produit->description;
        $this->images = $this->produit->images;
        $this->categories_id = $this->produit->categorieproduitsId();
        $this->tva_id = $this->produit->tva_id != null ? $this->produit->tva_id : '';
        $this->tva = $this->produit->tva_id != null ? $this->produit->tva?->taux : 0;
        
        $this->fiche_technique = $this->produit->fiche_technique;
        $this->a_declinaison = $this->produit->a_declinaison;
        $this->marque = $this->produit->marque_id;
        $this->prix_vente_ht = $this->produit->prix_vente_ht;
        $this->prix_vente_ttc = $this->produit->prix_vente_ttc;
        $this->prix_vente_max_ht = $this->produit->prix_vente_max_ht;
        $this->prix_vente_max_ttc = $this->produit->prix_vente_max_ttc;
        $this->prix_achat_ht = $this->produit->prix_achat_ht;
        $this->prix_achat_ttc = $this->produit->prix_achat_ttc;
        $this->prix_achat_commerciaux_ht = $this->produit->prix_achat_commerciaux_ht;
        $this->prix_achat_commerciaux_ttc = $this->produit->prix_achat_commerciaux_ttc;
        
        $this->quantite =  $this->produit->gerer_stock == true ? $this->produit->stock->quantite : null;
        $this->quantite_min_vente =  $this->produit->gerer_stock == true ? $this->produit->stock->quantite_min : null;
        $this->gerer_stock = $this->produit->gerer_stock;
        $this->seuil_alerte_stock =  $this->produit->gerer_stock == true ? $this->produit->stock->seuil_alerte : null;
    
    }
    
    public function render()
    {
        $this->tva= \App\Models\Tva::where('est_principal',1)->first();
        $this->tva_valeur = $this->tva->taux;
        
        return view('livewire.produit.edit-form');
    }
    
    
    /**
    * Validation des champs
    */
    public function rules()
    {
    
       
        if($this->a_declinaison == false){
            $require = [             
                'nature' => 'required',
                'prix_vente_ht' => 'required',
                'prix_vente_ttc' => 'required',                
                'fiche_technique' => 'file:pdf'
            ];
        }
        else{
        
            $require = [                
                'nature' => 'required',                         
                'fiche_technique' => 'file:pdf'
            ];
        }
        
       
        if($this->nom == $this->produit->nom){
            $require = array_merge($require,['nom' => 'required|string']);
        }
        else{
            $require = array_merge($require,['nom' => 'required|string|unique:produits']);
        }
        
        
        // if($this->reference == $this->produit->reference){
        //     $require = array_merge($require,['reference' => 'string']);
        // }
        // else{
        //     $require = array_merge($require,['reference' => 'string|unique:produits']);
        // }
        
        
// dd($require);

        return $require;
    }

    public function submit()
    {

        $this->validate();
    }
}
    