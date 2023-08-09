@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
@endsection

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Prospects</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Prospects</h4>
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
                                <a href="{{ route('prospect.index') }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Prospects</a>

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


                        <livewire:contact.add-form :typecontact="'Prospect'" />



                        <style>
                            .select2-container .select2-selection--single {
                                height: calc(1.69em + 0.9rem + 2px);
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
    {{-- Lorsqu'on submit le formulaire --}}
    <script>
        $('#enregistrer').click(function(e) {

            // e.preventDefault();
            var emails = [];

            var email_inputs = $('.emails');
            email_inputs.each((index, input) => {
                if (input.value != "") emails.push(input.value)
            });


            if (emails.length == 0) {
                swal.fire(
                    'Erreur',
                    'Veuillez renseigner au moins une adresse mail',
                    'error'
                )
            } else {
                $('#emailx').val(JSON.stringify(emails));
                // $('form').submit();
            }



        });
    </script>



    {{-- Suppression ou Ajout de champ email --}}
    <script>
        var x = 1;

        $(".cacher_btn_remove_field").hide();
        $(document).ready(function() {
            var max_fields = 5;
            var wrapper = $(".input_fields_wrap");
            var add_button = $(".add_field_button");

            $(add_button).click(function(e) {
                e.preventDefault();

                if (x < max_fields) {
                    x++;

                    $(wrapper).append(`
                
                        <div class="container_email_input mt-1 field${x}">
                            <div class="item_email">
                                <input type="email" id="email${x}" name="email${x}"
                                    value=""
                                    class="form-control emails" >
                            </div>
                            <div class="item_btn_remove">
                                <a class="btn btn-danger add_field_button"
                                    style="padding: 0.55rem 0.9rem;"><i
                                        class="mdi mdi-close-thick "></i> </a>
                            </div>
                        </div>
                
                `);

                }
            });
            $(wrapper).on("click", ".item_btn_remove", function(e) {
                e.preventDefault();
                // if (x > 2) $("#pal_starter" + (x - 1) + '').show();
                if (x > 1) $(this).parent('div').remove();
                x--;
            })
        });
    </script>




    {{-- selection des statuts du prospect --}}

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

    {{-- selection du type de prospect --}}

    <script>
        $(document).ready(function() {

            // $(".div_personne_morale").show();
            // $(".div_personne_physique").hide();
            // $(".div_couple").hide();
            // $(".div_groupe").hide();


            $(".div_associer_contact").show();



            // $("input[type='radio']").click(function(e) {

            //     let nature = e.currentTarget.value;

            //     if (nature == "Personne morale") {

            //         $("input[type='text']").removeAttr("required");
            //         $("select").removeAttr("required");
            //         $("#type").val("entité");

            //         $(".div_personne_physique").hide();
            //         $(".div_personne_morale").show();
            //         $(".div_couple").hide();
            //         $(".div_groupe").hide();
            //         $(".div_personne_tout").show();
            //         $(".div_associer_contact").show();

            //         $("#forme_juridique").attr("required", "required");
            //         $("#raison_sociale").attr("required", "required");
            //         $("#email").attr("required", "required");

            //     } else if (nature == "Personne physique") {
            //         $("input[type='text']").removeAttr("required");
            //         $("select").removeAttr("required");

            //         $(".div_personne_physique").show();
            //         $(".div_personne_morale").hide();
            //         $(".div_couple").hide();
            //         $(".div_groupe").hide();
            //         $(".div_personne_tout").show();

            //         $("#civilite").attr("required", "required");
            //         $("#nom").attr("required", "required");
            //         $("#prenom").attr("required", "required");
            //         $("#email").attr("required", "required");

            //         $("#type").val("individu");
            //         $(".div_associer_contact").hide();



            //     } else if (nature == "Couple") {
            //         $("input[type='text']").removeAttr("required");
            //         $("select").removeAttr("required");

            //         $(".div_personne_physique").hide();
            //         $(".div_personne_morale").hide();
            //         $(".div_couple").show();
            //         $(".div_groupe").hide();
            //         $(".div_personne_tout").hide();

            //         $("#civilite1").attr("required", "required");
            //         $("#nom1").attr("required", "required");
            //         $("#prenom1").attr("required", "required");
            //         $("#email1").attr("required", "required");

            //         $("#civilite2").attr("required", "required");
            //         $("#nom2").attr("required", "required");
            //         $("#prenom2").attr("required", "required");
            //         $("#email2").attr("required", "required");

            //         $("#type").val("individu");
            //         $(".div_associer_contact").hide();

            //     } else if (nature == "Groupe") {
            //         $("input[type='text']").removeAttr("required");
            //         $("select").removeAttr("required");

            //         $(".div_personne_physique").hide();
            //         $(".div_personne_morale").hide();
            //         $(".div_couple").hide();
            //         $(".div_personne_tout").show();
            //         $(".div_groupe").show();

            //         $(".div_associer_contact").show();

            //         $("#nom_groupe").attr("required", "required");
            //         $("#email").attr("required", "required");
            //         $("#type").val("entité");

            //     }

            // });


        });
    </script>
@endsection
