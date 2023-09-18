<?php

namespace App\Policies;

use App\Models\User;

class MesPolicies
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Determine si le user possède une permission
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function verifier(User $user, $permission)
    {
    
       return $user->role->havePermissionByName($permission);
      
    }
}
