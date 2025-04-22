<form action="{{ route('contact.update', $contact->id) }}" method="post" id="edit-contact">
    @csrf
    @method('POST')

    {{-- Affichage des erreurs globales --}}
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="mdi mdi-alert-circle-outline me-2"></i>Erreur !</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Affichage du message de succès --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><i class="mdi mdi-check-circle-outline me-2"></i>Succès !</strong>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-12 mb-3" style="background:#7e7b7b; color:white!important; padding:10px ">
            <strong>Informations principales
        </div>

        <div class="row">

            <input type="hidden" name="typecontact" wire:model="typecontact">

            <div class="col-md-12 col-lg-6">
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
                                        @error('typecontact')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                            @error('nature')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

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
                                            class="form-control @error('raison_sociale') is-invalid @enderror">

                                        @error('raison_sociale')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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

                                                    @error('civilite')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="item_input">
                                                    <input type="text" id="nom" name="nom"
                                                        wire:model.defer="nom" required
                                                        value="{{ old('nom') ? old('nom') : '' }}" class="form-control @error('nom') is-invalid @enderror">
                                                    @error('nom')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                @else 
                                            
                                                <div class="item_input">
                                                    <input type="text" id="nom" name="raison_sociale"
                                                        wire:model.defer="raison_sociale" required
                                                        value="{{ old('raison_sociale') ? old('raison_sociale') : '' }}" class="form-control @error('raison_sociale') is-invalid @enderror">
                                                    @error('raison_sociale')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                
                                            @endif
                                            

                                        </div>

                                    </div>

                                    @if($nature == "Personne physique")
                                        <div class="mb-3 div_personne_physique">
                                            <label for="prenom" class="form-label">
                                                Prénom(s) <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="prenom" name="prenom"
                                                wire:model.defer="prenom" required
                                                value="{{ old('prenom') ? old('prenom') : '' }}" class="form-control @error('prenom') is-invalid @enderror">

                                            @error('prenom')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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
                                    .container_indicatif {
                                        display: flex;
                                        gap: 5px;

                                    }

                                    .item_indicatif {
                                        flex-grow: 2;
                                    }

                                    .item_input {
                                        flex-grow: 10;
                                    }
                                </style>

                                <div class="mb-3">
                                    <div class=" container_email_label">
                                            <div class="">
                                                <label for="email" class="form-label">
                                                    Email
                                                </label>
                                            </div>
                                        </div>
                                        <div class="input_fields_wrap">
                                            <div class="container_email_input">
                                                <div class="item_email">
                                                    <input type="email" id="email" name="email"
                                                        wire:model.defer="email"
                                                        value="{{ old('email') ? old('email') : '' }}"
                                                        class="form-control @error('email') is-invalid @enderror">
                                                </div>

                                            </div>
                                        </div>

                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                                    class="form-control telephones @error('telephone_fixe') is-invalid @enderror">
                                            </div>

                                        </div>

                                        @error('telephone_fixe')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                                    class="form-control telephones @error('telephone_mobile') is-invalid @enderror">
                                            </div>

                                        </div>



                                        @error('telephone_mobile')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                          
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

                                        @error('forme_juridique')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                @endif

                                @if ($nature == 'Personne physique')

                                    @if ($typecontact != 'Collaborateur')
                                        <div class="mb-3 div_personne_physique">
                                            <label for="profession" class="form-label">
                                                Profession
                                            </label>
                                            <input type="text" id="profession" name="profession"
                                                wire:model.defer="profession"
                                                value="{{ old('profession') ? old('profession') : '' }}"
                                                class="form-control @error('profession') is-invalid @enderror">

                                            @error('profession')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 div_personne_physique">
                                            <label for="date_naissance" class="form-label">
                                                Date de naissance
                                            </label>
                                            <input type="date" id="date_naissance" name="date_naissance"
                                                wire:model.defer="date_naissance"
                                                class="form-control @error('date_naissance') is-invalid @enderror">
                                            @error('date_naissance')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                 

                                    

                                        <div class="mb-3 div_personne_physique">
                                            <label for="entreprise" class="form-label">
                                                Entreprise
                                            </label>
                                            <input type="text" id="entreprise" name="entreprise"
                                                wire:model.defer="entreprise"
                                                value="{{ old('entreprise') }}" 
                                                class="form-control @error('entreprise') is-invalid @enderror">

                                            @error('entreprise')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 div_personne_physique">
                                            <label for="fonction_entreprise" class="form-label">
                                                Fonction dans l'entreprise
                                            </label>
                                            <input type="text" id="fonction_entreprise" name="fonction_entreprise"
                                                wire:model.defer="fonction_entreprise"
                                                value="{{ old('fonction_entreprise') }}" 
                                                class="form-control @error('fonction_entreprise') is-invalid @enderror">

                                            @error('fonction_entreprise')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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
                                            class="form-control @error('numero_siret') is-invalid @enderror">

                                            @error('numero_siret')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>

                                    <div class="mb-3 div_personne_morale">
                                        <label for="numero_tva" class="form-label">
                                            Numéro TVA
                                        </label>
                                        <input type="text" id="numero_tva" name="numero_tva"
                                            wire:model.defer="numero_tva"
                                            value="{{ old('numero_tva') ? old('numero_tva') : '' }}"
                                            class="form-control @error('numero_tva') is-invalid @enderror">

                                            @error('numero_tva')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>

                                @endif

                                @if ($nature == 'Groupe')


                                    <div class="mb-3 ">
                                        <label for="forme_juridique" class="form-label">
                                            Type de groupe <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select select2" id="forme_juridique" name="forme_juridique"
                                            wire:model.defer="forme_juridique">
                                            <option value="{{ old('forme_juridique') }}">
                                                {{ old('forme_juridique') }}</option>
                                            <option value=""> </option>
                                            <option value="Succession">Succession </option>
                                            <option value="Association">Association </option>
                                            <option value="Indivision">Indivision </option>
                                            <option value="Autre">Autre</option>
                                        </select>

                                        @error('forme_juridique')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                                    Num voie
                                                </label>
                                            </div>
                                            <div class="col-12">
                                                <input type="number" id="numero_voie" name="numero_voie"
                                                    wire:model.defer="numero_voie"
                                                    value="{{ old('numero_voie') ? old('numero_voie') : '' }}"
                                                    class="form-control @error('numero_voie') is-invalid @enderror">
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
                                                    class="form-control @error('nom_voie') is-invalid @enderror">
                                            </div>

                                            @error('nom_voie')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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
                                        class="form-control @error('code_postal') is-invalid @enderror">

                                    @error('code_postal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="ville" class="form-label">
                                        Ville
                                    </label>
                                    <input type="text" id="ville" name="ville" wire:model.defer="ville"
                                        value="{{ old('ville') ? old('ville') : '' }}" class="form-control @error('ville') is-invalid @enderror">

                                    @error('ville')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
                                        class="form-control @error('complement_voie') is-invalid @enderror">

                                    @error('complement_voie')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3" wire:ignore>
                                    <label for="pays" class="form-label">
                                        Pays
                                    </label>

                                    <select class="form-control select2" data-toggle="select2" id="pays"
                                        name="pays" style="width:100%" wire:model.defer="pays">

                                        @include('livewire.pays')

                                    </select>

                                    @error('pays')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>



                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" wire:model.defer="notes" class="form-control @error('notes') is-invalid @enderror" id="notes" rows="5"
                                        placeholder="...">{{ old('notes') ? old('notes') : '' }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
                                <div class="mb-3">
                                    <label for="tags" class="form-label">
                                        Tags
                                        <i class="mdi mdi-information-outline" data-bs-toggle="tooltip" data-bs-placement="top" 
                                           title="Sélectionnez des tags existants ou créez-en de nouveaux"></i>
                                    </label>
                                    <select class="select2-tags form-control" id="tags" name="tags[]" multiple="multiple" data-toggle="select2" 
                                            data-placeholder="Choisir ou créer des tags..." data-allow-clear="true">
                                        @foreach($existingTags as $tag)
                                            <option value="{{ $tag }}" {{ in_array($tag, $selectedTags) ? 'selected' : '' }}>
                                                {{ $tag }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

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

                                        @error('commercial_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                @endif
                                @if ($typecontact != 'Collaborateur' && $nature == 'Personne physique')
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

                                        @error('societe_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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

@section('script')
{{-- <script>
    $(document).ready(function() {
        // Initialisation de Select2 avec options avancées
        $('#tags').select2({
            theme: 'bootstrap',
            tags: true,
            tokenSeparators: [',', ' ', ';'],
            placeholder: "Saisissez ou sélectionnez des tags...",
            allowClear: true,
            createTag: function(params) {
                var term = $.trim(params.term);
                
                if (term === '') {
                    return null;
                }
                
                return {
                    id: term,
                    text: term + ' (Nouveau)',
                    newTag: true
                };
            },
            templateResult: function(data) {
                var $result = $("<span></span>");
                
                if (data.newTag) {
                    $result.html('<i class="mdi mdi-plus-circle text-success me-1"></i>' + data.text);
                } else {
                    $result.html('<i class="mdi mdi-tag me-1"></i>' + data.text);
                }
                
                return $result;
            },
            templateSelection: function(data) {
                var icon = data.newTag ? 'mdi mdi-plus-circle' : 'mdi mdi-tag';
                var text = data.newTag ? data.text.replace(' (Nouveau)', '') : data.text;
                return $('<span><i class="' + icon + ' me-1"></i>' + text + '</span>');
            }
        }).on('change', function(e) {
            @this.set('selectedTags', $(this).val());
        });
        

    });

    // Réinitialisation quand Livewire met à jour le DOM
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            // $('#tags').select2('destroy');
            $('#tags').select2({
                tags: true,
                tokenSeparators: [',', ' ', ';'],
                placeholder: "Saisissez ou sélectionnez des tags...",
                allowClear: true,
            });
        });
    });
</script> --}}

<script>
    function initializeSelect2() {
        $('#tags').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            placeholder: "Saisissez ou sélectionnez des tags...",
            allowClear: true,
            language: {
                noResults: function() {
                    return "Aucun résultat trouvé";
                }
            }
        });
    }

    // Initialisation au chargement de la page
    $(document).ready(function() {
        initializeSelect2();
    });

    // Réinitialisation quand Livewire met à jour le DOM
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            initializeSelect2();
        });
    });

    // Réinitialisation lors du changement de nature
    $('input[name="nature"]').on('change', function() {
        setTimeout(function() {
            initializeSelect2();
        }, 100); // Petit délai pour laisser le DOM se mettre à jour
    });
</script>
@endsection


