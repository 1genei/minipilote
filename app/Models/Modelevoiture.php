<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelevoiture extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nom',
        'cout_kilometrique',
        'coefficient_prix',
        'prix_vente_kilometrique',
        'seuil_alerte_km_pneu',
        'seuil_alerte_km_vidange',
        'seuil_alerte_km_revision',
        'seuil_alerte_km_courroie',
        'seuil_alerte_km_frein',
        'seuil_alerte_km_amortisseur',
        'archive'
    ];

    /**
     * Retournes les voitures associées à un modèle de voiture
     */
    public function voitures()
    {
        return $this->hasMany(Voiture::class);
    }
}
