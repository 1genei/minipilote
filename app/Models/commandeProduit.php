<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeProduit extends Model
{
    use HasFactory;
    
    protected $table = 'commande_produit';
    
    protected $guarded = [];
    
    // protected $casts = [
    //     'quantite' => 'integer',
    //     'prix_unitaire' => 'decimal:2',
    //     'montant_tva' => 'decimal:2',
    //     'montant_ht' => 'decimal:2',
    //     'montant_ttc' => 'decimal:2',
    //     'taux_tva' => 'decimal:2',
    //     'remise' => 'decimal:2',
    //     'taux_remise' => 'decimal:2'
    // ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function beneficiaire()
    {
        return $this->belongsTo(Contact::class, 'beneficiaire_id');
    }
}
