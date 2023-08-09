<form action="{{ route('utilisateur.store') }}" method="post">
    @csrf


    <div class="row">

        <div class="col-md-12 col-lg-9">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                            <strong>Informations de connexion</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email de connexion<span class="text-danger">*</span>
                                </label>

                                <input type="email" id="email" name="email" wire:model.defer="email" required
                                    value="{{ old('email') ? old('email') : '' }}" class="form-control">
                                @if ($errors->has('email'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3" wire:ignore>
                                <label for="telephone_mobile" class="form-label">
                                    Sélectionner un contact existant
                                </label>

                                <p>
                                    <input type="checkbox" id="contact_existant" data-switch="primary" />
                                    <label for="contact_existant" data-on-label="Oui" data-off-label="Non"></label>
                                </p>



                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="nom" class="form-label">
                                    Rôle <span class="text-danger">*</span>
                                </label>

                                <select class="form-select select2" id="role" name="role"
                                    wire:model.defer="role">

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->nom }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('role'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </div>
                                @endif
                            </div>




                            <div class="mb-3 ancien_contact" wire:ignore>
                                <label for="pays" class="form-label">
                                    Contact
                                </label>

                                <select class="form-control select2" data-toggle="select2" id="individu"
                                    style="width:100%" wire:model.defer="individu">
                                    @foreach ($individus as $individu)
                                        <option value="{{ $individu->id }}">{{ $individu->prenom }}
                                            {{ $individu->nom }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('pays'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('pays') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>


                    </div>

                    <div class="nouveau_contact" wire:ignore>
                        <div class="row mb-3">
                            <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                                <strong>Informations principales</strong>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="mb-3 div_personne_physique">
                                    <label for="nom" class="form-label">
                                        Nom <span class="text-danger">*</span>
                                    </label>

                                    <div class="container_indicatif">

                                        <div class="item_indicatif">
                                            <select class="form-select select2" id="civilite" name="civilite"
                                                wire:model.defer="civilite">

                                                <option value="M.">M.</option>
                                                <option value="Mme">Mme</option>
                                            </select>

                                            @if ($errors->has('civilite'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('civilite') }}</strong>
                                                </div>
                                            @endif


                                        </div>

                                        <div class="item_input">
                                            <input type="text" id="nom" name="nom"
                                                wire:model.defer="nom" required
                                                value="{{ old('nom') ? old('nom') : '' }}" class="form-control">
                                            @if ($errors->has('nom'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('nom') }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                    </div>

                                </div>


                                <style>
                                    .container_indicatif {
                                        display: flex;
                                        flex-flow: row wrap;
                                        gap: 5px;

                                    }

                                    .item_indicatif {
                                        flex-grow: 2;
                                    }

                                    .item_input {
                                        flex-grow: 10;
                                    }
                                </style>


                                <div class="mb-3">
                                    <label for="telephone_fixe" class="form-label">
                                        Téléphone Fixe
                                    </label>

                                    <div class="container_indicatif">
                                        <div class="item_indicatif">
                                            <select class="form-select select2" id="indicatif_fixe"
                                                name="indicatif_fixe" style="width:100%"
                                                wire:model.defer="indicatif_fixe">

                                                @include('livewire.indicatifs-pays')

                                            </select>


                                        </div>
                                        <div class="item_input">
                                            <input type="tel" pattern="[0-9]*" id="telephone_fixe"
                                                name="telephone_fixe" wire:model.defer="telephone_fixe"
                                                value="{{ old('telephone_fixe') ? old('telephone_fixe') : '' }}"
                                                class="form-control">
                                        </div>

                                    </div>

                                    @if ($errors->has('telephone_fixe'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('telephone_fixe') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>



                            <div class="col-sm-6">

                                <div class="mb-3 ">
                                    <label for="prenom" class="form-label">
                                        Prénom(s) <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="prenom" name="prenom" wire:model.defer="prenom"
                                        required value="{{ old('prenom') ? old('prenom') : '' }}"
                                        class="form-control">

                                    @if ($errors->has('prenom'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('prenom') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="telephone_mobile" class="form-label">
                                        Téléphone Mobile
                                    </label>
                                    <div class="container_indicatif">
                                        <div class="item_indicatif">
                                            <select class="form-select select2" id="indicatif_mobile"
                                                name="indicatif_mobile" style="width:100%"
                                                wire:model.defer="indicatif_mobile">
                                                @include('livewire.indicatifs-pays')

                                            </select>

                                            </select>
                                        </div>
                                        <div class="item_input">
                                            <input type="tel" pattern="[0-9]*" id="telephone_mobile"
                                                name="telephone_mobile" wire:model.defer="telephone_mobile"
                                                value="{{ old('telephone_mobile') ? old('telephone_mobile') : '' }}"
                                                class="form-control">
                                        </div>

                                    </div>



                                    @if ($errors->has('telephone_mobile'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('telephone_mobile') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                                <strong>Informations Complémentaires
                            </div>
                        </div>

                        <div class="row">


                            <div class="col-6">



                                <div class="mb-3">
                                    <label for="adresse" class="form-label">
                                        Adresse
                                    </label>
                                    <input type="text" id="adresse" name="adresse" wire:model.defer="adresse"
                                        value="{{ old('adresse') ? old('adresse') : '' }}" class="form-control">

                                    @if ($errors->has('adresse'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('adresse') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="code_postal" class="form-label">
                                        Code Postal
                                    </label>
                                    <input type="text" id="code_postal" name="code_postal"
                                        wire:model.defer="code_postal"
                                        value="{{ old('code_postal') ? old('code_postal') : '' }}"
                                        class="form-control">

                                    @if ($errors->has('code_postal'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('code_postal') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="ville" class="form-label">
                                        Ville
                                    </label>
                                    <input type="text" id="ville" name="ville" wire:model.defer="ville"
                                        value="{{ old('ville') ? old('ville') : '' }}" class="form-control">

                                    @if ($errors->has('ville'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('ville') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>



                            <div class="col-6">

                                <div class="mb-3">
                                    <label for="complement_adresse" class="form-label">
                                        Complément d'adresse
                                    </label>
                                    <input type="text" id="complement_adresse" name="complement_adresse"
                                        wire:model.defer="complement_adresse"
                                        value="{{ old('complement_adresse') ? old('complement_adresse') : '' }}"
                                        class="form-control">

                                    @if ($errors->has('complement_adresse'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('complement_adresse') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-3" wire:ignore>
                                    <label for="pays" class="form-label">
                                        Pays
                                    </label>

                                    <select class="form-control select2" data-toggle="select2" id="pays"
                                        name="pays" style="width:100%" wire:model.defer="pays">

                                        @include('livewire.pays')

                                    </select>

                                    @if ($errors->has('pays'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('pays') }}</strong>
                                        </div>
                                    @endif
                                </div>



                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" wire:model.defer="notes" class="form-control" id="notes" rows="5"
                                        placeholder="..">{{ old('notes') ? old('notes') : '' }}</textarea>
                                    @if ($errors->has('notes'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('notes') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="modal-footer">

                            <button type="submit" id="enregistrer" wire:click="submit"
                                class="btn btn-primary">Enregistrer</button>

                        </div>
                    </div>
                    <!-- end row -->

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->



</form>
