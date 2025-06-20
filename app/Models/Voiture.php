<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voiture extends Model
{
    use HasFactory;
    protected $guarded =[];

    /**
     * Retourne le modèle de la voiture
     */
    public function modele()
    {
        return $this->belongsTo(Modelevoiture::class, 'modelevoiture_id');
    }
}
