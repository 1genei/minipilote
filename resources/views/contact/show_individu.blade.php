@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Contact')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Contact</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Contact - {{ $contact->individu->nom }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <style>
            body {

                font-size: 14px;
            }

            .info {

                margin-bottom: 15px;

            }
        </style>

        <!-- end row-->


        <div class="row">
            <div class="col-lg-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 mr-14 ">
                                <a href="{{ URL::previous() }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i> Retour</a>
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
            <div class="col-xl-5 ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="header-title">{{ $contact->individu->type }}</h4>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Weekly Report</a>

                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="bordered-tabs-preview">
                                            <ul class="nav nav-tabs nav-bordered mb-3">

                                                <li class="nav-item">
                                                    <a href="#profile-b1" data-bs-toggle="tab" aria-expanded="true"
                                                        class="nav-link active">
                                                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                                        <span class="d-none d-md-block">{{ $contact->individu->nom }}</span>
                                                    </a>
                                                </li>

                                            </ul>

                                            <div class="tab-content">

                                                <div class="tab-pane show active" id="profile-b1">

                                                    <div class="contact-information">
                                                        <div class="info">
                                                            <span class="font-15 my-1 fw-bold"><a href="javascript:void(0);"
                                                                    class="text-body">Statut</a>: </span>
                                                            <span class="text-muted font-14">
                                                                @if ($contact->est_prospect == true)
                                                                    <span class="badge bg-secondary">Prospect</span>
                                                                @endif
                                                                @if ($contact->est_client == true)
                                                                    <span class="badge bg-primary">Client</span>
                                                                @endif
                                                                @if ($contact->est_fournisseur == true)
                                                                    <span class="badge bg-danger">Fournisseur</span>
                                                                @endif
                                                            </span>
                                                        </div>

                                                        <div class="info">
                                                            <span class="font-15 my-1 fw-bold">Email: </span>
                                                            <span
                                                                class="text-muted font-14">{{ $contact->individu->email }}</span>
                                                        </div>


                                                        <div class="info">
                                                            <span class="font-15 my-1 fw-bold">Téléphone: </span>
                                                            <span
                                                                class="text-muted font-14">{{ $contact->individu->contact1 }}
                                                                - {{ $contact->individu->contact2 }}</span>
                                                        </div>

                                                        <div class="info">
                                                            <span class="font-15 my-1 fw-bold">Adresse: </span>
                                                            <span
                                                                class="text-muted font-14">{{ $contact->individu->adresse }}</span>
                                                        </div>

                                                        <div class="info">

                                                            <span class="font-15 my-1 fw-bold">Code postal: </span>
                                                            <span
                                                                class="text-muted font-14">{{ $contact->individu->code_postal }}</span>

                                                        </div>
                                                        <div class="info">
                                                            <span class="font-15 my-1 fw-bold">Ville: </span>
                                                            <span
                                                                class="text-muted font-14">{{ $contact->individu->ville }}</span>
                                                        </div>

                                                    </div>



                                                    <div class="user-skill m-t-10">
                                                        <h5 style="color: #32ade1;text-decoration: underline;">Actions</h5>

                                                        <a type="button"
                                                            href="{{ route('contact.edit', Crypt::encrypt($contact->id)) }}"
                                                            class="btn btn-success btn-sm rounded-pill"><i
                                                                class="mdi mdi-pencil me-1"></i> <span>Modifier</span>
                                                        </a>


                                                    </div>



                                                </div>

                                            </div>
                                        </div> <!-- end preview-->

                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->

                        <!-- end row-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->

            <div class="col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="header-title"></h4>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item"></a>

                                </div>
                            </div>
                        </div>


                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

        <!-- end row -->





    </div> <!-- End Content -->


@endsection

@section('script')
    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>

    {{-- selection des statuts du contact --}}

    <script>
        $('#client').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#prospect').prop('checked', false);
            }

        });

        $('#prospect').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#client').prop('checked', false);
            }

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
