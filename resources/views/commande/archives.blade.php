@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Commandes archivées')

@section('content')
    <div class="content">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('commande.index') }}">Commandes</a></li>
                            <li class="breadcrumb-item active">Archives</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Commandes archivées</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

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
                                <a href="{{ route('commande.index') }}" class="btn btn-primary mb-2">
                                    <i class="mdi mdi-arrow-left me-2"></i> Retour aux commandes
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <livewire:commande.commande-archive-table />
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
        // Désarchiver une commande
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            
            $('body').on('click', 'button.desarchiver_commande', function(event) {
                event.preventDefault()
                
                const button = $(this)
                
                Swal.fire({
                    title: 'Désarchiver la commande',
                    text: "Êtes-vous sûr de vouloir désarchiver cette commande ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, désarchiver',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: button.data('href'),
                            type: 'POST',
                            success: function() {
                                Swal.fire(
                                    'Désarchivée !',
                                    'La commande a été désarchivée avec succès.',
                                    'success'
                                )
                                button.closest('tr').remove()
                            },
                            error: function() {
                                Swal.fire(
                                    'Erreur !',
                                    'Une erreur est survenue lors du désarchivage.',
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