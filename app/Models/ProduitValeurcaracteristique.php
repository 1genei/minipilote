<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitValeurcaracteristique extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $table = 'produit_valeurcaracteristique';
    
    /**
     * The produits that belong to the ProduitValeurcaracteristique
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function produits(): BelongsToMany
    {
        return $this->belongsToMany(Produit::class);
    }
}
