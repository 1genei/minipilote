<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $dates = ['date_prestation'];
    protected $casts  = ['date_prestation' => 'date'];
    
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
    
    /*
    * Retourne le produit lié  à la prestation
    */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
    
    /*
    * Charges liées à  la prestation
    */
    
    public function depenses()
    {   
        return $this->hasMany(Depense::class);
    }
    
    /*
    * Montant total des charges
    */
    public function montantCharges()
    {
        $total = 0;
        foreach ($this->depenses as $depense) {
            $total += $depense->montant;
        }
        return $total;
    }
    
    /*
    * Retourne la voiture liée à la prestation
    */
    public function voiture(){
        
        return $this->belongsTo(Voiture::class);
    }
}
