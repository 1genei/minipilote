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

                        <livewire:produit.edit-form :produit="$produit" :categories="$categories" :marques="$marques">

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


        @include('produit.components.add_declinaison')

        {{-- FIN MODAL --}}


    </div> <!-- End Content -->
@endsection

@section('script')


    {{-- Gestion de stock --}}
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
@endsection
