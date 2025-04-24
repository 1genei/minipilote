<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecteurActivite extends Model
{
    protected $table = 'secteur_activite';
    
    protected $fillable = [
        'nom',
        'archive'
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
} 