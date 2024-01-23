@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/dropzone-custom.css') }}">
@endsection

@section('title', 'Modifier produit')

@section('content')


    <style>
        .container-gauche {

            display: flex;
            justify-content: flex-end;
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


                            <div class="col-sm-6 container-gauche">

                                <div class="item">
                                    <a href="{{ route('produit.index') }}" type="button" data-bs-toggle="modal"
                                        data-bs-target="#dark-header-modal" class="btn btn-dark"><i
                                            class="mdi mdi-plus-circle "></i>
                                        Ajouter une déclinaison
                                    </a>
                                </div>
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


                        <livewire:produit.edit-form :produit="$produit" :categories="$categories" :caracteristiques="$caracteristiques" :marques="$marques" :tvas="$tvas" :circuits="$circuits" :voitures="$voitures">

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



        {{-- MODAL AJOUT DECLINAISON --}}
        @include('produit.components.add_declinaison_modal')

        {{-- MODAL MODIFICATION DECLINAISON --}}
        @include('produit.components.edit_declinaison_modal')




        {{-- FIN MODAL --}}


    </div> <!-- End Content -->
@endsection



@section('script')

    <script>
          
        $('.champ').on('focus', function(e) {
            this.removeAttribute('readonly');
        });
      
        // $('.champ').hover(
        //     function() { // mouse enter
        //         $(this).removeAttr('readonly');
        //     },
        //     function() { // mouse leave
        //         $(this).attr('readonly', true);
        //     }
        // );
 
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

    {{-- Gestion de stock Ajout déclinaison --}}
    <script>
    
    $('input[type="radio"]').on('change', function(e) {
    
        console.log(e.target);
    //    $('input[type="radio"]').not(this).prop('checked', 'unchecked');
    }); 
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
        //@@@@@@@@@@@@@@@@@@@@@ SUPPRESSION DES ImageS DU BIEN @@@@@@@@@@@@@@@@@@@@@@@@@@


        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.delete_image', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Vraiment supprimer cette image',
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
                                type: 'GET',
                                success: function(data) {
                                    // document.location.reload();
                                    console.log(data);

                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            })
                            .done(function() {

                                that.parent().parent().parent().remove();
                                swalWithBootstrapButtons.fire(
                                    'Confirmation',
                                    'Image Supprimée',
                                    'success'
                                )
                                // document.location.reload();

                                // that.parents('tr').remove();
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Cette image n\'a pas été supprimée :)',
                            'error'
                        )
                    }
                });
            })

        });
    </script>





    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.archive-produit-decli', function(event) {
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
