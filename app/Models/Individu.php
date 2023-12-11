<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Individu extends Model
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
    public function entites()
    {
        return $this->belongsToMany(Entite::class);
    }
    
    /*
    * Retourne l'utilisateur qui a cree l'individu
    */
    public function user()
    {
        $user_id = $this->contact->user_id;
        return User::find($user_id);
       
    }
}
