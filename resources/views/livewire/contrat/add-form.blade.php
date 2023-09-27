<form action="{{ route('contrat.store') }}" method="post">
    @csrf


    <input type="hidden" name="typecontrat" wire:model="typecontrat">
    <div class="row">
        <div class="col-9 mb-3" style="background:#7e7b7b; color:white!important; padding:10px ">
            <strong>Informations principales
        </div>
        <div class="col-md-12 col-lg-9">

            <div class="card">
                <div class="card-body">


                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3 ">
                                <label for="typecontrat" class="form-label">
                                    Choisir le collaborateur<span class="text-danger">*</span>
                                </label>
                                <select class="form-select select2" id="typecontrat" name="typecontrat"
                                    wire:model="typecontrat">

                                </select>

                                @if ($errors->has('typecontrat'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('typecontrat') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3 ">
                                <label for="typecontrat" class="form-label">
                                    Statut<span class="text-danger">*</span>
                                </label>
                                <select class="form-select select2" id="typecontrat" name="typecontrat"
                                    wire:model="typecontrat">
                                    <option value="auto-entrepeneur">auto-entrepeneur</option>
                                    <option value="indépendant">indépendant</option>
                                </select>

                                @if ($errors->has('typecontrat'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('typecontrat') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3 ">
                                <label for="floatingInput" class="mb-1">Le collaborateur a t-il un parrain ? </label>
                                <br>

                                <input type="checkbox" name="contact_existant" id="contact_existant"
                                    data-switch="info" />
                                <label for="contact_existant" data-on-label="Oui" data-off-label="Non"></label>

                                @if ($errors->has('raison_sociale'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('raison_sociale') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3 ">
                                <label for="typecontrat" class="form-label">
                                    Choisir le parrain<span class="text-danger">*</span>
                                </label>
                                <select class="form-select select2" id="typecontrat" name="typecontrat"
                                    wire:model="typecontrat">

                                </select>

                                @if ($errors->has('typecontrat'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('typecontrat') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="col-6">
                            <div class="mb-3 ">
                                <label for="raison_sociale" class="form-label">
                                    Date de début <span class="text-danger">*</span>
                                </label>
                                <input type="date" id="raison_sociale" name="raison_sociale"
                                    wire:model.defer="raison_sociale" required
                                    value="{{ old('raison_sociale') ? old('raison_sociale') : '' }}"
                                    class="form-control">

                                @if ($errors->has('raison_sociale'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('raison_sociale') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3 ">
                                <label for="raison_sociale" class="form-label">
                                    Date de fin
                                </label>
                                <input type="date" id="raison_sociale" name="raison_sociale"
                                    wire:model.defer="raison_sociale"
                                    value="{{ old('raison_sociale') ? old('raison_sociale') : '' }}"
                                    class="form-control">

                                @if ($errors->has('raison_sociale'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{ $errors->first('raison_sociale') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3 ">
                                <label for="floatingInput" class="mb-1">Le collaborateur a t-il salarié ? </label>
                                <br>

                                <input type="checkbox" name="contact_existant" id="contact_existant" checked
                                    data-switch="info" />
                                <label for="contact_existant" data-on-label="Oui" data-off-label="Non"></label>

                                @if ($errors->has('raison_sociale'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{ $errors->first('raison_sociale') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3 ">
                                <label for="typecontrat" class="form-label">
                                    Choisir la société<span class="text-danger">*</span>
                                </label>
                                <select class="form-select select2" id="typecontrat" name="typecontrat"
                                    wire:model="typecontrat">

                                </select>

                                @if ($errors->has('typecontrat'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{ $errors->first('typecontrat') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>




                    <div class="row mt-3 mb-3">
                        <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                            <strong>Rémunérations
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                <li class="nav-item">
                                    <a href="#home1" data-bs-toggle="tab" aria-expanded="false"
                                        class="nav-link rounded-0">
                                        <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Salaire</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#profile1" data-bs-toggle="tab" aria-expanded="true"
                                        class="nav-link rounded-0 active">
                                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Commissions directes</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#settings1" data-bs-toggle="tab" aria-expanded="false"
                                        class="nav-link rounded-0">
                                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Commissions de parrainage</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane" id="home1">
                                    @include('livewire.contrat.components.add_salaire')
                                </div>
                                <div class="tab-pane show active" id="profile1">
                                    @include('livewire.contrat.components.add_commission')

                                </div>
                                <div class="tab-pane" id="settings1">
                                    @include('livewire.contrat.components.add_parrainage')

                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- 

                    <div class="row div_associer" style="margin-top:30px;">
                        <div class="col-12 mb-3" style="background:#7e7b7b; color:white!important; padding:10px ">
                            <strong>Associer d'autres contrats
                            </strong>
                        </div>

                    </div> --}}

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

<style>
    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #7e7b7b !important;
    }
</style>
