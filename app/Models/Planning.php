<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Retourne l'événement lié au planning
     */
    public function evenement(){
        return $this->belongsTo(Evenement::class);
    }

    /**
     * Retourne le circuit lié au planning
     */
    public function circuit(){
        return $this->belongsTo(Circuit::class);
    }

    /**
     * Retourne l'utilisateur qui a créé le planning
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Retourne les voitures du planning
     */
    public function voitures(){
        return $this->belongsToMany(Voiture::class, 'planning_voiture', 'planning_id', 'voiture_id');
    }

    /**
     * Retourne les instructeurs du planning
     */
    public function instructeurs(){
        return $this->belongsToMany(User::class, 'planning_user', 'planning_id', 'user_id');
    }
}
