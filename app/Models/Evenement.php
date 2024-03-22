<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $casts  = ['date_debut' => 'date', 'date_fin' => 'date'];

    
    /*
    * Relation with Circuit
    */
    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }
     
    /*
    * Retourne les prestations liees a l'evenement
    */
    public function prestations()
    {
        return $this->hasMany(Prestation::class);
    }
    
    /*
    * Retourne les dépenses liees a l'evenement
    */
    public function depenses(){
        return $this->hasMany(Depense::class);
    }
}
