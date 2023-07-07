@extends('layouts.app')
@section('css')
<link href="{{asset('assets/css/vendor/dataTables.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/vendor/responsive.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="content">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">Permissions</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Permissions</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 

    <style>
    
    body{
    
        font-size: 14px;
    }
    </style>
  
    <!-- end row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        
                        <div class="col-sm-2 mr-14 ">
                            <a href="{{route('role.index')}}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Rôles</a>
                        </div>
                        @if(session('ok'))
                        <div class="col-6">
                            <div class="alert alert-success alert-dismissible bg-success text-white text-center border-0 fade show" role="alert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong> {{session('ok')}}</strong>
                            </div>
                        </div>
                        @endif

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                 <div class="row mb-2">
                     <div class="col-sm-5">
                         <a href="javascript:void(0);" class="btn btn-primary mb-2"  data-bs-toggle="modal" data-bs-target="#standard-modal"><i class="mdi mdi-plus-circle me-2"></i> Ajouter permission</a>
                     </div>
                     
                 </div>
                 <div class="row">
                 
                     <div class="col-6">
                         @if(session('message'))       
                             <div class="alert alert-success text-secondary alert-dismissible ">
                                 <i class="dripicons-checkmark me-2"></i>
                                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                 <a href="#" class="alert-link"><strong> {{ session('message')}}</strong></a> 
                             </div>
                         @endif 
                         @if ($errors->has('role'))
                             <br>
                             <div class="alert alert-warning text-secondary " role="alert">
                                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                 <strong>{{$errors->first('role')}}</strong> 
                             </div>
                         @endif
                         <div  id="div-role-message" class="alert alert-success text-secondary alert-dismissible fade in">
                             <i class="dripicons-checkmark me-2"></i>
                             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <a href="#" class="alert-link"><strong> <span id="role-message"></span></strong></a> 
                         </div>

                     </div>
                 </div>
                
                    <div class="table-responsive">
                        <form action="{{route('permission_role.update')}}" method="post">
                        @csrf
                        <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap" id="tab1">
                            <thead class="table-light">
                                <tr>
                               
                                    <th>#</th>
                                    
                                    @foreach ($roles as $role)
                                    <th>{{$role->nom}}</th>
                                    @endforeach

                                    <th style="width: 125px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissionsGroups as $group)
                                            
                                    <tr>
                                  
                                        <td ><span class="fw-bold" style="font-size: 20px" >{{$group->nom}} </span></td>
                                    </tr>
                                    @foreach ($group->permissions as $permission)
                                    <tr>
                                       
                                        <td> <label for="{{$permission->id}}" style="cursor: pointer;" class="text-body fw-bold">{{$permission->description}} </label> </td>
                                        @foreach ($roles as $role)
                                        <td>
                                            
                                            <input type="checkbox" name="{{$role->id.'_'.$permission->id}}" id="{{$role->id.'_'.$permission->id}}"  @if($role->havePermission($permission->id)) checked @endif>
                                        </td>
                                        @endforeach
                                        
                                        <td>
                                            <a data-href="{{route('permission.update', $permission->id)}}" data-nom="{{$permission->nom}}" data-description="{{$permission->description}}"
                                                data-permissiongroup="{{$permission->permissiongroup->nom}}" data-permissiongroup_id="{{$permission->permissiongroup_id}}" data-bs-toggle="modal" data-bs-target="#edit-modal" class="action-icon edit-role text-success"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            
                                        </td>
                                
                                    </tr>
                                    @endforeach
                                
                               @endforeach
                                
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                        
                        </form>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->  

        {{-- Ajout d'un rôle --}}
        <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Ajouter une permission</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
    
                    <form action="{{route('permission.store')}}" method="post">
                    <div class="modal-body">
                    
                        @csrf
                        <div class="col-lg-12">
                            
                            <div class="form-floating mb-3">
                                <input type="text" name="nom" value="{{old('nom') ? old('nom') : ''}}" class="form-control" id="floatingInput" >
                                <label for="floatingInput">Permission</label>
                                @if ($errors->has('nom'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{$errors->first('nom')}}</strong> 
                                    </div>
                                @endif
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="description" value="{{old('description') ? old('description') : ''}}" class="form-control" id="floatingInput" >
                                <label for="floatingInput">Description</label>
                                @if ($errors->has('description'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{$errors->first('description')}}</strong> 
                                    </div>
                                @endif
                            </div>
                            
                            <div class="form-floating mb-3">
                                <select name="groupe_id" id="groupe_id" class="form-select">
                                @foreach ($permissionsGroups as $groupe)
                                    <option value="{{$groupe->id}}">{{$groupe->nom}}</option>                                    
                                @endforeach
                                
                                </select>
                                <label for="floatingInput">Groupe</label>
                                @if ($errors->has('role'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{$errors->first('role')}}</strong> 
                                    </div>
                                @endif
                            </div>
                                                    
                        </div>
    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
    
                    </div>
                </form>
    
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    
    
         {{-- Modification d'un rôle --}}
         <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Modifier la permission</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
    
                    <form action="" method="post" id="form-edit">
                    <div class="modal-body">
                    
                        @csrf
                        <div class="col-lg-12">
                            
                            <div class="form-floating mb-3">
                                <input type="text" name="nom" value="{{old('nom') ? old('nom') : ''}}" class="form-control" id="edit-nom" >
                                <label for="edit-nom">Permission</label>
                                @if ($errors->has('nom'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{$errors->first('nom')}}</strong> 
                                    </div>
                                @endif
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="description" value="{{old('description') ? old('description') : ''}}" class="form-control" id="edit-description" >
                                <label for="edit-description">Description</label>
                                @if ($errors->has('description'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{$errors->first('description')}}</strong> 
                                    </div>
                                @endif
                            </div>
                            
                            <div class="form-floating mb-3">
                                <select name="groupe_id" id="edit-permissiongroup_id" class="form-select">
                                @foreach ($permissionsGroups as $groupe)
                                    <option value="{{$groupe->id}}">{{$groupe->nom}}</option>                                    
                                @endforeach                                
                                </select>
                                <label for="edit-permissiongroup_id">Groupe</label>
                                
                                @if ($errors->has('role'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{$errors->first('role')}}</strong> 
                                    </div>
                                @endif
                            </div>
                                                    
                        </div>
    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success">Modifier</button>
    
                    </div>
                </form>
    
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    
    
</div> <!-- End Content -->


@endsection

@section('script')


{{-- Modification d'un rôle --}}
<script>

    $('.edit-role').click(function (e) {
    
            let that = $(this);
            let currentNom = that.data('nom');
            let currentDescription = that.data('description');
            let currentPermissiongroup_id = that.data('permissiongroup_id');
            let currentPermissiongroup = that.data('permissiongroup');
            
            let currentFormAction = that.data('href');
            $('#edit-nom').val(currentNom) ;
            $('#edit-description').val(currentDescription) ;
            $('#edit-permissiongroup_id option[value='+currentPermissiongroup_id+']').attr('selected','selected');
           

            $('#form-edit').attr('action', currentFormAction) ;
    
    })
    
    </script>
    

    
    
<script src="{{asset('assets/js/vendor/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/vendor/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/responsive.bootstrap5.min.js')}}"></script>
<script>
    $(document).ready(function()
    {
        "use strict";
        $("#tab1").
            DataTable(
            {
            language:{
            paginate:{previous:"<i class='mdi mdi-chevron-left'>",
            next:"<i class='mdi mdi-chevron-right'>"},
            info:"Showing actions _START_ to _END_ of _TOTAL_",
            lengthMenu:'Afficher <select class=\'form-select form-select-sm ms-1 me-1\'><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> '},
            pageLength:100,
   
            select:{style:"multi"},
            drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
            document.querySelector(".dataTables_wrapper .row").querySelectorAll(".col-md-6").forEach(function(e){e.classList.add("col-sm-6"),e.classList.remove("col-sm-12"),e.classList.remove("col-md-6")})}})});
</script>
@endsection