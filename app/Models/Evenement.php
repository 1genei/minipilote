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
}
