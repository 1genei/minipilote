<div class="row mt-4">
    <div class="col-lg-8 mb-2">
        <hr style="height: 10px; ">

    </div>
    <div class="col-12">

        <div class="row">
            <div class="col-sm-2 mb-2 mb-sm-0">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active show" id="v-pills-photo-tab" data-bs-toggle="pill" href="#v-pills-photo"
                        role="tab" aria-controls="v-pills-photo" aria-selected="true">
                        <i class="mdi mdi-align-vertical-distribute d-md-none d-block"></i>
                        <span class="d-none d-md-block">Photos du produit</span>
                    </a>
                    <a class="nav-link" id="v-pills-marque-tab" data-bs-toggle="pill" href="#v-pills-marque"
                        role="tab" aria-controls="v-pills-marque" aria-selected="false">
                        <i class="mdi mdi-align-vertical-distribute d-md-none d-block"></i>
                        <span class="d-none d-md-block">Marque</span>
                    </a>
                    <a class="nav-link" id="v-pills-fiche-tab" data-bs-toggle="pill" href="#v-pills-fiche"
                        role="tab" aria-controls="v-pills-fiche" aria-selected="false">
                        <i class="mdi mdi-align-vertical-distribute d-md-none d-block"></i>
                        <span class="d-none d-md-block">Fiche technique</span>
                    </a>
                </div>
            </div> <!-- end col-->

            <div class="col-sm-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade active show" id="v-pills-photo" role="tabpanel"
                        aria-labelledby="v-pills-photo-tab">


                        <div class="col-12 mb-3">
                            <label for="images" class="form-label fw-bold fs-5 mb-2">Photo(s) du produit </label>
                            <div class="fallback">
                                <input name="images[]" wire:model.defer="images" id="images"
                                    class=" btn btn-secondary image-multiple" accept="image/*" type="file"
                                    multiple />
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="v-pills-marque" role="tabpanel" aria-labelledby="v-pills-marque-tab">
                        <div class="col-lg-3 mb-3" wire:ignore>
                            <label for="marque" class="form-label">Marque</label>

                            <select class="form-control select2" id="marque" name="marque" wire:model.defer="marque"
                                data-toggle="select2">
                                <option></option>
                                @foreach ($marques as $marque)
                                    <option value="{{ $marque->id }}">{{ $marque->nom }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-fiche" role="tabpanel" aria-labelledby="v-pills-fiche-tab">
                        <div class="col-12 mb-3">
                            <label for="images" class="form-label">Fiche technique</label>

                            <div class="fallback">
                                <input name="fiche_technique" wire:model.defer="fiche_technique"
                                    class=" btn btn-secondary image-multiple" accept=".pdf" type="file" />
                            </div>
                        </div>
                    </div>
                </div> <!-- end tab-content-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->
    </div>
</div>
