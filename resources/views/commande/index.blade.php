@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Commandes')

@section('content')
    <div class="content">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('commande.index') }}">Commandes</a></li>
                            <li class="breadcrumb-item active">Liste</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Gestion des Commandes</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Stats -->
        {{-- <div class="row">
            <div class="col-xl-3 col-lg-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-cart-plus widget-icon bg-success-lighten text-success"></i>
                        </div>
                        <h6 class="text-muted text-uppercase mt-0">Commandes du mois</h6>
                        <h3 class="text-success mt-3 mb-3">{{ $commandes_mois_count ?? 0 }}</h3>
                        <p class="mb-0">
                            <span class="text-nowrap">Total : {{ number_format($commandes_mois_total ?? 0, 2, ',', ' ') }} €</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-clock-alert widget-icon bg-warning-lighten text-warning"></i>
                        </div>
                        <h6 class="text-muted text-uppercase mt-0">En attente</h6>
                        <h3 class="text-warning mt-3 mb-3">{{ $commandes_en_cours ?? 0 }}</h3>
                        <p class="mb-0">
                            <span class="text-nowrap">À traiter rapidement</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-currency-eur widget-icon bg-info-lighten text-info"></i>
                        </div>
                        <h6 class="text-muted text-uppercase mt-0">Non payées</h6>
                        <h3 class="text-info mt-3 mb-3">{{ $commandes_non_payees ?? 0 }}</h3>
                        <p class="mb-0">
                            <span class="text-nowrap">Total : {{ number_format($montant_non_paye ?? 0, 2, ',', ' ') }} €</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-archive widget-icon bg-danger-lighten text-danger"></i>
                        </div>
                        <h6 class="text-muted text-uppercase mt-0">Archivées</h6>
                        <h3 class="text-danger mt-3 mb-3">{{ $commandes_archivees ?? 0 }}</h3>
                        <p class="mb-0">
                            <span class="text-nowrap">Sur les 12 derniers mois</span>
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Alerts -->
        @if (session('ok'))
            <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Succès ! </strong> {{ session('ok') }}
            </div>
        @endif

        <!-- Main card -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-5">
                                @can('permission', 'ajouter-commande')
                                    <a href="{{ route('commande.create') }}" class="btn btn-primary mb-2">
                                        <i class="mdi mdi-plus-circle me-2"></i> Nouvelle commande
                                    </a>
                                @endcan
                            </div>
                            <div class="col-sm-7">
                                <div class="text-sm-end">
                                    @can('permission', 'archiver-commande')
                                        <a href="{{ route('commande.archives') }}" class="btn btn-warning mb-2">
                                            <i class="mdi mdi-archive me-2"></i> Commandes archivées
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <livewire:commande.commande-table />
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- End Content -->
@endsection

@section('script')
    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>

    <script>
        // Archiver une commande
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            
            $('body').on('click', 'button.archive_commande', function(event) {
                event.preventDefault()
                
                const button = $(this)
                
                Swal.fire({
                    title: 'Archiver la commande',
                    text: "Êtes-vous sûr de vouloir archiver cette commande ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, archiver',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: button.data('href'),
                            type: 'POST',
                            success: function() {
                                Swal.fire(
                                    'Archivée !',
                                    'La commande a été archivée avec succès.',
                                    'success'
                                )
                                button.closest('tr').remove()
                            },
                            error: function() {
                                Swal.fire(
                                    'Erreur !',
                                    'Une erreur est survenue lors de l\'archivage.',
                                    'error'
                                )
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection

