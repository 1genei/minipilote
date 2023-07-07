<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Retourne la liste des permissions d'un rôles
     */
    function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    /**
     * Retourne le groupe de permission d'une permission
     */
    function permissiongroup()
    {
        return $this->belongsTo(permissiongroup::class);
    }
    
}
