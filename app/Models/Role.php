<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Retourne la liste des permissions d'un rôles
     */
    function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
    * Vérifie si le rôle a la permission passée en paramètre
    */
    public function havePermission($permission_id) {
        
        $permission_role = PermissionRole::where([['permission_id', $permission_id], ['role_id', $this->id] ])->count();
      
        return $permission_role > 0 ? true : false;
        
    }
    
    /**
    * Vérifie si le rôle a la permission passée en paramètre
    */
    public function havePermissionByName($permission_name) {
        
        $permission = Permission::where('nom', $permission_name)->first();
        

        if($permission != null ){
            return $this->havePermission($permission->id);
        }else{
            return false;
        }
        
    }

    
    /**
     * Retourne la liste des utilisateurs associé à un rôles
     */
    function users()
    {
        return $this->hasMany(User::class);
    }
}
