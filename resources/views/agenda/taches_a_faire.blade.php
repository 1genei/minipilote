@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
        <style>
            /* Forcer l'affichage de toutes les colonnes */
            .table-responsive {
                overflow-x: auto !important;
                min-width: 100%;
            }
            
            /* Définir des largeurs minimales pour certaines colonnes */
            .table th, .table td {
                white-space: normal;
                min-width: 100px;
            }
            
            /* Largeurs spécifiques pour chaque colonne */
            .table th.col-user, .table td.col-user { min-width: 150px; }
            .table th.col-contact, .table td.col-contact { min-width: 200px; }
            .table th.col-type, .table td.col-type { min-width: 120px; }
            .table th.col-task, .table td.col-task { min-width: 250px; }
            .table th.col-date, .table td.col-date { min-width: 150px; }
            .table th.col-status, .table td.col-status { min-width: 100px; }
            .table th.col-actions, .table td.col-actions { min-width: 100px; }
    
            /* Style pour les tâches en retard */
            .task-overdue {
                background-color: rgba(255, 0, 0, 0.05);
            }
            
            /* Style pour forcer le retour à la ligne dans la colonne tâche */
            .task-description {
                white-space: normal !important;
                word-wrap: break-word;
                max-width: 250px;
            }
            
            .task-title {
                font-weight: bold;
                color: #e05555;
                margin-bottom: 5px;
            }
            
            .task-details {
                font-style: italic;
                color: #666;
                font-size: 0.9em;
            }
    
            /* Styles pour les flèches de tri */
            th.sortable {
                cursor: pointer;
                position: relative;
                padding-right: 20px !important;
            }
    
            th.sortable:before,
            th.sortable:after {
                content: '';
                position: absolute;
                right: 8px;
                width: 0;
                height: 0;
                border-style: solid;
            }
    
            th.sortable:before {
                top: 40%;
                border-width: 0 4px 4px;
                border-color: transparent transparent #999 transparent;
            }
    
            th.sortable:after {
                bottom: 40%;
                border-width: 4px 4px 0;
                border-color: #999 transparent transparent transparent;
            }
    
            th.sortable.asc:before {
                border-color: transparent transparent #000 transparent;
            }
    
            th.sortable.desc:after {
                border-color: #000 transparent transparent transparent;
            }
    
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

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('agenda.index') }}">Agenda</a></li>
                            <li class="breadcrumb-item active">Tâches à faire</li>
                        </ol>
                    </div>
                    <h4 class="page-title text-warning">
                        <i class="mdi mdi-calendar-check me-1"></i> Tâches à faire
                    </h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 mr-14 ">
                                <a href="{{ route('agenda.index') }}" type="button" class="btn btn-danger"><i
                                        class="uil-calendar-alt"></i> Affichage sur le calendrier</a>
                            </div>
                            @if (session('ok'))
                                <div class="col-6">
                                    <div class="alert alert-success alert-dismissible bg-success text-white text-center border-0 fade show"
                                        role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong> {{ session('ok') }}</strong>
                                    </div>
                                </div>
                            @endif

                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col-->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-5">
                                @can('permission', 'ajouter-agenda')
                                    <a href="javascript:void(0);" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                        data-bs-target="#add-modal"><i class="mdi mdi-plus-circle me-2"></i> Ajouter
                                        tâche
                                    </a>
                                @endcan
                            </div>
                            <div class="col-sm-7">

                            </div><!-- end col-->
                        </div>
                        <div class="row">

                            <div class="col-6">
                                @if (session('message'))
                                    <div class="alert alert-success text-secondary alert-dismissible ">
                                        <i class="dripicons-checkmark me-2"></i>
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <a href="#" class="alert-link"><strong> {{ session('message') }}</strong></a>
                                    </div>
                                @endif
                                @if ($errors->has('role'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </div>
                                @endif
                                <div id="div-role-message"
                                    class="alert alert-success text-secondary alert-dismissible fade in">
                                    <i class="dripicons-checkmark me-2"></i>
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <a href="#" class="alert-link"><strong> <span
                                                id="role-message"></span></strong></a>
                                </div>

                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="media">
                                        @include("agenda.components.tasks-table", ['route' => route('agenda.listing_a_faire')])
                                        <hr>


                                    </div>
                                </div>
                            </div>
                        </div>






                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

        <style>
            .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
                width: 100%;

            }
        </style>

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
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/i18n/defaults-fr_FR.js"></script>

    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>

    @stack('scripts')
    @include('partials._sidebar_collapse')
@endsection
