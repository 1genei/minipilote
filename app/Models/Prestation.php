<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['date_prestation'];
    
    /**
    * Get the client that owns the Prestation
    */
    public function client()
    {
        $client = Contact::where('id', $this->client_id)->first();
        return $client;
        
    }
    
    
    /**
    * Get the beneficiaire that owns the Prestation
    */
    public function beneficiaire()
    {
        $beneficiaire = Contact::where('id', $this->beneficiaire_id)->first();
        return $beneficiaire;
        
    }
    
    /**
    * Get the user that owns the Prestation
    */
    public function user()
    {
        return $this->belongsTo(User::class);        
    }
    
    
}
