@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
@endsection

@section('title', 'Ajout contrat')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Contrats</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Contrats</h4>
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
                                <a href="{{ route('contrat.index') }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Contrats</a>

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


                        <livewire:contrat.add-form />



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
    {{-- ###### Parrainage --}}
    <script>
        $('#parrain-id').hide();
        $('#parrainage_div').hide();

        $('#a_parrain').change(function(e) {
            e.preventDefault();
            if ($("#a_parrain").prop('checked')) {
                $('#parrain-id').slideDown();
                $('#parrainage_div').slideDown();
            } else {
                $('#parrain-id').slideUp();
                $('#parrainage_div').slideUp();

            }


        });
    </script>
    {{-- ###### Fin parrain --}}





    {{-- ##### Pack Expert  --}}

    <script>
        $('#palier').hide();
        // $('#pack_starter').hide();



        $("#check_palier").change(function(e) {
            e.preventDefault();
            if ($("#check_palier").prop('checked')) {
                $('#palier').slideDown();
            } else {
                $('#palier').slideUp();
            }

        });
    </script>


    <script>
        var y = 1;
        $(document).ready(function() {
            var max_fields = 15;
            var wrapper = $(".input_fields_wrap");
            var add_button = $(".add_field_button");


            $(add_button).click(function(e) {
                e.preventDefault();

                if (y < max_fields) {
                    var ca_min = parseInt($("#ca_max" + y + '').change().val()) + 1;



                    var percent_diff = (95 - (parseFloat($("#pourcentage_depart").change().val())));
                    var i = 1;
                    while (i <= y) {
                        let tmp = parseFloat($("#percent" + i + '').change().val());
                        percent_diff = (percent_diff - tmp);
                        i++;
                    }
                    if (y > 1 && percent_diff > 0)
                        $("#pal" + y + '').hide();
                    if (percent_diff > 0)
                        y++;
                    if (percent_diff < 0) {
                        percent_diff = 0;

                    }
                    var val_chiffre = parseInt(ca_min) + 19999;

                    if (percent_diff > 5)
                        $(wrapper).append('<div class = "row gy-2 gx-2 align-items-center field' + y +
                            '"><div class="col-auto"><label for="level' + y +
                            '">Niveau: </label> <input class="form-control" type="text" value="' + y +
                            '" id="level' + y + '" name="level' + y +
                            '"/ readonly></div> <div class="col-auto"><label for="percent' + y +
                            '">Pourcentage en + : </label> <input class="form-control" type="number" step="0.10" min="0" max="' +
                            percent_diff + '" value="' + percent_diff + '" id="percent' + y +
                            '" name="percent' + y +
                            '"/> </div> <div class="col-auto"><label for="ca_min' + y +
                            '">CA min (€): </label> <input class="form-control" type="number" value="' +
                            ca_min + '" id="ca_min' + y + '" name="ca_min' + y +
                            '" readonly></div> <div class="col-auto"><label for="ca_max' + y +
                            '">CA max (€): </label> <input class="form-control" type="number" min="' +
                            ca_min + '" value="' + val_chiffre + '" id="ca_max' + y +
                            '" name="ca_max' + y +
                            '"/></div>  <div class="col-auto"> <button href="#" id="pal' + y +
                            '" class="btn btn-danger remove_field">Enlever</button></div></br></div>'
                        ); //add input box
                    else if (percent_diff <= 5 && percent_diff > 0)
                        $(wrapper).append('<div class = "form-inline field' + y +
                            '"><div class="col-auto"><label for="level' + y +
                            '">Niveau: </label> <input class="form-control" type="text" value="' + y +
                            '" id="level' + y + '" name="level' + y +
                            '"/ readonly></div> <div class="col-auto"><label for="percent' + y +
                            '">Pourcentage en + : </label> <input class="form-control" type="number" step="0.10" min="0" max="' +
                            percent_diff + '" value="' + percent_diff + '" id="percent' + y +
                            '" name="percent' + y +
                            '"/> </div> <div class="col-auto"><label for="ca_min' + y +
                            '">CA min (€): </label> <input class="form-control" type="number" value="' +
                            ca_min + '" id="ca_min' + y + '" name="ca_min' + y +
                            '" readonly></div> <div class="col-auto"><label for="ca_max' + y +
                            '">CA max (€): </label> <input class="form-control" type="number" min="' +
                            ca_min + '" value="' + val_chiffre + '" id="ca_max' + y +
                            '" name="ca_max' + y +
                            '"/></div>  <div class="col-auto"> <button href="#" id="pal' + y +
                            '" class="btn btn-danger remove_field">Enlever</button></div></br></div>'
                        ); //add input box
                    else {



                        swal.fire(
                            'Ajout impossible!',
                            'Le maximum de 95% en pourcentage est atteint, vous ne pouvez plus ajouter de nouveau  palier!',
                            'error'
                        );
                    }
                }
            });

            $(wrapper).on("click", ".remove_field", function(e) {
                e.preventDefault();
                if (y > 2) $("#pal" + (y - 1) + '').show();
                $(this).parent().parent('div').remove();
                y--;
            })
        });
    </script>

    {{-- Fin pack Expert --}}

    {{-- Envoi des données en ajax pour le stockage --}}
    <script>
        $('.form-valide3').submit(function(e) {
            e.preventDefault();
            var form = $(".form-valide3");


            var palierdata = $('#palier_starter input').serialize();

            data = {

                "forfait_administratif": $('#forfait_administratif').val(),
                "forfait_carte_pro": $('#forfait_carte_pro').val(),
                "forfait_pack_info": $('#forfait_pack_info').val(),

                "date_entree": $('#date_entree').val(),
                "date_debut": $('#date_debut').val(),
                "ca_depart": $('#ca_depart').val(),
                "ca_depart_sty": $('#ca_depart_sty').val(),
                "est_starter": $("#est_starter").prop('checked'),
                "a_parrain": $("#a_parrain").prop('checked'),
                "a_condition_parrain": $("#a_condition_parrain").prop('checked'),
                "parrain_id": $('#parrain_id').val(),
                "est_soumis_tva": $("#est_soumis_tva").prop('checked'),
                "deduis_jeton": $("#deduis_jeton").prop('checked'),


                "pourcentage_depart_starter": $('#pourcentage_depart_starter').val(),
                "nb_vente_passage": $('#nb_vente_passage').val(),
                "duree_pack_info_starter": $('#duree_pack_info_starter').val(),

                "duree_max_starter": $('#duree_max_starter').val(),
                "duree_gratuite_starter": $('#duree_gratuite_starter').val(),
                "check_palier_starter": $("#check_palier_starter").prop('checked'),
                "est_soumis_fact_pub": $("#est_soumis_fact_pub").prop('checked'),

                "palier_starter": $('#palier_starter input').serialize(),

                "pourcentage_depart": $('#pourcentage_depart').val(),
                "duree_gratuite": $('#duree_gratuite').val(),
                "duree_pack_info": $('#duree_pack_info').val(),


                // "nb_vente_gratuite" : $('#nb_vente_gratuite').val(),

                "check_palier": $("#check_palier").prop('checked'),
                "palier": $('#palier input').serialize(),
                "nombre_vente_min": $('#nombre_vente_min').val(),
                "chiffre_affaire": $('#chiffre_affaire').val(),
                "nombre_mini_filleul": $('#nombre_mini_filleul').val(),
                "a_soustraitre": $('#a_soustraitre').val(),
                "a_condition": $("#a_condition").prop('checked'),

                "prime_max_forfait_parrain": $('#prime_max_forfait').val(),
                "pack_pub": $('#pack_pub').val(),

                "p_1_1": $('#p_1_1').val(),
                "p_1_2": $('#p_1_2').val(),
                "p_1_3": $('#p_1_3').val(),
                "p_1_n": $('#p_1_n').val(),
                "seuil_parr_1": $('#seuil_parr_1').val(),
                "seuil_fill_1": $('#seuil_fill_1').val(),

                "p_2_1": $('#p_2_1').val(),
                "p_2_2": $('#p_2_2').val(),
                "p_2_3": $('#p_2_3').val(),
                "p_2_n": $('#p_2_n').val(),
                "seuil_parr_2": $('#seuil_parr_2').val(),
                "seuil_fill_2": $('#seuil_fill_2').val(),


                "p_3_1": $('#p_3_1').val(),
                "p_3_2": $('#p_3_2').val(),
                "p_3_3": $('#p_3_3').val(),
                "p_3_n": $('#p_3_n').val(),
                "seuil_parr_3": $('#seuil_parr_3').val(),
                "seuil_fill_3": $('#seuil_fill_3').val(),

                "seuil_comm": $('#seuil_comm').val(),

            }

            // console.log(data);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                type: "POST",
                url: "{{ route('contrat.create') }}",

                data: data,
                success: function(data) {
                    console.log(data);

                    swal(
                            'Ajouté',
                            'Le contrat a été ajouté avec succés!',
                            'success'
                        )
                        .then(function() {
                            window.location.href = "";
                        })

                },
                error: function(data) {
                    console.log(data);

                    swal(
                        'Echec',
                        'Le contrat  n\'a pas été ajouté!',
                        'error'
                    );
                }
            });
        });
    </script>

@endsection
