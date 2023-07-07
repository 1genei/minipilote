<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntiteIndividu extends Model
{
    use HasFactory;
    protected $guarded =[];
    
    protected $table = 'entite_individu';
    
    /**
     * retourne l'entite
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entite()
    {
        return $this->belongsTo(Entite::class);
    }
    
    
    /**
     * retourne l'individu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individu()
    {
        return $this->belongsTo(Individu::class);
    }
}
