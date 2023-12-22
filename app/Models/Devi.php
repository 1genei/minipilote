<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devi extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $casts  = ['date_devis' => 'date'];
    /**
    *   retourne tous les produits liés au devis
    */
    public function produits(){
        return $this->belongsToMany(Produit::class, 'devi_produit', 'devi_id', 'produit_id');
    }
    
    /**
    * Retourne le client ou prospect lié au devis
    */
    public function client_prospect(){
    
        $clientProspect = Contact::where('id', $this->client_prospect_id)->first();
        return $clientProspect;
    }
    
    /**
    * Retourne le collaborateur lié au devis
    */
    public function collaborateur(){
    
        $collaborateur = User::where('id', $this->collaborateur_id)->first();
        
        return $collaborateur;
    }
}
