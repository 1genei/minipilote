<form action="{{ route('contact.update', Crypt::encrypt($contact->id)) }}" method="post" id="edit-contact">
    @csrf


    <div class="row">
        <div class="col-12 mb-3" style="background:#7e7b7b; color:white!important; padding:10px ">
            <strong>Informations principales
        </div>

        <div class="row">

            <input type="hidden" name="typecontact" wire:model="typecontact">

            <div class="col-md-12 col-lg-9">
                <div class="card">
                    <div class="card-body">

                        @if ($displaytypecontact == true)
                            <div class="row">
                                <div class="col-6">

                                    <div class="mb-3 ">
                                        <label for="typecontact" class="form-label">
                                            Type de contact <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select select2" id="typecontact" name="typecontact"
                                            wire:model="typecontact">
                                            @foreach ($typecontacts as $type)
                                                <option value="{{ $type->type }}">{{ $type->type }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('typecontact'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('typecontact') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endif
                        <div class="row mb-3">

                            @if ($typecontact == 'Collaborateur')
                                <div class="col-sm-3">

                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="nature2" name="nature" wire:model="nature"
                                            value="Personne physique" required class="form-check-input">
                                        <label class="form-check-label" for="nature2">
                                            Personne physique
                                        </label>

                                    </div>

                                </div>
                            @else
                                <div class="col-sm-3">

                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="nature1" name="nature" wire:model="nature"
                                            @if (old('nature') == 'Personne morale') checked @endif
                                            @if ($contact->nature == 'Personne morale') checked @endif value="Personne morale"
                                            required class="form-check-input">
                                        <label class="form-check-label" for="nature1">
                                            Personne morale
                                        </label>

                                    </div>

                                </div>
                                <div class="col-sm-3">

                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="nature2" name="nature" wire:model="nature"
                                            @if (old('nature') == 'Personne physique') checked @endif
                                            @if ($contact->nature == 'Personne physique') checked @endif value="Personne physique"
                                            required class="form-check-input">
                                        <label class="form-check-label" for="nature2">
                                            Personne physique
                                        </label>

                                    </div>

                                </div>
                                {{-- <div class="col-sm-3">

                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="nature3" name="nature" wire:model="nature"
                                            value="Couple" @if (old('nature') == 'Couple') checked @endif
                                            @if ($contact->nature == 'Couple') checked @endif required
                                            class="form-check-input">
                                        <label class="form-check-label" for="nature3">
                                            Couple
                                        </label>

                                    </div>

                                </div> --}}
                                <div class="col-sm-3">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="nature4" name="nature" wire:model="nature"
                                            value="Groupe" @if (old('nature') == 'Groupe') checked @endif
                                            @if ($contact->nature == 'Groupe') checked @endif required
                                            class="form-check-input">
                                        <label class="form-check-label" for="nature4">
                                            Groupe
                                        </label>

                                    </div>

                                </div>
                            @endif
                            @if ($errors->has('nature'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>{{ $errors->first('nature') }}</strong>
                                </div>
                            @endif

                        </div>





                        <div class="row">


                            <div class="col-sm-6">

                                @if ($nature == 'Personne morale')
                                    <div class="mb-3 div_personne_morale">
                                        <label for="raison_sociale" class="form-label">
                                            Raison sociale <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="raison_sociale" name="raison_sociale"
                                            wire:model.defer="raison_sociale" required {{-- value="{{ old('raison_sociale') ? old('raison_sociale') : '' }}" --}}
                                            class="form-control">

                                        @if ($errors->has('raison_sociale'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('raison_sociale') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                @if ($nature == 'Personne physique' || $nature == 'Groupe')
                                    <div class="mb-3 div_personne_physique">
                                        <label for="nom" class="form-label">
                                            Nom <span class="text-danger">*</span>
                                        </label>

                                        <div class="container_indicatif">
                                            @if ($nature == 'Personne physique')
                                                <div class="item_indicatif">
                                                    <select class="form-select select2" id="civilite"
                                                        name="civilite" wire:model.defer="civilite">

                                                        <option value="M.">M.</option>
                                                        <option value="Mme">Mme</option>
                                                    </select>

                                                    @if ($errors->has('civilite'))
                                                        <br>
                                                        <div class="alert alert-warning text-secondary "
                                                            role="alert">
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>{{ $errors->first('civilite') }}</strong>
                                                        </div>
                                                    @endif


                                                </div>
                                            @endif
                                            <div class="item_input">
                                                <input type="text" id="nom" name="nom"
                                                    wire:model.defer="nom" required
                                                    value="{{ old('nom') ? old('nom') : '' }}" class="form-control">
                                                @if ($errors->has('nom'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('nom') }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                    </div>

                                @endif

                                @if ($nature == 'Couple')


                                    <div class="mb-3 div_couple">
                                        <label for="nom1" class="form-label">
                                            Nom <span class="text-danger">*</span>
                                        </label>

                                        <div class="container_indicatif">
                                            <div class="item_indicatif">
                                                <select class="form-select select2" id="civilite1" name="civilite1"
                                                    wire:model.defer="civilite1">

                                                    <option value="M.">M.</option>
                                                    <option value="Mme">Mme</option>
                                                </select>

                                                @if ($errors->has('civilite1'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('civilite1') }}</strong>
                                                    </div>
                                                @endif


                                            </div>

                                            <div class="item_input">
                                                <input type="text" id="nom1" name="nom1"
                                                    wire:model.defer="nom1" required
                                                    value="{{ old('nom1') ? old('nom1') : '' }}"
                                                    class="form-control">
                                                @if ($errors->has('nom1'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('nom1') }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                    </div>

                                    <div class="mb-3 ">
                                        <label for="prenom1" class="form-label">
                                            Prénom(s) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="prenom1" name="prenom1"
                                            wire:model.defer="prenom1" required
                                            value="{{ old('prenom1') ? old('prenom1') : '' }}" class="form-control">

                                        @if ($errors->has('prenom1'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('prenom1') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="email1" class="form-label">
                                            Email
                                        </label>
                                        <input type="email" id="email1" name="email1"
                                            wire:model.defer="email1"
                                            value="{{ old('email1') ? old('email1') : '' }}"
                                            class="form-control emails">

                                        @if ($errors->has('email1'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('email1') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    @if ($typecontact == 'Prospect' || $typecontact == 'Client')
                                        <div class="mb-3 div_personne_physique">
                                            <label for="profession1" class="form-label">
                                                Profession
                                            </label>
                                            <input type="text" id="profession1" name="profession1"
                                                wire:model.defer="profession1"
                                                value="{{ old('profession1') ? old('profession1') : '' }}"
                                                class="form-control">

                                            @if ($errors->has('profession1'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('profession1') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endif

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

                                    .container_indicatif {
                                        display: flex;
                                        flex-flow: row wrap;
                                        gap: 5px;

                                    }

                                    .item_indicatif {
                                        flex-grow: 2;
                                    }

                                    .item_input {
                                        flex-grow: 10;
                                    }
                                </style>

                                {{-- <input type="text" name="emailx" wire:model.defer="emailx" id="emailx"
                                value="" hidden> --}}
                                @if ($nature != 'Couple')
                                    <div class="mb-3">
                                        <div class=" container_email_label">
                                            <div class="">
                                                <label for="email" class="form-label">
                                                    Email
                                                </label>
                                            </div>
                                            {{-- <div class="">
                                            <a class="btn btn-warning add_field_button"
                                                style=" margin-top:-10px; padding: 0.2rem 0.4rem;"><i
                                                    class="mdi mdi-plus-thick "></i> </a>
                                        </div> --}}
                                        </div>
                                        <div class="input_fields_wrap">
                                            <div class="container_email_input">
                                                <div class="item_email">
                                                    <input type="email" id="email" name="email"
                                                        wire:model.defer="email"
                                                        value="{{ old('email') ? old('email') : '' }}"
                                                        class="form-control emails">
                                                </div>

                                            </div>
                                        </div>

                                        @if ($errors->has('email'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="telephone_fixe" class="form-label">
                                            Téléphone Fixe
                                        </label>

                                        <div class="container_indicatif">
                                            <div class="item_indicatif">
                                                <select class="form-select select2" id="indicatif_fixe"
                                                    name="indicatif_fixe" style="width:100%"
                                                    wire:model.defer="indicatif_fixe">

                                                    @include('livewire.indicatifs-pays')

                                                </select>


                                            </div>
                                            <div class="item_input">
                                                <input type="text" id="telephone_fixe" name="telephone_fixe"
                                                    wire:model.defer="telephone_fixe"
                                                    value="{{ old('telephone_fixe') ? old('telephone_fixe') : '' }}"
                                                    class="form-control telephones">
                                            </div>

                                        </div>

                                        @if ($errors->has('telephone_fixe'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('telephone_fixe') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="telephone_mobile" class="form-label">
                                            Téléphone Mobile
                                        </label>
                                        <div class="container_indicatif">
                                            <div class="item_indicatif">
                                                <select class="form-select select2" id="indicatif_mobile"
                                                    name="indicatif_mobile" style="width:100%"
                                                    wire:model.defer="indicatif_mobile">
                                                    @include('livewire.indicatifs-pays')

                                                </select>

                                                </select>
                                            </div>
                                            <div class="item_input">
                                                <input type="text" id="telephone_mobile" name="telephone_mobile"
                                                    wire:model.defer="telephone_mobile"
                                                    value="{{ old('telephone_mobile') ? old('telephone_mobile') : '' }}"
                                                    class="form-control telephones">
                                            </div>

                                        </div>



                                        @if ($errors->has('telephone_mobile'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('telephone_mobile') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if ($nature == 'Couple')

                                    <div class="mb-3">
                                        <label for="telephone_fixe1" class="form-label">
                                            Téléphone Fixe
                                        </label>

                                        <div class="container_indicatif">
                                            <div class="item_indicatif">
                                                <select class="form-select select2" id="indicatif_fixe1"
                                                    name="indicatif_fixe1" style="width:100%"
                                                    wire:model.defer="indicatif_fixe1">
                                                    @include('livewire.indicatifs-pays')

                                                </select>

                                                </select>
                                            </div>
                                            <div class="item_input">
                                                <input type="text" id="telephone_fixe1" name="telephone_fixe1"
                                                    wire:model.defer="telephone_fixe1"
                                                    value="{{ old('telephone_fixe1') ? old('telephone_fixe1') : '' }}"
                                                    class="form-control telephones">
                                            </div>

                                        </div>
                                        @if ($errors->has('telephone_fixe1'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('telephone_fixe1') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="telephone_mobile1" class="form-label">
                                            Téléphone Mobile
                                        </label>

                                        <div class="container_indicatif">
                                            <div class="item_indicatif">
                                                <select class="form-select select2" id="indicatif_mobile1"
                                                    name="indicatif_mobile1" style="width:100%"
                                                    wire:model.defer="indicatif_mobile1">
                                                    @include('livewire.indicatifs-pays')

                                                </select>

                                                </select>
                                            </div>
                                            <div class="item_input">
                                                <input type="text" id="telephone_mobile1" name="telephone_mobile1"
                                                    wire:model.defer="telephone_mobile1"
                                                    value="{{ old('telephone_mobile1') ? old('telephone_mobile1') : '' }}"
                                                    class="form-control telephones">
                                            </div>

                                        </div>

                                        @if ($errors->has('telephone_mobile1'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('telephone_mobile1') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                @endif




                            </div>



                            <div class="col-sm-6">


                                @if ($nature == 'Personne morale')
                                    <div class="mb-3 div_personne_morale">
                                        <label for="forme_juridique" class="form-label">
                                            Forme juridique <span class="text-danger">*</span>
                                        </label>

                                        <select class="form-select select2" id="forme_juridique"
                                            name="forme_juridique" required wire:model.defer="forme_juridique">
                                            <option value="{{ old('forme_juridique') }}">
                                                {{ old('forme_juridique') }}</option>

                                            <option value="Non défini">Non défini</option>
                                            <option value="CE">CE - Comité d'Entreprise </option> 
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
                                            <option value="Autre">Autre</option>

                                        </select>

                                        @if ($errors->has('forme_juridique'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('forme_juridique') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if ($nature == 'Personne physique')

                                    <div class="mb-3 div_personne_physique">
                                        <label for="prenom" class="form-label">
                                            Prénom(s) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="prenom" name="prenom"
                                            wire:model.defer="prenom" required
                                            value="{{ old('prenom') ? old('prenom') : '' }}" class="form-control">

                                        @if ($errors->has('prenom'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('prenom') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    @if ($typecontact == 'Prospect' || $typecontact == 'Client')
                                        <div class="mb-3 div_personne_physique">
                                            <label for="profession" class="form-label">
                                                Profession
                                            </label>
                                            <input type="text" id="profession" name="profession"
                                                wire:model.defer="profession"
                                                value="{{ old('profession') ? old('profession') : '' }}"
                                                class="form-control">

                                            @if ($errors->has('profession'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('profession') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                                @if ($nature == 'Personne morale')
                                    <div class="mb-3 div_personne_morale">
                                        <label for="numero_siret" class="form-label">
                                            Numéro siret
                                        </label>
                                        <input type="text" id="numero_siret" name="numero_siret"
                                            wire:model.defer="numero_siret"
                                            value="{{ old('numero_siret') ? old('numero_siret') : '' }}"
                                            class="form-control">

                                        @if ($errors->has('numero_siret'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
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
                                            wire:model.defer="numero_tva"
                                            value="{{ old('numero_tva') ? old('numero_tva') : '' }}"
                                            class="form-control">

                                        @if ($errors->has('numero_tva'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('numero_tva') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                @endif

                                @if ($nature == 'Couple')


                                    <div class="mb-3 div_couple">
                                        <label for="nom2" class="form-label">
                                            Nom <span class="text-danger">*</span>
                                        </label>

                                        <div class="container_indicatif">
                                            <div class="item_indicatif">
                                                <select class="form-select select2" id="civilite2" name="civilite2"
                                                    wire:model.defer="civilite2">

                                                    <option value="M.">M.</option>
                                                    <option value="Mme">Mme</option>
                                                </select>

                                                @if ($errors->has('civilite2'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('civilite2') }}</strong>
                                                    </div>
                                                @endif


                                            </div>

                                            <div class="item_input">
                                                <input type="text" id="nom2" name="nom2"
                                                    wire:model.defer="nom2" required
                                                    value="{{ old('nom2') ? old('nom2') : '' }}"
                                                    class="form-control">
                                                @if ($errors->has('nom2'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('nom2') }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                    </div>



                                    <div class="mb-3 ">
                                        <label for="prenom2" class="form-label">
                                            Prénom(s) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="prenom2" name="prenom2"
                                            wire:model.defer="prenom2" required
                                            value="{{ old('prenom2') ? old('prenom2') : '' }}" class="form-control">

                                        @if ($errors->has('prenom2'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('prenom2') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="email2" class="form-label">
                                            Email
                                        </label>
                                        <input type="email" id="email2" name="email2"
                                            wire:model.defer="email2"
                                            value="{{ old('email2') ? old('email2') : '' }}"
                                            class="form-control emails">

                                        @if ($errors->has('email2'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('email2') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    @if ($typecontact == 'Prospect' || $typecontact == 'Client')
                                        <div class="mb-3 div_personne_physique">
                                            <label for="profession2" class="form-label">
                                                Profession
                                            </label>
                                            <input type="text" id="profession2" name="profession2"
                                                wire:model.defer="profession2"
                                                value="{{ old('profession2') ? old('profession2') : '' }}"
                                                class="form-control">

                                            @if ($errors->has('profession2'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('profession2') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endif

                                @if ($nature == 'Groupe')


                                    <div class="mb-3 ">
                                        <label for="type" class="form-label">
                                            Type de groupe <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select select2" id="type" name="type"
                                            wire:model.defer="type">
                                            <option value="{{ old('type') }}">
                                                {{ old('type') }}</option>
                                            <option value=""> </option>
                                            <option value="Succession">Succession </option>
                                            <option value="Association">Association </option>
                                            <option value="Indivision">Indivision </option>
                                            <option value="Autre">Autre</option>
                                        </select>

                                        @if ($errors->has('type'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if ($nature == 'Couple')

                                    <div class="mb-3">
                                        <label for="telephone_fixe2" class="form-label">
                                            Téléphone Fixe
                                        </label>
                                        <div class="container_indicatif">
                                            <div class="item_indicatif">
                                                <select class="form-select select2" id="indicatif_fixe2"
                                                    name="indicatif_fixe2" style="width:100%"
                                                    wire:model.defer="indicatif_fixe2">
                                                    @include('livewire.indicatifs-pays')

                                                </select>

                                                </select>
                                            </div>
                                            <div class="item_input">
                                                <input type="text" id="telephone_fixe2" name="telephone_fixe2"
                                                    wire:model.defer="telephone_fixe2"
                                                    value="{{ old('telephone_fixe2') ? old('telephone_fixe2') : '' }}"
                                                    class="form-control telephones">
                                            </div>

                                        </div>

                                        @if ($errors->has('telephone_fixe2'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('telephone_fixe2') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="telephone_mobile2" class="form-label">
                                            Téléphone Mobile
                                        </label>
                                        <div class="container_indicatif">
                                            <div class="item_indicatif">
                                                <select class="form-select select2" id="indicatif_mobile2"
                                                    name="indicatif_mobile2" style="width:100%"
                                                    wire:model.defer="indicatif_mobile2">
                                                    @include('livewire.indicatifs-pays')

                                                </select>

                                                </select>
                                            </div>
                                            <div class="item_input">
                                                <input type="text" id="telephone_mobile2" name="telephone_mobile2"
                                                    wire:model.defer="telephone_mobile2"
                                                    value="{{ old('telephone_mobile2') ? old('telephone_mobile2') : '' }}"
                                                    class="form-control telephones">
                                            </div>

                                        </div>

                                        @if ($errors->has('telephone_mobile2'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('telephone_mobile2') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                @endif
                            </div>




                        </div>

                        <div class="row mb-3">
                            <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                                <strong>Informations Complémentaires</strong>
                            </div>
                        </div>

                        <div class="row" wire:ignore>


                            <div class="col-6">



                                <div class="row">

                                    <div class="col-lg-4">

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="telephone_fixe" class="form-label item_input">
                                                    Numéro de voie
                                                </label>
                                            </div>
                                            <div class="col-12">
                                                <input type="number" id="numero_voie" name="numero_voie"
                                                    wire:model.defer="numero_voie"
                                                    value="{{ old('numero_voie') ? old('numero_voie') : '' }}"
                                                    class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="nom_voie" class="form-label item_input">
                                                    Nom de la voie
                                                </label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="nom_voie" name="nom_voie"
                                                    wire:model.defer="nom_voie"
                                                    value="{{ old('nom_voie') ? old('nom_voie') : '' }}"
                                                    class="form-control">
                                            </div>

                                            @if ($errors->has('nom_voie'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('nom_voie') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>



                                <div class="mb-3">
                                    <label for="code_postal" class="form-label">
                                        Code Postal
                                    </label>
                                    <input type="text" id="code_postal" name="code_postal"
                                        wire:model.defer="code_postal"
                                        value="{{ old('code_postal') ? old('code_postal') : '' }}"
                                        class="form-control">

                                    @if ($errors->has('code_postal'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
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
                                    <input type="text" id="ville" name="ville" wire:model.defer="ville"
                                        value="{{ old('ville') ? old('ville') : '' }}" class="form-control">

                                    @if ($errors->has('ville'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('ville') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>



                            <div class="col-6">

                                <div class="mb-3">
                                    <label for="complement_voie" class="form-label">
                                        Complément de voie
                                    </label>
                                    <input type="text" id="complement_voie" name="complement_voie"
                                        wire:model.defer="complement_voie"
                                        value="{{ old('complement_voie') ? old('complement_voie') : '' }}"
                                        class="form-control">

                                    @if ($errors->has('complement_voie'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('complement_voie') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-3" wire:ignore>
                                    <label for="pays" class="form-label">
                                        Pays
                                    </label>

                                    <select class="form-control select2" data-toggle="select2" id="pays"
                                        name="pays" style="width:100%" wire:model.defer="pays">

                                        @include('livewire.pays')

                                    </select>

                                    @if ($errors->has('pays'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('pays') }}</strong>
                                        </div>
                                    @endif
                                </div>



                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" wire:model.defer="notes" class="form-control" id="notes" rows="5"
                                        placeholder="...">{{ old('notes') ? old('notes') : '' }}</textarea>
                                    @if ($errors->has('notes'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('notes') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>



                        <div class="row mt-3">
                            <div class="modal-footer">

                                <button type="submit" id="modifier" wire:click="submit"
                                    class="btn btn-success">Modifier</button>

                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->



            <div class="col-md-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12">
                                @if ($typecontact == 'Prospect' || $typecontact == 'Client')
                                    <div class="mb-3 ">
                                        <label for="commercial_id" class="form-label">
                                            Suivi par
                                        </label>
                                        <select class="form-select select2" id="commercial_id" name="commercial_id"
                                            wire:model.defer="commercial_id">
                                            <option value=""></option>
                                            @foreach ($collaborateurs as $collaborateur)
                                                <option value="{{ $collaborateur->id }}">
                                                    {{ $collaborateur->infos()->nom }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('commercial_id'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close">
                                                </button>
                                                <strong>{{ $errors->first('commercial_id') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                @if ($typecontact != 'Collaborateur')
                                    <div class="mb-3 ">
                                        <label for="societe_id" class="form-label">
                                            Est un contact de la société
                                        </label>
                                        <select class="form-select select2" id="societe_id" name="societe_id"
                                            wire:model.defer="societe_id">
                                            <option value=""></option>
                                            @foreach ($societes as $societe)
                                                <option value="{{ $societe->id }}">{{ $societe->raison_sociale }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('societe_id'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close">
                                                </button>
                                                <strong>{{ $errors->first('societe_id') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>



                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end row-->



</form>
