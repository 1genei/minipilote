@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Evènement')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Evènement</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Evènement - {{ $evenement->nom }}</h4>
                </div>
            </div>
            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-6">

                                <div class="col-sm-4 ">
                                    <a href="{{ route('contact.index') }}" type="button" class="btn btn-outline-primary"><i
                                            class="uil-arrow-left"></i>
                                        Evènement</a>

                                </div>
                                @if (session('ok'))
                                    <div class="col-6">
                                        <div class="alert alert-success alert-dismissible text-center border-0 fade show"
                                            role="alert">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                            <strong> {{ session('ok') }}</strong>
                                        </div>
                                    </div>
                                @endif
                            </div>





                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-box-->
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-4 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
                        <p class="text-muted font-14">Evènement:</p>

                        <h4 class="mb-0 mt-2">{{ $evenement->nom }}
                            @if ($evenement->date_debut == $evenement->date_fin)
                                <span class="text-primary"> {{ $evenement->date_debut->format('d/m/Y') }} </span>
                            @else
                                <span class="text-primary"> {{ $evenement->date_debut->format('d/m/Y') }} -
                                    {{ $evenement->date_fin->format('d/m/Y') }} </span>
                            @endif
                            <a href="{{ route('evenement.edit', Crypt::encrypt($evenement->id)) }}" class="text-muted"><i
                                    class="mdi mdi-square-edit-outline ms-2"></i></a>
                        </h4>


                        <div class="text-start mt-3">
                            <h4 class="text-muted mb-2 font-13">Description :</h4>
                            <p class="text-muted font-13 mb-3">
                                {{ $evenement->description }}
                            </p>
                        </div>



                    </div> <!-- end card-body -->
                </div> <!-- end card -->

                <!-- Messages-->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center ">
                            <h4 class="header-title">Circuit: <span class="text-muted"> {{ $evenement->circuit?->nom }}
                                </span> </h4>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                </div>
                            </div>
                        </div>

                        <div class="inbox-widget">
                            <div class="inbox-item">
                                <h4 class="mb-0 "> </h4>


                            </div>



                        </div> <!-- end inbox-widget -->
                    </div> <!-- end card-body-->
                </div> <!-- end card-->

            </div> <!-- end col-->

            <div class="col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">


                            <li class="nav-item">
                                <a href="#prestation" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0 active">
                                    Prestations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#charge" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 ">
                                    Charges globales
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane show active" id="prestation">
                                {{-- <button type="button" class="btn btn-secondary btn-sm rounded-pill"
                            data-bs-toggle="modal" data-bs-target="#prestation-modal"><i
                                class="mdi mdi-file-plus-outline me-1"></i> <span>Ajouter prestation</span>
                            </button> --}}

                                <a type="button" href="{{ route('prestation.create', Crypt::encrypt($evenement->id)) }}"
                                    class="btn btn-secondary btn-sm rounded-pill"><i
                                        class="mdi mdi-file-plus-outline me-1"></i> <span>Ajouter prestation</span>
                                </a>
                                <hr>

                                @include('evenement.prestations', [
                                    'prestations' => $evenement->prestations,
                                ])
                            </div>

                            <div class="tab-pane " id="charge">

                                <button type="button" class="btn btn-warning btn-sm rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#standard-modal"><i class="mdi mdi-account-plus me-1"></i> <span>Ajouter
                                        charge</span>
                                </button>
                                <hr>

                                @include('evenement.depenses', [
                                    'depenses' => $evenement->depenses,
                                ])

                            </div> <!-- end tab-pane -->



                        </div> <!-- end tab-content -->
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row-->
        {{-- @include('contact.add_interlocuteur')     --}}
        @include('prestation.add_modal_presta_evenement')

    </div> <!-- End Content -->

@endsection

@section('script')
    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>




    {{-- Associer individu --}}
    <script>
        $('.nouveau_contact').hide();
        $('.nouveau_client').hide();

        $('#contact_existant').change(function(e) {
            if (e.currentTarget.checked == true) {
                $('.nouveau_contact').hide();
                $('.contact_existant').show();
                $('#nom').removeAttr('required', 'required');
                $('#email').removeAttr('required', 'required');
                $('#newcontact').attr('required', 'required');
                $('#poste').attr('required', 'required');

            } else {
                $('.nouveau_contact').show();
                $('.contact_existant').hide();
                $('#nom').attr('required', 'required');
                $('#email').attr('required', 'required');
                $('#newcontact').removeAttr('required', 'required');
                $('#poste').removeAttr('required', 'required');
            }

        });

        $('#client_existant').change(function(e) {
            if (e.currentTarget.checked == true) {
                $('.nouveau_client').hide();
                $('.client_existant').show();
                $('#nom').removeAttr('required', 'required');
                $('#email').removeAttr('required', 'required');
                $('#newcontact').attr('required', 'required');
                $('#poste').attr('required', 'required');

            } else {
                $('.nouveau_client').show();
                $('.client_existant').hide();
                $('#nom').attr('required', 'required');
                $('#email').attr('required', 'required');
                $('#newcontact').removeAttr('required', 'required');
                $('#poste').removeAttr('required', 'required');
            }

        });
    </script>


    <script>
        // Retirer

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.dissocier_individu', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Retirer l\'interlocuteur',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
                                // url:"/role/desarchiver/2",

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
                                    'Confirmation',
                                    'Interlocuteur retiré',
                                    'success'
                                )
                                document.location.reload();
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Interlocuteur conservé',
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
    <!-- Datatables js -->

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

    <script src="/js/mesfonctions.js"></script>
    <script>
        formater_tel("#telephone_fixe", "#indicatif_fixe");
        formater_tel("#telephone_mobile", "#indicatif_mobile");
    </script>
@endsection
