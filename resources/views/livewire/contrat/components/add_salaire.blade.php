<div class="row">

    <div class="col-6">
        <div class="mb-3">
            <label for="adresse" class="form-label">
                Horaire brut
            </label>
            <input type="number" min="0" step="0.01" id="adresse" name="adresse" wire:model.defer="adresse"
                value="{{ old('adresse') ? old('adresse') : '' }}" class="form-control">

            @if ($errors->has('adresse'))
                <br>
                <div class="alert alert-warning text-secondary " role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>{{ $errors->first('adresse') }}</strong>
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label for="adresse" class="form-label">
                Mensuel brut
            </label>
            <input type="number" min="0" step="0.01" id="adresse" name="adresse" wire:model.defer="adresse"
                value="{{ old('adresse') ? old('adresse') : '' }}" class="form-control">

            @if ($errors->has('adresse'))
                <br>
                <div class="alert alert-warning text-secondary " role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>{{ $errors->first('adresse') }}</strong>
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label for="adresse" class="form-label">
                Annuel brut
            </label>
            <input type="number" min="0" step="0.01" id="adresse" name="adresse" wire:model.defer="adresse"
                value="{{ old('adresse') ? old('adresse') : '' }}" class="form-control">

            @if ($errors->has('adresse'))
                <br>
                <div class="alert alert-warning text-secondary " role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>{{ $errors->first('adresse') }}</strong>
                </div>
            @endif
        </div>
    </div>



    <div class="col-6">
        <div class="mb-3">
            <label for="complement_adresse" class="form-label">
                Horaire net
            </label>
            <input type="number" min="0" step="0.01" id="complement_adresse" name="complement_adresse"
                wire:model.defer="complement_adresse"
                value="{{ old('complement_adresse') ? old('complement_adresse') : '' }}" class="form-control">

            @if ($errors->has('complement_adresse'))
                <br>
                <div class="alert alert-warning text-secondary " role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>{{ $errors->first('complement_adresse') }}</strong>
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="complement_adresse" class="form-label">
                Mensuel net
            </label>
            <input type="number" min="0" step="0.01" id="complement_adresse" name="complement_adresse"
                wire:model.defer="complement_adresse"
                value="{{ old('complement_adresse') ? old('complement_adresse') : '' }}" class="form-control">

            @if ($errors->has('complement_adresse'))
                <br>
                <div class="alert alert-warning text-secondary " role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>{{ $errors->first('complement_adresse') }}</strong>
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label for="complement_adresse" class="form-label">
                Annuel net
            </label>
            <input type="number" min="0" step="0.01" id="complement_adresse" name="complement_adresse"
                wire:model.defer="complement_adresse"
                value="{{ old('complement_adresse') ? old('complement_adresse') : '' }}" class="form-control">

            @if ($errors->has('complement_adresse'))
                <br>
                <div class="alert alert-warning text-secondary " role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>{{ $errors->first('complement_adresse') }}</strong>
                </div>
            @endif
        </div>



    </div>
</div>

<div class="row mb-3">

    <div class="col-sm-3">
        <div class="form-check form-check-inline">
            <input type="radio" id="nature1" name="nature" wire:model="nature" checked
                value="Salarié non cadre" required class="form-check-input">
            <label class="form-check-label" for="nature1">
                Salarié non cadre
            </label>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-check form-check-inline">
            <input type="radio" id="nature2" name="nature" wire:model="nature"
                @if (old('nature') == 'Salarié cadre') checked @endif value="Salarié cadre" required
                class="form-check-input">
            <label class="form-check-label" for="nature2">
                Salarié cadre
            </label>
        </div>
    </div>


    <div class="col-sm-3">

        <div class="form-check form-check-inline">
            <input type="radio" id="nature2" name="nature" wire:model="nature"
                @if (old('nature') == 'Profession libérale') checked @endif value="Profession libérale" required
                class="form-check-input">
            <label class="form-check-label" for="nature2">
                Profession libérale
            </label>

        </div>

    </div>

    <div class="col-sm-3">
        <div class="form-check form-check-inline">
            <input type="radio" id="nature4" name="nature" wire:model="nature" value="Portage salarial"
                @if (old('nature') == 'Portage salarial') checked @endif required class="form-check-input">
            <label class="form-check-label" for="nature4">
                Portage salarial
            </label>

        </div>

    </div>


    @if ($errors->has('nature'))
        <br>
        <div class="alert alert-warning text-secondary " role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                aria-label="Close"></button>
            <strong>{{ $errors->first('nature') }}</strong>
        </div>
    @endif

</div>
