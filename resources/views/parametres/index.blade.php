@extends('layouts.app')
@section('css')
@endsection

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Paramètres</a></li>
                            {{-- <li class="breadcrumb-item active">Détails</li> --}}
                        </ol>
                    </div>
                    <h4 class="page-title">Paramètres</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->



        <!-- end row-->


        <div class="row">
            <div class="col-lg-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-4  mr-14 ">
                                {{-- <a href="{{route('action.index')}}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Retour</a> --}}
                                <h4 class="modal-title" id="addActionModalLabel"> Modification de vos paramètres </h4>

                            </div>
                            @if (session('ok'))
                                <div class="col-6">
                                    <div class="alert alert-success alert-dismissible bg-success text-white text-center border-0 fade show"
                                        role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong> {{ session('ok') }}</strong>
                                    </div>
                                </div>
                            @endif

                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->
        <div class="row">



            <div class="col-12 ">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('parametre.update') }}" method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    @csrf
                                    <fieldset class="form-group">
                                        <div class="row">
                                            <legend class="col-form-label col-sm-2 pt-0">Paramètres généraux</legend>
                                            <div class="col-xs-12 col-sm-6 col-lg-4 ">
                                                <div class="mb-3">
                                                    <label for="seuil_alerte" class="form-label">Nom de la société <i
                                                            data-bs-toggle="tooltip" title=""
                                                            class="text-danger uil-info-circle xl "></i> </label>
                                                    <input type="number" step="0.01" max="100" min="0"
                                                        class="form-control" name="seuil_alerte"
                                                        value="{{ old('seuil_alerte') ? old('seuil_alerte') : ($parametre != null ? $parametre->seuil_alerte : '') }}"
                                                        id="seuil_alerte" required>
                                                    @if ($errors->has('seuil_alerte'))
                                                        <br>
                                                        <div class="alert alert-danger" role="alert">
                                                            <i class="dripicons-wrong me-2"></i>
                                                            <strong>{{ $errors->first('nom') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <label for="heure_ouverture" class="form-label">Numéro TVA </label>
                                                    <input type="text" class="form-control" name="heure_ouverture"
                                                        value="{{ old('heure_ouverture') ? old('heure_ouverture') : ($parametre != null ? $parametre->heure_ouverture : '') }}"
                                                        id="heure_ouverture" required>
                                                    @if ($errors->has('heure_ouverture'))
                                                        <br>
                                                        <div class="alert alert-danger" role="alert">
                                                            <i class="dripicons-wrong me-2"></i>
                                                            <strong>{{ $errors->first('heure_ouverture') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>



                                            </div>
                                        </div>
                                    </fieldset>

                                    <hr style="color: rgb(45, 6, 103); height:5px; margin-bottom: 30px">


                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-light" href="{{ route('parametre.index') }}">Annuler</a>
                                    <button type="submit" class="btn btn-success">Modifier</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->




        </div> <!-- end row -->

        <style>
            .container {
                display: flex;

                flex-flow: row wrap;
                gap: 20px;

            }
        </style>


    </div> <!-- End Content -->
@endsection

@section('script')
@endsection
