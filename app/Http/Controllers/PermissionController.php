<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Permissiongroup;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class PermissionController extends Controller
{
    /**
     * Retourne la liste des perrmissions
    */

     public function index(){
        
        $roles = Role::all();
        $permissionsGroups = Permissiongroup::orderBy('rang')->get();
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
     * Créer un groupe de permission et Générer de nouvelles permissions
    */

    public function storeAuto(Request $request)
    {
        try {
            
            // Validation avec règle d'unicité sur le nom
            $request->validate([
                'nom' => 'required|string|unique:permissiongroups,nom',
                'description' => 'nullable|string'
            ]);
            DB::beginTransaction();

            // Création du groupe
            $rang = Permissiongroup::max('rang') + 10;
            $groupe = PermissionGroup::create([
                'nom' => $request->nom,
                'rang' => $rang
            ]);

            $groupId = $groupe->id;
            $nomGroup = strtolower($request->nom);

            Permission::insert([
                [
                    "nom"=>"ajouter-$nomGroup",
                    "description"=>"Ajouter",
                    "permissiongroup_id"=> $groupId,
                ],
                [
                    "nom"=>"modifier-$nomGroup",
                    "description"=>"Modifier",
                    "permissiongroup_id"=> $groupId,
                ],
                [
                    "nom"=>"afficher-$nomGroup",
                    "description"=>"Afficher",
                    "permissiongroup_id"=> $groupId,
                ],
                [
                    "nom"=>"supprimer-$nomGroup",
                    "description"=>"Supprimer",
                    "permissiongroup_id"=> $groupId,
                ],
                [
                    "nom"=>"archiver-$nomGroup",
                    "description"=>"Archiver",
                    "permissiongroup_id"=> $groupId,
                ],
        
            ]);

            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
        
  
        return redirect()->back()->with('ok','Groupe de permission créé avec succès');
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
