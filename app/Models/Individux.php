<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Individux extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $table ='individuxs';

    
    
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
}
