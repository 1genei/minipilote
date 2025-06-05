<div class="modal fade" id="add-contact" tabindex="-1" role="dialog" aria-labelledby="quickAddContactLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="quickAddContactLabel">Ajout d'un contact</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="quickAddContactForm">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Type de contact <span class="text-danger">*</span></label>
                            <select class="form-select" id="contact_type" name="type" required>
                                <option value="">Sélectionner</option>
                                <option value="individu">Personne physique</option>
                                <option value="entite">Personne morale</option>
                            </select>
                        </div>
                    </div>

                    {{-- Champs pour Individu --}}
                    <div id="individu_fields" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Civilité</label>
                                <select class="form-select" name="civilite">
                                    <option value="M.">M.</option>
                                    <option value="Mme">Mme</option>
                                    <option value="Mlle">Mlle</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nom" id="nom">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="prenom" id="prenom">
                            </div>
                        </div>
                    </div>

                    {{-- Champs pour Entité --}}
                    <div id="entite_fields" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Raison sociale <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="raison_sociale" id="raison_sociale">
                            </div>
                        </div>
                    </div>

                    {{-- Champs communs --}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
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
                                            value="{{ old('telephone_fixe') ? old('telephone_fixe') : '' }}"
                                            class="form-control telephones">
                                    </div>
        
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
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
        
        
                                    </div>
                                    <div class="item_input">
                                        <input type="text" id="telephone_mobile" name="telephone_mobile"
                                            value="{{ old('telephone_mobile') ? old('telephone_mobile') : '' }}"
                                            class="form-control telephones">
                                    </div>
        
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" id="submitContact">
                        <i class="mdi mdi-plus-circle me-1"></i> Ajouter le contact
                    </button>
                </div>
            </form>
        </div>
    </div>
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