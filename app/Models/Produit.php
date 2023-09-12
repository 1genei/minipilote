<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    /**
     * The categorieproduis that belong to the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categorieproduits()
    {
        return $this->belongsToMany(Categorieproduit::class);
    }
    
    /**
     * The categorieproduis that belong to the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categorieproduitsId()
    {
        $categories = $this->categorieproduits;
        $catIds = [];
        
        foreach ($categories as $cat) {
           $catIds [] = $cat->id;
        }
        return $catIds;
        
    }
    
    /**
     * Get all of the imageproduits for the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function imageproduits()
    {
        return $this->hasMany(Imageproduit::class,);
    }
    
    /**
     * Get the marque associated with the Produit
     *
     */
    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }
    
    
    /**
     * Get the stock associated with the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }
    
    /**
     * The Valeurcaracteristiques that belong to the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function valeurcaracteristiques()
    {
        return $this->belongsToMany(Valeurcaracteristique::class);
    }
    
    /**
     * Get all of the declinaisons for the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function declinaisons()
    {
        if($this->a_declinaison){
        
            $declinaisons = Produit::where('produit_id', $this->id)->get();
            return $declinaisons;
        }else{
        
            return [];
        }
    }
    
   public function valeurcaracteristique_id(){
    
        $valeurcaracteristiques = ProduitValeurcaracteristique::where('produit_id', $this->id)->get();
        
        $valids = [];
        
        foreach ($valeurcaracteristiques as $valeurcaracteristique) {
            $valids[] = $valeurcaracteristique->valeurcaracteristique_id;
        }
        
        return json_encode($valids);    
   }
}
