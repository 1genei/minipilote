{{-- Ajout d'une société --}}
<div id="standard-modal-societe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter une société</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('societe.store') }}" method="post" id="form-add-societexx">
                <div class="modal-body">
                    @csrf


                    <div class="row">
                        <div class="col-12 mb-3" style="background:#7e7b7b; color:white!important; padding:10px ">
                            <strong>Informations principales
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">



                                    <div class="row">


                                        <div class="col-sm-6">


                                            <div class="mb-3 div_personne_morale">
                                                <label for="raison_sociale" class="form-label">
                                                    Raison sociale <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="raison_sociale" name="raison_sociale"
                                                    wire:model.defer="raison_sociale" required
                                                    value="{{ old('raison_sociale') ? old('raison_sociale') : '' }}"
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


                                            <div class="mb-3">
                                                <div class=" container_email_label">
                                                    <div class="">
                                                        <label for="email" class="form-label">
                                                            Adresse mail
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
                                                <label for="telephone" class="form-label">
                                                    Téléphone
                                                </label>

                                                <div class="container_indicatif">
                                                    <div class="item_indicatif">
                                                        <select class="form-select select2" id="indicatif"
                                                            name="indicatif" style="width:100%"
                                                            wire:model.defer="indicatif">

                                                            @include('livewire.indicatifs-pays')

                                                        </select>


                                                    </div>
                                                    <div class="item_input">
                                                        <input type="text" id="telephone" name="telephone"
                                                            wire:model.defer="telephone"
                                                            value="{{ old('telephone') ? old('telephone') : '' }}"
                                                            class="form-control">
                                                    </div>

                                                </div>

                                                @if ($errors->has('telephone'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('telephone') }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label for="gerant" class="form-label">
                                                    Gérant
                                                </label>
                                                <input type="text" id="gerant" name="gerant"
                                                    wire:model.defer="gerant"
                                                    value="{{ old('gerant') ? old('gerant') : '' }}"
                                                    class="form-control">

                                                @if ($errors->has('gerant'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('gerant') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="banque" class="form-label">Banque</label>
                                                <input type="text" id="banque" name="banque" class="form-control" value="{{ old('banque') ? old('banque') : '' }}">
                                                @if ($errors->has('banque'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary" role="alert">
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('banque') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="bic" class="form-label">BIC</label>
                                                <input type="text" id="bic" name="bic" class="form-control" value="{{ old('bic') ? old('bic') : '' }}">
                                                @if ($errors->has('bic'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary" role="alert">
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('bic') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="numero_rcs" class="form-label">Numéro RCS</label>
                                                <input type="text" id="numero_rcs" name="numero_rcs" class="form-control" value="{{ old('numero_rcs') ? old('numero_rcs') : '' }}">
                                                @if ($errors->has('numero_rcs'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary" role="alert">
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('numero_rcs') }}</strong>
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
                                                    name="forme_juridique" wire:model.defer="forme_juridique">
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

                                            <div class="mb-3">
                                                <label for="capital" class="form-label">
                                                    Capital
                                                </label>
                                                <input type="text" id="capital" name="capital"
                                                    wire:model.defer="capital"
                                                    value="{{ old('capital') ? old('capital') : '' }}"
                                                    class="form-control">

                                                @if ($errors->has('capital'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('capital') }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                           
                                            <div class="mb-3">
                                                <label for="iban" class="form-label">IBAN</label>
                                                <input type="text" id="iban" name="iban" class="form-control" value="{{ old('iban') ? old('iban') : '' }}">
                                                @if ($errors->has('iban'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary" role="alert">
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('iban') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="rib" class="form-label">RIB</label>
                                                <input type="text" id="rib" name="rib" class="form-control" value="{{ old('rib') ? old('rib') : '' }}">
                                                @if ($errors->has('rib'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary" role="alert">
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('rib') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                           
                                            <div class="mb-3">
                                                <label for="ville_rcs" class="form-label">Ville RCS</label>
                                                <input type="text" id="ville_rcs" name="ville_rcs" class="form-control" value="{{ old('ville_rcs') ? old('ville_rcs') : '' }}">
                                                @if ($errors->has('ville_rcs'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary" role="alert">
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('ville_rcs') }}</strong>
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

                                    <div class="row" wire:ignore>


                                        <div class="col-6">


                                            <div class="row">

                                                <div class="col-lg-4">

                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <label for="numero_voie" class="form-label item_input">
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
                                                            <div class="alert alert-warning text-secondary "
                                                                role="alert">
                                                                <button type="button"
                                                                    class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert"
                                                                    aria-label="Close"></button>
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
                                                <input type="text" id="ville" name="ville"
                                                    wire:model.defer="ville"
                                                    value="{{ old('ville') ? old('ville') : '' }}"
                                                    class="form-control">

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

                                                <select class="form-control select2" data-toggle="select2"
                                                    data-toggle="select2" id="pays" name="pays"
                                                    style="width:100%" wire:model.defer="pays">

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


                                    <!-- end row -->

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>

                </div>
            </form>
        </div>
    </div>
</div>
