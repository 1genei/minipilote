{{-- Ajout d'un individu --}}
<div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter des interlocuteurs</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('contact.associate', $contact->entite->id) }}" method="post">
                <div class="modal-body">

                    @csrf

                    <input type="hidden" name="typecontact" value="Interlocuteur" />
                    <input type="hidden" name="nature" value=" Personne physique" />

                    <div class="col-lg-12 mb-3">
                        <label for="floatingInput">Contact existant ? </label> <br>

                        <input type="checkbox" name="contact_existant" id="contact_existant" checked
                            data-switch="success" />
                        <label for="contact_existant" data-on-label="Oui" data-off-label="Non"></label>

                    </div>

                    <div class="col-lg-12 contact_existant">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="newcontact" class="form-label">
                                        Sélectionnez le contact <span class="text-danger">*</span>
                                    </label>
                                    <select name="newcontact" id="newcontact" class="form-control" required>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3 ">
                                    <label for="poste" class="form-label">
                                        Fonction <span class="text-danger">*</span>
                                    </label>
                                    <select class="select2 form-select" data-toggle="select2" id="poste" required
                                        name="poste">
                                        <option value=""></option>
                                        <option value="Directeur">Directeur</option>
                                        <option value="Président">Président</option>
                                        <option value="Directeur général">Directeur général</option>
                                        <option value="Gérant">Gérant</option>
                                        <option value="Associé">Associé</option>
                                        <option value="Chef d'entreprise">Chef d'entreprise</option>
                                        <option value="Profession libérale">Profession libérale</option>
                                        <option value="Directeur financier">Directeur financier</option>
                                        <option value="Contrôleur(se) de gestion">Contrôleur(se) de gestion</option>
                                        <option value="Assistant(e) de direction">Assistant(e) de direction</option>
                                        <option value="Assistant(e)">Assistant(e)</option>
                                        <option value="Comptable">Comptable</option>
                                        <option value="Responsable administratif(ve)">Responsable administratif(ve)
                                        </option>
                                        <option value="Secrétaire">Secrétaire</option>
                                        <option value="Responsable des achats">Responsable des achats</option>
                                        <option value="Responsable comptable">Responsable comptable</option>
                                        <option value="Directeur informatique">Directeur informatique</option>
                                        <option value="Responsable informatique">Responsable informatique</option>
                                        <option value="Autre">Autre</option>

                                    </select>

                                    @if ($errors->has('poste'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('poste') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="nouveau_contact">
                        <div class="row">


                            <div class="col-6">
                                <div class="mb-3 ">
                                    <label for="email" class="form-label">
                                        Email 
                                    </label>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email') ? old('email') : '' }}" class="form-control">

                                    @if ($errors->has('email'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-6">

                            </div>

                        </div>
                        <br>


                        <div class="row">

                            <div class="col-6">
                                <div class="mb-3 div_personne_physique">
                                    <label for="nom" class="form-label">
                                        Nom <span class="text-danger">*</span>
                                    </label>

                                    <div class="container_indicatif">

                                        <div class="item_indicatif">
                                            <select class="form-select select2" id="civilite" name="civilite">

                                                <option value="M.">M.</option>
                                                <option value="Mme">Mme</option>
                                            </select>

                                            @if ($errors->has('civilite'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('civilite') }}</strong>
                                                </div>
                                            @endif


                                        </div>

                                        <div class="item_input">
                                            <input type="text" id="nom" name="nom"
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
                            </div>
                            <div class="col-6 div-individu">
                                <div class="mb-3 ">
                                    <label for="prenom" class="form-label">
                                        Prénom(s)
                                    </label>
                                    <input type="text" id="prenom" name="prenom"
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
                            </div>



                        </div>


                        <div class="row">

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="telephone_mobile" class="form-label">
                                        Téléphone Mobile
                                    </label>
                                    <div class="container_indicatif">
                                        <div class="item_indicatif">
                                            <select class="form-select select2" id="indicatif_mobile"
                                                name="indicatif_mobile" style="width:100%">
                                                @include('livewire.indicatifs-pays')

                                            </select>

                                            </select>
                                        </div>
                                        <div class="item_input">
                                            <input type="text" id="telephone_mobile" name="telephone_mobile"
                                                value="{{ old('telephone_mobile') ? old('telephone_mobile') : '' }}"
                                                class="form-control">
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
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="telephone_fixe" class="form-label">
                                        Téléphone Fixe
                                    </label>

                                    <div class="container_indicatif">
                                        <div class="item_indicatif">
                                            <select class="form-select select2" id="indicatif_fixe"
                                                name="indicatif_fixe" style="width:100%">

                                                @include('livewire.indicatifs-pays')

                                            </select>


                                        </div>
                                        <div class="item_input">
                                            <input type="text" id="telephone_fixe" name="telephone_fixe"
                                                wire:model.defer="telephone_fixe"
                                                value="{{ old('telephone_fixe') ? old('telephone_fixe') : '' }}"
                                                class="form-control">
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
                            </div>

                        </div>

                        <br>
                        <hr><br>



                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>

                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('scripts')
<script>
$(document).ready(function() {
    // Initialisation de Select2 avec recherche Ajax
    $('#newcontact').select2({
        dropdownParent: $('#standard-modal'),
        placeholder: 'Rechercher un contact...',
        allowClear: true,
        minimumInputLength: 2,
        language: {
            inputTooShort: function() {
                return 'Veuillez saisir au moins 2 caractères';
            },
            noResults: function() {
                return 'Aucun résultat trouvé';
            },
            searching: function() {
                return 'Recherche en cours...';
            }
        },
        ajax: {
            url: '{{ route('contact.search.individu') }}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function(data) {
                return {
                    results: data.results
                };
            },
            cache: true
        },
        templateResult: formatContact,
        templateSelection: formatContactSelection
    });

    // Fonction pour formater l'affichage des résultats de recherche
    function formatContact(contact) {
        if (!contact.id) return contact.text;
        
        return $(`
            <div class="d-flex align-items-center" >
                <div>
                    <div class="font-weight-bold">${contact.nom} ${contact.prenom}</div>
                    <div class="small text-muted">
                        ${contact.email ? `<i class="mdi mdi-email text-danger"></i> ${contact.email}<br>` : ''}
                    </div>
                </div>
            </div>
        `);
    }

    // Fonction pour formater l'affichage de la sélection
    function formatContactSelection(contact) {
        if (!contact.id) return contact.text;
        return `${contact.nom} ${contact.prenom}`;
    }
});
</script>
@endpush

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

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #727cf5;
    }

    .select2-results__option {
        padding: 8px;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #e3e6f0;
    }

    .select2-dropdown {
        border: 1px solid #e3e6f0;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>
