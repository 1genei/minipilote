@extends('layouts.app')
@section('css')
<link href="{{asset('assets/css/vendor/dataTables.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/vendor/responsive.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Contact')

@section('content')
<div class="content">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">Contact</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Contact - {{$contact->entite->nom}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 

    <style>
    
    body{
    
        font-size: 14px;
    }
    
    .info{
        
        margin-bottom: 15px;
    
    }
    </style>
  
    <!-- end row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        
                        <div class="col-sm-2 mr-14 ">
                            <a href="{{ URL::previous() }}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Retour</a>
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
        <div class="col-xl-5 ">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">{{$contact->entite->type}}</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Weekly Report</a>
                             
                            </div>
                        </div>
                    </div>

                   
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="bordered-tabs-preview">
                                        <ul class="nav nav-tabs nav-bordered mb-3">
                                           
                                            <li class="nav-item">
                                                <a href="#profile-b1" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                                    <span class="d-none d-md-block">{{$contact->entite->nom}}</span>
                                                </a>
                                            </li>
                                           
                                        </ul>

                                        <div class="tab-content">
                                           
                                            <div class="tab-pane show active" id="profile-b1">
                                                
                                                <div class="contact-information">
                                                    <div class="info">
                                                        <span class="font-14 my-1 fw-bold"><a href="javascript:void(0);" class="text-body">Statut</a>: </span>
                                                        <span class="text-muted font-13">
                                                            @if($contact->est_prospect == true) <span class="badge bg-secondary">Prospect</span> @endif
                                                            @if($contact->est_client == true) <span class="badge bg-primary">Client</span> @endif
                                                            @if($contact->est_fournisseur == true) <span class="badge bg-danger">Fournisseur</span> @endif
                                                        </span>
                                                    </div>
                                                    
                                                    <div class="info">
                                                        <span class="font-14 my-1 fw-bold">Email: </span>
                                                        <span class="text-muted font-13">{{$contact->entite->email}}</span>
                                                     </div>
                                                   
                                                    
                                                     <div class="info">
                                                        <span class="font-14 my-1 fw-bold">Téléphone: </span>
                                                        <span class="text-muted font-13">{{$contact->entite->contact1}} - {{$contact->entite->contact2}}</span>                                                        
                                                     </div>
                                                     
                                                     <div class="info">
                                                        <span class="font-14 my-1 fw-bold">Adresse: </span>
                                                        <span class="text-muted font-13">{{$contact->entite->adresse}}</span>
                                                     </div>
                                                     
                                                     <div class="info">
                                                     
                                                        <span class="font-14 my-1 fw-bold">Code postal: </span>
                                                        <span class="text-muted font-13">{{$contact->entite->code_postal}}</span>
                                                       
                                                     </div>
                                                     <div class="info">
                                                        <span class="font-14 my-1 fw-bold">Ville: </span>
                                                        <span class="text-muted font-13">{{$contact->entite->ville}}</span>
                                                     </div>
                                                     
                                                  </div>
                                                    
                                                      
                                            
                                                  <div class="user-skill m-t-10">
                                                     <h5 style="color: #32ade1;text-decoration: underline;">Actions</h5>
                                                     <button type="button" class="btn btn-success btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#edit-modal"><i class="mdi mdi-pencil me-1"></i> <span>Modifier</span> </button>
                                                     <button type="button" class="btn btn-warning btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#standard-modal"><i class="mdi mdi-key me-1"></i> <span>Associer des individus</span> </button>
                                                     
                                                     
                                                  </div>
                                             
                                                         
                                             
                                            </div>
                                            
                                        </div>                                          
                                    </div> <!-- end preview-->
         
                                </div> <!-- end tab-content-->
                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
     
                    <!-- end row-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->

        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Individus associés</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Weekly Report</a>
                        
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0" id="tab1">
                        
                            <thead class="table-light">
                                <tr>
                               
                                    <th>Nom</th>                                    
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Adresse</th>
                                    <th>Code Postal</th>
                                    <th>Ville</th>

                                    <th style="width: 125px;">Action</th>
                                </tr>
                            </thead>
                            
                            
                            <tbody>
                            
                            @foreach ($contact->entite->individus as $individu )
                                
                           
                                <tr>
                                    <td>                                        
                                        <span class="">{{$individu->nom}} {{$individu->prenom}}</span>
                                    </td>
                                    
                                    <td>                                        
                                        <span class="">{{$individu->email}}</span>
                                    </td>
                                    <td>                                        
                                        <span class="">{{$individu->contact1}} - {{$individu->contact2}}</span>
                                    </td>
                                    <td>                                        
                                        <span class="">{{$individu->adresse}}</span>
                                    </td>
                                    <td>                                        
                                        <span class="">{{$individu->code_postal}}</span>
                                    </td>
                                    
                                    <td>                                        
                                        <span class="">{{$individu->ville}}</span>
                                    </td>

                                  
                                    <td class="table-action" style="width: 90px;">
                                        <a href="{{route('contact.show', Crypt::encrypt($individu->contact->id))}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                        <a href="#" data-href="{{route('contact.deassociate',[$contact->entite->id, $individu->id])}}"  class="action-icon desassocier"> <i class="mdi mdi-close-thick"></i></a>
                                    </td>
                                </tr>
                                
                            @endforeach   
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->

    <!-- end row -->  

        {{-- Ajout d'un individu --}}
        <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Associer des individus</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
    
                    <form action="{{route('contact.associate', $contact->entite->id)}}" method="post">
                    <div class="modal-body">
                    
                        @csrf
                        
                        
                        <input type="hidden" name="association"  />
                        <input type="hidden" name="type" value="individu"  />
                        
                        <div class="col-lg-12 ">                        
                            <label for="floatingInput">Contact existant ? </label>   <br>                         
                                
                            <input type="checkbox" name="contact_existant" id="contact_existant" checked data-switch="success"/>
                            <label for="contact_existant" data-on-label="Oui" data-off-label="Non"></label>
                                                                         
                        </div>
                    
                        <div class="col-lg-12 contact_existant">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <select name="newcontacts[]" id="newcontacts" class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" data-placeholder="Selectionner les contacts ...">  
                                            @foreach ($newcontacts as $contactn)
                                            <option value="{{$contactn->individu->id}}">{{$contactn->individu->nom}} {{$contactn->individu->prenom}}</option>  
                                            @endforeach                        
                                        </select>
                                        <label for="floatingInput"></label>
                                        @if ($errors->has('newcontacts'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{$errors->first('newcontacts')}}</strong> 
                                            </div>
                                        @endif
                                    </div>
                                    
                                </div>
                                
                            </div>
                                                                         
                        </div>
                        
                        <div class="nouveau_contact">
                            <div class="row">
                         
                                
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email" value="{{old('email') ? old('email') : ''}}" class="form-control" id="email"  >
                                        <label for="email">Email</label>
                                        @if ($errors->has('email'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{$errors->first('email')}}</strong> 
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mt-2">
                                        <div class="form-check form-check-inline form-checkbox-secondary">
                                            <input type="checkbox" name="prospect" class="form-check-input" id="prospect">
                                            <label class="form-check-label"  for="prospect">Prospect</label>
                                        </div>
                                        <div class="form-check form-check-inline form-checkbox-success">
                                            <input type="checkbox" name="client" class="form-check-input " id="client">
                                            <label class="form-check-label"  for="client">Client</label>
                                        </div>
                                        <div class="form-check form-check-inline form-checkbox-danger">
                                            <input type="checkbox" name="fournisseur" class="form-check-input " id="fournisseur">
                                            <label class="form-check-label"  for="fournisseur">Fournisseur</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr><br> 
                            
                            <div class="row">
                            
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nom" value="{{old('nom') ? old('nom') : ''}}" class="form-control" id="nom"  >
                                        <label for="nom">Nom</label>
                                        @if ($errors->has('nom'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{$errors->first('nom')}}</strong> 
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 div-individu">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="prenom" value="{{old('prenom') ? old('prenom') : ''}}" class="form-control" id="floatingInput" >
                                        <label for="floatingInput">Prénom(s)</label>
                                        @if ($errors->has('prenom'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{$errors->first('prenom')}}</strong> 
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                       
                            
                            </div>
    
                            
                            <div class="row">
                            
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="contact1" value="{{old('contact1') ? old('contact1') : ''}}" class="form-control" id="floatingInput" >
                                        <label for="floatingInput">Téléphone1</label>
                                        @if ($errors->has('contact1'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{$errors->first('contact1')}}</strong> 
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="contact2" value="{{old('contact2') ? old('contact2') : ''}}" class="form-control" id="floatingInput" >
                                        <label for="floatingInput">Téléphone2</label>
                                        @if ($errors->has('contact2'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{$errors->first('contact2')}}</strong> 
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            
                            </div>
    
                            <br><hr><br> 
    
                            <div class="row">
                            
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="adresse" value="{{old('adresse') ? old('adresse') : ''}}" class="form-control" id="floatingInput" >
                                        <label for="floatingInput">Adresse</label>
                                        @if ($errors->has('adresse'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{$errors->first('adresse')}}</strong> 
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                            
                            </div>
                            
                            <div class="row">
                            
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="code_postal" value="{{old('code_postal') ? old('code_postal') : ''}}" class="form-control" id="floatingInput" >
                                        <label for="floatingInput">Code postal</label>
                                        @if ($errors->has('code_postal'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{$errors->first('code_postal')}}</strong> 
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="ville" value="{{old('ville') ? old('ville') : ''}}" class="form-control" id="floatingInput" >
                                        <label for="floatingInput">Ville</label>
                                        @if ($errors->has('ville'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{$errors->first('ville')}}</strong> 
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            
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
    
    

         {{-- Modification d'un contact --}}
         <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Modifier le contact</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
    
                    <form action="{{route('contact.update', $contact->id)}}" method="post" id="form-edit">
                    <div class="modal-body">
                    
                        @csrf
                        
                        <input type="hidden" name="type" value="entité"  />
                        
                        <div class="row">                            
                            
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" value="{{old('email') ? old('email') : $contact->entite->email}}" class="form-control" id="edit-email" required >
                                    <label for="floatingInput">Email</label>
                                    @if ($errors->has('email'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{$errors->first('email')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="mt-2">
                                    <div class="form-check form-check-inline form-checkbox-secondary">
                                        <input type="checkbox" name="prospect" class="form-check-input" id="edit-prospect" @if($contact->est_prospect) checked @endif  disabled>
                                        <label class="form-check-label"  for="edit-prospect">Prospect</label>
                                    </div>
                                    <div class="form-check form-check-inline form-checkbox-success">
                                        <input type="checkbox" name="client" class="form-check-input " id="edit-client" @if($contact->est_client) checked @endif disabled>
                                        <label class="form-check-label"  for="edit-client">Client</label>
                                    </div>
                                    <div class="form-check form-check-inline form-checkbox-danger">
                                        <input type="checkbox" name="fournisseur" class="form-check-input " id="edit-fournisseur" @if($contact->est_fournisseur) checked @endif disabled>
                                        <label class="form-check-label"  for="edit-fournisseur">Fournisseur</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr><br> 
                        
                        <div class="row">
                        
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="nom" value="{{old('nom') ? old('nom') : $contact->entite->nom}}" class="form-control" id="edit-nom" required >
                                    <label for="floatingInput">Nom</label>
                                    @if ($errors->has('nom'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{$errors->first('nom')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>                      
                            
                            <div class="col-6 div-edit-entite" >
                                <div class="form-floating mb-3">
                                    <select name="type_entite" id="edit-type_entite" class="form-select">                               
                                        
                                        
                                        <option value="{{$contact->entite->type}}">{{$contact->entite->type}}</option>  
                                        
                                        <option value="entreprise">entreprise</option>                                   
                                        <option value="CE">CE</option>
                                        <option value="association">association</option>                                   
                                        <option value="groupe">groupe</option>                                   
                                        <option value="autre">autre</option>                                   
                                    </select>
                                    <label for="floatingInput">Type d'entité</label>
                                    @if ($errors->has('type_entite'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{$errors->first('type_entite')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                                
                            </div>
                        
                        </div>

                        
                        <div class="row">
                        
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="tel" name="contact1" value="{{old('contact1') ? old('contact1') : $contact->entite->contact1}}" class="form-control" id="edit-contact1" >
                                    <label for="floatingInput">Téléphone1</label>
                                    @if ($errors->has('contact1'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{$errors->first('contact1')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="tel" name="contact2" value="{{old('contact2') ? old('contact2') : $contact->entite->contact2}}" class="form-control" id="edit-contact2" >
                                    <label for="floatingInput">Téléphone2</label>
                                    @if ($errors->has('contact2'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{$errors->first('contact2')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>
                        
                        </div>

                        <br><hr><br> 

                        <div class="row">
                        
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="tel" name="adresse" value="{{old('adresse') ? old('adresse') : $contact->entite->adresse}}" class="form-control" id="edit-adresse" >
                                    <label for="floatingInput">Adresse</label>
                                    @if ($errors->has('adresse'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{$errors->first('adresse')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                        
                        </div>
                        
                        <div class="row">
                        
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="tel" name="code_postal" value="{{old('code_postal') ? old('code_postal') : $contact->entite->code_postal}}" class="form-control" id="edit-code_postal" >
                                    <label for="floatingInput">Code postal</label>
                                    @if ($errors->has('code_postal'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{$errors->first('code_postal')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="tel" name="ville" value="{{old('ville') ? old('ville') : $contact->entite->ville}}" class="form-control" id="edit-ville" >
                                    <label for="floatingInput">Ville</label>
                                    @if ($errors->has('ville'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{$errors->first('ville')}}</strong> 
                                        </div>
                                    @endif
                                </div>
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
<script src="{{ asset('assets/js/sweetalert2.all.js')}}"></script>

{{-- selection des statuts du contact --}}

<script>
    
    $('#client').click(function(e){
        if(e.currentTarget.checked == true){
            $('#prospect').prop('checked',false);
        }
   
    });
    
    $('#prospect').click(function(e){
        if(e.currentTarget.checked == true){
            $('#client').prop('checked',false);
        }
   
    });

</script>


{{-- Associer individu --}}
<script>
    $('.nouveau_contact').hide();
    
    $('#contact_existant').change(function(e){
        if(e.currentTarget.checked == true){
            $('.nouveau_contact').hide();
            $('.contact_existant').show();
            
        }else{
            $('.nouveau_contact').show();
            $('.contact_existant').hide();
            $('#nom').attr('required', 'required');
            $('#email').attr('required', 'required');
        }
    
    });
    
    
    console.log($('#contact_existant')[0].checked);
    
</script>

<script>
    
    // Désarchiver

    $(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $('[data-toggle="tooltip"]').tooltip()
        $('body').on('click','a.desassocier',function(event) {
            let that = $(this)
            event.preventDefault();
            
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            });

            swalWithBootstrapButtons.fire({
            title: 'Supprimer de la liste ?',
            text: "",
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
                            'Supprimé',
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
                'Individu non supprimé :)',
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