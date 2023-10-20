@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
@endsection

@section('title', 'Modification client')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Clients</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Clients</h4>
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
                                <a href="{{ route('client.index') }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Clients</a>

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


                        <livewire:contact.edit-form :typecontact="'Client'" :contact="$contact" :cont="$cont"
                            :emails="$emails" />



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

        {{-- @php
            
            $nbemails = sizeof($emails);
            
        @endphp --}}




    </div> <!-- End Content -->
@endsection

@section('script')
    {{-- Lorsqu'on submit le formulaire --}}

    <script>
        $('#modifier').click(function(e) {

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
        var emails = @json($emails);

        var x = emails != null ? emails.length : 0;

        $(".cacher_btn_remove_field").hide();
        $(document).ready(function() {
            var max_fields = 5;
            var wrapper = $(".input_fields_wrap");
            var add_button = $(".add_field_button");

            //  Ajout dans inuts emails existants
            if (emails != null) {

                emails.forEach((email, index) => {

                    if (index > 0) {

                        $(wrapper).append(`
                        
                        <div class="container_email_input mt-1 field${index}">
                            <div class="item_email">
                                <input type="email" id="email${index}" name="email${index}" value="${email}"
                                    class="form-control emails" >
                            </div>
                            <div class="item_btn_remove">
                                <a class="btn btn-danger add_field_button"
                                    style="padding: 0.55rem 0.9rem;"><i
                                        class="mdi mdi-close-thick "></i> </a>
                            </div>
                        </div>
                        `);
                    };


                });

            }



            $(add_button).click(function(e) {
                e.preventDefault();

                if (x <= max_fields) {
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




    {{-- selection des statuts du client --}}

    <script>
        $('#client').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#client').prop('checked', false);
            }

        });

        $('#client').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#client').prop('checked', false);
            }

        });
    </script>


    <script>
        let autocomplete_adresse;
        let autocomplete_code_postal;
        let autocomplete_ville;


        function initAutocomplete() {
            autocomplete_adresse = new google.maps.places.Autocomplete(
                document.getElementById('nom_voie'), {
                    types: ['address'],
                    componentRestrictions: {
                        'country': ['FR']
                    },
                    fields: ['address_components', 'address_components', 'adr_address', 'formatted_address', 'name',
                        'vicinity'
                    ]
                }
            );

            autocomplete_code_postal = new google.maps.places.Autocomplete(
                document.getElementById('code_postal'), {
                    types: ['postal_code'],
                    componentRestrictions: {
                        'country': ['FR']
                    },
                    fields: ['name', 'vicinity']
                }
            );

            autocomplete_ville = new google.maps.places.Autocomplete(
                document.getElementById('ville'), {
                    types: ['geocode'],
                    componentRestrictions: {
                        'country': ['FR']
                    },
                    fields: ['address_components', 'address_components', 'adr_address', 'formatted_address', 'name',
                        'vicinity'
                    ]
                }
            );

            autocomplete_adresse.addListener('place_changed', onPlaceChanged);
            autocomplete_code_postal.addListener('place_changed', onPlaceChanged);
            autocomplete_ville.addListener('place_changed', onPlaceChanged);



        }


        function onPlaceChanged() {

            var place_voie = autocomplete_adresse.getPlace();
            var place_ville = autocomplete_ville.getPlace();
            var place_code_postal = autocomplete_code_postal.getPlace();


            if (place_voie) {
                document.getElementById('nom_voie').value = place_voie.name;
                document.getElementById('ville').value = place_voie.vicinity;
                document.getElementById('code_postal').value = place_voie.address_components[5].long_name;

            }

            if (place_code_postal) {
                document.getElementById('ville').value = place_code_postal.vicinity;
                document.getElementById('code_postal').value = place_code_postal.name;
            }

            if (place_ville) {
                document.getElementById('ville').value = place_ville.vicinity;
            }


        }
    </script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCD0y8QWgApdFG33-i8dVHWia-fIXcOMyc&libraries=places&callback=initAutocomplete"
        async defer></script>
@endsection
