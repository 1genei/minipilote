<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    // protected $casts = [
    //     'date_commande' => 'date',
    //     'date_realisation_prevue' => 'date',
    //     'date_realisation_reelle' => 'date',
    //     'montant_ht' => 'decimal:2',
    //     'montant_ttc' => 'decimal:2',
    //     'montant_tva' => 'decimal:2',
    //     'net_a_payer' => 'decimal:2',
    //     'remise' => 'decimal:2',
    //     'montant_remise' => 'decimal:2',
    //     'montant_remise_total' => 'decimal:2',
    //     'archive' => 'boolean'
    // ];

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }

    public function collaborateur()
    {
        return $this->belongsTo(Contact::class, 'collaborateur_id');
    }

    public function client()
    {
        return $this->belongsTo(Contact::class, 'client_prospect_id');
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_produit')
            ->withPivot([
                'quantite',
                'prix_unitaire',
                'montant_tva',
                'montant_ht',
                'montant_ttc',
                'taux_tva',
                'remise',
                'taux_remise',
                'beneficiaire_id'
            ])
            ->withTimestamps();
    }

    public static function genererNumero()
    {
        $dernierNumero = self::orderBy('id', 'desc')->first()?->numero_commande ?? 'CMD-000000';
        $numero = intval(substr($dernierNumero, 4)) + 1;
        return 'CMD-' . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Retourne le devis lié à la commande
     */
    public function devi(){
        return $this->belongsTo(Devi::class);
    }
}
