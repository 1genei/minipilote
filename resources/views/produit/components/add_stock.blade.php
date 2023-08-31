<div class="row">

    <div class="col-lg-6 div_stock">
        <div class="col-12">
            <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">Quantités
                <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix" data-bs-toggle="tooltip"
                    data-bs-placement="right" title="Quantité du produit en stock"></i>
            </label>
        </div>

        <div class="row">

            <div class="col-sm-6 col-xxl-4 mb-3">
                <label for="quantite" class="form-label">Quantité</label>
                <input type="number" min="0" class="form-control" wire:model.defer="quantite" name="quantite"
                    value="{{ old('quantite') }}" id="quantite">
                @if ($errors->has('quantite'))
                    <br>
                    <div class="alert alert-danger" role="alert">
                        <i class="dripicons-wrong me-2"></i>
                        <strong>{{ $errors->first('quantite') }}</strong>
                    </div>
                @endif

            </div>

            <div class="col-sm-6 col-xxl-4 mb-3">

                <label for="quantite_min_vente" class="form-label">Quantité minimale pour la vente </label>
                <input type="number" min="0" class="form-control" wire:model.defer="quantite_min_vente"
                    name="quantite_min_vente" value="{{ old('quantite_min_vente') }}" id="quantite_min_vente">
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


    <div class="col-lg-6">

        <div class="col-12">
            <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">&nbsp;</label>
        </div>

        <div class="col-6">
            <div class="mb-3">
                <label for="categorie_id" class="form-label">Activer la gestion de stock </label> <br>

                <input type="checkbox" id="gerer_stock" name="gerer_stock" wire:model.defer="gerer_stock"
                    data-switch="info" />
                <label for="gerer_stock" data-on-label="Oui" data-off-label="Non"></label>
            </div>

        </div>

    </div>
</div>


<div class="row mt-3 div_stock">
    <div class="col-lg-6">
        <div class="col-12">
            <label for="nom" id="tooltip-stock" class="form-label fs-5 mb-2 text-bold">Alertes
                <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-stock"
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Prix de vente à ne pas dépasser"></i>
            </label>
        </div>

        <div class="row">

            <div class="col-md-6 col-xxl-4">
                <label for="seuil_alerte_stock" class="form-label">Niveau de stock au quel vous souhaitez être
                    alerté
                </label>
                <input type="number" min="0" class="form-control" placeholder="Laisser vide pour désactiver"
                    wire:model.defer="seuil_alerte_stock" name="seuil_alerte_stock"
                    value="{{ old('seuil_alerte_stock') }}" id="seuil_alerte_stock">
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
