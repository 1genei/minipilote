@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('title', 'Caractéristiques produit')

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('caracteristique.index') }}">Caractéristiques des
                                    produits</a>
                            </li>
                        </ol>
                    </div>
                    <h4 class="page-title">Caractéristiques</h4>
                </div>
            </div>
        </div>

        <style>
            body {

                font-size: 13px;
            }
        </style>
        <div class="row">
            <div class="col-lg-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 mr-14 ">
                                {{-- <a href="{{route('caracteristique.index')}}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Caracteristiques</a> --}}
                            </div>
                            @if (session('ok'))
                                <div class="col-6">
                                    <div class="alert alert-success alert-dismissible  text-center border-0 fade show"
                                        caracteristique="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong> {{ session('ok') }}</strong>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex justify-content-start">
                                @can('permission', 'ajouter-caracteristique-produit')
                                    <a href="#" class="btn btn-primary mb-2" type="button" data-bs-toggle="modal"
                                        data-bs-target="#standard-modal">
                                        <i class="mdi mdi-plus-circle me-2"></i> Ajouter caractéristique
                                    </a>
                                @endcan

                            </div>
                            <div class="d-flex justify-content-end">
                                @can('permission', 'archiver-caracteristique-produit')
                                    <a href="{{ route('caracteristique.archives') }}" class="btn btn-warning mb-2">
                                        <i class="mdi mdi-archive me-2"></i> Caractéristiques archivées
                                    </a>
                                @endcan
                            </div>
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
                                @if ($errors->has('nom'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " caracteristique="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-centered table-borderless table-hover w-100 dt-responsive "
                                id="tab1">
                                <thead class="table-light">
                                    <tr>

                                        <th>Caractéristiques</th>
                                        <th>Valeurs</th>
                                        <th>Utiliser pour calculer le prix du produit</th>
                                        <th>Type de calcul</th>
                                        <th>Statut</th>
                                        <th style="width: 125px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($caracteristiques as $caracteristique)
                                        <tr>

                                            <td>
                                                <a href="#" class="text-body fw-bold">{{ $caracteristique->nom }}</a>
                                            </td>
                                            <td>
                                                @foreach ($caracteristique->valeurcaracteristiques as $key => $val)
                                                    {{ $val->nom }}
                                                    @if ($key < count($caracteristique->valeurcaracteristiques) - 1)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($caracteristique->calcul_prix_produit)
                                                    <span class="badge bg-success">Oui</span>
                                                @else
                                                    <span class="badge bg-danger">Non</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($caracteristique->calcul_prix_produit_type == "multiplier")
                                                    <span class="badge bg-success">Multiplier</span>
                                                @elseif ($caracteristique->calcul_prix_produit_type == "additionner")
                                                    <span class="badge bg-danger">Additionner</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($caracteristique->archive == false)
                                                    <span class="badge bg-success">Actif</span>
                                                @else
                                                    <span class="badge bg-warning">Archivé</span>
                                                @endif
                                            </td>

                                            <td>
                                                @can('permission', 'afficher-caracteristique-produit')
                                                    <a href="{{ route('caracteristique.show', Crypt::encrypt($caracteristique->id)) }}"
                                                        class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                                @endcan
                                                @can('permission', 'modifier-caracteristique-produit')
                                                    <a data-href="{{ route('caracteristique.update', Crypt::encrypt($caracteristique->id)) }}"
                                                        data-nom="{{ $caracteristique->nom }}" 
                                                        data-calcul_prix_produit = "{{$caracteristique->calcul_prix_produit}}"
                                                        data-calcul_prix_produit_type = "{{$caracteristique->calcul_prix_produit_type}}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit-caracteristique"
                                                        class="action-icon edit-caracteristique text-success">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                @endcan
                                                @can('permission', 'archiver-caracteristique-produit')
                                                    @if ($caracteristique->archive == false)
                                                        <a data-href="{{ route('caracteristique.archive', Crypt::encrypt($caracteristique->id)) }}"
                                                            style="cursor: pointer;"
                                                            class="action-icon archive-caracteristique text-warning"> <i
                                                                class="mdi mdi-archive-arrow-down"></i></a>
                                                    @else
                                                        <a data-href="{{ route('caracteristique.unarchive', Crypt::encrypt($caracteristique->id)) }}"
                                                            style="cursor: pointer;"
                                                            class="action-icon unarchive-caracteristique text-success"> <i
                                                                class="mdi mdi-archive-arrow-up"></i></a>
                                                    @endif
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ajout d'une caractéristique --}}
        <div id="standard-modal" class="modal fade" tabindex="-1" caracteristique="dialog"
            aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-dark">
                        <h4 class="modal-title" id="standard-modalLabel">Ajouter une caractéristique</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('caracteristique.store') }}" method="post">
                        <div class="modal-body">

                            @csrf
                            <div class="col-lg-12">

                                <div class="form-floating mb-3">
                                    <input type="text" name="nom" value="{{ old('nom') ? old('nom') : '' }}"
                                        class="form-control" id="floatingInput">
                                    <label for="floatingInput">Nom de la Caractéristique</label>
                                    @if ($errors->has('nom'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " caracteristique="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('nom') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2">
                              
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" value="true" name="calcul_prix_produit"  id="calcul_prix_produit">
                                        <label class="form-check-label" for="calcul_prix_produit">Calculer le prix des produits avec les caracteristiques</label>
                                        
                                        @if ($errors->has('calcul_prix_produit'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " caracteristique="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('calcul_prix_produit') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    <div id="type_calcul" style="display: none;" class="mt-2">
                                        <select name="calcul_prix_produit_type" class="form-select">
                                            <option value="multiplier">Multiplier par le prix du produit</option>
                                            <option value="additionner">Additionner au prix du produit</option>
                                        </select>
                                        @if ($errors->has('calcul_prix_produit_type'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " caracteristique="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('calcul_prix_produit_type') }}</strong>
                                            </div>
                                        @endif
                                    </div>
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
        <div id="edit-caracteristique" class="modal fade" tabindex="-1" caracteristique="dialog"
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
                                    <label for="edit_nom">Nom de la Caractéristique</label>
                                    @if ($errors->has('nom'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " caracteristique="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('nom') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                
                                
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" name="calcul_prix_produit" value="true" id="edit_calcul_prix_produit">
                                    <label class="form-check-label"  for="edit_calcul_prix_produit">Calculer le prix des produits avec les caracteristiques</label>
                                    
                                    @if ($errors->has('calcul_prix_produit'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " caracteristique="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('calcul_prix_produit') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div id="edit_type_calcul" style="display: none;" class="mt-2">
                                    <select name="calcul_prix_produit_type" class="form-select" id="edit_calcul_prix_produit_type">
                                        <option value="multiplier">Multiplier par le prix du produit</option>
                                        <option value="additionner">Additionner au prix du produit</option>
                                    </select>
                                    @if ($errors->has('calcul_prix_produit_type'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " caracteristique="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('calcul_prix_produit_type') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div id="edit_type_calcul" style="display: none;" class="mt-2">
                                    <select name="calcul_prix_produit_type" class="form-select" id="edit_calcul_prix_produit_type">
                                        <option value="multiplier">Multiplier par le prix du produit</option>
                                        <option value="additionner">Additionner au prix du produit</option>
                                    </select>
                                    @if ($errors->has('calcul_prix_produit_type'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " caracteristique="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('calcul_prix_produit_type') }}</strong>
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

    </div>
@endsection

@section('script')
    {{-- Modification d'une caractéristique --}}
    <script>
        // Gestion de l'affichage du select pour le type de calcul
        $('#calcul_prix_produit').change(function() {
            if($(this).is(':checked')) {
                $('#type_calcul').show();
            } else {
                $('#type_calcul').hide();
            }
        });

        $('#edit_calcul_prix_produit').change(function() {
            if($(this).is(':checked')) {
                $('#edit_type_calcul').show();
            } else {
                $('#edit_type_calcul').hide();
            }
        });

        $('.edit-caracteristique').click(function(e) {

            let that = $(this);
            let currentCaracteristique = that.data('nom');
            let currentCalculPrixProduit = that.data('calcul_prix_produit');
            let currentCalculPrixProduitType = that.data('calcul_prix_produit_type');
            let currentFormAction = that.data('href');
            $('#edit_nom').val(currentCaracteristique);
            $('#edit_calcul_prix_produit').prop('checked', currentCalculPrixProduit == "1" ? true : false);
            if(currentCalculPrixProduit == "1") {
                $('#edit_type_calcul').show();
                $('#edit_calcul_prix_produit_type').val(currentCalculPrixProduitType);
            }
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
