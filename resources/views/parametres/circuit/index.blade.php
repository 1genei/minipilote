@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('title', 'Circuits ')

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('circuit.index') }}">Circuits </a>
                            </li>
                        </ol>
                    </div>
                    <h4 class="page-title">Circuits</h4>
                </div>
            </div>
        </div>

        <style>
            body {

                font-size: 13px;
            }
        </style>
        @include('layouts.nav_parametre')

        <div class="row">
            <div class="col-lg-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 mr-14 ">
                                {{-- <a href="{{route('circuit.index')}}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Circuits</a> --}}
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

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex justify-content-start">
                                @can('permission', 'ajouter-circuit')
                                    <a href="#" class="btn btn-primary mb-2" type="button" data-bs-toggle="modal"
                                        data-bs-target="#standard-modal">
                                        <i class="mdi mdi-plus-circle me-2"></i> Ajouter circuit
                                    </a>
                                @endcan

                            </div>
                            <div class="d-flex justify-content-end">
                                @can('permission', 'archiver-circuit')
                                    <a href="{{ route('circuit.archives') }}" class="btn btn-warning mb-2">
                                        <i class="mdi mdi-archive me-2"></i> Circuits archivés
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
                                    <div class="alert alert-warning text-secondary " role="alert">
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

                                        <th>Nom</th>
                                        <th>Distance</th>
                                        <th>Statut</th>
                                        <th style="width: 125px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($circuits as $circuit)
                                        <tr>

                                            <td>
                                                <a href="#" class="text-body fw-bold">{{ $circuit->nom }}</a>
                                            </td>
                                           
                                            <td>
                                                {{ $circuit->distance }}
                                            </td>
                                            
                                            
                                            <td>
                                                @if ($circuit->archive == false)
                                                    <span class="badge bg-success">Actif</span>
                                                @else
                                                    <span class="badge bg-warning">Archivé</span>
                                                @endif
                                            </td>

                                            <td>
                                                @can('permission', 'afficher-circuit')
                                                    <a href="{{ route('circuit.show', Crypt::encrypt($circuit->id)) }}"
                                                        class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                                @endcan
                                                @can('permission', 'modifier-circuit')
                                                    <a data-href="{{ route('circuit.update', Crypt::encrypt($circuit->id)) }}"
                                                        data-nom="{{ $circuit->nom }}"
                                                        data-distance = "{{ $circuit->distance }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit-circuit"
                                                        class="action-icon edit-circuit text-success">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                @endcan
                                                @can('permission', 'archiver-circuit')
                                                    @if ($circuit->archive == false)
                                                        <a data-href="{{ route('circuit.archiver', Crypt::encrypt($circuit->id)) }}"
                                                            style="cursor: pointer;"
                                                            class="action-icon archive-circuit text-warning"> <i
                                                                class="mdi mdi-archive-arrow-down"></i></a>
                                                    @else
                                                        <a data-href="{{ route('circuit.desarchiver', Crypt::encrypt($circuit->id)) }}"
                                                            style="cursor: pointer;"
                                                            class="action-icon unarchive-circuit text-success"> <i
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

        {{-- Ajout d'une circuit --}}
        <div id="standard-modal" class="modal fade" tabindex="-1" circuit="dialog"
            aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-dark">
                        <h4 class="modal-title" id="standard-modalLabel">Ajouter une circuit</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('circuit.store') }}" method="post">
                        <div class="modal-body">

                            @csrf
                            <div class="row" >

                                <div class="col-lg-6">
                                
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nom" value="{{ old('nom') ? old('nom') : '' }}"
                                            class="form-control" id="floatingInput">
                                        <label for="floatingInput">Nom de la Circuit</label>
                                        @if ($errors->has('nom'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " circuit="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('nom') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="distance" step="0.01" value="{{ old('distance') ? old('distance') : '' }}"
                                            class="form-control" id="distance">
                                        <label for="distance">Distance</label>
                                        @if ($errors->has('distance'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " circuit="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('distance') }}</strong>
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




        {{-- Modification d'une circuit --}}
        <div id="edit-circuit" class="modal fade" tabindex="-1" circuit="dialog"
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
                            <div class="row" >

                                <div class="col-lg-6">
                                
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nom" value="{{ old('nom') ? old('nom') : '' }}"
                                            class="form-control" id="edit_nom">
                                        <label for="edit_nom">Nom de la Circuit</label>
                                        @if ($errors->has('nom'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('nom') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="distance" step="0.01" value="{{ old('distance') ? old('distance') : '' }}"
                                            class="form-control" id="edit_distance">
                                        <label for="edit_distance">Distance</label>
                                        @if ($errors->has('distance'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " circuit="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('distance') }}</strong>
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

    </div>
@endsection

@section('script')
    {{-- Modification d'une circuit --}}
    <script>
        $('.edit-circuit').click(function(e) {

            let that = $(this);
            let currentCircuit = that.data('nom');
            let currentDistance = that.data('distance');
           
            let currentFormAction = that.data('href');
            $('#edit_nom').val(currentCircuit);
            $('#edit_distance').val(currentDistance);

            
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
            $('body').on('click', 'a.archive-circuit', function(event) {
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
                                        'Archivé',
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
                            'Circuit non archivé :)',
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
            $('body').on('click', 'a.unarchive-circuit', function(event) {
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
                                        'Désarchivé',
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
                            'Circuit non désarchivé :)',
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
