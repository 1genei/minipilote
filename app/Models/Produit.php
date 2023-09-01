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
     * Get the stock associated with the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }
}
