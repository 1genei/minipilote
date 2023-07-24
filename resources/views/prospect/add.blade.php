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
                                <a href="{{ URL::previous() }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Retour</a>
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

                        <form action="{{ route('prospect.store') }}" method="post">
                            @csrf


                            <div class="row">
                                <div class="col-9 mb-3" style="background:#7e7b7b; color:white!important; padding:10px ">
                                    <strong>Informations principales
                                </div>
                                <div class="col-md-12 col-lg-9">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="row mb-3">

                                                <div class="col-sm-3">

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" id="nature1" name="nature" checked
                                                            value="Personne morale" required class="form-check-input">
                                                        <label class="form-check-label" for="nature1">
                                                            Personne morale
                                                        </label>
                                                        @if ($errors->has('nature'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary " role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('nature') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="col-sm-3">

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" id="nature2" name="nature"
                                                            value="Personne physique" required class="form-check-input">
                                                        <label class="form-check-label" for="nature2">
                                                            Personne physique
                                                        </label>
                                                        @if ($errors->has('nature'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary " role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('nature') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="col-sm-3">

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" id="nature3" name="nature" value="Couple"
                                                            required class="form-check-input">
                                                        <label class="form-check-label" for="nature3">
                                                            Couple
                                                        </label>
                                                        @if ($errors->has('nature'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary " role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('nature') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" id="nature4" name="nature"
                                                            value="Groupe" required class="form-check-input">
                                                        <label class="form-check-label" for="nature4">
                                                            Groupe
                                                        </label>
                                                        @if ($errors->has('nature'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('nature') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>


                                            </div>





                                            <div class="row">


                                                <div class="col-sm-6">
                                                    <div class="mb-3 div_personne_morale">
                                                        <label for="raison_sociale" class="form-label">
                                                            Raison sociale
                                                        </label>
                                                        <input type="text" id="raison_sociale" name="raison_sociale"
                                                            required
                                                            value="{{ old('raison_sociale') ? old('raison_sociale') : '' }}"
                                                            class="form-control">

                                                        @if ($errors->has('raison_sociale'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('raison_sociale') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="mb-3 div_personne_physique">
                                                        <label for="nom" class="form-label">
                                                            Nom
                                                        </label>
                                                        <input type="text" id="nom" name="nom"
                                                            value="{{ old('nom') ? old('nom') : '' }}"
                                                            class="form-control">

                                                        @if ($errors->has('nom'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('nom') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>


                                                    <style>
                                                        .container_email_label {
                                                            display: flex;
                                                            flex-flow: row wrap;
                                                            gap: 5px;
                                                        }

                                                        .container_email_input {
                                                            display: flex;
                                                            flex-flow: row nowrap;
                                                            justify-content: space-between;
                                                            /* gap: 5px; */
                                                        }

                                                        .item_email {
                                                            flex-grow: 11;
                                                        }

                                                        .item_btn_remove {
                                                            flex-grow: 1;
                                                        }
                                                    </style>

                                                    <input type="text" name="emailx" id="emailx" value=""
                                                        hidden>
                                                    <div class="mb-3">
                                                        <div class=" container_email_label">
                                                            <div class="">
                                                                <label for="email1" class="form-label">
                                                                    Email
                                                                </label>
                                                            </div>
                                                            <div class="">
                                                                <a class="btn btn-warning add_field_button"
                                                                    style=" margin-top:-10px; padding: 0.2rem 0.4rem;"><i
                                                                        class="mdi mdi-plus-thick "></i> </a>
                                                            </div>
                                                        </div>
                                                        <div class="input_fields_wrap">
                                                            <div class="container_email_input">
                                                                <div class="item_email">
                                                                    <input type="email" id="email" name="email"
                                                                        required
                                                                        value="{{ old('email') ? old('email') : '' }}"
                                                                        class="form-control emails">
                                                                </div>
                                                                {{-- <div class="item_btn_remove">
                                                                    <a class="btn btn-danger add_field_button"
                                                                        style="padding: 0.55rem 0.9rem;"><i
                                                                            class="mdi mdi-close-thick "></i> </a>

                                                                </div> --}}
                                                            </div>
                                                        </div>






                                                        @if ($errors->has('email'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="contact1" class="form-label">
                                                            Téléphone Fixe
                                                        </label>
                                                        <input type="text" id="contact1" name="contact1"
                                                            value="{{ old('contact1') ? old('contact1') : '' }}"
                                                            class="form-control">

                                                        @if ($errors->has('contact1'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('contact1') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="contact2" class="form-label">
                                                            Téléphone Mobile
                                                        </label>
                                                        <input type="text" id="contact2" name="contact2"
                                                            value="{{ old('contact2') ? old('contact2') : '' }}"
                                                            class="form-control">

                                                        @if ($errors->has('contact2'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('contact2') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>



                                                </div>



                                                <div class="col-sm-6">



                                                    <div class="mb-3 div_personne_morale">
                                                        <label for="forme_juridique" class="form-label">
                                                            Forme juridique
                                                        </label>

                                                        <select class="form-select select2" id="forme_juridique"
                                                            name="forme_juridique">
                                                            <option value="{{ old('forme_juridique') }}">
                                                                {{ old('forme_juridique') }}</option>

                                                            <option value="">Non défini</option>
                                                            <option value="EURL">
                                                                EURL - Entreprise unipersonnelle à responsabilité limitée
                                                            </option>
                                                            <option value="EI">EI - Entreprise individuelle</option>
                                                            <option value="SARL">SARL - Société à responsabilité limitée
                                                            </option>
                                                            <option value="SA">SA - Société anonyme</option>
                                                            <option value="SAS">SAS - Société par actions simplifiée
                                                            </option>
                                                            <option value="SCI">SCI - Société civile immobilière
                                                            </option>
                                                            <option value="SNC">SNC - Société en nom collectif</option>
                                                            <option value="EARL">
                                                                EARL - Entreprise agricole à responsabilité limitée
                                                            </option>
                                                            <option value="EIRL">
                                                                EIRL - Entreprise individuelle à responsabilité limitée
                                                            </option>
                                                            <option value="GAEC">GAEC - Groupement agricole
                                                                d'exploitation en
                                                                commun</option>
                                                            <option value="GEIE">GEIE - Groupement européen d'intérêt
                                                                économique</option>
                                                            <option value="GIE">GIE - Groupement d'intérêt économique
                                                            </option>
                                                            <option value="SASU">SASU - Société par actions simplifiée
                                                                unipersonnelle</option>
                                                            <option value="SC">SC - Société civile</option>
                                                            <option value="SCA">
                                                                SCA - Société en commandite par actions
                                                            </option>
                                                            <option value="SCIC">
                                                                SCIC - Société coopérative d'intérêt collectif
                                                            </option>
                                                            <option value="SCM">SCM - Société civile de moyens</option>
                                                            <option value="SCOP">
                                                                SCOP - Société coopérative ouvrière de production
                                                            </option>
                                                            <option value="SCP">SCP - Société civile professionnelle
                                                            </option>
                                                            <option value="SCS">SCS - Société en commandite simple
                                                            </option>
                                                            <option value="SEL">SEL - Société d'exercice libéral
                                                            </option>
                                                            <option value="SELAFA">
                                                                SELAFA - Société d'exercice libéral à forme anonyme
                                                            </option>
                                                            <option value="SELARL">
                                                                SELARL - Société d'exercice libéral à responsabilité limitée
                                                            </option>
                                                            <option value="SELAS">
                                                                SELAS - Société d'exercice libéral par actions simplifiée
                                                            </option>
                                                            <option value="SELCA">
                                                                SELCA - Société d'exercice libéral en commandite par actions
                                                            </option>
                                                            <option value="SEM">SEM - Société d'économie mixte</option>
                                                            <option value="SEML">
                                                                SEML - Société d'économie mixte locale
                                                            </option>
                                                            <option value="SEP">SEP - Société en participation</option>
                                                            <option value="SICA">SICA - Société d'intérêt collectif
                                                                agricole
                                                            </option>

                                                        </select>

                                                        @if ($errors->has('type'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('type') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="mb-3 div_personne_physique">
                                                        <label for="prenom" class="form-label">
                                                            Prénom(s)
                                                        </label>
                                                        <input type="text" id="prenom" name="prenom"
                                                            value="{{ old('prenom') ? old('prenom') : '' }}"
                                                            class="form-control">

                                                        @if ($errors->has('prenom'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('prenom') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>


                                                    <div class="mb-3 div_personne_morale">
                                                        <label for="numero_siret" class="form-label">
                                                            Numéro siret
                                                        </label>
                                                        <input type="text" id="numero_siret" name="numero_siret"
                                                            value="{{ old('numero_siret') ? old('numero_siret') : '' }}"
                                                            class="form-control">

                                                        @if ($errors->has('numero_siret'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('numero_siret') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="mb-3 div_personne_morale">
                                                        <label for="numero_tva" class="form-label">
                                                            Numéro TVA
                                                        </label>
                                                        <input type="text" id="numero_tva" name="numero_tva"
                                                            value="{{ old('numero_tva') ? old('numero_tva') : '' }}"
                                                            class="form-control">

                                                        @if ($errors->has('numero_tva'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('numero_tva') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>


                                                </div>


                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-12 "
                                                    style="background:#7e7b7b; color:white!important; padding:10px ">
                                                    <strong>Informations Complémentaires
                                                </div>
                                            </div>

                                            <div class="row">


                                                <div class="col-6">



                                                    <div class="mb-3">
                                                        <label for="adresse" class="form-label">
                                                            Adresse
                                                        </label>
                                                        <input type="text" id="adresse" name="adresse"
                                                            value="{{ old('adresse') ? old('adresse') : '' }}"
                                                            class="form-control">

                                                        @if ($errors->has('adresse'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('adresse') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="code_postal" class="form-label">
                                                            Code Postal
                                                        </label>
                                                        <input type="text" id="code_postal" name="code_postal"
                                                            value="{{ old('code_postal') ? old('code_postal') : '' }}"
                                                            class="form-control">

                                                        @if ($errors->has('code_postal'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('code_postal') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="ville" class="form-label">
                                                            Ville
                                                        </label>
                                                        <input type="text" id="ville" name="ville"
                                                            value="{{ old('ville') ? old('ville') : '' }}"
                                                            class="form-control">

                                                        @if ($errors->has('ville'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('ville') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>



                                                <div class="col-6">

                                                    <div class="mb-3">
                                                        <label for="complement_adresse" class="form-label">
                                                            Complément d'adresse
                                                        </label>
                                                        <input type="text" id="complement_adresse"
                                                            name="complement_adresse"
                                                            value="{{ old('complement_adresse') ? old('complement_adresse') : '' }}"
                                                            class="form-control">

                                                        @if ($errors->has('complement_adresse'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('complement_adresse') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="pays" class="form-label">
                                                            Pays
                                                        </label>
                                                        <input type="text" id="pays" name="pays"
                                                            value="{{ old('pays') ? old('pays') : 'France' }}"
                                                            class="form-control">

                                                        @if ($errors->has('pays'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('pays') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>



                                                    <div class="mb-3">
                                                        <label for="notes" class="form-label">Notes</label>
                                                        <textarea name="notes" class="form-control" id="notes" rows="5" placeholder="..">{{ old('notes') ? old('notes') : '' }}</textarea>
                                                        @if ($errors->has('notes'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('notes') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="row div_associer" style="margin-top:30px;">
                                                <div class="col-12 mb-3"
                                                    style="background:#7e7b7b; color:white!important; padding:10px ">
                                                    <strong>Associer d'autres contacts
                                                    </strong>
                                                </div>

                                            </div>

                                            <div class="row mt-3">
                                                <div class="modal-footer">

                                                    <button type="submit" id="enregistrer"
                                                        class="btn btn-primary">Enregistrer</button>

                                                </div>
                                            </div>
                                            <!-- end row -->

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div>
                            <!-- end row-->



                        </form>

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

            e.preventDefault();
            var emails = [];

            var email_inputs = $('.emails');
            email_inputs.each((index, input) => {
                if (input.value != "") emails.push(input.value)
            });
            console.log();
            if (emails.length == 0) {
                swal.fire(
                    'Erreur',
                    'Veuillez renseigner au moins une adresse mail',
                    'error'
                )
            } else {
                $('#emailx').val(JSON.stringify(emails));
                $('form').submit();
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

            $(".div_personne_morale").show();
            $(".div_personne_physique").hide();
            $(".div_couple").hide();
            $(".div_groupe").hide();


            $(".div_associer_contact").show();



            $("input[type='radio']").click(function(e) {

                let nature = e.currentTarget.value;

                if (nature == "Personne morale") {

                    $("input[type='text']").removeAttr("required");
                    $("select").removeAttr("required");
                    $("#type").val("entité");

                    $(".div_personne_physique").hide();
                    $(".div_personne_morale").show();
                    $(".div_couple").hide();
                    $(".div_groupe").hide();
                    $(".div_personne_tout").show();
                    $(".div_associer_contact").show();

                    $("#forme_juridique").attr("required", "required");
                    $("#raison_sociale").attr("required", "required");
                    $("#email").attr("required", "required");

                } else if (nature == "Personne physique") {
                    $("input[type='text']").removeAttr("required");
                    $("select").removeAttr("required");

                    $(".div_personne_physique").show();
                    $(".div_personne_morale").hide();
                    $(".div_couple").hide();
                    $(".div_groupe").hide();
                    $(".div_personne_tout").show();

                    $("#civilite").attr("required", "required");
                    $("#nom").attr("required", "required");
                    $("#prenom").attr("required", "required");
                    $("#email").attr("required", "required");

                    $("#type").val("individu");
                    $(".div_associer_contact").hide();



                } else if (nature == "Couple") {
                    $("input[type='text']").removeAttr("required");
                    $("select").removeAttr("required");

                    $(".div_personne_physique").hide();
                    $(".div_personne_morale").hide();
                    $(".div_couple").show();
                    $(".div_groupe").hide();
                    $(".div_personne_tout").hide();

                    $("#civilite1").attr("required", "required");
                    $("#nom1").attr("required", "required");
                    $("#prenom1").attr("required", "required");
                    $("#email1").attr("required", "required");

                    $("#civilite2").attr("required", "required");
                    $("#nom2").attr("required", "required");
                    $("#prenom2").attr("required", "required");
                    $("#email2").attr("required", "required");

                    $("#type").val("individu");
                    $(".div_associer_contact").hide();

                } else if (nature == "Groupe") {
                    $("input[type='text']").removeAttr("required");
                    $("select").removeAttr("required");

                    $(".div_personne_physique").hide();
                    $(".div_personne_morale").hide();
                    $(".div_couple").hide();
                    $(".div_personne_tout").show();
                    $(".div_groupe").show();

                    $(".div_associer_contact").show();

                    $("#nom_groupe").attr("required", "required");
                    $("#email").attr("required", "required");
                    $("#type").val("entité");

                }

            });


        });
    </script>



    <script>
        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }

        /*An array containing all the country names in the world:*/
        // var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

        var countries = ["Afghanistan", "Afrique du Sud", "Albanie", "Algérie", "Allemagne", "Andorre", "Angola",
            "Anguilla", "Arabie Saoudite", "Argentine", "Arménie", "Australie", "Autriche", "Azerbaidjan", "Bahamas",
            "Bangladesh", "Barbade", "Bahrein", "Belgique", "Bélize", "Bénin", "Biélorussie", "Bolivie", "Botswana",
            "Bhoutan", "Boznie-Herzégovine", "Brésil", "Brunei", "Bulgarie", "Burkina Faso", "Burundi", "Cambodge",
            "Cameroun", "Canada", "Cap-Vert", "Chili", "Chine", "Chypre", "Colombie", "Comores", "République du Congo",
            "République Démocratique du Congo", "Corée du Nord", "Corée du Sud", "Costa Rica", "Côte d’Ivoire",
            "Croatie", "Cuba", "Danemark", "Djibouti", "Dominique", "Egypte", "Emirats Arabes Unis", "Equateur",
            "Erythrée", "Espagne", "Estonie", "Etats-Unis d’Amérique", "Ethiopie", "Fidji", "Finlande", "France",
            "Gabon", "Gambie", "Géorgie", "Ghana", "Grèce", "Grenade", "Guatémala", "Guinée", "Guinée Bissau",
            "Guinée Equatoriale", "Guyana", "Haïti", "Honduras", "Hongrie", "Inde", "Indonésie", "Iran", "Iraq",
            "Irlande", "Islande", "Israël", "italie", "Jamaïque", "Japon", "Jordanie", "Kazakhstan", "Kenya",
            "Kirghizistan", "Kiribati", "Koweït", "Laos", "Lesotho", "Lettonie", "Liban", "Liberia", "Liechtenstein",
            "Lituanie", "Luxembourg", "Lybie", "Macédoine", "Madagascar", "Malaisie", "Malawi", "Maldives", "Mali",
            "Malte", "Maroc", "Marshall", "Maurice", "Mauritanie", "Mexique", "Micronésie", "Moldavie", "Monaco",
            "Mongolie", "Mozambique", "Namibie", "Nauru", "Nepal", "Nicaragua", "Niger", "Nigéria", "Nioué", "Norvège",
            "Nouvelle Zélande", "Oman", "Ouganda", "Ouzbékistan", "Pakistan", "Palau", "Palestine", "Panama",
            "Papouasie Nouvelle Guinée", "Paraguay", "Pays-Bas", "Pérou", "Philippines", "Pologne", "Portugal", "Qatar",
            "République centrafricaine", "République Dominicaine", "République Tchèque", "Roumanie", "Royaume Uni",
            "Russie", "Rwanda", "Saint-Christophe-et-Niévès", "Sainte-Lucie", "Saint-Marin",
            "Saint-Vincent-et-les Grenadines", "Iles Salomon", "Salvador", "Samoa Occidentales", "Sao Tomé et Principe",
            "Sénégal", "Serbie", "Seychelles", "Sierra Léone", "Singapour", "Slovaquie", "Slovénie", "Somalie",
            "Soudan", "Sri Lanka", "Suède", "Suisse", "Suriname", "Swaziland", "Syrie", "Tadjikistan", "Taiwan",
            "Tanzanie", "Tchad", "Thailande", "Timor Oriental", "Togo", "Tonga", "Trinité et Tobago", "Tunisie",
            "Turkménistan", "Turquie", "Tuvalu", "Ukraine", "Uruguay", "Vanuatu", "Vatican", "Vénézuela", "Vietnam",
            "Yemen", "Zambie", "Zimbabwe"
        ]
        /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
        autocomplete(document.getElementById("pays"), countries);
    </script>
@endsection
