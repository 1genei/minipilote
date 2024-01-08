{{-- MODIFIER UNE DECLINAISON --}}

<form action="" id="edit_form_decli" method="POST">
    @csrf
    <input type="hidden" name="produit_id" value="{{ $produit->id }}">
    <div id="edit-declinaison" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dark-header-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" style="max-width: 70%">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-dark">
                    <h4 class="modal-title" id="dark-header-modalLabel">Modifier la déclinaison </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-lg-3">

                            <div class="col-12">
                                <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">
                                    Caractéristiques
                                </label>
                            </div>

                            <div class="col-12">

                                @foreach ($caracteristiques as $caracteristique)
                                    <div class="collapse show mt-3" id="todayTasks">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <!-- task -->
                                                <span class="text-dark fw-bold fs-4">{{ $caracteristique->nom }}</span>
                                                <div class="mt-2" style="margin-left: 20px;">
                                                    <div class="form-check">
                                                        <input type="radio" id="customRadio{{ $caracteristique->id }}" name="valeurNom_{{ $caracteristique->id }}" value="" class="form-check-input check-decli">
                                                        <label class="form-check-label"
                                                            for="customRadio{{ $caracteristique->id }}">Aucun
                                                        </label>
                                                    </div>
                                                    @foreach ($caracteristique->valeurcaracteristiques as $valeur)
                                                        <div class="form-check">
                                                            <input type="radio" id="customRadio1{{ $valeur->id }}"
                                                                name="valeurNom_{{ $caracteristique->id }}"
                                                                value="{{ $valeur->id }}"
                                                                class="form-check-input check-decli">
                                                            <label class="form-check-label"
                                                                for="customRadio1{{ $valeur->id }}">{{ $valeur->nom }}
                                                            </label>
                                                        </div>
                                                    @endforeach

                                                </div>


                                            </div> <!-- end card-body-->
                                        </div> <!-- end card -->
                                    </div> <!-- end .collapse-->
                                @endforeach
                            </div> <!-- end .mt-2-->


                        </div>


                        <div class="col-lg-9">
                            <div class="col-12">
                                <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">
                                    Prix de Vente
                                    <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix"
                                        data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Prix de vente conseillé">
                                    </i>
                                </label>
                            </div>

                            <div class="row">

                                <div class=" col-sm-6 col-lg-6 col-xxl-4 mb-3">
                                    <label for="edit_prix_vente_ht_decli" class="form-label">Montant HT *</label>
                                    <input type="number" step="0.001" min="0" class="form-control"
                                        name="prix_vente_ht_decli" value="{{ old('prix_vente_ht_decli') }}"
                                        id="edit_prix_vente_ht_decli" required>
                                    @if ($errors->has('prix_vente_ht_decli'))
                                        <br>
                                        <div class="alert alert-danger" role="alert">
                                            <i class="dripicons-wrong me-2"></i>
                                            <strong>{{ $errors->first('prix_vente_ht_decli') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class=" col-sm-6 col-lg-6 col-xxl-4">

                                    <label for="edit_prix_vente_ttc_decli" class="form-label">Montant TTC </label>
                                    <input type="number" step="0.001" min="0" class="form-control"
                                        name="prix_vente_ttc_decli" value="{{ old('prix_vente_ttc_decli') }}"
                                        id="edit_prix_vente_ttc_decli">
                                    @if ($errors->has('prix_vente_ttc_decli'))
                                        <br>
                                        <div class="alert alert-danger" role="alert">
                                            <i class="dripicons-wrong me-2"></i>
                                            <strong>{{ $errors->first('prix_vente_ttc_decli') }}</strong>
                                        </div>
                                    @endif

                                </div>
                            </div>



                            <div class="row">

                                {{-- <div class="col-12">
                                    <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">
                                        Prix de Vente Max
                                        <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix"
                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="Prix de vente à ne pas dépasser"></i>
                                    </label>
                                </div> --}}

                                {{-- <div class="row">

                                    <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                                        <label for="edit_prix_vente_max_ht_decli" class="form-label">Montant HT
                                        </label>
                                        <input type="number" step="0.001" min="0" class="form-control"
                                            name="prix_vente_max_ht_decli"
                                            value="{{ old('prix_vente_max_ht_decli') }}"
                                            id="edit_prix_vente_max_ht_decli">
                                        @if ($errors->has('prix_vente_max_ht_decli'))
                                            <br>
                                            <div class="alert alert-danger" role="alert">
                                                <i class="dripicons-wrong me-2"></i>
                                                <strong>{{ $errors->first('prix_vente_max_ht_decli') }}</strong>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">

                                        <label for="edit_prix_vente_max_ttc_decli" class="form-label">Montant TTC
                                        </label>
                                        <input type="number" step="0.001" min="0" class="form-control"
                                            name="prix_vente_max_ttc_decli"
                                            value="{{ old('prix_vente_max_ttc_decli') }}"
                                            id="edit_prix_vente_max_ttc_decli">
                                        @if ($errors->has('prix_vente_max_ttc_decli'))
                                            <br>
                                            <div class="alert alert-danger" role="alert">
                                                <i class="dripicons-wrong me-2"></i>
                                                <strong>{{ $errors->first('prix_vente_max_ttc_decli') }}</strong>
                                            </div>
                                        @endif

                                    </div>
                                </div> --}}

                            </div>


                            <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-12">
                                        <label for="nom" id="tooltip-prix"
                                            class="form-label fs-5 mb-2 text-bold">
                                            Prix d'Achat
                                            <i class=" mdi mdi-information text-primary "
                                                data-bs-container="#tooltip-prix" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="Prix d'achat réel"></i>
                                        </label>
                                    </div>

                                    <div class="row">

                                        <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                                            <label for="edit_prix_achat_ht_decli" class="form-label">Montant HT
                                            </label>
                                            <input type="number" step="0.001" min="0" class="form-control"
                                                name="prix_achat_ht_decli" value="{{ old('prix_achat_ht_decli') }}"
                                                id="edit_prix_achat_ht_decli">
                                            @if ($errors->has('prix_achat_ht_decli'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('prix_achat_ht_decli') }}</strong>
                                                </div>
                                            @endif

                                        </div>

                                        <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">

                                            <label for="edit_prix_achat_ttc_decli" class="form-label">Montant TTC
                                            </label>
                                            <input type="number" step="0.001" min="0" class="form-control"
                                                name="prix_achat_ttc_decli" value="{{ old('prix_achat_ttc_decli') }}"
                                                id="edit_prix_achat_ttc_decli">
                                            @if ($errors->has('prix_achat_ttc_decli'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('prix_achat_ttc_decli') }}</strong>
                                                </div>
                                            @endif

                                        </div>
                                    </div>


                                </div>


                                {{-- <div class="col-lg-12">
                                    <div class="col-12">
                                        <label for="nom" id="tooltip-prix"
                                            class="form-label fs-5 mb-2 text-bold">Prix d'Achat Commercial
                                            <i class=" mdi mdi-information text-primary "
                                                data-bs-container="#tooltip-prix" data-bs-toggle="tooltip"
                                                data-bs-placement="right"
                                                title="Prix d'achat affiché au commercial"></i>
                                        </label>
                                    </div>

                                    <div class="row">

                                        <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                                            <label for="edit_prix_achat_commerciaux_ht_decli"
                                                class="form-label">Montant HT
                                            </label>
                                            <input type="number" step="0.001" min="0" class="form-control"
                                                name="prix_achat_commerciaux_ht_decli"
                                                value="{{ old('prix_achat_commerciaux_ht_decli') }}"
                                                id="edit_prix_achat_commerciaux_ht_decli">
                                            @if ($errors->has('prix_achat_commerciaux_ht_decli'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('prix_achat_commerciaux_ht_decli') }}</strong>
                                                </div>
                                            @endif

                                        </div>

                                        <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">

                                            <label for="edit_prix_achat_commerciaux_ttc_decli"
                                                class="form-label">Montant TTC
                                            </label>
                                            <input type="number" step="0.001" min="0" class="form-control"
                                                name="prix_achat_commerciaux_ttc_decli"
                                                id="edit_prix_achat_commerciaux_ttc_decli"
                                                value="{{ old('prix_achat_commerciaux_ttc_decli') }}">
                                            @if ($errors->has('prix_achat_commerciaux_ttc_decli'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('prix_achat_commerciaux_ttc_decli') }}</strong>
                                                </div>
                                            @endif

                                        </div>
                                    </div>

                                </div> --}}
                            </div>

                            <hr>





                            <div class="row">

                                <div class="col-lg-12">

                                    <div class="col-12">
                                        <label for="nom" id="tooltip-prix"
                                            class="form-label fs-5 mb-2 text-bold">&nbsp;</label>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="categorie_id" class="form-label">Activer la gestion de stock
                                            </label> <br>

                                            <input type="checkbox" id="edit_gerer_stock_decli"
                                                name="gerer_stock_decli" data-switch="info" />
                                            <label for="edit_gerer_stock_decli" data-on-label="Oui"
                                                data-off-label="Non"></label>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-12 div_edit_stock_decli">
                                    <div class="col-12">
                                        <label for="nom" id="tooltip-prix"
                                            class="form-label fs-5 mb-2 text-bold">Quantités
                                            <i class=" mdi mdi-information text-primary "
                                                data-bs-container="#tooltip-prix" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="Quantité du produit en stock"></i>
                                        </label>
                                    </div>

                                    <div class="row">

                                        <div class="col-sm-6 col-xxl-4 mb-3">
                                            <label for="edit_quantite_decli" class="form-label">Quantité</label>
                                            <input type="number" min="0" class="form-control"
                                                name="quantite_decli" value="{{ old('quantite_decli') }}"
                                                id="edit_quantite_decli">
                                            @if ($errors->has('quantite_decli'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('quantite_decli') }}</strong>
                                                </div>
                                            @endif

                                        </div>

                                        <div class="col-sm-6 col-xxl-4 mb-3">

                                            <label for="edit_quantite_min_vente_decli" class="form-label">
                                                Quantité minimale pour la vente
                                            </label>
                                            <input type="number" min="0" class="form-control"
                                                name="quantite_min_vente_decli"
                                                value="{{ old('quantite_min_vente_decli') }}"
                                                id="edit_quantite_min_vente_decli">
                                            @if ($errors->has('quantite_min_vente_decli'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('quantite_min_vente_decli') }}</strong>
                                                </div>
                                            @endif

                                        </div>
                                    </div>


                                </div>



                            </div>



                            <div class="row mt-3 div_edit_stock_decli">
                                <div class="col-lg-12">
                                    <div class="col-12">
                                        <label for="nom" id="tooltip-stock"
                                            class="form-label fs-5 mb-2 text-bold">Alertes
                                            <i class=" mdi mdi-information text-primary "
                                                data-bs-container="#tooltip-stock" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="Prix de vente à ne pas dépasser"></i>
                                        </label>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6 col-xxl-4">
                                            <label for="edit_seuil_alerte_stock_decli" class="form-label">
                                                Niveau de stock au quel vous souhaitez être alerté
                                            </label>
                                            <input type="number" min="0" class="form-control"
                                                placeholder="Laisser vide pour désactiver"
                                                name="seuil_alerte_stock_decli"
                                                value="{{ old('seuil_alerte_stock_decli') }}"
                                                id="edit_seuil_alerte_stock_decli">
                                            @if ($errors->has('seuil_alerte_stock_decli'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('seuil_alerte_stock_decli') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                </div>


                                <div class="col-6">

                                </div>
                            </div>

                            <hr>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" id="modifier-decli" class="btn btn-dark">Modifier</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</form>
