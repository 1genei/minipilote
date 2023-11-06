<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entitex extends Model
{
   
    use HasFactory;
    protected $guarded =[];
    protected $table ='entitexs';
    
    
    /**
     * Retourne le contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    
    /**
     * retournes les individus de l'entite
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function individus()
    {
        return $this->belongsToMany(Individu::class);
    }
    
    
    
    /**
     * nombre d'individus de l'entité
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function nb_membres()
    {
        return  count($this->individus);
    }
    
    
}
