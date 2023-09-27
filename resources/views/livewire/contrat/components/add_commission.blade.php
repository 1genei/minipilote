<div class="row">

    <div class="col-6">
        <div class="mb-3">
            <label for="pourcentage_depart" class="form-label">
                Pourcentage de démarrage
            </label>
            <input type="number" min="0" step="0.01" id="pourcentage_depart" name="pourcentage_depart"
                wire:model.defer="pourcentage_depart"
                value="{{ old('pourcentage_depart') ? old('pourcentage_depart') : '' }}" class="form-control">

            @if ($errors->has('pourcentage_depart'))
                <br>
                <div class="alert alert-warning text-secondary " role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>{{ $errors->first('pourcentage_depart') }}</strong>
                </div>
            @endif
        </div>
        <div class="mb-3 ">
            <label for="floatingInput" class="mb-1">Ajouter des paliers ? </label>
            <br>

            <input type="checkbox" name="check_palier" id="check_palier" data-switch="info" />
            <label for="check_palier" data-on-label="Oui" data-off-label="Non"></label>

            @if ($errors->has('check_palier'))
                <br>
                <div class="alert alert-warning text-secondary " role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>{{ $errors->first('check_palier') }}</strong>
                </div>
            @endif
        </div>

    </div>


    <div class="col-6">

    </div>
</div>

<div class="row">
    <div class="col-12">

        <div class="col-lg-12 col-md-12 col-sm-12" id="palier">
            <div class="panel panel-pink m-t-15">
                <div class="panel-heading"><strong>Paliers </strong></div>
                <div class="panel-body">
                    <div class="input_fields_wrap">
                        <button class="btn btn-warning add_field_button" style="margin-left: 53px;">
                            Ajouter un niveau
                        </button>
                        <div class="row gy-2 gx-2 align-items-center field1">


                            <div class="col-auto">
                                <label for="level1">Niveau: </label>
                                <input class="form-control" type="text" value="1" id="level1" name="level1"
                                    readonly>
                            </div>
                            <div class="col-auto">
                                <label for="percent1">Pourcentage en +: </label>
                                <input class="form-control" type="number" min="0" max="0" step="0.10"
                                    value="0" id="percent1" name="percent1" readonly>
                            </div>
                            <div class="col-auto">
                                <label for="ca_min1">CA min (€): </label>
                                <input class="form-control" type="number" value="0" id="ca_min1" name="ca_min1"
                                    readonly>
                            </div>
                            <div class="col-auto">
                                <label for="ca_max1">CA max (€): </label>
                                <input class="form-control" type="number" min="0" value="20000" id="ca_max1"
                                    name="ca_max1" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
