{{-- Ajout d'une prestation --}}
<div id="prestation-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter une prestation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('prestation.store') }}" method="post">
                <div class="modal-body">

                    @csrf
                    <input type="hidden" name="typecontact" value="Bénéficiaire" />
                    <input type="hidden" name="nature" value=" Personne physique" />
                    <input type="hidden" name="client_id" value="{{$contact->id}}" />


                    <div class="row">

                            <div class="col-6 ">
                                <div class="mb-3 ">
                                    <label for="numero" class="form-label">
                                        Numéro de la prestation <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" id="numero" name="numero" min="{{$prochain_numero_prestation}}"
                                        value="{{$prochain_numero_prestation}}" class="form-control" style="font-size: 1.5rem;color: #772e7b;" required>

                                    @if ($errors->has('numero'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('numero') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
   
                       
                            <div class="col-6 ">
                                <div class="mb-3 ">
                                    <label for="nom_prestation" class="form-label">
                                        Nom de la prestation <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="nom_prestation" name="nom_prestation" style="font-size: 1.5rem;color: #772e7b;"
                                        value="{{ old('nom_prestation') ? old('nom_prestation') : '' }}" class="form-control" required>

                                    @if ($errors->has('nom_prestation'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('nom_prestation') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>                    

                    </div>
                    
                    <div class="row">

                        <div class="col-6 ">
                            <div class=" mb-3">
                                <label for="methode_paiement" class="form-label">
                                    Méthode de paiement 
                                </label>
                                <select name="methode_paiement" id="methode_paiement" class=" form-control select2"
                                    data-toggle="select2" >
                                    <option value=""></option>
                                    <option value="Espèces">Espèces</option>
                                    <option value="Carte bancaire">Carte bancaire</option>
                                    <option value="Virement">Virement</option>
                                    <option value="Chèque">Chèque</option>
                                    <option value="Autre">Autre</option>
                                   
                                </select>
                                @if ($errors->has('methode_paiement'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{ $errors->first('methode_paiement') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>

                   
                        <div class="col-6 ">
                            <div class="mb-3 ">
                                <label for="date_prestation" class="form-label">
                                    Date de la prestation 
                                </label>
                                <input type="date" id="date_prestation" name="date_prestation" 
                                    value="{{ old('date_prestation') ? old('date_prestation') : '' }}" class="form-control" >

                                @if ($errors->has('date_prestation'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{ $errors->first('date_prestation') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>                    

                    </div>
                    
                    <div class="row">

                        <div class="col-6 ">
                            <div class="mb-3 ">
                                <label for="montant_ttc" class="form-label">
                                    Montant de la prestation (TTC) <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="montant_ttc" name="montant_ttc" step="0.01"
                                    value="{{ old('montant_ttc') ? old('montant_ttc') : '' }}" class="form-control" required>

                                @if ($errors->has('montant_ttc'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{ $errors->first('montant_ttc') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>                    
                        <div class="col-6">
                                
                            <div class="mb-3 ">
                                <label for="notes" class="form-label">
                                    Notes 
                                </label>
                                <textarea name="notes" id="notes" rows="5" class="form-control"></textarea>

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

                    <hr>

                    <div class="col-lg-12 mb-3">
                        <label for="floatingInput">Le Bénéficiaire existe ? </label> <br>

                        <input type="checkbox" name="contact_existant" id="contact_existant" checked
                            data-switch="success" />
                        <label for="contact_existant" data-on-label="Oui" data-off-label="Non"></label>

                    </div>

                    <div class="col-lg-12 contact_existant">
                        <div class="row">
                            <div class="col-6">
                                <div class=" mb-3">
                                    <label for="newcontact" class="form-label">
                                        Sélectionnez le Bénéficiaire <span class="text-danger">*</span>
                                    </label>
                                    <select name="newcontact" id="newcontact" class=" form-control select2"
                                        data-toggle="select2" >
                                        <option value=""></option>
                                        @foreach ($beneficiaires as $beneficiaire)
                                            <option value="{{ $beneficiaire->id }}">
                                                {{ $beneficiaire->individu->nom }} {{ $beneficiaire->individu->prenom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('newcontact'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('newcontact') }}</strong>
                                        </div>
                                    @endif
                                </div>


                            </div>
                            

                        </div>

                    </div>

                    <div class="nouveau_contact">
                        <div class="row">


                            <div class="col-6">
                                <div class="mb-3 ">
                                    <label for="email" class="form-label">
                                        Email
                                    </label>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email') ? old('email') : '' }}" class="form-control">

                                    @if ($errors->has('email'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-6">

                            </div>

                        </div>
                        <br>


                        <div class="row">

                            <div class="col-6">
                                <div class="mb-3 div_personne_physique">
                                    <label for="nom" class="form-label">
                                        Nom <span class="text-danger">*</span>
                                    </label>

                                    <div class="container_indicatif">

                                        <div class="item_indicatif">
                                            <select class="form-select select2" id="civilite" name="civilite">

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
                            </div>
                            <div class="col-6 div-individu">
                                <div class="mb-3 ">
                                    <label for="prenom" class="form-label">
                                        Prénom(s)
                                    </label>
                                    <input type="text" id="prenom" name="prenom"
                                        value="{{ old('prenom') ? old('prenom') : '' }}" class="form-control">

                                    @if ($errors->has('prenom'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('prenom') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>



                        </div>


                        <div class="row">

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="telephone_mobile" class="form-label">
                                        Téléphone Mobile
                                    </label>
                                    <div class="container_indicatif">
                                        <div class="item_indicatif">
                                            <select class="form-select select2" id="indicatif_mobile"
                                                name="indicatif_mobile" style="width:100%">
                                                @include('livewire.indicatifs-pays')

                                            </select>

                                            </select>
                                        </div>
                                        <div class="item_input">
                                            <input type="text" id="telephone_mobile" name="telephone_mobile"
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
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="telephone_fixe" class="form-label">
                                        Téléphone Fixe
                                    </label>

                                    <div class="container_indicatif">
                                        <div class="item_indicatif">
                                            <select class="form-select select2" id="indicatif_fixe"
                                                name="indicatif_fixe" style="width:100%">

                                                @include('livewire.indicatifs-pays')

                                            </select>


                                        </div>
                                        <div class="item_input">
                                            <input type="text" id="telephone_fixe" name="telephone_fixe"
                                                wire:model.defer="telephone_fixe"
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

                        </div>

                        <br>
                        <hr><br>



                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>

                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<style>
    .container_email_label {
        display: flex;
        flex-flow: row wrap;
        gap: 5px;
    }

    .container_email_input {
        display: flex;
        flex-flow: row nowrap;
        justify-content: space-between;
        /* gap: 5px; */
    }

    .item_email {
        flex-grow: 11;
    }

    .item_btn_remove {
        flex-grow: 1;
    }

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
