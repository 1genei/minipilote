<form action="{{ route('societe.update', Crypt::encrypt($societe->id)) }}" method="POST"
    id="edit-form-{{ $index }}" class="edit-societe">
    <div class="modal-header d-flex justify-content-between">
        <h3>{{ $societe->est_societe_principale ? $societe->raison_sociale . ' (principale)' : ($societe->archive ? $societe->raison_sociale . ' (archivée)' : $societe->raison_sociale) }}
        </h3>
        <div class="d-flex align-items-center">
            @if (!$societe->est_societe_principale)
                @if (!$societe->archive)
                    <span id="tooltip-archive">
                        <a data-href="{{ route('societe.archive', Crypt::encrypt($societe->id)) }}"
                            style="cursor: pointer;" class="action-icon text-warning archive_societe""
                            data-bs-container="#tooltip-archive" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Archiver">
                            <i class="mdi mdi-archive-arrow-down" style="font-size: 2rem;"></i>
                        </a>
                    </span>
                @else
                    <span id="tooltip-unarchive">
                        <a data-href="{{ route('societe.unarchive', Crypt::encrypt($societe->id)) }}"
                            style="cursor: pointer;" class="action-icon text-info unarchive_societe"
                            data-bs-container="#tooltip-unarchive" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Restaurer">
                            <i class="mdi mdi-archive-arrow-up" style="font-size: 2rem;"></i>
                        </a>
                    </span>
                @endif
            @endif
        </div>
    </div>
    <div class="modal-body">
        @csrf
        <div class="col-lg-12">
            <div class="form-floating mb-3">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="m-2">
                            <label for="forme_juridique">Forme juridique</label>
                            <select name="forme_juridique" class="form-control w-75">
                                <option value="{{ $societe->forme_juridique }}">{{ $societe->forme_juridique }}</option>
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
                        </div>
                        <div class="m-2">
                            <label for="raison_sociale">Raison Sociale</label>
                            <input type="text" name="raison_sociale" class="form-control w-75"
                                value="{{ $societe->raison_sociale }}" />
                        </div>
                        <div class="m-2">
                            <label for="numero_sirete">Numéro de SIRET</label>
                            <input type="text" name="numero_siret" class="form-control w-75"
                                value="{{ $societe->numero_siret }}" />
                        </div>
        
                        <div class="m-2">
                            <label for="capital">Capital</label>
                            <input type="text" name="capital" class="form-control w-75" value="{{ $societe->capital }}" />
                        </div>
                        <div class="m-2">
                            <label for="gerant">Gérant</label>
                            <input type="text" name="gerant" class="form-control w-75" value="{{ $societe->gerant }}" />
                        </div>
                        <div class="m-2">
                            <label for="raison_sociale">Numéro de TVA</label>
                            <input type="text" name="numero_tva" class="form-control w-75"
                                value="{{ $societe->numero_tva }}" />
                        </div>
                        <div class="m-2">
                            <label for="email">Adresse mail</label>
                            <input type="text" name="email" class="form-control w-75" value="{{ $societe->email }}" />
                        </div>
                        {{-- <div class="m-2">
                            <label for="telephone">Numéro de téléphone</label>
                            <input type="text" name="telephone" class="form-control w-75"
                                value="{{ $societe->telephone }}" />
                        </div> --}}
                        <div class="m-2">
                            <label for="telephone" class="form-label">
                                Téléphone
                            </label>

                            <div class="container_indicatif">
                                <div class="item_indicatif">
                                    <select class="form-select w-75" id="indicatif"
                                        name="indicatif" 
                                        >
                                        <option value="{{ $societe->indicatif }}">{{ $societe->indicatif }}</option>
                                        @include('livewire.indicatifs-pays')

                                    </select>


                                </div>
                                <div class="item_input">
                                    <input type="text" id="telephone" name="telephone"
                                        value="{{ $societe->telephone }}"
                                        class="form-control w-50">
                                </div>

                            </div>
                        </div>
                        <div class="m-2">
                            <label for="numero_voie">numéro de la voie</label>
                            <input type="text" name="numero_voie" class="form-control w-75"
                                value="{{ $societe->numero_voie }}" />
                        </div>
                        <div class="m-2">
                            <label for="nom_voie">nom de la voie</label>
                            <input type="text" name="nom_voie" class="form-control w-75" value="{{ $societe->nom_voie }}" />
                        </div>
                        <div class="m-2">
                            <label for="complement_voie">Complément de la voie</label>
                            <input type="text" name="complement_voie" class="form-control w-75"
                                value="{{ $societe->complement_voie }}" />
                        </div>
                        <div class="m-2">
                            <label for="ville">Ville</label>
                            <input type="text" name="ville" class="form-control w-75" value="{{ $societe->ville }}" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="m-2">
                            <label for="code_postal">Code postal</label>
                            <input type="text" name="code_postal" class="form-control w-75"
                                value="{{ $societe->code_postal }}" />
                        </div>
                        <div class="m-2">
                            <label for="pays">Pays</label>
                            <input type="text" name="pays" class="form-control w-75" value="{{ $societe->pays }}" />
                        </div>
                        
                        <div class="m-2">
                            <label for="banque">Banque</label>
                            <input type="text" name="banque" class="form-control w-75" value="{{ $societe->banque }}" />
                        </div>
                        <div class="m-2">
                            <label for="iban">IBAN</label>
                            <input type="text" name="iban" class="form-control w-75" value="{{ $societe->iban }}" />
                        </div>
                        <div class="m-2">
                            <label for="bic">BIC</label>
                            <input type="text" name="bic" class="form-control w-75" value="{{ $societe->bic }}" />
                        </div>
                        <div class="m-2">
                            <label for="rib">RIB</label>
                            <input type="text" name="rib" class="form-control w-75" value="{{ $societe->rib }}" />
                        </div>
                        <div class="m-2">
                            <label for="numero_rcs">Numéro RCS</label>
                            <input type="text" name="numero_rcs" class="form-control w-75" value="{{ $societe->numero_rcs }}" />
                        </div>
                        <div class="m-2">
                            <label for="ville_rcs">Ville RCS</label>
                            <input type="text" name="ville_rcs" class="form-control w-75" value="{{ $societe->ville_rcs }}" />
                        </div>
                    </div>
                </div>

                
                
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="save-button-{{ $index }}">Sauvegarder</button>
        <button type="button" class="btn btn-light" id="cancel-button-{{ $index }}">Annuler</button>
    </div>
</form>

<style>
     .container_indicatif
      {
        display: flex;
        flex-flow: row wrap;
        gap: 5px;

        }

    .item_indicatif {
        flex-grow: 2;
    }

</style>