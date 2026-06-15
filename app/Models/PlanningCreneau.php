<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningCreneau extends Model
{
    protected $guarded = [];
    protected $table   = 'planning_creneaux';
    protected $casts   = ['cam' => 'boolean', 'permis' => 'boolean', 'decharge' => 'boolean'];

    public function planning()
    {
        return $this->belongsTo(Planning::class);
    }

    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }
}
