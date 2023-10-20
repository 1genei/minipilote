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


                        {{-- PHOTO --}}
                        <div class="col-12 mb-3">
                            <label for="images" class="form-label fw-bold fs-5 mb-2">Photo(s) du produit </label>
                            <div class="fallback">
                                <input name="images[]" wire:model.defer="images" id="images"
                                    class=" btn btn-secondary image-multiple" accept="image/*" type="file"
                                    multiple />
                            </div>

                        </div>

                        <div class="row" wire:ignore>
                            <div class="col-md-8 col-lg-8" id="liste_photo_visible">

                                <div id="sortable_visible">
                                    <div class="row">

                                        @foreach ($produit->imageproduits as $photosproduit)
                                            <div class=" col-xl-4 col-lg-6 col-md-3" id="{{ $photosproduit->id }}">
                                                <div
                                                    style="margin: auto; width:70%; border: 1px solid white; padding-bottom: 30px; ">
                                                    <div><span class="badge badge-info "></span>
                                                        <p><img src="{{ asset('/images/images_produits/' . $photosproduit->nom_fichier) }}"
                                                                alt="aaa" width="100%" height="100px"></p>
                                                    </div>
                                                    <p style="border: 2px solid #323a47; text-align:center">
                                                        <a data-href="{{ route('produit.photoDelete', $photosproduit->id) }}"
                                                            style="cursor: pointer" class="delete_image fs-4"
                                                            data-toggle="tooltip" title="@lang('Supprimer ')"><i
                                                                class="mdi lg mdi-delete"></i>
                                                        </a>
                                                        <a href="{{ route('produit.getPhoto', Crypt::encrypt($photosproduit->id)) }}"
                                                            class="fs-4" title="@lang('Télécharger ')"><i
                                                                class="mdi mdi-download"></i>
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- MARQUE --}}
                    <div class="tab-pane fade" id="v-pills-marque" role="tabpanel" aria-labelledby="v-pills-marque-tab">
                        <div class="col-lg-3 mb-3" wire:ignore>
                            <label for="marque" class="form-label">Marque</label>

                            <select class="form-select " id="marque" name="marque" wire:model.defer="marque">
                                <option></option>
                                @foreach ($marques as $marque)
                                    <option value="{{ $marque->id }}">{{ $marque->nom }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    {{-- FICHE --}}
                    <div class="tab-pane fade" id="v-pills-fiche" role="tabpanel" aria-labelledby="v-pills-fiche-tab">
                        <div class="col-12 mb-3">
                            <label for="images" class="form-label">Fiche technique</label>

                            <div class="fallback">
                                <input name="fiche_technique" wire:model.defer="fiche_technique"
                                    class=" btn btn-secondary image-multiple" accept=".pdf" type="file" />
                            </div>
                            @if ($produit->fiche_technique)
                                <a type="button"
                                    href="{{ route('produit.getFicheTechnique', $produit->fiche_technique) }}"
                                    class="btn btn-danger btn-xs mt-2"><i class="mdi fs-4 mdi-download me-1"></i>
                                    <span>Fiche technique</span> </a>
                            @endif
                        </div>


                    </div>
                </div> <!-- end tab-content-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->
    </div>
</div>
