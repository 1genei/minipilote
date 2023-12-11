<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entite extends Model
{
    use HasFactory;
    protected $guarded =[];
    
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
    
    
    /*
    * Retourne l'utilisateur qui a cree l'entité
    */
    public function user()
    {
        $user_id = $this->contact->user_id;
        return User::find($user_id);
       
    }
    
}
