@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Plannings')

@section('content')
<div class="content">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Plannings</li>
                    </ol>
                </div>
                <h4 class="page-title">Gestion des plannings</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                @can('permission', 'ajouter-planning')
                    <a href="{{ route('planning.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus-circle me-1"></i> Créer un planning
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('ok'))
                        <div class="alert alert-success alert-dismissible text-center border-0 fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>{{ session('ok') }}</strong>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <livewire:planning.index-table />
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection 

@section('script')
    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>

    <script>
        $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            // Archiver
            $('body').on('click', 'a.archive_planning', function(event) {
                let that = $(this);
                event.preventDefault();

                const swal2 = swal.mixin({
                    customClass: { confirmButton: 'btn btn-success', cancelButton: 'btn btn-danger' },
                    buttonsStyling: false
                });

                swal2.fire({
                    title: 'Archiver le planning',
                    text: 'Voulez-vous vraiment archiver ce planning ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, archiver',
                    cancelButtonText: 'Non, annuler',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = that.attr('data-href');
                    }
                });
            });

            // Supprimer
            $('body').on('click', 'a.delete_planning', function(event) {
                let that = $(this);
                event.preventDefault();

                const swal2 = swal.mixin({
                    customClass: { confirmButton: 'btn btn-danger', cancelButton: 'btn btn-secondary' },
                    buttonsStyling: false
                });

                swal2.fire({
                    title: 'Supprimer le planning',
                    text: 'Cette action est irréversible. Confirmer ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Non, annuler',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: that.attr('data-href'),
                            type: 'DELETE',
                            success: function() {
                                swal2.fire('Supprimé !', 'Le planning a été supprimé.', 'success')
                                    .then(() => document.location.reload());
                            },
                            error: function() {
                                swal2.fire('Erreur', 'Impossible de supprimer ce planning.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
