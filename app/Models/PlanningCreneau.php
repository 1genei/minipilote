<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningCreneau extends Model
{
    protected $guarded = [];
    protected $table   = 'planning_creneaux';

    public function planning()
    {
        return $this->belongsTo(Planning::class);
    }

    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }
}
