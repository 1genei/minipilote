<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Permissiongroup;
use App\Models\PermissionRole;
use App\Models\Role;


class PermissionController extends Controller
{
    /**
     * Retourne la liste des perrmissions
    */

     public function index(){
        
        $roles = Role::all();
        $permissionsGroups = Permissiongroup::all();
        $permissionRoles = PermissionRole::all();
        
        foreach ($permissionsGroups as $group) {
           $group->permissions;
        }
        
      
        foreach ($roles as $role) {        
            $role->permissions->makeHidden('pivot');
        }
        
        $permissionroles = [];
        foreach ($permissionRoles as $key => $permissionRole) {
           $permissionroles [] = $permissionRole->permission_id . '_'.$permissionRole->role_id; 
        }
        
        
        return view('permission.index', compact('permissionsGroups', 'permissionRoles', 'roles'));
    }
    
    /**
     * Ajouter une nouvelle permission
    */

    public function store(Request $request){
        

        $request->validate([
            "nom" => 'required',
            "description" => 'required',
            "groupe_id" => 'required',
        ]);

        Permission::create([
            "nom"=>$request->nom,
            "description"=>$request->description,
            "permissiongroup_id"=>$request->groupe_id,
        ]);
        
        return redirect()->back()->with('ok','Permissions modifiées');
    }
    
     /**
     * Modifier une  permission
    */

    public function update(Request $request, $permission_id){
        
        $permission = Permission::where('id', $permission_id)->first();
        
        
        
        $request->validate([
            "nom" => 'required',
            "description" => 'required',
            "groupe_id" => 'required',
        ]);

  
        $permission->nom=$request->nom;
        $permission->description=$request->description;
        $permission->permissiongroup_id=$request->groupe_id;
        
        $permission->update();
    
        
        return redirect()->back()->with('ok','Permission modifiées');
    }
    
    
    /**
     * Modifier les permissions des rôles
    */

    public function updateRolePermission(Request $request){
        
        
       
        $roles = Role::where('archive', false)->get();

        
        $permissions_roles = $request->all();
        $permissions_roles =  array_keys($permissions_roles);
        unset($permissions_roles[0]);
        
        foreach ($roles as $rol) {
            $rol->permissions()->detach();
        }
        
        foreach ($permissions_roles as $permission_role ) {
                
            $tab = explode('_',$permission_role);
            

            $role_id = $tab[0];           
            $permission_id = $tab[1];
        
            
            $role = Role::where('id', $role_id)->first();
            
            

        
            $role->havePermission($permission_id)  ? null  : $role->permissions()->attach($permission_id);
            
                
        }
        

        return redirect()->back()->with('ok','Permissions modifiées');

    }
}
