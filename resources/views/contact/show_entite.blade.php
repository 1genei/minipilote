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
                <h4 class="page-title">Contact - {{ $contact->entite?->raison_sociale }}</h4>
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
                    
                    <p class="text-muted font-14">{{ $contact->entite?->forme_juridique }}</p>
                    <h4 class="mb-0 mt-2">
                        {{ $contact->entite?->raison_sociale }}
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
                        <h5 class="font-13 text-uppercase">Informations de l'entreprise :</h5>
                        
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
                    
                        @if($contact->entite?->numero_siret)
                        <p class="text-muted mb-2">
                            <strong>SIRET :</strong>
                            <span class="ms-2">{{ $contact->entite?->numero_siret }}</span>
                        </p>
                        @endif

                        @if($contact->entite?->numero_tva)
                        <p class="text-muted mb-2">
                            <strong>TVA :</strong>
                            <span class="ms-2">{{ $contact->entite?->numero_tva }}</span>
                        </p>
                        @endif

                        <h5 class="font-13 text-uppercase mt-4">Informations de contact :</h5>
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-email me-1"></i> Email :</strong>
                            <span class="ms-2">{{ $contact->entite?->email }}</span>
                        </p>

                        @if($contact->entite?->telephone_fixe)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-phone me-1"></i> Téléphone Fixe :</strong>
                            <span class="ms-2">{{ $contact->entite?->indicatif_fixe }} {{ $contact->entite?->telephone_fixe }}</span>
                        </p>
                        @endif

                        @if($contact->entite?->telephone_mobile)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-cellphone me-1"></i> Téléphone Mobile :</strong>
                            <span class="ms-2">{{ $contact->entite?->indicatif_mobile }} {{ $contact->entite?->telephone_mobile }}</span>
                        </p>
                        @endif
                    
                        <h5 class="font-13 text-uppercase mt-4">Adresse :</h5>
                        <p class="text-muted mb-2">
                            <i class="mdi mdi-map-marker me-1"></i>
                            {{ $contact->entite?->numero_voie }} {{ $contact->entite?->nom_voie }}
                            @if($contact->entite?->complement_voie)
                                <br><span class="ms-4">{{ $contact->entite?->complement_voie }}</span>
                            @endif
                            @if($contact->entite?->residence || $contact->entite?->batiment || $contact->entite?->escalier || $contact->entite?->etage || $contact->entite?->porte)
                                <br><span class="ms-4">
                                    {{ $contact->entite?->residence }}
                                    {{ $contact->entite?->batiment ? 'Bât. '.$contact->entite?->batiment : '' }}
                                    {{ $contact->entite?->escalier ? 'Esc. '.$contact->entite?->escalier : '' }}
                                    {{ $contact->entite?->etage ? 'Étage '.$contact->entite?->etage : '' }}
                                    {{ $contact->entite?->porte ? 'Porte '.$contact->entite?->porte : '' }}
                                </span>
                            @endif
                            <br><span class="ms-4">{{ $contact->entite?->code_postal }} {{ $contact->entite?->ville }}</span>
                            @if($contact->entite?->pays && $contact->entite?->pays != 'France')
                                <br><span class="ms-4">{{ $contact->entite?->pays }}</span>
                            @endif
                        </p>

                        @if($contact->entite?->notes)
                        <h5 class="font-13 text-uppercase mt-4">Notes :</h5>
                        <p class="text-muted mb-2">
                            {{ $contact->entite?->notes }}
                        </p>
                        @endif

                        <h5 class="font-13 text-uppercase mt-4">Informations légales :</h5>
                        @if($contact->entite?->code_naf)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-office-building-outline me-1"></i> Code NAF :</strong>
                            <span class="ms-2">{{ $contact->entite?->code_naf }}</span>
                        </p>
                        @endif
                        @if($contact->entite?->numero_rcs)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-file-document-outline me-1"></i> RCS :</strong>
                            <span class="ms-2">{{ $contact->entite?->numero_rcs }}</span>
                        </p>
                        @endif

                        @if($contact->entite?->site_web)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-web me-1"></i> Site web :</strong>
                            <span class="ms-2">
                                <a href="{{ $contact->entite?->site_web }}" target="_blank" class="text-primary">
                                    {{ $contact->entite?->site_web }}
                                </a>
                            </span>
                        </p>
                        @endif

                        @if($contact->entite?->rib_bancaire || $contact->entite?->iban || $contact->entite?->bic)
                        <h5 class="font-13 text-uppercase mt-4">Informations bancaires :</h5>
                        @if($contact->entite?->rib_bancaire)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-bank me-1"></i> RIB :</strong>
                            <span class="ms-2">{{ $contact->entite?->rib_bancaire }}</span>
                        </p>
                        @endif
                        @if($contact->entite?->iban)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-bank-transfer me-1"></i> IBAN :</strong>
                            <span class="ms-2">{{ $contact->entite?->iban }}</span>
                        </p>
                        @endif
                        @if($contact->entite?->bic)
                        <p class="text-muted mb-2">
                            <strong><i class="mdi mdi-bank-outline me-1"></i> BIC :</strong>
                            <span class="ms-2">{{ $contact->entite?->bic }}</span>
                        </p>
                        @endif
                        @endif
                    </div>


                    <button type="button" class="btn btn-warning btn-sm rounded-pill mt-4"
                    data-bs-toggle="modal" data-bs-target="#standard-modal"><i
                        class="mdi mdi-account-plus me-1"></i> <span>Ajouter interlocuteur</span>
                    </button> <hr>
                    
                    <livewire:contact.associes-table entite_id="{{ $entite_id }}" />

            
                  
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
                        <div class="tab-content">
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

                    {{-- Nouvelle section pour les notes --}}
                    <div class="col-12">
            <div class="card">
                <div class="card-body">
                                
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                      
                        <li class="nav-item">
                                                <a href="#activite" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                            Commandes
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                                    
                                    <div class="tab-pane show active" id="activite">
                                        <a href="{{ route('commande.create', Crypt::encrypt($contact->id)) }}" class="btn btn-secondary btn-sm rounded-pill"><i
                                            class="mdi mdi-file-plus-outline me-1"></i> <span>Ajouter commande</span>
                                        </a> <hr>
                                        
                                        <livewire:commande.commande-table client_id="{{ $contact->id }}" />
                        </div>

                    </div> <!-- end tab-content -->
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
  
    <!-- end row-->
    @include('contact.add_interlocuteur')    
    {{-- @include('prestation.add_modal')     --}}
    
    <div class="loading-overlay">
        <div class="loading-content">
            <div class="spinner-border text-light" role="status"></div>
            <p class="mt-2">Enregistrement en cours...</p>
        </div>
    </div>

    <!-- Inclusion des modals -->
    @include('agenda.components.add-modal')
    @include('agenda.components.edit-modal')
    
</div> <!-- End Content -->

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
                // $('#email').removeAttr('required', 'required');
                $('#newcontact').attr('required', 'required');
                $('#poste').attr('required', 'required');

            } else {
                $('.nouveau_contact').show();
                $('.contact_existant').hide();
                $('#nom').attr('required', 'required');
                // $('#email').attr('required', 'required');
                $('#newcontact').removeAttr('required', 'required');
                $('#poste').removeAttr('required', 'required');
            }

        });


    </script>

    {{-- Prendre en compte la recherche dans le modal --}}
    <script>
        $('.select2').select2({
            dropdownParent: $('#standard-modal')
        });
    </script>

    <script>
        // Retirer

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.dissocier_individu', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Retirer l\'interlocuteur',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
                                // url:"/role/desarchiver/2",

                                type: 'POST',
                                success: function(data) {

                                    // document.location.reload();
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            })
                            .done(function() {

                                swalWithBootstrapButtons.fire(
                                    'Confirmation',
                                    'Interlocuteur retiré',
                                    'success'
                                )
                                document.location.reload();
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Interlocuteur conservé',
                            'error'
                        )
                    }
                });
            })

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
