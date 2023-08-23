<div class="row">
    <div class="col-8">
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
        <div class="col-12">
            <label for="description" class="form-label">Description *</label>

            <textarea rows="10" id="description" name="description" wire:model.defer="description" required> </textarea>
        </div>
    </div>


    <div class="col-4 ">
        <div class="col-12 mb-3">
            <label for="images" class="form-label">Image(s)</label>

            <div class="fallback">
                <input name="images[]" class=" btn btn-danger image-multiple" accept="image/*" type="file"
                    multiple />
            </div>

        </div>

        <div class="col-12">
            <div class="mb-3">
                <label for="categorie_id" class="form-label">Catégorie *</label>
                <select name="categorie_id" wire:model.defer="categorie_id" id="categorie_id" class="form-select"
                    required>
                    <option value=""></option>
                    {{-- @foreach ($categories as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}
                        </option>
                    @endforeach --}}
                </select>
            </div>
        </div>

    </div>
</div>
