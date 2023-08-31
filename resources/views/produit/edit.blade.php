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


                            </div>
                        </div>

                        <livewire:produit.edit-form :produit="$produit" :categories="$categories">

                            <style>
                                .select2-container .select2-selection--single {
                                    height: calc(1.69em + 0.9rem + 2px);
                                }

                                .card-body {
                                    padding: 0.0rem 1.5rem !important;
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
        // cette fonction permet de réccupérer les images du bloc id et de recalculer leurs positions afin de l'afficher 
        // dans le span (children[0])   
        function display_position(id) {
            // élement du dom sur lequel on clic
            var index = $('ul' + id + ' li').index(this);
            var list = $('ul' + id + ' li');

            //on reparcour les images pour leur attribuer une position
            for (var i = 0; i < list.length; i++) {
                list[i].children[0].innerHTML = i + 1;
            }
        }

        display_position("#sortable_visible");
        display_position("#sortable_invisible");


        // @@@@@@@@ Liste des images visibles

        $('#btn_save_visible').hide();

        $(function() {
            $("#sortable_visible").sortable({
                grid: [20, 10],
            });
        });

        $('#sortable_visible').mousemove(function() {
            display_position("#sortable_visible");

        });


        $('#sortable_visible').mouseup(function() {
            $('#btn_save_visible').show();

        });

        // Ajouter une image visible 
        $('#div_add_image_visible').hide();

        $('#clic_add_image_visible').click(function() {
            $('#div_add_image_visible').fadeIn();
        });

        $('#refresh_div_visible').click(function() {
            $('#div_add_image_visible').fadeOut();
            $("#sortable_visible").load(" #sortable_visible");
        });


        $('#btn_save_visible').click(function() {

            // élement du dom sur lequel on clic
            var list_id = $('ul#sortable_visible div');
            var list_id_tab = Array();
            // var list_position = $('ul#sortable_visible li');

            //on reparcour les images pour leur attribuer une position
            for (var i = 0; i < list_id.length; i++) {
                // console.log(list_id[i].getAttribute("id"));
                list_id_tab.push(list_id[i].getAttribute("id"));
                i++;

            }

            //On envoie les nouvelles positions pour les sauvegarder
            $.ajax({
                type: "POST",
                url: '/images-update',
                datatype: 'json',
                data: {
                    "list": JSON.stringify(list_id_tab)
                },

                success: function(data) {
                    console.log(data);
                    swal("Super!", "Nouvelles positions enregistrées!", "success");
                },
                error: function(data) {
                    console.log(data);
                },


            });

            $('#btn_save_visible').hide();
        });



        // @@@@@@@@@ fin



        // @@@@@@@@ Liste des images invisibles
        $('#btn_save_invisible').hide();
        $(function() {
            $("#sortable_invisible").sortable({
                grid: [20, 10]
            });
        });

        $("ul#sortable_invisible li").mousemove(function() {
            display_position("#sortable_invisible");

        });

        $('#sortable_invisible').mouseup(function() {
            $('#btn_save_invisible').show();

        });

        // Ajouter une image invisible 
        $('#div_add_image_invisible').hide();

        $('#clic_add_image_invisible').click(function() {
            $('#div_add_image_invisible').fadeIn();
        });

        $('#refresh_div_invisible').click(function() {
            $('#div_add_image_invisible').fadeOut();
            $("#sortable_invisible").load(" #sortable_invisible");
        });


        $('#btn_save_invisible').click(function() {

            // élement du dom sur lequel on clic
            var list_id = $('ul#sortable_invisible div');
            var list_id_tab = Array();
            // var list_position = $('ul#sortable_invisible li');

            //on reparcour les images pour leur attribuer une position
            for (var i = 0; i < list_id.length; i++) {
                // console.log(list_id[i].getAttribute("id"));
                list_id_tab.push(list_id[i].getAttribute("id"));
                i++;

            }

            //On envoie les nouvelles positions pour les sauvegarder
            $.ajax({
                type: "POST",
                url: '/images-update',
                datatype: 'json',
                data: {
                    "list": JSON.stringify(list_id_tab)
                },

                success: function(data) {
                    console.log((data));
                    swal("Super!", "Nouvelles positions enregistrées!", "success");
                },
                error: function(data) {
                    console.log(data);
                },


            });

            $('#btn_save_invisible').hide();
        });


        // @@@@@@@@@ fin




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




        // $(document).ready(function() {

        //     $(function() {
        //         $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             }
        //         })
        //         $('[data-toggle="tooltip"]').tooltip()
        //         $('#sortable_visible').on('click', '.delete_image', function(e) {
        //             let that = $(this)
        //             e.preventDefault()
        //             const swalWithBootstrapButtons = swal.mixin({
        //                 confirmButtonClass: 'btn btn-success',
        //                 cancelButtonClass: 'btn btn-danger',
        //                 buttonsStyling: false,
        //             })

        //             swalWithBootstrapButtons({
        //                 title: '@lang('Vraiment supprimer cette image  ?')',
        //                 type: 'warning',
        //                 showCancelButton: true,
        //                 confirmButtonColor: '#DD6B55',
        //                 confirmButtonText: '@lang('Oui')',
        //                 cancelButtonText: '@lang('Non')',

        //             }).then((result) => {
        //                 if (result.value) {
        //                     // $('[data-toggle="tooltip"]').tooltip('hide')
        //                     $.ajax({
        //                             url: that.attr('data-href'),
        //                             type: 'GET'
        //                         })
        //                         .done(function() {

        //                             that.parent().parent().parent().remove();



        //                             // var index = $('ul#sortable_visible li').index(this);
        //                             // var list = $('ul#sortable_visible li');
        //                             // for (var i = 0; i < list.length; i++) {
        //                             //     list[i].children[0].innerHTML = i + 1;
        //                             //     // console.log(list[i].children[0].innerHTML);
        //                             // }



        //                         })

        //                     swalWithBootstrapButtons(
        //                         'Supprimé!',
        //                         'Image supprimée.',
        //                         'success'
        //                     )


        //                 } else if (
        //                     result.dismiss === swal.DismissReason.cancel
        //                 ) {
        //                     swalWithBootstrapButtons(
        //                         'Annulé',
        //                         'Cette image n\'a pas été supprimée :)',
        //                         'error'
        //                     )
        //                 }
        //             })
        //         })
        //     })

        // });
        //@@@@@@@@@@@@@@@@@@@@@ FIN @@@@@@@@@@@@@@@@@@@@@@@@@@
    </script>
@endsection
