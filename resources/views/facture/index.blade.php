@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Factures')

@section('content')
<div class="content">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('facture.index') }}">Factures</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Gestion des Factures</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                @can('permission', 'ajouter-facture')
                    <div class="d-flex gap-2">
                        <a href="{{ route('facture.create', ['type' => 'client']) }}" class="btn btn-primary">
                            <i class="mdi mdi-plus-circle me-2"></i> Nouvelle facture client
                        </a>
                        <a href="{{ route('facture.create', ['type' => 'fournisseur']) }}" class="btn btn-warning">
                            <i class="mdi mdi-file-upload me-2"></i> Facture fournisseur
                        </a>
                        <a href="{{ route('facture.create', ['type' => 'directe']) }}" class="btn btn-info">
                            <i class="mdi mdi-file-document me-2"></i> Facture directe
                        </a>
                    </div>
                @endcan
                @can('permission', 'archiver-facture')
                    <a href="{{ route('facture.archives') }}" class="btn btn-secondary">
                        <i class="mdi mdi-archive me-2"></i> Factures archivées
                    </a>
                @endcan
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card">
           
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible text-center border-0 fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <livewire:facture.index-table />
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
        // Archiver
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            
            $('body').on('click', 'a.archive_facture', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Archiver la facture',
                    text: "Voulez-vous vraiment archiver cette facture ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, archiver',
                    cancelButtonText: 'Non, annuler',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: that.attr('data-href'),
                            type: 'PUT',
                            success: function(data) {
                                swalWithBootstrapButtons.fire(
                                    'Archivée !',
                                    'La facture a été archivée avec succès.',
                                    'success'
                                ).then(() => {
                                    document.location.reload();
                                });
                            },
                            error: function(data) {
                                swalWithBootstrapButtons.fire(
                                    'Erreur',
                                    'Une erreur est survenue lors de l\'archivage.',
                                    'error'
                                );
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Annulé',
                            'La facture n\'a pas été archivée.',
                            'error'
                        )
                    }
                });
            })
        });
    </script>
@endsection 