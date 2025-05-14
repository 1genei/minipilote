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
                    
                 
                    <h4 class="mb-0 mt-2">
                        {{ $contact->individu?->civilite }} {{ $contact->individu?->nom }} {{ $contact->individu?->prenom }}
                        <a href="{{ route('contact.edit', Crypt::encrypt($contact->id)) }}" class="text-muted">
                            <i class="mdi mdi-square-edit-outline ms-2"></i>
                        </a>
                    </h4>

                    <div class="mt-3">
                    @foreach ($contact->typecontacts as $typecontact)
                            @switch($typecontact->type)
                                @case('Prospect')
                                    <span class="badge bg-secondary rounded-pill">{{$typecontact->type}}</span>
                                    @break
                                @case('Client')
                                    <span class="badge bg-info rounded-pill">{{$typecontact->type}}</span>
                                    @break
                                @case('Fournisseur')
                                    <span class="badge bg-warning rounded-pill">{{$typecontact->type}}</span>
                                    @break
                                @case('Collaborateur')
                                    <span class="badge bg-danger rounded-pill">{{$typecontact->type}}</span>
                                    @break
                                @case('Bénéficiaire')
                                    <span class="badge bg-primary rounded-pill">{{$typecontact->type}}</span>
                                    @break
                                @default
                                    <span class="badge bg-light rounded-pill">{{$typecontact->type}}</span>
                            @endswitch
                        @endforeach
                    </div>

                    {{-- Tags --}}
                    @if($contact->tags->count() > 0)
                    <div class="mt-2">
                        @foreach($contact->tags as $tag)
                            <span class="badge bg-primary-lighten text-primary rounded-pill">
                                <i class="mdi mdi-tag-outline"></i> {{ $tag->nom }}
                            </span>
                        @endforeach
                    </div>
                    @endif

                    <div class="text-start mt-4">
                        <h5 class="font-13 text-uppercase">Informations de contact :</h5>
                        
                        @if($contact->source_contact)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-source-branch me-1"></i> Source du contact :</strong>
                            <span class="ms-2">{{ $contact->source_contact }}</span>
                        </p>
                        @endif

                        @if($contact->secteurActivite)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-domain me-1"></i> Secteur d'activité :</strong>
                            <span class="ms-2">{{ $contact->secteurActivite->nom }}</span>
                        </p>
                        @endif

                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-email me-1"></i> Email :</strong>
                            <span class="ms-2">{{ $contact->individu?->email }}</span>
                        </p>

                        @if($contact->individu?->telephone_fixe)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-phone me-1"></i> Téléphone Fixe :</strong>
                            <span class="ms-2">{{ $contact->individu?->indicatif_fixe }} {{ $contact->individu?->telephone_fixe }}</span>
                        </p>
                        @endif

                        @if($contact->individu?->telephone_mobile)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-cellphone me-1"></i> Téléphone Mobile :</strong>
                            <span class="ms-2">{{ $contact->individu?->indicatif_mobile }} {{ $contact->individu?->telephone_mobile }}</span>
                        </p>
                        @endif
                    
                        @if($contact->individu?->entreprise)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-office-building me-1"></i> Entreprise :</strong>
                            <span class="ms-2">{{ $contact->individu?->entreprise }}</span>
                        </p>
                        @endif

                        @if($contact->individu?->fonction_entreprise)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-badge-account me-1"></i> Fonction :</strong>
                            <span class="ms-2">{{ $contact->individu?->fonction_entreprise }}</span>
                        </p>
                        @endif

                        <h5 class="font-13 text-uppercase mt-4">Adresse :</h5>
                        <p class="text-muted mb-2">
                            <i class="mdi mdi-map-marker me-1"></i>
                            {{ $contact->individu?->numero_voie }} {{ $contact->individu?->nom_voie }}
                            @if($contact->individu?->complement_voie)
                                <br><span class="ms-4">{{ $contact->individu?->complement_voie }}</span>
                            @endif
                            @if($contact->individu?->residence || $contact->individu?->batiment || $contact->individu?->escalier || $contact->individu?->etage || $contact->individu?->porte)
                                <br><span class="ms-4">
                                    {{ $contact->individu?->residence }}
                                    {{ $contact->individu?->batiment ? 'Bât. '.$contact->individu?->batiment : '' }}
                                    {{ $contact->individu?->escalier ? 'Esc. '.$contact->individu?->escalier : '' }}
                                    {{ $contact->individu?->etage ? 'Étage '.$contact->individu?->etage : '' }}
                                    {{ $contact->individu?->porte ? 'Porte '.$contact->individu?->porte : '' }}
                                </span>
                            @endif
                            <br><span class="ms-4">{{ $contact->individu?->code_postal }} {{ $contact->individu?->ville }}</span>
                            @if($contact->individu?->pays && $contact->individu?->pays != 'France')
                                <br><span class="ms-4">{{ $contact->individu?->pays }}</span>
                            @endif
                        </p>

                        @if($contact->individu?->date_naissance)
                        <h5 class="font-13 text-uppercase mt-4">Informations personnelles :</h5>
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-calendar me-1"></i> Date de naissance :</strong>
                            <span class="ms-2">{{ \Carbon\Carbon::parse($contact->individu?->date_naissance)->format('d/m/Y') }}</span>
                        </p>
                        @endif

                        @if($contact->individu?->notes)
                        <h5 class="font-13 text-uppercase mt-4">Notes :</h5>
                        <p class="text-muted mb-2">
                            {{ $contact->individu?->notes }}
                        </p>
                        @endif

                        @if($contact->individu?->numero_siret || $contact->individu?->numero_tva)
                        <h5 class="font-13 text-uppercase mt-4">Informations légales :</h5>
                        @if($contact->individu?->numero_siret)
                        <p class="text-muted mb-2">
                            <strong>SIRET :</strong>
                            <span class="ms-2">{{ $contact->individu?->numero_siret }}</span>
                        </p>
                        @endif
                        @if($contact->individu?->numero_tva)
                        <p class="text-muted mb-2">
                            <strong>TVA :</strong>
                            <span class="ms-2">{{ $contact->individu?->numero_tva }}</span>
                        </p>
                        @endif
                        @endif
                    </div>

            
                  
                </div> <!-- end card-body -->
            </div> <!-- end card -->

            <!-- Messages-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Notes</h4>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                            <i class="mdi mdi-plus-circle me-1"></i> Nouvelle note
                        </button>
                    </div>
                    <livewire:notes.notes-list :contact_id="$contact->id" />
                    

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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-pane" id="taches">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Tâches</h5>                                        
                                    @can('permission', 'ajouter-agenda')
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add-modal">
                                            <i class="mdi mdi-plus-circle me-1"></i> Nouvelle tâche
                                        </button>                                       
                                    @endcan
                                </div>
                                
                                <livewire:taches.tasks-list :contact_id="$contact->id" />
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-12">
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
                                        Commandes
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">    
                                <div class="tab-pane show active" id="activite">
                                    <a href="{{ route('commande.create', Crypt::encrypt($contact->id)) }}" class="btn btn-secondary btn-sm rounded-pill"><i class="mdi mdi-file-plus-outline me-1"></i> <span>Ajouter commande</span>
                                    </a> <hr>
                                    
                                    <livewire:commande.commande-table client_id="{{ $contact->id }}" />
                                </div>
                            </div> <!-- end tab-content -->
                            
                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row-->
    {{-- @include('prestation.add_modal')     --}}
    
</div> <!-- End Content -->

<div class="loading-overlay">
    <div class="loading-content">
        <div class="spinner-border text-light" role="status"></div>
        <p class="mt-2">Enregistrement en cours...</p>
    </div>
</div>

<!-- Inclusion des modals -->
@include('agenda.components.add-modal')
@include('agenda.components.edit-modal')

<style>
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
    }
    .loading-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        text-align: center;
    }
</style>

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

    @stack('scripts')
    @include('partials._sidebar_collapse')
@endsection
