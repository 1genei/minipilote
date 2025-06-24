@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
@endsection

@section('title', 'Ajout produit')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('produit.index') }}">Produits</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Produits</h4>
                </div>
            </div>

            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 ">
                                {{-- <a href="{{ URL::previous() }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Retour</a> --}}
                                <a href="{{ route('produit.index') }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Produits</a>

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
            </div>
        </div>
        <!-- end page title -->

        <!-- end row-->

        <div class="row">
            <div class="col-12">
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
                                @if (session('error'))
                                <div class="col-6">
                                    <div class="alert alert-danger alert-dismissible bg-danger text-white text-center border-0 fade show"
                                        role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong> {{ session('error') }}</strong>
                                    </div>
                                </div>
                            @endif


                            </div>
                        </div>

                        <livewire:produit.add-form :categories="$categories" :marques="$marques" :tvas="$tvas" :caracteristiques="$caracteristiques" :circuits="$circuits" :modelevoitures="$modelevoitures">

                            <style>
                                .select2-container .select2-selection--single {
                                    height: calc(1.69em + 0.9rem + 2px);
                                }

                                .card-body {
                                    padding: 0.0rem 0.0rem !important;
                                }

                                .modal-footer {
                                    border-top: 0px solid #ffffff;
                                }
                            </style>



                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->


    </div> <!-- End Content -->
@endsection

@section('script')

{{-- Convertion du prix ht en ttc  --}}
    <script>
        var tva = "{{$valeur_tva }}";
        tva = parseInt(tva);
        
        $('#prix_vente_ht').keyup(function() {
            var prix_vente_ht = $('#prix_vente_ht').val();
            var prix_vente_ttc = (prix_vente_ht * tva) / 100 + parseInt(prix_vente_ht);
            $('#prix_vente_ttc').val(prix_vente_ttc.toFixed(2));
        });
        
        $('#prix_vente_ttc').keyup(function() {
            var prix_vente_ttc = $('#prix_vente_ttc').val();
            
      
            var prix_vente_ht = (prix_vente_ttc * 100) / (100 + tva);
            
            $('#prix_vente_ht').val( prix_vente_ht.toFixed(2));
        });
        
        $('#prix_achat_ht').keyup(function() {
            var prix_achat_ht = $('#prix_achat_ht').val();
            var prix_achat_ttc = (prix_achat_ht * tva) / 100 + parseInt(prix_achat_ht);
            $('#prix_achat_ttc').val(prix_achat_ttc.toFixed(2));
        });
        
        $('#prix_achat_ttc').keyup(function() {
            var prix_achat_ttc = $('#prix_achat_ttc').val();
            var prix_achat_ht = (prix_achat_ttc * 100) / (100 + tva);
            $('#prix_achat_ht').val(prix_achat_ht.toFixed(2));
        });
      
    </script>

    {{-- Gestion de stock --}}
    <script>
        $(".div_stock").hide();

        $('#gerer_stock').change(function() {
            if ($("#gerer_stock").is(":checked")) {
                $(".div_stock").slideDown();
            } else {
                $(".div_stock").slideUp();

            }

        });
    </script>

    <script src="https://cdn.tiny.cloud/1/raz3clgrdrwxg1nj7ky75jzhjuv9y1gb8qu8xsjph3ov99k0/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#description',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
    
    
    
@endsection
