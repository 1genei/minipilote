<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristque extends Model
{
    use HasFactory;
    protected $guarded =[];
    
    
    /**
     * Get all of the valeurcaracteristiques for the Caracteristque
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function valeurcaracteristiques()
    {
        return $this->hasMany(Comment::class);
    }
}
