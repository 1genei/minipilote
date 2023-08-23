<div class="row">
    <div class="col-6">
        <div class="col-12">
            <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">Prix
                <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix" data-bs-toggle="tooltip"
                    data-bs-placement="right" title="Tooltip on right"></i>
            </label>
        </div>

        <div class="row">

            <div class="col-4">
                <label for="prix_ht" class="form-label">Montant HT *</label>
                <input type="number" step="0.001" min="0" class="form-control" name="prix_ht"
                    value="{{ old('prix_ht') }}" id="prix_ht" required>
                @if ($errors->has('prix_ht'))
                    <br>
                    <div class="alert alert-danger" role="alert">
                        <i class="dripicons-wrong me-2"></i>
                        <strong>{{ $errors->first('prix_ht') }}</strong>
                    </div>
                @endif

            </div>

            <div class="col-4">

                <label for="prix_ttc" class="form-label">Montant TTC </label>
                <input type="number" step="0.001" min="0" class="form-control" name="prix_ttc"
                    value="{{ old('prix_ttc') }}" id="prix_ttc">
                @if ($errors->has('prix_ttc'))
                    <br>
                    <div class="alert alert-danger" role="alert">
                        <i class="dripicons-wrong me-2"></i>
                        <strong>{{ $errors->first('prix_ttc') }}</strong>
                    </div>
                @endif

            </div>
        </div>


    </div>


    <div class="col-6">


        <div class="col-6">
            <div class="mb-3">
                <label for="categorie_id" class="form-label">Taxe</label>
                <select name="categorie_id" id="categorie_id" class="form-select select2">
                    <option value="">Aucune taxe</option>
                    {{-- @foreach ($tvas as $tva)
                        <option value="{{ $tva->id }}">{{ $tva->nom }}
                        </option>
                    @endforeach --}}
                </select>
            </div>
        </div>





    </div>
</div>
