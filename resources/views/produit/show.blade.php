@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/dropzone-custom.css') }}">
@endsection

@section('title', 'Afficher produit')

@section('content')


    <style>
        .container-titre {

            display: flex;
            justify-content: flex-start;
            gap: 10px;

        }
    </style>
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

                            <div class="col-sm-6">

                                <div class="col-sm-4 ">
                                    <a href="{{ route('produit.index') }}" type="button" class="btn btn-outline-primary"><i
                                            class="uil-arrow-left"></i>
                                        Produits</a>

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
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <!-- Product image -->
                                                @if (sizeof($produit->imageproduits))
                                                    <a href="javascript: void(0);" class="text-center d-block mb-4">
                                                        <img src="{{ asset('/images/images_produits/' . $produit->imageproduits[0]?->nom_fichier) }} "
                                                            class="img-fluid" style="max-width: 280px;"
                                                            alt="Photo du produit" />
                                                    </a>

                                                    <div class="d-lg-flex d-none justify-content-center">

                                                        @foreach ($produit->imageproduits as $photosproduit)
                                                            <a href="javascript: void(0);" class="ms-2">
                                                                <img src="{{ asset('/images/images_produits/' . $photosproduit->nom_fichier) }}"
                                                                    class="img-fluid img-thumbnail p-2"
                                                                    style="max-width: 100px; max-height:100px;"
                                                                    alt="Photo du produit" />
                                                            </a>
                                                        @endforeach

                                                    </div>
                                                @endif
                                            </div> <!-- end col -->
                                            <div class="col-lg-7">
                                                <form class="ps-lg-4">


                                                    <div class="container-titre">

                                                        <div class="item-titre">
                                                            <!-- Product title -->
                                                            <h3 class="mt-0">{{ $produit->nom }}
                                                                <a href="{{ route('produit.edit', Crypt::encrypt($produit->id)) }}"
                                                                    class="text-muted">
                                                                    <i class="mdi mdi-square-edit-outline ms-2"></i>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                        @if($produit->nature == "Matériel" )
                                                        
                                                        <div class="item-titre">
                                                            <!-- Product stock -->
                                                            <h5 class="mt-0">
                                                                @if ($produit->stock?->quantite > 0)
                                                                    <span class="badge badge-success-lighten">
                                                                        En Stock
                                                                    </span>
                                                                @else
                                                                    <span class="badge badge-danger-lighten">
                                                                        Rupture de Stock
                                                                    </span>
                                                                @endif
                                                            </h5>

                                                        </div>
                                                        @endif
                                                        <div class="item-titre">
                                                            <!-- Product title -->
                                                            <span class="mt-0 ">{{ $produit->nature }} </span>
                                                        </div>
                                                    </div>




                                                    <p class="mb-1">Ajouté le:
                                                        {{ $produit->created_at->format('d/m/Y') }}</p>



                                                    @if($produit->prix_vente_ht != null )

                                                        <!-- Product description -->
                                                        <div class="mt-4">
                                                            <h6 class="font-14">Prix de vente HT</h6>
                                                            <h4> {{ $produit->prix_vente_ht }} € </h4>
                                                        </div>
                                                    @endif


                                                    <!-- Product description -->
                                                    <div class="mt-4">
                                                        <h6 class="font-14">Description:</h6>
                                                        <p>{!! $produit->description !!}</p>
                                                    </div>

                                                    <!-- Product information -->
                                                    <div class="mt-4">
                                                        <div class="row">
                                                            @if($produit->nature == "Matériel" )
                                                        
                                                                <div class="col-md-4">
                                                                    <h6 class="font-14">Stock restant:</h6>
                                                                    <p class="text-sm lh-150">{{ $produit->stock?->quantite }}
                                                                    </p>
                                                                </div>
                                                            @endif
                                                            <div class="col-md-4">
                                                                <h6 class="font-14">Catégories:</h6>
                                                                @foreach ($produit->categorieproduits as $key => $categorieproduit)
                                                                                <span class="text-body fw-bold">
                                                                        {{ $categorieproduit->nom }}
                                                                    </span>
                                                                    @if ($key < count($produit->categorieproduits) - 1)
                                                                        ,
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                            <div class="col-md-4">
                                                                <h6 class="font-14">Nombre de commandes:</h6>
                                                                <p class="text-sm lh-150">10</p>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </form>
                                            </div> <!-- end col -->
                                        </div> <!-- end row-->


                                        <div class="modal-body mt-5">

                                            @csrf

                                            <ul class="nav nav-tabs nav-bordered mb-3">
                                                
                                                @if($produit->nature == "Matériel" )
                                                
                                                    <li class="nav-item">
                                                        <a href="#essentiel-tab" data-bs-toggle="tab" aria-expanded="false"
                                                            class="nav-link active">
                                                            <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                                            <span class="d-none d-md-block">Essentiel</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if ($produit->a_declinaison == true)
                                                    <li class="nav-item">
                                                        <a href="#declinaison-tab" data-bs-toggle="tab"
                                                            aria-expanded="false" class="nav-link @if($produit->nature != 'Matériel' ) active @endif">
                                                            <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                                            <span class="d-none d-md-block">Déclinaisons</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if($produit->nature == "Matériel" )
                                               <li class="nav-item">
                                                    <a href="#stock-tab" data-bs-toggle="tab" aria-expanded="false"
                                                        class="nav-link">
                                                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                                        <span class="d-none d-md-block">Stock</span>
                                                    </a>
                                                </li> 
                                                @endif
                                            </ul>


                                            <div class="tab-content">
                                                @if($produit->nature == "Matériel" )                                                
                                                {{-- ESSENTIEL --}}
                                                <div class="tab-pane show active" id="essentiel-tab">
                                                    <div class="col-lg-12">

                                                        <div class="table-responsive">
                                                            <table class="table mb-0">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th>Référence produit</th>
                                                                        <th>Fiche technique</th>
                                                                        {{-- <th>Catégories</th> --}}
                                                                        <th>Marque</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <span class="fw-bold me-2">
                                                                                {{ $produit->reference }}
                                                                            </span>

                                                                        </td>
                                                                        <td>
                                                                            @if ($produit->fiche_technique)
                                                                                <a type="button"
                                                                                    href="{{ route('produit.getFicheTechnique', $produit->fiche_technique) }}"
                                                                                    class="btn btn-danger btn-xs ">
                                                                                    <i
                                                                                        class="mdi fs-6 mdi-download me-1"></i>
                                                                                    <span>Télécharger</span>
                                                                                </a>
                                                                            @endif
                                                                        </td>
                                                                        {{-- <td>
                                                                            @foreach ($produit->categorieproduits as $key => $categorieproduit)
                                                                                <span class="text-body fw-bold">
                                                                                    {{ $categorieproduit->nom }}
                                                                                </span>
                                                                                @if ($key < count($produit->categorieproduits) - 1)
                                                                                    ,
                                                                                @endif
                                                                            @endforeach
                                                                        </td> --}}
                                                                        <td>{{ $produit->marque?->nom }}</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="table-responsive mt-5">
                                                            <table
                                                                class="table table-centered table-borderless table-hover w-100 dt-responsive ">
                                                                <thead class="table-light">
                                                                    <tr>

                                                                        <th class="text-primary">Prix d'achat HT</th>
                                                                        <th class="text-primary">Prix d'achat TTC</th>
                                                                        <th class="text-danger">Prix de vente HT</th>
                                                                        <th class="text-danger">Prix de vente TTC</th>
                                                                        {{-- <th class="text-dark">Prix de vente max HT</th>
                                                                        <th class="text-dark">
                                                                            Prix de vente max TTC
                                                                        </th> --}}
                                                                        {{-- <th class="text-secondary">Prix d'achat commerciaux
                                                                            HT
                                                                        </th>
                                                                        <th class="text-secondary">Prix d'achat commerciaux
                                                                            TTC
                                                                        </th> --}}

                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <tr>

                                                                        <td>
                                                                            <a href="#"
                                                                                class="text-body fw-bold">{{ $produit->prix_achat_ht }}</a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#"
                                                                                class="text-body fw-bold">{{ $produit->prix_achat_ttc }}</a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#"
                                                                                class="text-body fw-bold">{{ $produit->prix_vente_ht }}</a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#"
                                                                                class="text-body fw-bold">{{ $produit->prix_vente_ttc }}</a>
                                                                        </td>
      
                                                                    </tr>



                                                                </tbody>
                                                            </table>
                                                        </div>


                                                    </div> <!-- end col -->

                                                </div>
                                                @endif
                                                {{-- DECLINAISONS --}}
                                                @if ($produit->a_declinaison == true)
                                                    <div class="tab-pane @if($produit->nature != 'Matériel' ) show active @endif" id="declinaison-tab">
                                                        <div class="table-responsive">
                                                            <form action="{{ route('produit_all_declinaison.update', $produit->id) }}" method="POST">    
                                                                @csrf
                                                            <table
                                                                class="table table-centered table-borderless table-hover w-100 dt-responsive "
                                                                id="tab1">
                                                                <thead class="table-light">
                                                                    <tr>

                                                                        <th>Déclinaisons</th>
                                                                       
                                                                        <th>Prix de vente HT</th>
                                                                        <th>Prix de vente TTC</th>
                                                                        @if($produit->nature == "Matériel" )                                                                        
                                                                        <th>Prix d'achat HT</th>
                                                                        <th>Prix d'achat TTC</th>
                                                                        <th>Stock</th>
                                                                        @endif
                                                                        <th>Statut</th>
                                                                    </tr>
                                                                </thead>
                                                                
                                                                <tbody>
                                                                
                                                                    @foreach ($produit->declinaisons() as $proddecli)
                                                                        <tr>
                                                                            <td>
                                                                                <input type="text" class="form-control champ" name="nom_{{$proddecli->id}}" value="{{$proddecli->nom }}"
                                                                                 required readonly>
                                                                               @foreach ($proddecli->valeurcaracteristiques as $key => $valeurcaracteristique)
                                                                                    <span
                                                                                        class="text-body fw-bold">{{ $valeurcaracteristique->caracteristique?->nom }}
                                                                                    </span>
                                                                                    : <span class="text-body">
                                                                                        {{ $valeurcaracteristique->nom }}
                                                                                    </span>
                                                                                    @if ($key < count($proddecli->valeurcaracteristiques) - 1)
                                                                                        /
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                           
                                                                            <td>
                                                                                <input type="number" step="0.01" class="form-control champ prixventeht" name="prixventeht_{{$proddecli->id}}" value="{{$proddecli->prix_vente_ht }}"
                                                                                required readonly>
                                                                                
                                                                                
                                                                                {{-- <a href="#" class="text-body fw-bold">{{ $proddecli->prix_vente_ht }}</a> --}}
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" step="0.01" class="form-control champ prixventettc" name="prixventettc_{{$proddecli->id}}" value="{{$proddecli->prix_vente_ttc }}"
                                                                                required readonly>
                                                                                <input type="hidden"  name="id_{{$proddecli->id}}" value="{{$proddecli->id }}">
                                                                                
                                                                                {{-- <a href="#" class="text-body fw-bold">{{ $proddecli->prix_vente_ttc }}</a> --}}
                                                                            </td>
                                                                            @if($produit->nature == "Matériel" )
                                                                                <td>
                                                                                    <a href="#"
                                                                                        class="text-body fw-bold">{{ $proddecli->prix_achat_ht }}</a>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="#"
                                                                                        class="text-body fw-bold">{{ $proddecli->prix_achat_ttc }}</a>
                                                                                </td>
                                                                                <td>
                                                                                    @if ($proddecli->gerer_stock)
                                                                                        <span class="fw-bold">
                                                                                            {{ $proddecli->stock->quantite }}</span>
                                                                                    @else
                                                                                        <span class="fst-italic">non
                                                                                            géré</span>
                                                                                    @endif   
    
                                                                                </td>
    
                                                                            @endif

                                                                            <td>
                                                                                @if ($proddecli->archive == false)
                                                                                    <span
                                                                                        class="badge bg-success">Actif</span>
                                                                                @else
                                                                                    <span
                                                                                        class="badge bg-warning">Archivé</span>
                                                                                @endif
                                                                            </td>

                                                                            

                                                                        </tr>
                                                                    @endforeach

                                                                    <div class="modal-footer" style="position: fixed;bottom: 10px; margin: 0;  left: 50%; z-index:1 ;">
                                                                        {{-- <a class="btn btn-light btn-lg " href="{{ route('produit.index') }}">Annuler</a> --}}
                                                                        <button type="submit" class="btn btn-info btn-flat btn-addon btn-lg "
                                                                            wire:click="submit">Modifier les déclinaisons</button>
                                                                    </div>
                                            
                                                                </tbody>
                                                                
                                                            </table>
                                                        </form> 
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($produit->nature == "Matériel" )
                                                {{-- STOCK --}}
                                                <div class="tab-pane" id="stock-tab" wire:ignore>
                                                    @if ($produit->gerer_stock && $produit->stock != null)
                                                        <div class="col-lg-6">

                                                            <h4 class="header-title mb-3">Stock</h4>

                                                            <div class="table-responsive">
                                                                <table class="table mb-0">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>Description</th>
                                                                            <th>Valeur</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="fw-bold">Quantité :</td>
                                                                            <td>{{ $produit->stock?->quantite }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="fw-bold">Quantité minimal pour la
                                                                                vente :
                                                                            </td>
                                                                            <td>{{ $produit->stock?->quantite_min }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="fw-bold">Seuil d'alerte : </td>
                                                                            <td>{{ $produit->stock?->seuil_alerte }}
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <!-- end table-responsive -->


                                                        </div> <!-- end col -->
                                                    @endif
                                                </div>
                                                @endif
                                            </div>


                                        </div>




                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->








                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->



    </div> <!-- End Content -->
@endsection

@section('script')
    
    <script>
        $('.champ').on('focus', function(e) {
            this.removeAttribute('readonly');
        });
        
    </script>


    {{-- Lorsqu'on modifie le prix HT d'une déclinaison --}}
    
    <script>
        tva = "{{ $produit->tva->taux }}";
        
        $(document).on('keyup', '.prixventeht', function() { 
            var prix_ht = $(this).val();
            var prix_ttc = prix_ht * (1 + tva / 100);
            $(this).parent().parent().find('.prixventettc').val(prix_ttc.toFixed(2));
        });
        
        $(document).on('keyup', '.prixventettc', function() { 
            var prix_ttc = $(this).val();
            var prix_ht = prix_ttc / (1 + tva / 100);
            $(this).parent().parent().find('.prixventeht').val(prix_ht.toFixed(2));
          
        });
    </script>
    


    {{-- Gestion de stock Ajout déclinaison --}}
    <script>
        var gerer_stock = @json($produit->gerer_stock);

        if (gerer_stock == false) {
            $(".div_stock").hide();
            $(".div_stock_decli").hide();
        }
        $('#gerer_stock').change(function() {
            if ($("#gerer_stock").is(":checked")) {
                $(".div_stock").slideDown();
            } else {
                $(".div_stock").slideUp();

            }

        });

        $('#gerer_stock_decli').change(function() {
            if ($("#gerer_stock_decli").is(":checked")) {
                $(".div_stock_decli").slideDown();
            } else {
                $(".div_stock_decli").slideUp();
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




    <script>
        // Désarchiver

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.unarchive-produit-decli', function(event) {
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


    {{-- Modification d'une déclinaison --}}
    <script>
        $('.edit-declinaison').click(function(e) {

            let that = $(this);
            let currentCaracteristique = that.data('nom');

            let currentFormAction = that.data('href');


            $('#edit_form_decli').attr('action', currentFormAction);


            $('#edit_prix_vente_ht_decli').val(that.data('prix_vente_ht'));
            $('#edit_prix_vente_ttc_decli').val(that.data('prix_vente_ttc'));
            $('#edit_prix_vente_max_ht_decli').val(that.data('prix_vente_max_ht'));
            $('#edit_prix_vente_max_ttc_decli').val(that.data('prix_vente_max_ttc'));
            $('#edit_prix_achat_ht_decli').val(that.data('prix_achat_ht'));
            $('#edit_prix_achat_ttc_decli').val(that.data('prix_achat_ttc'));
            $('#edit_prix_achat_commerciaux_ht_decli').val(that.data('prix_achat_commerciaux_ht'));
            $('#edit_prix_achat_commerciaux_ttc_decli').val(that.data('prix_achat_commerciaux_ttc'));
            $('#edit_gerer_stock_decli').val(that.data('gerer_stock'));
            $('#edit_valeurcaracteristique_decli').val(that.data('valeurcaracteristique'));
            $('#edit_produitdecli_id_decli').val(that.data('produitdecli_id'));
            $('#edit_quantite_decli').val(that.data('quantite'));
            $('#edit_quantite_min_vente_decli').val(that.data('quantite_min'));
            $('#edit_seuil_alerte_stock_decli').val(that.data('seuil_alerte'));


            var check_declis = $('.check-decli');



            valeursExistantes = that.data('valeurcaracteristique');
            // Parcourez les valeurs existantes et cochez les boutons radio correspondants
            valeursExistantes.forEach(function(valeurId) {
                $('input[value="' + valeurId + '"]').prop('checked', true);
            });


            // {{-- Gestion de stock modification déclinaison --}}

            var gerer_stock = that.data('gerer_stock');

            if (gerer_stock == false) {
                $(".div_edit_stock_decli").hide();
                $(".div_edit_stock_decli").hide();
                $("#edit_gerer_stock_decli").prop("checked", false);

            } else {
                $(".div_edit_stock_decli").show();
                $(".div_edit_stock_decli").show();
                $("#edit_gerer_stock_decli").prop("checked", true);

            }



        });

        $('#edit_gerer_stock_decli').change(function() {
            if ($("#edit_gerer_stock_decli").is(":checked")) {
                $(".div_edit_stock_decli").slideDown();
            } else {
                $(".div_edit_stock_decli").slideUp();
            }
        });
    </script>
@endsection
