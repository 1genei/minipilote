@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Contact</a></li>
                     
                    </ol>
                </div>
                <h4 class="page-title">Contact - {{ $contact->individu?->nom }} {{ $contact->individu?->prenom }}</h4>
            </div>
        </div>
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">

                        <div class="col-sm-6">

                            <div class="col-sm-4 ">
                                <a href="{{ route('contact.index') }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Contact</a>

                            </div>
                            @if (session('ok'))
                                <div class="col-6">
                                    <div class="alert alert-success alert-dismissible text-center border-0 fade show"
                                        role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong> {{ session('ok') }}</strong>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div>
    </div>
    <!-- end page title --> 

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">
                    
                 
                    <h4 class="mb-0 mt-2">{{ $contact->individu?->civilite }} {{ $contact->individu?->nom }} {{ $contact->individu?->prenom }}<a href="{{ route('contact.edit', Crypt::encrypt($contact->id)) }}" class="text-muted"><i class="mdi mdi-square-edit-outline ms-2"></i></a></h4>

                    @foreach ($contact->typecontacts as $typecontact)
                    
                    
                        @if($typecontact->type == "Prospect")
                            <div class="badge bg-secondary btn-sm font-12 mt-2">{{$typecontact->type}}</div>
                        @elseif($typecontact->type == "Client")
                            <div class="badge bg-info btn-sm font-12 mt-2">{{$typecontact->type}}</div>
                        @elseif($typecontact->type == "Fournisseur")
                            <div class="badge bg-warning btn-sm font-12 mt-2">{{$typecontact->type}}</div>
                        
                        @elseif($typecontact->type == "Collaborateur")
                            <div class="badge bg-danger btn-sm font-12 mt-2">{{$typecontact->type}}</div>
                        
                        @elseif($typecontact->type == "Bénéficiaire")                        
                            <div class="badge bg-primary btn-sm font-12 mt-2">{{$typecontact->type}}</div>                
                        @else 
                            <div class="badge bg-light btn-sm font-12 mt-2">{{$typecontact->type}}</div>                    
                        @endif
                    
                        
                    @endforeach
                

                    <div class="text-start mt-3">
                        
                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2 ">{{ $contact->individu?->email }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Téléphone Fixe :</strong> 
                            <span class="ms-2 "> @if($contact->individu?->telephone_fixe!= null) {{ $contact->individu?->indicatif_fixe }} {{ $contact->individu?->telephone_fixe }} @endif</span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Téléphone Mobile :</strong> 
                            <span class="ms-2 "> @if($contact->individu?->telephone_mobile!= null) {{ $contact->individu?->indicatif_mobile }} {{ $contact->individu?->telephone_mobile }} @endif</span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong> Adresse :</strong> 
                            <span class="ms-2 "> {{$contact->individu?->numero_voie}} {{$contact->individu?->nom_voie }} {{$contact->individu?->complement_voie }}, {{$contact->individu?->code_postal }}, {{$contact->individu?->ville }} </span>
                        </p>
                        
                        <h4 class="text-muted mb-2 font-13">Notes :</h4>
                        <p class="text-muted font-13 mb-3">
                           {{$contact->individu?->notes }}
                        </p>
                       
                        <p class="text-muted mb-2 font-13"><strong>Numéro siret :</strong> <span class="ms-2 ">{{ $contact->individu?->numero_siret }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Numéro TVA :</strong> <span class="ms-2 ">{{ $contact->individu?->numero_tva }}</span></p>

                    </div>

            
                  
                </div> <!-- end card-body -->
            </div> <!-- end card -->

            <!-- Messages-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title"></h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                           
                            </div>
                        </div>
                    </div>

                    <div class="inbox-widget">
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/avatar-2.jpg" class="rounded-circle" alt=""></div>
                            
                            @if( sizeof($contact->individu?->entites) > 0)
                            <h4 class="header-title">Entreprises</h4>
                                @foreach($contact->individu?->entites as $entite)
                                    <a href="{{ route('contact.show', Crypt::encrypt($entite->contact_id)) }}" class="text-muted">
                                        <span class="badge text-info font-15"><li> {{$entite->raison_sociale}}<i class="mdi mdi-eye-outline ms-2"></i></li></span>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                       

                       
                    </div> <!-- end inbox-widget -->
                </div> <!-- end card-body-->
            </div> <!-- end card-->

        </div> <!-- end col-->

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                        {{-- <li class="nav-item">
                            <a href="#interlocuteur" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 ">
                                Interlocuteurs
                            </a>
                        </li> --}}
                      
                        <li class="nav-item">
                            <a href="#activite" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                Prestations
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        
                     
                        <div class="tab-pane show active" id="activite">
                            <button type="button" class="btn btn-secondary btn-sm rounded-pill"
                            data-bs-toggle="modal" data-bs-target="#prestation-modal"><i
                                class="mdi mdi-file-plus-outline me-1"></i> <span>Ajouter prestation</span>
                            </button> <hr>
                            
                            <livewire:prestation.prestation-table client_id="{{ $contact->id }}" />
                        </div>

                    </div> <!-- end tab-content -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->
    @include('prestation.add_modal')    
    
</div> <!-- End Content -->

@endsection

@section('script')
    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>


    

    {{-- Associer individu --}}
    <script>
        $('.nouveau_contact').hide();

        $('#contact_existant').change(function(e) {
            if (e.currentTarget.checked == true) {
                $('.nouveau_contact').hide();
                $('.contact_existant').show();
                $('#nom').removeAttr('required', 'required');
                $('#email').removeAttr('required', 'required');
                $('#newcontact').attr('required', 'required');
                $('#poste').attr('required', 'required');

            } else {
                $('.nouveau_contact').show();
                $('.contact_existant').hide();
                $('#nom').attr('required', 'required');
                $('#email').attr('required', 'required');
                $('#newcontact').removeAttr('required', 'required');
                $('#poste').removeAttr('required', 'required');
            }

        });
    </script>




    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            "use strict";
            $("#tab1").
            DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    info: "Showing actions _START_ to _END_ of _TOTAL_",
                    lengthMenu: 'Afficher <select class=\'form-select form-select-sm ms-1 me-1\'><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> '
                },
                pageLength: 100,

                select: {
                    style: "multi"
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
                        document.querySelector(".dataTables_wrapper .row").querySelectorAll(".col-md-6")
                        .forEach(function(e) {
                            e.classList.add("col-sm-6"), e.classList.remove("col-sm-12"), e
                                .classList.remove("col-md-6")
                        })
                }
            })
        });
    </script>

    <script src="/js/mesfonctions.js"></script>
    <script>
        formater_tel("#telephone_fixe", "#indicatif_fixe");
        formater_tel("#telephone_mobile", "#indicatif_mobile");
    </script>
@endsection
