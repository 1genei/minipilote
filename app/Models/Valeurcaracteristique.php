<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valeurcaracteristique extends Model
{
    use HasFactory;
    protected $guarded =[];
    
    /**
     * Get the caracteristique that owns the Valeurcaracteristique
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function caracteristique()
    {
        return $this->belongsTo(Caracteristique::class);
    }
}
