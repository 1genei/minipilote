<div class="row">
    <div class="col-lg-6">
        <div class="col-12">
            <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">Prix de Vente
                <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix" data-bs-toggle="tooltip"
                    data-bs-placement="right" title="Prix de vente conseillé"></i>
            </label>
        </div>

        <div class="row">

            <div class=" col-sm-6 col-lg-6 col-xxl-4 mb-3">
                <label for="prix_vente_ht" class="form-label">Montant HT *</label>
                <input type="number" step="0.001" min="0" class="form-control"
                    wire:model.defer="prix_vente_ht" name="prix_vente_ht" value="{{ old('prix_vente_ht') }}"
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
                    wire:model.defer="prix_vente_ttc" name="prix_vente_ttc" value="{{ old('prix_vente_ttc') }}"
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


    </div>


    <div class="col-lg-6">

        <div class="col-12">
            <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">&nbsp;</label>
        </div>

        <div class="col-6">
            <div class="mb-3">
                <label for="tva_id" class="form-label">Taxe</label>
                <select wire:model.defer="tva_id" name="tva_id" id="tva_id"
                    class="form-select select2">
                    @foreach ($tvas as $tva)
                        <option value="{{ $tva->id }}">{{ $tva->nom }}</option>
                    @endforeach
                    <option value="">Aucune taxe</option>
                </select>
            </div>
        </div>

    </div>
</div>


<div class="row">
    {{-- <div class="col-lg-6">
        <div class="col-12">
            <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">Prix de Vente Max
                <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix" data-bs-toggle="tooltip"
                    data-bs-placement="right" title="Prix de vente à ne pas dépasser"></i>
            </label>
        </div>

        <div class="row">

            <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                <label for="prix_vente_max_ht" class="form-label">Montant HT </label>
                <input type="number" step="0.001" min="0" class="form-control"
                    wire:model.defer="prix_vente_max_ht" name="prix_vente_max_ht" value="{{ old('prix_vente_max_ht') }}"
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
                    wire:model.defer="prix_vente_max_ttc" name="prix_vente_max_ttc"
                    value="{{ old('prix_vente_max_ttc') }}" id="prix_vente_max_ttc">
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


    <div class="col-6">

    </div>
</div>


<hr>
<div class="row">
    <div class="col-lg-6">
        <div class="col-12">
            <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">Prix d'Achat
                <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix"
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Prix d'achat réel"></i>
            </label>
        </div>

        <div class="row">

            <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                <label for="prix_achat_ht" class="form-label">Montant HT </label>
                <input type="number" step="0.001" min="0" class="form-control"
                    wire:model.defer="prix_achat_ht" name="prix_achat_ht" value="{{ old('prix_achat_ht') }}"
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
                    wire:model.defer="prix_achat_ttc" name="prix_achat_ttc" value="{{ old('prix_achat_ttc') }}"
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


    {{-- <div class="col-lg-6">
        <div class="col-12">
            <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">Prix d'Achat Commercial
                <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix"
                    data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Prix d'achat affiché au commercial"></i>
            </label>
        </div>

        <div class="row">

            <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                <label for="prix_achat_commerciaux_ht" class="form-label">Montant HT </label>
                <input type="number" step="0.001" min="0" class="form-control"
                    wire:model.defer="prix_achat_commerciaux_ht" name="prix_achat_commerciaux_ht"
                    value="{{ old('prix_achat_commerciaux_ht') }}" id="prix_achat_commerciaux_ht">
                @if ($errors->has('prix_achat_commerciaux_ht'))
                    <br>
                    <div class="alert alert-danger" role="alert">
                        <i class="dripicons-wrong me-2"></i>
                        <strong>{{ $errors->first('prix_achat_commerciaux_ht') }}</strong>
                    </div>
                @endif

            </div>

            <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">

                <label for="prix_achat_commerciaux_ttc" class="form-label">Montant TTC </label>
                <input type="number" step="0.001" min="0" class="form-control"
                    wire:model.defer="prix_achat_commerciaux_ttc" name="prix_achat_commerciaux_ttc"
                    value="{{ old('prix_achat_commerciaux_ttc') }}" id="prix_achat_commerciaux_ttc">
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
