<div class="row">
    <div class="col-lg-8">
        <div class="col-12">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du produit *</label>
                <input type="text" class="form-control" name="nom" wire:model.defer="nom"
                    value="{{ old('nom') }}" id="nom" required>
                @if ($errors->has('nom'))
                    <br>
                    <div class="alert alert-danger" role="alert">
                        <i class="dripicons-wrong me-2"></i>
                        <strong>{{ $errors->first('nom') }}</strong>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12 mb-3" wire:ignore>
            <label for="description" class="form-label">Description *</label>

            <textarea rows="10" id="description" name="description" wire:model.defer="description"> </textarea>
        </div>
    </div>




    <div class="col-lg-4 ">

        <div class="col-12  mb-3">
            <div class="mb-3">
                <label for="reference" class="form-label">Référence produit</label>
                <input type="text" class="form-control" name="reference" wire:model.defer="reference"
                    value="{{ old('reference') }}" id="reference" required>
                @if ($errors->has('reference'))
                    <br>
                    <div class="alert alert-danger" role="alert">
                        <i class="dripicons-wrong me-2"></i>
                        <strong>{{ $errors->first('reference') }}</strong>
                    </div>
                @endif
            </div>
        </div>



        <div class="col-12 mb-3">
            <label for="images" class="form-label">Fiche technique</label>

            <div class="fallback">
                <input name="fiche_technique" wire:model.defer="fiche_technique"
                    class=" btn btn-secondary image-multiple" accept=".pdf" type="file" />
            </div>
        </div>

        <div class="col-12 mb-3" wire:ignore>
            <label for="marque" class="form-label">Marque</label>

            <select class="form-control select2" id="marque" name="marque" wire:model.defer="marque"
                data-toggle="select2">
                <option></option>
                @foreach ($marques as $marque)
                    <option value="{{ $marque->id }}">{{ $marque->nom }}</option>
                @endforeach

            </select>
        </div>


        <div class="col-12 mb-3">
            <label for="images" class="form-label fw-bold fs-5 mb-2">Photo(s) du produit </label>
            <div class="fallback">
                <input name="images[]" wire:model.defer="images" id="images"
                    class=" btn btn-secondary image-multiple" accept="image/*" type="file" multiple />
            </div>

        </div>


        <div class="col-12" wire:ignore>
            <div class="mb-3">
                <label for="categorie_id" class="form-label fw-bold fs-5 mb-2">Catégories </label>

                @include('produit.components.input-checkbox', ['categories' => $categories])

                <hr>
            </div>
        </div>

    </div>
</div>
