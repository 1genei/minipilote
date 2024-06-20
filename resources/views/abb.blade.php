@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Tests</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Tests</h4>
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
                                <a href="{{ route('role.index') }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i> Rôles</a>
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


                <iframe src="http://51.77.193.222:3000/d-solo/ddnnyrz7g7klcf/vues-abb?orgId=1&panelId=5" width="100%" height="1000" frameborder="0"></iframe>

<br><br>

        <iframe src="http://51.77.193.222:3000/d-solo/fdns3n98dimm8f/chargeur-4-v3?orgId=1&panelId=1" width="100%" height="1000" frameborder="0"></iframe>
            </div>
        </div>


    </div> <!-- End Content -->
@endsection

@section('script')
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
@endsection
