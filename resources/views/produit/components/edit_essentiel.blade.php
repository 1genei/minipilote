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
            @if ($produit->fiche_technique)
                <a type="button" href="{{ route('produit.getFicheTechnique', $produit->fiche_technique) }}"
                    class="btn btn-danger btn-xs mt-2"><i class="mdi fs-4 mdi-download me-1"></i>
                    <span>Fiche technique</span> </a>
            @endif
        </div>

        <div class="col-12 mb-3" wire:ignore>
            <label for="marque" class="form-label">Marque</label>

            <select class="form-select " id="marque" name="marque" wire:model.defer="marque">
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





        <div class="row" wire:ignore>
            <div class="col-md-12 col-lg-12" id="liste_photo_visible">

                <div id="sortable_visible">
                    <div class="row">

                        @foreach ($produit->imageproduits as $photosproduit)
                            <div class=" col-xl-4 col-lg-6 col-md-3" id="{{ $photosproduit->id }}">
                                <div style="margin: auto; width:70%; border: 1px solid white; padding-bottom: 30px; ">
                                    <div><span class="badge badge-info "></span>
                                        <p><img src="{{ asset('/images/images_produits/' . $photosproduit->nom_fichier) }}"
                                                alt="aaa" width="100%" height="100px"></p>
                                    </div>
                                    <p style="border: 2px solid #323a47; text-align:center">
                                        <a data-href="{{ route('produit.photoDelete', $photosproduit->id) }}"
                                            style="cursor: pointer" class="delete_image fs-4" data-toggle="tooltip"
                                            title="@lang('Supprimer ')"><i class="mdi lg mdi-delete"></i>
                                        </a>
                                        <a href="{{ route('produit.getPhoto', Crypt::encrypt($photosproduit->id)) }}"
                                            class="fs-4" title="@lang('Télécharger ')"><i class="mdi mdi-download"></i>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>


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
