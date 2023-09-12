<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Valeurcaracteristique;

class Caracteristique extends Model
{
    use HasFactory;
    protected $guarded =[];
    
    
    /**
     * Get all of the valeurcaracteristiques for the Caracteristique
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function valeurcaracteristiques()
    {
        return $this->hasMany(Valeurcaracteristique::class);
    }

}
