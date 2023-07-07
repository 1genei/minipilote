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
                            <a href="{{route('role.index')}}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Retour</a>
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
                                <h4 class="page-title">Permissions du rôle "{{$role->nom}}"</h4>
                            </div>
                             <div class="col-sm-7">
                                 
                             </div><!-- end col-->
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <form action="{{route('role.update_permissions', Crypt::encrypt($role->id))}}" method="POST">
                                @csrf
                                 <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap" id="tab1">
                                    <thead class="table-light">
                                        <tr>
                                       
                                            <th>Permissions</th>
                                            <th></th>
                                                                              
        
                                            <th style="width: 125px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    
                                        @foreach ($permissionsGroups as $group)
                                            
                                             <tr>
                                           
                                                 <td ><span class="fw-bold" style="font-size: 20px">{{$group->nom}} </span></td>
                                             </tr>
                                             @foreach ($group->permissions as $permission)
                                             <tr>
                                                 <td></td>
                                                 <td> <label for="{{$permission->id}}" style="cursor: pointer;" class="text-body fw-bold">{{$permission->description}} </label> </td>
                                                 <td>
                                                     <input type="checkbox" name="{{$permission->id}}" id="{{$permission->id}}" @if(in_array($permission->id, $permissions_id) ) checked @endif>
                                                 </td>
                                                
                                             </tr>
                                             @endforeach
                                         
                                        @endforeach
                                        
                                     
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-success">Enregistrer</button>

                            </form>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->  

</div> <!-- End Content -->


@endsection

@section('script')


{{-- Modification d'un rôle --}}
<script>

    $('.edit-role').click(function (e) {
    
            let that = $(this);
            let currentRole = that.data('value');
            let currentFormAction = that.data('href');
            $('#edit-role').val(currentRole) ;
            $('#form-edit').attr('action', currentFormAction) ;
    
    })
    
    </script>
    
    
    <script>
        $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click','a.archive-role',function(event) {
                let that = $(this)
                event.preventDefault();
    
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                });
    
                swalWithBootstrapButtons.fire({
                title: 'Archiver',
                text: "Confirmer ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                cancelButtonText: 'Non',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    
                    $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({                        
                            url: that.attr('data-href'),
                            type: 'PUT',
                            success: function(data){
                                // document.location.reload();
                            },
                            error : function(data){
                            console.log(data);
                            }
                        })
                        .done(function () {
    
                            swalWithBootstrapButtons.fire(
                                'Archivé',
                                '',
                                'success'
                            )
                                document.location.reload();
    
                                // that.parents('tr').remove();
                        })
                   
    
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Annulé',
                    'Rôle non archivé :)',
                    'error'
                    )
                }
                }); 
                })
    
        });
    
    
    </script>
    
    <script>
    
        // Désarchiver
    
        $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click','a.unarchive-role',function(event) {
                let that = $(this)
                event.preventDefault();
                
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                });
    
                swalWithBootstrapButtons.fire({
                title: 'Désarchiver',
                text: "Confirmer ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                cancelButtonText: 'Non',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    
                    $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({                        
                            url:that.attr('data-href'),
                            // url:"/role/desarchiver/2",
                            
                            type: 'POST',
                            success: function(data){
                               
                                // document.location.reload();
                            },
                            error : function(data){
                            console.log(data);
                            }
                        })
                        .done(function () {
    
                            swalWithBootstrapButtons.fire(
                                'Désarchivé',
                                '',
                                'success'
                                )
                            document.location.reload();
                        })
                    
    
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Annulé',
                    'Rôle non désarchivé :)',
                    'error'
                    )
                }
                }); 
                })
    
        });
       
    
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
            language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",
            next:"<i class='mdi mdi-chevron-right'>"},
            info:"Showing actions _START_ to _END_ of _TOTAL_",
            lengthMenu:'Afficher <select class=\'form-select form-select-sm ms-1 me-1\'><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> '},
            pageLength:100,
   
            select:{style:"multi"},
            drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
            document.querySelector(".dataTables_wrapper .row").querySelectorAll(".col-md-6").forEach(function(e){e.classList.add("col-sm-6"),e.classList.remove("col-sm-12"),e.classList.remove("col-md-6")})}})});
</script>
@endsection