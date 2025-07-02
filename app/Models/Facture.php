<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Facture extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = [];
    
    protected $casts = [
        'date' => 'date',
        'paiements' => 'array',
        'palier' => 'array',
        'commandes_liees' => 'array',
        'a_avoir' => 'boolean',
        'montant_ht' => 'decimal:2',
        'montant_tva' => 'decimal:2',
        'montant_ttc' => 'decimal:2',
        'net_a_payer' => 'decimal:2',
        'montant_restant_a_payer' => 'decimal:2',
        'remise' => 'decimal:2',
    ];

    /**
     * Retourner le client de la facture
     */
    public function client()
    {
        return $this->belongsTo(Contact::class, 'client_id');
    }

    /**
     * Retourner le fournisseur de la facture
     */
    public function fournisseur()
    {
        return $this->belongsTo(Contact::class, 'fournisseur_id');
    }

    /**
     * Retourner le devis de la facture
     */
    public function devi()
    {
        return $this->belongsTo(Devi::class, 'devi_id');
    }

    /**
     * Retourner la commande principale de la facture
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

    /**
     * Retourner toutes les commandes liées à la facture
     */
    public function commandesLiees()
    {
        if ($this->commandes_liees) {
            $commandeIds = collect($this->commandes_liees)->pluck('commande_id');
            return Commande::whereIn('id', $commandeIds)->get();
        }
        return collect();
    }

    /**
     * Retourner l'événement lié à la facture
     */
    public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'evenement_id');
    }

    /**
     * Retourner la prestation liée à la facture
     */
    public function prestation()
    {
        return $this->belongsTo(Prestation::class, 'prestation_id');
    }

    /**
     * Retourner la depense liée à la facture
     */
    public function depense()
    {
        return $this->belongsTo(Depense::class, 'depense_id');
    }

    /**
     * Retourner le user qui a créé la facture
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Retourner les paiements de la facture
     */
    public function getPaiementsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Définir les paiements de la facture
     */
    public function setPaiementsAttribute($value)
    {
        $this->attributes['paiements'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Calculer le montant total payé
     */
    public function montantPaye()
    {
        return collect($this->paiements)->sum('montant');
    }

    /**
     * Vérifier si la facture est entièrement payée
     */
    public function estPayee()
    {
        return $this->montantPaye() >= $this->net_a_payer;
    }

    /**
     * Vérifier si la facture est partiellement payée
     */
    public function estPartiellementPayee()
    {
        $montantPaye = $this->montantPaye();
        return $montantPaye > 0 && $montantPaye < $this->net_a_payer;
    }

    /**
     * Générer le numéro de facture automatiquement
     */
    public function genererNumero()
    {
        $prefix = 'FACT';
        $annee = date('Y');
        $derniereFacture = self::whereYear('created_at', $annee)
            ->where('numero', 'like', $prefix . $annee . '%')
            ->orderBy('numero', 'desc')
            ->first();

        if ($derniereFacture) {
            $dernierNumero = (int) substr($derniereFacture->numero, -4);
            $nouveauNumero = $dernierNumero + 1;
        } else {
            $nouveauNumero = 1;
        }

        return $prefix . $annee . str_pad($nouveauNumero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Obtenir le prochain numéro de facture cliente (commence à 1500)
     */
    public static function getProchainNumeroFactureClient()
    {
        $derniereFacture = self::where('type', 'client')
            ->orderBy('numero', 'desc')
            ->first();

        if ($derniereFacture && is_numeric($derniereFacture->numero)) {
            return (int) $derniereFacture->numero + 1;
        }

        return 1500; // Premier numéro pour les factures clientes
    }

    /**
     * Calculer les montants de la facture
     */
    public function calculerMontants()
    {
        $ht = $this->montant_ht;
        $tva = $this->montant_tva;
        $ttc = $ht + $tva;
        
        // Appliquer la remise
        if ($this->remise > 0) {
            if ($this->type_remise === 'pourcentage') {
                $remiseMontant = $ttc * ($this->remise / 100);
            } else {
                $remiseMontant = $this->remise;
            }
            $ttc -= $remiseMontant;
        }
        
        $this->net_a_payer = $ttc;
        $this->montant_restant_a_payer = $ttc - $this->montantPaye();
        
        return $this;
    }

    /**
     * Scope pour les factures clients
     */
    public function scopeClients($query)
    {
        return $query->where('type', 'client');
    }

    /**
     * Scope pour les factures fournisseurs
     */
    public function scopeFournisseurs($query)
    {
        return $query->where('type', 'fournisseur');
    }

    /**
     * Scope pour les factures directes
     */
    public function scopeDirectes($query)
    {
        return $query->where('type', 'directe');
    }

    /**
     * Scope pour les factures non payées
     */
    public function scopeNonPayees($query)
    {
        return $query->where('statut_paiement', 'attente paiement');
    }

    /**
     * Scope pour les factures partiellement payées
     */
    public function scopePartiellementPayees($query)
    {
        return $query->where('statut_paiement', 'partiellement payée');
    }

    /**
     * Scope pour les factures payées
     */
    public function scopePayees($query)
    {
        return $query->where('statut_paiement', 'payée');
    }
    
}
