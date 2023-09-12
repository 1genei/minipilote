@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
@endsection

@section('title', 'Modification valeur')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Valeurs pour {{ $caracteristique->nom }} </a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Valeurs pour {{ $caracteristique->nom }} </h4>
                </div>
            </div>

            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-6 ">

                                <a href="{{ route('caracteristique.index') }}" type="button"
                                    class="btn btn-outline-primary"><i class="uil-arrow-left"></i>
                                    Caractéristiques</a>

                                <a href="#" class="btn btn-primary " type="button" data-bs-toggle="modal"
                                    data-bs-target="#standard-modal">
                                    <i class="mdi mdi-plus-circle me-2"></i> Nouvelle valeur
                                </a>
                                @if ($errors->has('nom'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " caracteristique="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </div>
                                @endif

                                <strong> {{ session('message') }}</strong>
                            </div>
                            @if (session('ok'))
                                <div class="col-6">
                                    <div class="alert alert-success alert-dismissible  text-center border-0 fade show"
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
            </div>
        </div>
        <!-- end page title -->

        <!-- end row-->

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">



                        <!-- end row-->
                        <div class="row">

                            <div class="col-6">
                                @if (session('message'))
                                    <div class="alert alert-success text-secondary alert-dismissible ">
                                        <i class="dripicons-checkmark me-2"></i>
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <a href="#" class="alert-link"><strong> {{ session('message') }}</strong></a>
                                    </div>
                                @endif


                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap"
                                id="tab1">
                                <thead class="table-light">
                                    <tr>
                                        <th>Valeurs</th>
                                        <th>Statut</th>
                                        <th style="width: 125px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($caracteristique->valeurcaracteristiques as $valeur)
                                        <tr>

                                            <td>
                                                <a href="#" class="text-body fw-bold">{{ $valeur->nom }}</a>
                                            </td>

                                            <td>
                                                @if ($valeur->archive == false)
                                                    <span class="badge bg-success">Actif</span>
                                                @else
                                                    <span class="badge bg-warning">Archivé</span>
                                                @endif
                                            </td>

                                            <td>

                                                <a data-href="{{ route('caracteristique_valeur.update', Crypt::encrypt($valeur->id)) }}"
                                                    data-nom="{{ $valeur->nom }}" data-bs-toggle="modal"
                                                    data-bs-target="#edit-caracteristique-valeur"
                                                    class="action-icon edit-caracteristique-valeur text-success">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>
                                                @if ($valeur->archive == false)
                                                    <a data-href="{{ route('caracteristique_valeur.archive', Crypt::encrypt($valeur->id)) }}"
                                                        style="cursor: pointer;"
                                                        class="action-icon archive-caracteristique text-warning"> <i
                                                            class="mdi mdi-archive-arrow-down"></i></a>
                                                @else
                                                    <a data-href="{{ route('caracteristique_valeur.unarchive', Crypt::encrypt($valeur->id)) }}"
                                                        style="cursor: pointer;"
                                                        class="action-icon unarchive-caracteristique text-success"> <i
                                                            class="mdi mdi-archive-arrow-up"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>


                        <style>
                            .select2-container .select2-selection--single {
                                height: calc(1.69em + 0.9rem + 2px);
                            }
                        </style>



                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->




        {{-- Ajout d'une caractéristique --}}
        <div id="standard-modal" class="modal fade" tabindex="-1" caracteristique="dialog"
            aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-dark">
                        <h4 class="modal-title" id="standard-modalLabel">Ajouter une valeur pour
                            {{ $caracteristique->nom }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('caracteristique_valeur.store') }}" method="post">
                        <div class="modal-body">

                            @csrf
                            <div class="col-lg-12">
                                <input type="hidden" name="caracteristique_id" value="{{ $caracteristique->id }}">
                                <div class="form-floating mb-3">
                                    <input type="text" name="nom" value="{{ old('nom') ? old('nom') : '' }}"
                                        class="form-control" id="floatingInput">
                                    <label for="floatingInput">Valeur</label>
                                    @if ($errors->has('nom'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " caracteristique="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('nom') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-dark">Enregistrer</button>

                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->




        {{-- Modification d'une caractéristique --}}
        <div id="edit-caracteristique-valeur" class="modal fade" tabindex="-1" caracteristique="dialog"
            aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-dark">
                        <h4 class="modal-title" id="standard-modalLabel">Modification </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="" id="edit_form" method="post">
                        <div class="modal-body">

                            @csrf
                            <div class="col-lg-12">

                                <div class="form-floating mb-3">
                                    <input type="text" name="nom" value="{{ old('nom') ? old('nom') : '' }}"
                                        class="form-control" id="edit_nom">
                                    <label for="edit_nom">Valeur</label>
                                    @if ($errors->has('nom'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " caracteristique="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('nom') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-dark">Enregistrer</button>

                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->




    </div> <!-- End Content -->
@endsection

@section('script')

    {{-- Modification d'une caractéristique --}}
    <script>
        $('.edit-caracteristique-valeur').click(function(e) {

            let that = $(this);
            let currentCaracteristique = that.data('nom');
            let currentFormAction = that.data('href');
            $('#edit_nom').val(currentCaracteristique);
            $('#edit_form').attr('action', currentFormAction);

        })
    </script>


    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.archive-caracteristique', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Archiver',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
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
                                        'Archivée',
                                        '',
                                        'success'
                                    )

                                    .then((result) => {
                                        if (result.isConfirmed) {
                                            document.location.reload();
                                        }
                                    })


                                // that.parents('tr').remove();
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulé',
                            'Caracteristique non archivée :)',
                            'error'
                        )
                    }
                });
            })

        });
    </script>

    <script>
        // Désarchiver

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.unarchive-caracteristique', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Désarchiver',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
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
                                        'Désarchivée',
                                        '',
                                        'success'
                                    )
                                    .then((result) => {
                                        if (result.isConfirmed) {
                                            document.location.reload();
                                        }
                                    })
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulé',
                            'Caracteristique non désarchivée :)',
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
                    info: "Affichage de  _START_ à _END_ sur _TOTAL_",
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



@endsection
