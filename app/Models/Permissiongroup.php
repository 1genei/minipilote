<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissiongroup extends Model
{
    use HasFactory;
    protected $guarded = [];
   
      
    /**
     * retourne toutes les permissions de PermissionGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function permissions(){
       
        return $this->hasMany(Permission::class);
    }
}
