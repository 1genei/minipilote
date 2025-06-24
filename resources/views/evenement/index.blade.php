@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Évènements')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('evenement.index') }}">Évènements</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Gestion des Évènements</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    @can('permission', 'ajouter-evenement')
                        <a href="{{ route('evenement.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus-circle me-2"></i> Ajouter un évènement
                        </a>
                    @endcan
                    @can('permission', 'archiver-evenement')
                        <a href="{{ route('evenement.archives') }}" class="btn btn-warning">
                            <i class="mdi mdi-archive me-2"></i> Évènements archivés
                        </a>
                    @endcan
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h4 class="header-title">Liste des évènements</h4>
              
                    </div>
                    <div class="card-body">
                        @if (session('ok'))
                            <div class="alert alert-success alert-dismissible text-center border-0 fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>{{ session('ok') }}</strong>
                            </div>
                        @endif
                        @if (session('message'))
                            <div class="alert alert-success text-secondary alert-dismissible">
                                <i class="dripicons-checkmark me-2"></i>
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>{{ session('message') }}</strong>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <livewire:evenement.index-table />
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
            $('body').on('click', 'a.archive_evenement', function(event) {
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
                    title: 'Archiver l\'évènement',
                    text: "Voulez-vous vraiment archiver cet évènement ?",
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
                                    'Archivé !',
                                    'L\'évènement a été archivé avec succès.',
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
                            'L\'évènement n\'a pas été archivé.',
                            'error'
                        )
                    }
                });
            })
        });
    </script>
@endsection
