{{-- Ajout d'une société --}}
<div id="standard-modal-societe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter une société</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('societe.store') }}" method="post" id="form-add-societexx">
                <div class="modal-body">
                    @csrf
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <div class="m-2">
                                <label for="raison_sociale">Raison Sociale</label>
                                <input type="text" name="raison_sociale" class="form-control" value="" />
                            </div>
                            <div class="m-2">
                                <label for="numero_sirete">Numéro de SIRET</label>
                                <input type="text" name="numero_siret" class="form-control" value="" />
                            </div>
                            <div class="m-2">
                                <label for="logo">Logo</label>
                                <div>
                                    <p>Pas de logo chargé</p>
                                </div>
                                <div>
                                    <input type="file" name="add_logo_file" id="add_logo_file" accept="image/*"
                                        style="display: none;" />
                                    <button type="button" id="add_browse_button"
                                        class="btn btn-success mt-1">Parcourir</button>
                                </div>
                            </div>
                            <div class="m-2">
                                <label for="capital">Capital</label>
                                <input type="text" name="capital" class="form-control" value="" />
                            </div>
                            <div class="m-2">
                                <label for="gerant">Gérant</label>
                                <input type="text" name="gerant" class="form-control" value="" />
                            </div>
                            <div class="m-2">
                                <label for="raison_sociale">Numéro de TVA</label>
                                <input type="text" name="numero_tva" class="form-control" value="" />
                            </div>
                            <div class="m-2">
                                <label for="email">Adresse mail</label>
                                <input type="text" name="email" class="form-control" value="" />
                            </div>
                            <div class="m-2">
                                <label for="telephone">Numéro de téléphone</label>
                                <input type="text" name="telephone" class="form-control" value="" />
                            </div>
                            <div class="m-2">
                                <label for="numero_voie">numéro de la vie</label>
                                <input type="text" name="numero_voie" class="form-control" value="" />
                            </div>
                            <div class="m-2">
                                <label for="nom_voie">nom de la vie</label>
                                <input type="text" name="nom_voie" class="form-control" value="" />
                            </div>
                            <div class="m-2">
                                <label for="complement_voie">Complément de voie</label>
                                <input type="text" name="complement_voie" class="form-control" value="" />
                            </div>
                            <div class="m-2">
                                <label for="ville">Ville</label>
                                <input type="text" name="ville" class="form-control" value="" />
                            </div>
                            <div class="m-2">
                                <label for="code_postal">Code postal</label>
                                <input type="text" name="code_postal" class="form-control" value="" />
                            </div>
                            <div class="m-2">
                                <label for="pays">Pays</label>
                                <input type="text" name="pays" class="form-control" value="" />
                            </div>
                        </div>
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
