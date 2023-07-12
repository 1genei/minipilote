@extends('layouts.app')
@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12">
            <div class="card alert">
                <a href="#" data-toggle="modal" data-target="#entite_add"
                    class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i
                        class="ti-plus"></i>@lang('Ajouter')</a>
                <div class="card-body">

                    <div class="form-validation">
                        <form class="form-valide form-horizontal" action="{{ route('contact.store') }}" method="post">
                            {{ csrf_field() }}

                            <div class="col-md-12 col-lg-12 col-sm-12 "
                                style="background:#175081; color:white!important; padding:10px ">
                                <strong>Informations principales
                            </div>
                            <br>
                            <br>
                            <br>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px">

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-md-2 col-sm-4 control-label"
                                            for="statut">@lang('Statut du contact') <span class="text-danger">*</span></label>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <select class="js-select2 form-control" id="statut" name="statut"
                                                style="width: 100%;" required>

                                                <option value="Acquéreur">Acquéreur</option>
                                                <option value="ProprietaireLocataire">Proprietaire</option>
                                                <option value="Locataire">Locataire</option>

                                            </select>
                                            @if ($errors->has('statut'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('statut') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3  ">
                                    <div class="form-group ">
                                        <label class="col-lg-8  col-md-8  col-sm-48 control-label" style="padding-top: 5px;"
                                            for="nature1">Personne seule <span class="text-danger">*</span></label>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <input type="radio" style="height: 22px;" class="form-control" id="nature1"
                                                name="nature" value="Personne seule" required>
                                            @if ($errors->has('nature'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nature') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3  ">

                                    <div class="form-group ">
                                        <label class="col-lg-8 col-md-8 col-sm-8 control-label" style="padding-top: 5px;"
                                            for="nature2">Personne morale <span class="text-danger">*</span></label>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <input type="radio" style="height: 22px;" class="form-control" id="nature2"
                                                name="nature" value="Personne morale" required>
                                            @if ($errors->has('nature'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nature') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 div_proprietaire ">

                                    <div class="form-group ">
                                        <label class="col-lg-8 col-md-8 col-sm-8 control-label" style="padding-top: 5px;"
                                            for="nature3">Couple <span class="text-danger">*</span></label>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <input type="radio" style="height: 22px;" class="form-control" id="nature3"
                                                name="nature" value="Couple" required>
                                            @if ($errors->has('nature'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nature') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3  ">

                                    <div class="form-group ">
                                        <label class="col-lg-8 col-md-8 col-sm-8 control-label" style="padding-top: 5px;"
                                            for="nature4">Groupe <span class="text-danger">*</span></label>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <input type="radio" style="height: 22px;" class="form-control" id="nature4"
                                                name="nature" value="Groupe" required>
                                            @if ($errors->has('nature'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nature') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <input type="hidden" id="type" name="type">

                            <div class="row">
                                <hr>

                                <div class="col-lg-6 col-md-6 col-sm-6">


                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="civilite1">@lang('Civilité') <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <select class="js-select2 form-control " id="civilite1" name="civilite1"
                                                style="width: 100%;" required>
                                                <option value="{{ old('civilite1') }}">{{ old('civilite1') }}</option>
                                                <option value="M.">M.</option>
                                                <option value="Mme">Mme</option>
                                            </select>
                                            @if ($errors->has('civilite1'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('civilite1') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom1">Nom <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control " value="{{ old('nom1') }}"
                                                id="nom1" name="nom1" required>
                                            @if ($errors->has('nom1'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nom1') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom1">Prénom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control" value="{{ old('prenom1') }}"
                                                id="prenom1" name="prenom1" required>
                                            @if ($errors->has('prenom1'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('prenom1') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email1">Email <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control" id="email1"
                                                value="{{ old('email1') }}" name="email1" required>
                                            @if ($errors->has('email1'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('email1') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_portable1">Téléphone portable </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_portable1') }}" id="telephone_portable1"
                                                name="telephone_portable1">
                                            @if ($errors->has('telephone_portable1'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_portable1') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_fixe1">Téléphone fixe </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_fixe1') }}" id="telephone_fixe1"
                                                name="telephone_fixe1">
                                            @if ($errors->has('telephone_fixe1'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_fixe1') }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                    </div>


                                    <div class="form-group div_personne_seule">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="civilite">@lang('Civilité') <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <select class="js-select2 form-control " id="civilite" name="civilite"
                                                style="width: 100%;" required>
                                                <option value="{{ old('civilite') }}">{{ old('civilite') }}</option>
                                                <option value="M.">M.</option>
                                                <option value="Mme">Mme</option>
                                            </select>
                                            @if ($errors->has('civilite'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('civilite') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_seule">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom">Nom <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control " value="{{ old('nom') }}"
                                                id="nom" name="nom" required>
                                            @if ($errors->has('nom'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nom') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_seule">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom">Prénom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control" value="{{ old('prenom') }}"
                                                id="prenom" name="prenom" required>
                                            @if ($errors->has('prenom'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('prenom') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_morale">
                                        <label class="col-lg-4 col-md-4 col-sm-4  control-label"
                                            for="forme_juridique">Forme juridique<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <select class="js-select2 form-control" id="forme_juridique"
                                                name="forme_juridique" style="width: 100%;" required>
                                                <option value="{{ old('forme_juridique') }}">{{ old('forme_juridique') }}
                                                </option>

                                                <option value="">Non défini</option>
                                                <option value="EURL">EURL - Entreprise unipersonnelle à responsabilité
                                                    limitée</option>
                                                <option value="EI">EI - Entreprise individuelle</option>
                                                <option value="SARL">SARL - Société à responsabilité limitée</option>
                                                <option value="SA">SA - Société anonyme</option>
                                                <option value="SAS">SAS - Société par actions simplifiée</option>
                                                <option value="SCI">SCI - Société civile immobilière</option>
                                                <option value="SNC">SNC - Société en nom collectif</option>
                                                <option value="EARL">EARL - Entreprise agricole à responsabilité limitée
                                                </option>
                                                <option value="EIRL">EIRL - Entreprise individuelle à responsabilité
                                                    limitée (01.01.2010)</option>
                                                <option value="GAEC">GAEC - Groupement agricole d'exploitation en commun
                                                </option>
                                                <option value="GEIE">GEIE - Groupement européen d'intérêt économique
                                                </option>
                                                <option value="GIE">GIE - Groupement d'intérêt économique</option>
                                                <option value="SASU">SASU - Société par actions simplifiée unipersonnelle
                                                </option>
                                                <option value="SC">SC - Société civile</option>
                                                <option value="SCA">SCA - Société en commandite par actions</option>
                                                <option value="SCIC">SCIC - Société coopérative d'intérêt collectif
                                                </option>
                                                <option value="SCM">SCM - Société civile de moyens</option>
                                                <option value="SCOP">SCOP - Société coopérative ouvrière de production
                                                </option>
                                                <option value="SCP">SCP - Société civile professionnelle</option>
                                                <option value="SCS">SCS - Société en commandite simple</option>
                                                <option value="SEL">SEL - Société d'exercice libéral</option>
                                                <option value="SELAFA">SELAFA - Société d'exercice libéral à forme anonyme
                                                </option>
                                                <option value="SELARL">SELARL - Société d'exercice libéral à responsabilité
                                                    limitée</option>
                                                <option value="SELAS">SELAS - Société d'exercice libéral par actions
                                                    simplifiée</option>
                                                <option value="SELCA">SELCA - Société d'exercice libéral en commandite par
                                                    actions</option>
                                                <option value="SEM">SEM - Société d'économie mixte</option>
                                                <option value="SEML">SEML - Société d'économie mixte locale</option>
                                                <option value="SEP">SEP - Société en participation</option>
                                                <option value="SICA">SICA - Société d'intérêt collectif agricole</option>

                                            </select>
                                            @if ($errors->has('forme_juridique'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('forme_juridique') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_morale">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="raison_sociale">Raison sociale <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('raison_sociale') }}" id="raison_sociale"
                                                name="raison_sociale" required>
                                            @if ($errors->has('raison_sociale'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('raison_sociale') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_groupe">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom_groupe">Nom du
                                            groupe <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control" value="{{ old('nom_groupe') }}"
                                                id="nom_groupe" name="nom_groupe" required>
                                            @if ($errors->has('nom_groupe'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nom_groupe') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div id="source_div">
                                        <div class="form-group div_personne_groupe">
                                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="type_groupe">Type
                                                de groupe</label>
                                            <div class="col-lg-8">
                                                <select class="selectpicker col-lg-6" id="type_groupe" name="type_groupe"
                                                    data-live-search="true" data-style="btn-ligth btn-rounded">
                                                    <option value=""> </option>
                                                    <option value="Succession">Succession </option>
                                                    <option value="Association">Association </option>
                                                    <option value="Indivision">Indivision </option>
                                                    <option value="Autre">Autre</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="source_div">
                                        <div class="form-group div_partenaire">
                                            <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                for="metier">Métier</label>
                                            <div class="col-lg-8">
                                                <select class="selectpicker col-lg-6" id="metier" name="metier"
                                                    data-live-search="true" data-style="btn-warning btn-rounded">

                                                    <option value=""> </option>
                                                    <option value="Notaire">Notaire </option>
                                                    <option value="Collaborateur">Collaborateur </option>
                                                    <option value="Fournisseur">Fournisseur </option>
                                                    <option value="Diagnostiqueur">Diagnostiqueur </option>
                                                    <option value="Promoteur">Promoteur </option>

                                                    <option value="Autre">Autre</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div id="source_div">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="source_id">Source
                                                du contact</label>
                                            <div class="col-lg-8">
                                                <select class="selectpicker col-lg-6" id="source_id" name="source_id"
                                                    data-live-search="true" data-style="btn-warning btn-rounded">

                                                    <option value=""> </option>
                                                    <option value="Réseaux sociaux">Réseaux sociaux</option>
                                                    <option value="Bouche à oreille">Bouche à oreille</option>
                                                    <option value="Internet">Internet</option>
                                                    <option value="Autre">Autre</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="civilite2">@lang('Civilité') <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <select class="js-select2 form-control " id="civilite2" name="civilite2"
                                                style="width: 100%;" required>
                                                <option value="{{ old('civilite2') }}">{{ old('civilite2') }}</option>
                                                <option value="M.">M.</option>
                                                <option value="Mme">Mme</option>
                                            </select>
                                            @if ($errors->has('civilite2'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('civilite2') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom2">Nom <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control " value="{{ old('nom2') }}"
                                                id="nom2" name="nom2" required>
                                            @if ($errors->has('nom2'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nom2') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom2">Prénom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control" value="{{ old('prenom2') }}"
                                                id="prenom2" name="prenom2" required>
                                            @if ($errors->has('prenom2'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('prenom2') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email2">Email <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control" id="email2"
                                                value="{{ old('email2') }}" name="email2" required>
                                            @if ($errors->has('email2'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('email2') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_portable2">Téléphone portable </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_portable2') }}" id="telephone_portable2"
                                                name="telephone_portable2">
                                            @if ($errors->has('telephone_portable2'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_portable2') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_fixe2">Téléphone fixe </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_fixe2') }}" id="telephone_fixe2"
                                                name="telephone_fixe2">
                                            @if ($errors->has('telephone_fixe2'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_fixe2') }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                    </div>



                                    <div class="form-group div_personne_tout">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email">Email <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control" id="email"
                                                value="{{ old('email') }}" name="email" required>
                                            @if ($errors->has('email'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_tout">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_portable">Téléphone portable </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_portable') }}" id="telephone_portable"
                                                name="telephone_portable">
                                            @if ($errors->has('telephone_portable'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_portable') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_tout">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_fixe">Téléphone fixe </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_fixe') }}" id="telephone_fixe"
                                                name="telephone_fixe">
                                            @if ($errors->has('telephone_fixe'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_fixe') }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                    </div>


                                    <div class="form-group div_personne_morale ">
                                        <label class="col-lg-4 col-md-4 col-sm-4  control-label" for="numero_siret">Numéro
                                            siret</label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" id="numero_siret" class="form-control "
                                                value="{{ old('numero_siret') }}" name="numero_siret">
                                            @if ($errors->has('telephone'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <a href="#" class="close" data-dismiss="alert"
                                                        aria-label="close">&times;</a>
                                                    <strong>{{ $errors->first('telephone') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group div_personne_morale ">
                                        <label class="col-lg-4 col-md-4 col-sm-4  control-label" for="numero_tva">Numéro
                                            TVA</label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" id="numero_tva" class="form-control "
                                                value="{{ old('numero_tva') }}" name="numero_tva">
                                            @if ($errors->has('numero_tva'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <a href="#" class="close" data-dismiss="alert"
                                                        aria-label="close">&times;</a>
                                                    <strong>{{ $errors->first('numero_tva') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 "
                                style="background:#175081; color:white!important; padding:10px ">
                                <strong>Informations complémentaires
                                </strong>
                            </div>

                            <br>
                            <br>
                            <br>

                            <div class="row">


                                <div class="col-lg-6 col-md-6 col-sm-6">

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="adresse">Adresse
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control " value="{{ old('adresse') }}"
                                                id="adresse" name="adresse">
                                            @if ($errors->has('adresse'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('adresse') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="code_postal">Code
                                            postal </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control" value="{{ old('code_postal') }}"
                                                id="code_postal" name="code_postal">
                                            @if ($errors->has('code_postal'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('code_postal') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="ville">Ville
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control" value="{{ old('ville') }}"
                                                id="ville" name="ville">
                                            @if ($errors->has('ville'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('ville') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="pays">Pays
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text"
                                                class="form-control {{ $errors->has('pays') ? ' is-invalid' : '' }}"
                                                value="{{ old('pays') ? old('pays') : 'France' }}" id="pays"
                                                name="pays" placeholder="Entez une lettre et choisissez..">
                                            @if ($errors->has('pays'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('pays') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">





                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="note">Note</label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <textarea name="note" id="note" class="form-control" cols="30" rows="5"> {{ old('note') }}</textarea>
                                            @if ($errors->has('note'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('note') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="row div_associer" style="margin-top:30px;">
                                <div class="col-md-12 col-lg-12 col-sm-12 "
                                    style="background:#763b93; color:white!important; padding:10px ">
                                    <strong>Associer d'autres contacts
                                    </strong>
                                </div>
                                <div class="form-group row" id="op1" style="margin-top:90px;">
                                    <label class="col-sm-4 control-label" for="individus">Selectionnez les
                                        contacts</label>
                                    <div class="col-lg-8">
                                        <select class="selectpicker col-lg-8" id="individus" name="individus[]"
                                            data-live-search="true" data-style="btn-default btn-rounded" multiple>
                                            @foreach ($contacts as $contact)
                                                @if ($contact->type == 'individu')
                                                    @if ($contact->nature == 'Couple')
                                                        <option value="{{ $contact->individu->id }}"
                                                            data-content="<span class='user-avatar'></span><span class='badge badge-pink'>{{ $contact->individu->civilite }}</span> {{ $contact->individu->nom }} {{ $contact->individu->prenom }}"
                                                            data-tokens="{{ $contact->individu->civilite }} {{ $contact->individu->nom }} {{ $contact->individu->prenom }} ">
                                                        </option>
                                                    @else
                                                        <option value="{{ $contact->individu->id }}"
                                                            data-content="<span class='user-avatar'></span><span class='badge badge-pink'>{{ $contact->individu->civilite }}</span> {{ $contact->individu->nom }} {{ $contact->individu->prenom }}"
                                                            data-tokens="{{ $contact->individu->civilite }} {{ $contact->individu->nom }} {{ $contact->individu->prenom }} ">
                                                        </option>
                                                    @endif
                                                    {{-- @else
                                        <option value="{{ $contact->id }}"
                                            data-content="<span class='user-avatar'></span><span class='badge badge-pink'>{{ $contact->entite->forme_juridique }}</span> {{ $contact->entite->raison_sociale }} "
                                            data-tokens="{{ $contact->entite->forme_juridique }} {{ $contact->entite->raison_sociale }} ">
                                        </option> --}}
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" style="text-align: center; margin-top: 50px;">
                                <div class="col-lg-8 ml-auto">
                                    <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit"
                                        id="ajouter"><i class="ti-plus"></i>Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
    {{-- @include('components.contact.entite_add') --}}
@stop
@section('js-content')

    <script src="{{ asset('js/autocomplete_cp_ville.js') }}"></script>
    <script src={{ 'https://code.jquery.com/ui/1.13.2/jquery-ui.js' }}></script>

    {{-- dropzone --}}
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <script src="{{ asset('js/dropzone-config.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#entitelist').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $(".div_proprietaire").show();
            $(".div_partenaire").hide();

            $(".div_personne_seule").show();
            $(".div_personne_morale").hide();
            $(".div_personne_couple").hide();
            $(".div_personne_groupe").hide();


            $(".div_associer").hide();



            $('#statut').change(function(e) {
                let statut = $("#statut option:selected").text();

                if (statut != "Partenaire") {
                    $(".div_proprietaire").show();
                    $(".div_partenaire").hide();
                } else {
                    $(".div_proprietaire").hide();
                    $(".div_partenaire").show();
                }
            });

            $("input[type='radio']").click(function(e) {

                let nature = e.currentTarget.value;

                if (nature == "Personne morale") {

                    $("input[type='text']").removeAttr("required");
                    $("select").removeAttr("required");
                    $("#type").val("entité");

                    $(".div_personne_seule").hide();
                    $(".div_personne_morale").show();
                    $(".div_personne_couple").hide();
                    $(".div_personne_groupe").hide();
                    $(".div_personne_tout").show();
                    $(".div_associer").show();

                    $("#forme_juridique").attr("required", "required");
                    $("#raison_sociale").attr("required", "required");
                    $("#email").attr("required", "required");

                } else if (nature == "Personne seule") {
                    $("input[type='text']").removeAttr("required");
                    $("select").removeAttr("required");

                    $(".div_personne_seule").show();
                    $(".div_personne_morale").hide();
                    $(".div_personne_couple").hide();
                    $(".div_personne_groupe").hide();
                    $(".div_personne_tout").show();

                    $("#civilite").attr("required", "required");
                    $("#nom").attr("required", "required");
                    $("#prenom").attr("required", "required");
                    $("#email").attr("required", "required");

                    $("#type").val("individu");
                    $(".div_associer").hide();



                } else if (nature == "Couple") {
                    $("input[type='text']").removeAttr("required");
                    $("select").removeAttr("required");

                    $(".div_personne_seule").hide();
                    $(".div_personne_morale").hide();
                    $(".div_personne_couple").show();
                    $(".div_personne_groupe").hide();
                    $(".div_personne_tout").hide();

                    $("#civilite1").attr("required", "required");
                    $("#nom1").attr("required", "required");
                    $("#prenom1").attr("required", "required");
                    $("#email1").attr("required", "required");

                    $("#civilite2").attr("required", "required");
                    $("#nom2").attr("required", "required");
                    $("#prenom2").attr("required", "required");
                    $("#email2").attr("required", "required");

                    $("#type").val("individu");
                    $(".div_associer").hide();

                } else if (nature == "Groupe") {
                    $("input[type='text']").removeAttr("required");
                    $("select").removeAttr("required");

                    $(".div_personne_seule").hide();
                    $(".div_personne_morale").hide();
                    $(".div_personne_couple").hide();
                    $(".div_personne_tout").show();
                    $(".div_personne_groupe").show();

                    $(".div_associer").show();

                    $("#nom_groupe").attr("required", "required");
                    $("#email").attr("required", "required");
                    $("#type").val("entité");

                }

            });


        });
    </script>


    {{-- //   Auto complète adresses  --}}
    <script>
        $("#code_postal").autocomplete({
            source: function(request, response) {
                $.ajax({
                    beforeSend: function() {},
                    url: "https://api-adresse.data.gouv.fr/search/?postcode=" + $(
                        "input[name='code_postal']").val(),
                    data: {
                        q: request.term
                    },
                    dataType: "json",
                    success: function(data) {
                        var postcodes = [];
                        response($.map(data.features, function(item) {
                            // Ici on est obligé d'ajouter les CP dans un array pour ne pas avoir plusieurs fois le même
                            if ($.inArray(item.properties.city, postcodes) == -1) {
                                postcodes.push(item.properties.postcode);
                                return {
                                    label: item.properties.postcode + " - " + item
                                        .properties.city,
                                    city: item.properties.city,
                                    value: item.properties.postcode
                                };
                            }
                        }));
                    }
                });
            },
            // On remplit aussi la ville
            select: function(event, ui) {
                $('#ville').val(ui.item.city);
            }
        });
        $("#ville").autocomplete({
            source: function(request, response) {
                $.ajax({
                    beforeSend: function() {},
                    url: "https://api-adresse.data.gouv.fr/search/?city=" + $("input[name='ville']")
                        .val(),
                    data: {
                        q: request.term
                    },
                    dataType: "json",
                    success: function(data) {
                        var cities = [];
                        response($.map(data.features, function(item) {
                            // Ici on est obligé d'ajouter les villes dans un array pour ne pas avoir plusieurs fois la même
                            if ($.inArray(item.properties.postcode, cities) == -1) {
                                cities.push(item.properties.postcode);
                                return {
                                    label: item.properties.postcode + " - " + item
                                        .properties.city,
                                    postcode: item.properties.postcode,
                                    value: item.properties.city
                                };
                            }
                        }));
                    }
                });
            },
            // On remplit aussi le CP
            select: function(event, ui) {
                $('#code_postal').val(ui.item.postcode);
            }
        });
        $("#adresse").autocomplete({
            source: function(request, response) {
                $.ajax({
                    beforeSend: function() {},
                    url: "https://api-adresse.data.gouv.fr/search/?postcode=" + $(
                        "input[name='code_postal']").val(),
                    data: {
                        q: request.term
                    },
                    dataType: "json",
                    success: function(data) {
                        response($.map(data.features, function(item) {
                            return {
                                label: item.properties.name,
                                value: item.properties.name
                            };
                        }));
                    }
                });
            }
        });
    </script>




    <script>
        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }

        /*An array containing all the country names in the world:*/
        // var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

        var countries = ["Afghanistan", "Afrique du Sud", "Albanie", "Algérie", "Allemagne", "Andorre", "Angola",
            "Anguilla", "Arabie Saoudite", "Argentine", "Arménie", "Australie", "Autriche", "Azerbaidjan", "Bahamas",
            "Bangladesh", "Barbade", "Bahrein", "Belgique", "Bélize", "Bénin", "Biélorussie", "Bolivie", "Botswana",
            "Bhoutan", "Boznie-Herzégovine", "Brésil", "Brunei", "Bulgarie", "Burkina Faso", "Burundi", "Cambodge",
            "Cameroun", "Canada", "Cap-Vert", "Chili", "Chine", "Chypre", "Colombie", "Comores", "République du Congo",
            "République Démocratique du Congo", "Corée du Nord", "Corée du Sud", "Costa Rica", "Côte d’Ivoire",
            "Croatie", "Cuba", "Danemark", "Djibouti", "Dominique", "Egypte", "Emirats Arabes Unis", "Equateur",
            "Erythrée", "Espagne", "Estonie", "Etats-Unis d’Amérique", "Ethiopie", "Fidji", "Finlande", "France",
            "Gabon", "Gambie", "Géorgie", "Ghana", "Grèce", "Grenade", "Guatémala", "Guinée", "Guinée Bissau",
            "Guinée Equatoriale", "Guyana", "Haïti", "Honduras", "Hongrie", "Inde", "Indonésie", "Iran", "Iraq",
            "Irlande", "Islande", "Israël", "italie", "Jamaïque", "Japon", "Jordanie", "Kazakhstan", "Kenya",
            "Kirghizistan", "Kiribati", "Koweït", "Laos", "Lesotho", "Lettonie", "Liban", "Liberia", "Liechtenstein",
            "Lituanie", "Luxembourg", "Lybie", "Macédoine", "Madagascar", "Malaisie", "Malawi", "Maldives", "Mali",
            "Malte", "Maroc", "Marshall", "Maurice", "Mauritanie", "Mexique", "Micronésie", "Moldavie", "Monaco",
            "Mongolie", "Mozambique", "Namibie", "Nauru", "Nepal", "Nicaragua", "Niger", "Nigéria", "Nioué", "Norvège",
            "Nouvelle Zélande", "Oman", "Ouganda", "Ouzbékistan", "Pakistan", "Palau", "Palestine", "Panama",
            "Papouasie Nouvelle Guinée", "Paraguay", "Pays-Bas", "Pérou", "Philippines", "Pologne", "Portugal", "Qatar",
            "République centrafricaine", "République Dominicaine", "République Tchèque", "Roumanie", "Royaume Uni",
            "Russie", "Rwanda", "Saint-Christophe-et-Niévès", "Sainte-Lucie", "Saint-Marin",
            "Saint-Vincent-et-les Grenadines", "Iles Salomon", "Salvador", "Samoa Occidentales", "Sao Tomé et Principe",
            "Sénégal", "Serbie", "Seychelles", "Sierra Léone", "Singapour", "Slovaquie", "Slovénie", "Somalie",
            "Soudan", "Sri Lanka", "Suède", "Suisse", "Suriname", "Swaziland", "Syrie", "Tadjikistan", "Taiwan",
            "Tanzanie", "Tchad", "Thailande", "Timor Oriental", "Togo", "Tonga", "Trinité et Tobago", "Tunisie",
            "Turkménistan", "Turquie", "Tuvalu", "Ukraine", "Uruguay", "Vanuatu", "Vatican", "Vénézuela", "Vietnam",
            "Yemen", "Zambie", "Zimbabwe"
        ]
        /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
        autocomplete(document.getElementById("pays"), countries);
    </script>

@endsection
