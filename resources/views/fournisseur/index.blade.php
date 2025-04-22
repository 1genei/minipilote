@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Fournisseurs')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('fournisseur.index') }}">Fournisseurs</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Fournisseurs</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <style>
            body {

                font-size: 14px;
            }
        </style>

        <!-- end row-->


        <div class="row">
            <div class="col-lg-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 mr-14 ">
                                <a href="{{ url()->previous() }}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Retour</a>
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
        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex justify-content-start">
                                @can('permission', 'ajouter-fournisseur')
                                    <a href="{{ route('fournisseur.create') }}" class="btn btn-primary mb-2">
                                        <i class="mdi mdi-plus-circle me-2"></i> Ajouter fournisseur
                                    </a>
                                @endcan
                            </div>
                            <div class="d-flex justify-content-end">
                                @can('permission', 'ajouter-fournisseur')
                                    <a href="{{ route('fournisseur.archives') }}" class="btn btn-warning mb-2">
                                        <i class="mdi mdi-archive me-2"></i> Fournisseurs archivés
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
                                @if ($errors->has('role'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </div>
                                @endif

                            </div>
                        </div>

                        <ul class="nav nav-tabs nav-bordered mb-3">

                            <li class="nav-item">
                                <a href="#entite" data-bs-toggle="tab" aria-expanded="true" class="nav-link active ">
                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Personnes morales</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#individu" data-bs-toggle="tab" aria-expanded="false" class="nav-link ">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Individus</span>
                                </a>
                            </li>

                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane show active" id="entite">
                                <div class="table-responsive">
                                    <livewire:fournisseur.entite-table />
                                </div>

                            </div>
                            <div class="tab-pane " id="individu">
                                <div class="table-responsive">
                                    <livewire:fournisseur.individu-table />
                                </div>


                            </div>

                        </div>


                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->



    </div> <!-- End Content -->
@endsection

@section('script')
    {{-- selection des statuts du fournisseur --}}

    <script>
        $('#client').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#fournisseur').prop('checked', false);
            }

        });

        $('#fournisseur').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#client').prop('checked', false);
            }

        });
    </script>

    {{-- selection du type de fournisseur --}}

    <script>
        $('.div-entite').hide();

        $('#type').change(function(e) {

            if (e.currentTarget.value == "entité") {
                $('.div-entite').show();
                $('.div-individu').hide();

            } else {
                $('.div-entite').hide();
                $('.div-individu').show();
            }

        });
    </script>


    {{-- Modification d'un fournisseur --}}
    <script>
        $('.edit-contact').click(function(e) {

            let that = $(this);

            $('#edit-nom').val(that.data('nom'));
            $('#edit-prenom').val(that.data('prenom'));


            $('#edit-email').val(that.data('email'));
            $('#edit-contact1').val(that.data('contact1'));
            $('#edit-contact2').val(that.data('contact2'));
            $('#edit-adresse').val(that.data('adresse'));
            $('#edit-code_postal').val(that.data('code-postal'));
            $('#edit-ville').val(that.data('ville'));


            let currentFormAction = that.data('href');
            $('#form-edit').attr('action', currentFormAction);




            //    selection du type de fournisseur


            let currentType = that.data('type-contact');
            let currentTypeentite = that.data('typeentite');

            $('#edit-type option[value=' + currentType + ']').attr('selected', 'selected');


            if (currentType == "entité") {
                $('.div-edit-entite').show();
                $('.div-edit-individu').hide();

            } else {
                $('.div-edit-entite').hide();
                $('.div-edit-individu').show();
            }

            $('#edit-type').change(function(e) {

                if (e.currentTarget.value == "entité") {
                    $('.div-edit-entite').show();
                    $('.div-edit-individu').hide();

                } else {
                    $('.div-edit-entite').hide();
                    $('.div-edit-individu').show();
                }

            });


            $('#edit-type_entite option[value=' + currentTypeentite + ']').attr('selected', 'selected');



        })



        // selection des statuts du fournisseur  Modal modifier
        $('#edit-client').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#edit-fournisseur').prop('checked', false);
            }

        });

        $('#edit-fournisseur').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#edit-client').prop('checked', false);
            }

        });
    </script>


    <script>
        // Archiver
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.archive_contact', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Archiver le fournisseur',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
                                type: 'PUT',
                                success: function(data) {
                                    // document.location.reload();
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            })
                            .done(function() {

                                swalWithBootstrapButtons.fire(
                                    'Confirmation',
                                    'Fournisseur archivé avec succès',
                                    'success'
                                )
                                // document.location.reload();

                                that.parents('tr').remove();
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Fournisseur non archivé',
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
                    info: "Showing actions _START_ to _END_ of _TOTAL_",
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
