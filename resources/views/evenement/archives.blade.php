@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Évènements archivés')

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('evenement.index') }}">Évènements</a></li>
                            <li class="breadcrumb-item active">Archives</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Évènements archivés</h4>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('evenement.index') }}" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left me-2"></i> Retour aux évènements
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h4 class="header-title">Liste des évènements archivés</h4>
                    </div>
                    <div class="card-body">
                        @if (session('ok'))
                            <div class="alert alert-success alert-dismissible text-center border-0 fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>{{ session('ok') }}</strong>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <livewire:evenement.archive-table />
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
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', 'a.unarchive_evenement', function(event) {
                let that = $(this);
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Désarchiver l\'évènement',
                    text: "Voulez-vous vraiment désarchiver cet évènement ?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, désarchiver',
                    cancelButtonText: 'Non, annuler',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: that.attr('data-href'),
                            type: 'PUT',
                            success: function(data) {
                                swalWithBootstrapButtons.fire(
                                    'Désarchivé !',
                                    'L\'évènement a été désarchivé avec succès.',
                                    'success'
                                ).then(() => {
                                    document.location.reload();
                                });
                            },
                            error: function(data) {
                                swalWithBootstrapButtons.fire(
                                    'Erreur',
                                    'Une erreur est survenue lors du désarchivage.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
