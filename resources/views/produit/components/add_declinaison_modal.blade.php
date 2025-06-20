<form action="{{ route('produit_declinaison.store') }}" method="POST">
    @csrf

    <input type="hidden" name="produit_id" value="{{ $produit->id }}">
    <div id="dark-header-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dark-header-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" style="max-width: 70%">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-dark">
                    <h4 class="modal-title" id="dark-header-modalLabel">Ajouter une déclinaison pour {{ $produit->nom }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-lg-3">

                            <div class="col-12">
                                <label for="nom" id="tooltip-prix"
                                    class="form-label fs-5 mb-2 text-bold">Caractéristiques</label>
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
                                                        <input type="radio" id="customRadio1{{ $caracteristique->id }}" name="valeurNom_{{ $caracteristique->id }}" value="" class="form-check-input check-decli">
                                                        <label class="form-check-label"
                                                            for="customRadio1{{ $caracteristique->id }}">Aucun
                                                        </label>
                                                    </div>
                                                    @foreach ($caracteristique->valeurcaracteristiques as $valeur)
                                                        <div class="form-check">
                                                            <input type="radio" id="valeurId{{ $valeur->id }}"
                                                                name="valeurNom_{{ $caracteristique->id }}"
                                                                value="{{ $valeur->id }}" class="form-check-input">
                                                            <label class="form-check-label"
                                                                for="valeurId{{ $valeur->id }}">{{ $valeur->nom }}
                                                            </label>
                                                        </div>
                                                    @endforeach

                                                </div>


                                            </div> <!-- end card-body-->
                                        </div> <!-- end card -->
                                    </div> <!-- end .collapse-->
                                @endforeach
                            </div> <!-- end .mt-2-->

                            <!-- Modèles de voiture -->
                            <div class="col-12 mt-4">
                                <label for="nom" id="tooltip-modele"
                                    class="form-label fs-5 mb-2 text-bold">Modèles de voiture</label>
                            </div>

                            <div class="col-12">
                                <div class="collapse show mt-3" id="modeleTasks">
                                    <div class="card mb-0">
                                        <div class="card-body">
                                            <span class="text-dark fw-bold fs-4">Modèle</span>
                                            <div class="mt-2" style="margin-left: 20px;">
                                                <div class="form-check">
                                                    <input type="radio" id="modele_aucun" name="modelevoiture_id" value="" class="form-check-input check-decli">
                                                    <label class="form-check-label" for="modele_aucun">Aucun</label>
                                                </div>
                                                @foreach ($modelevoitures as $modele)
                                                    <div class="form-check">
                                                        <input type="radio" id="modele_{{ $modele->id }}"
                                                            name="modelevoiture_id"
                                                            value="{{ $modele->id }}" class="form-check-input">
                                                        <label class="form-check-label"
                                                            for="modele_{{ $modele->id }}">{{ $modele->nom }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card -->
                                </div> <!-- end .collapse-->
                            </div> <!-- end .mt-2-->

                            <!-- Circuits -->
                            <div class="col-12 mt-4">
                                <label for="nom" id="tooltip-circuit"
                                    class="form-label fs-5 mb-2 text-bold">Circuits</label>
                            </div>

                            <div class="col-12">
                                <div class="collapse show mt-3" id="circuitTasks">
                                    <div class="card mb-0">
                                        <div class="card-body">
                                            <span class="text-dark fw-bold fs-4">Circuit</span>
                                            <div class="mt-2" style="margin-left: 20px;">
                                                <div class="form-check">
                                                    <input type="radio" id="circuit_aucun" name="circuit_id" value="" class="form-check-input check-decli">
                                                    <label class="form-check-label" for="circuit_aucun">Aucun</label>
                                                </div>
                                                @foreach ($circuits as $circuit)
                                                    <div class="form-check">
                                                        <input type="radio" id="circuit_{{ $circuit->id }}"
                                                            name="circuit_id"
                                                            value="{{ $circuit->id }}" class="form-check-input">
                                                        <label class="form-check-label"
                                                            for="circuit_{{ $circuit->id }}">{{ $circuit->nom }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card -->
                                </div> <!-- end .collapse-->
                            </div> <!-- end .mt-2-->

                        </div>


                        <div class="col-lg-9">
                            <div class="col-12">
                                <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">Prix de
                                    Vente
                                    <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix"
                                        data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Prix de vente conseillé"></i>
                                </label>
                            </div>

                            <div class="row">

                                <div class=" col-sm-6 col-lg-6 col-xxl-4 mb-3">
                                    <label for="prix_vente_ht" class="form-label">Montant HT *</label>
                                    <input type="number" step="0.001" min="0" class="form-control"
                                        name="prix_vente_ht_decli"
                                        value="{{ old('prix_vente_ht') ? old('prix_vente_ht') : $produit->prix_vente_ht }}"
                                        id="prix_vente_ht" required>
                                    @if ($errors->has('prix_vente_ht'))
                                        <br>
                                        <div class="alert alert-danger" role="alert">
                                            <i class="dripicons-wrong me-2"></i>
                                            <strong>{{ $errors->first('prix_vente_ht') }}</strong>
                                        </div>
                                    @endif

                                </div>

                                <div class=" col-sm-6 col-lg-6 col-xxl-4">

                                    <label for="prix_vente_ttc" class="form-label">Montant TTC </label>
                                    <input type="number" step="0.001" min="0" class="form-control"
                                        name="prix_vente_ttc_decli"
                                        value="{{ old('prix_vente_ttc') ? old('prix_vente_ttc') : $produit->prix_vente_ttc }}"
                                        id="prix_vente_ttc">
                                    @if ($errors->has('prix_vente_ttc'))
                                        <br>
                                        <div class="alert alert-danger" role="alert">
                                            <i class="dripicons-wrong me-2"></i>
                                            <strong>{{ $errors->first('prix_vente_ttc') }}</strong>
                                        </div>
                                    @endif

                                </div>
                            </div>



                            {{-- <div class="row">

                                <div class="col-12">
                                    <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">
                                        Prix de Vente Max
                                        <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix"
                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="Prix de vente à ne pas dépasser"></i>
                                    </label>
                                </div>

                                <div class="row">

                                    <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                                        <label for="prix_vente_max_ht" class="form-label">Montant HT </label>
                                        <input type="number" step="0.001" min="0" class="form-control"
                                            name="prix_vente_max_ht_decli"
                                            value="{{ old('prix_vente_max_ht') ? old('prix_vente_max_ht') : $produit->prix_vente_max_ht }}"
                                            id="prix_vente_max_ht">
                                        @if ($errors->has('prix_vente_max_ht'))
                                            <br>
                                            <div class="alert alert-danger" role="alert">
                                                <i class="dripicons-wrong me-2"></i>
                                                <strong>{{ $errors->first('prix_vente_max_ht') }}</strong>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">

                                        <label for="prix_vente_max_ttc" class="form-label">Montant TTC </label>
                                        <input type="number" step="0.001" min="0" class="form-control"
                                            name="prix_vente_max_ttc_decli"
                                            value="{{ old('prix_vente_max_ttc') ? old('prix_vente_max_ttc') : $produit->prix_vente_max_ttc }}"
                                            id="prix_vente_max_ttc">
                                        @if ($errors->has('prix_vente_max_ttc'))
                                            <br>
                                            <div class="alert alert-danger" role="alert">
                                                <i class="dripicons-wrong me-2"></i>
                                                <strong>{{ $errors->first('prix_vente_max_ttc') }}</strong>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                            </div> --}}


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
                                            <label for="prix_achat_ht" class="form-label">Montant HT </label>
                                            <input type="number" step="0.001" min="0" class="form-control"
                                                name="prix_achat_ht_decli"
                                                value="{{ old('prix_achat_ht') ? old('prix_achat_ht') : $produit->prix_achat_ht }}"
                                                id="prix_achat_ht">
                                            @if ($errors->has('prix_achat_ht'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('prix_achat_ht') }}</strong>
                                                </div>
                                            @endif

                                        </div>

                                        <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">

                                            <label for="prix_achat_ttc" class="form-label">Montant TTC </label>
                                            <input type="number" step="0.001" min="0" class="form-control"
                                                name="prix_achat_ttc_decli"
                                                value="{{ old('prix_achat_ttc') ? old('prix_achat_ttc') : $produit->prix_achat_ttc }}"
                                                id="prix_achat_ttc">
                                            @if ($errors->has('prix_achat_ttc'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('prix_achat_ttc') }}</strong>
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
                                            <label for="prix_achat_commerciaux_ht" class="form-label">Montant HT
                                            </label>
                                            <input type="number" step="0.001" min="0" class="form-control"
                                                name="prix_achat_commerciaux_ht_decli"
                                                value="{{ old('prix_achat_commerciaux_ht') ? old('prix_achat_commerciaux_ht') : $produit->prix_achat_commerciaux_ht }}"
                                                id="prix_achat_commerciaux_ht">
                                            @if ($errors->has('prix_achat_commerciaux_ht'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('prix_achat_commerciaux_ht') }}</strong>
                                                </div>
                                            @endif

                                        </div>

                                        <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">

                                            <label for="prix_achat_commerciaux_ttc" class="form-label">Montant TTC
                                            </label>
                                            <input type="number" step="0.001" min="0" class="form-control"
                                                name="prix_achat_commerciaux_ttc_decli"
                                                id="prix_achat_commerciaux_ttc"
                                                value="{{ old('prix_achat_commerciaux_ttc') ? old('prix_achat_commerciaux_ttc') : $produit->prix_achat_commerciaux_ttc }}">
                                            @if ($errors->has('prix_achat_commerciaux_ttc'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('prix_achat_commerciaux_ttc') }}</strong>
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

                                            <input type="checkbox" id="gerer_stock_decli" name="gerer_stock_decli"
                                                @if ($produit->gerer_stock) checked @endif data-switch="info" />
                                            <label for="gerer_stock_decli" data-on-label="Oui"
                                                data-off-label="Non"></label>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-12 div_stock_decli">
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
                                            <label for="quantite" class="form-label">Quantité</label>
                                            <input type="number" min="0" class="form-control"
                                                name="quantite_decli"
                                                value="{{ old('quantite') ? old('quantite') : $produit->stock?->quantite }}"
                                                id="quantite">
                                            @if ($errors->has('quantite'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('quantite') }}</strong>
                                                </div>
                                            @endif

                                        </div>

                                        <div class="col-sm-6 col-xxl-4 mb-3">

                                            <label for="quantite_min_vente" class="form-label">
                                                Quantité minimale pour la vente
                                            </label>
                                            <input type="number" min="0" class="form-control"
                                                name="quantite_min_vente_decli"
                                                value="{{ old('quantite_min_vente') ? old('quantite_min_vente') : $produit->stock?->quantite_min }}"
                                                id="quantite_min_vente">
                                            @if ($errors->has('quantite_min_vente'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('quantite_min_vente') }}</strong>
                                                </div>
                                            @endif

                                        </div>
                                    </div>


                                </div>



                            </div>



                            <div class="row mt-3 div_stock_decli">
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
                                            <label for="seuil_alerte_stock" class="form-label">
                                                Niveau de stock au quel vous souhaitez être alerté
                                            </label>
                                            <input type="number" min="0" class="form-control"
                                                placeholder="Laisser vide pour désactiver"
                                                name="seuil_alerte_stock_decli"
                                                value="{{ old('seuil_alerte_stock') ? old('seuil_alerte_stock') : $produit->stock?->seuil_alerte }}"
                                                id="seuil_alerte_stock">
                                            @if ($errors->has('seuil_alerte_stock'))
                                                <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i>
                                                    <strong>{{ $errors->first('seuil_alerte_stock') }}</strong>
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
                    <button type="submit" class="btn btn-dark">Enregistrer</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</form>
