<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningPlacement extends Model
{
    protected $guarded = [];

    public function planning()
    {
        return $this->belongsTo(Planning::class);
    }

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
