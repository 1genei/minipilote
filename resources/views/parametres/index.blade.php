@extends('layouts.app')
@section('css')
@endsection

@section('title', 'Paramètres')

@section('content')
    <div class="content">
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

                        </div>
                    </div>
                </div>
            </div> 
        </div>

        <div class="row">

            <div class="col-12 ">
                <div class="card">
                    <div class="card-body">

                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#societes" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0 active">
                                    <i class="mdi mdi-domain font-18"></i>
                                    <span class="d-none d-lg-block">Sociétés</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#application" data-bs-toggle="tab" aria-expanded="true"
                                    class="nav-link rounded-0">
                                    <i class="mdi mdi-application-cog font-18"></i>
                                    <span class="d-none d-lg-block">Application</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            @php
                                $principalSociete = null;
                                $activeSocietes = [];
                                $archivedSocietes = [];

                                foreach ($societes as $societe) {
                                    if ($societe->est_societe_principale) {
                                        $principalSociete = $societe;
                                    } elseif (!$societe->archive) {
                                        $activeSocietes[] = $societe;
                                    } else {
                                        $archivedSocietes[] = $societe;
                                    }
                                }
                            @endphp
                            <div class="tab-pane show active" id="societes">

                                <div class="row mt-1 mb-2">
                                    <div class="col-sm-5">
                                        <a href="#add-societe" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                            data-bs-target="#standard-modal-societe"><i class="mdi mdi-plus-circle me-2"></i> Nouvelle société</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        @if (session('message'))
                                            <div class="alert alert-success text-secondary alert-dismissible ">
                                                <i class="dripicons-checkmark me-2"></i>
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <a href="#" class="alert-link"><strong> {{ session('message') }}</strong></a>
                                            </div>
                                        @endif
                                        @if ($errors->has('societe'))
                                            <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                    <strong>{{ $errors->first('societe') }}</strong>
                                                </div>
                                            </br>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 my-2">
                                        <label for="principale-id">Société principale :</label>
                                        <select class="form-select w-50" id="principale-id">
                                            @if ($principalSociete)
                                            <option value="{{ $principalSociete->id }}" {{ $societe->est_societe_principale ? 'selected' : '' }}>
                                                {{ $principalSociete->raison_sociale.' (principale)' }}
                                            </option>
                                            @endif
                                            @foreach ($activeSocietes as $societe)
                                            <option value="{{ $societe->id }}">
                                                {{ $societe->raison_sociale }}
                                            </option>
                                            @endforeach
                                            @foreach ($archivedSocietes as $societe)
                                            <option value="{{ $societe->id }}">
                                                {{ $societe->raison_sociale.' (archivée)' }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <button id="modif-principale" class="btn btn-primary mt-2" disabled>Modifier</button>
                                    </div>
                                </div>
                                <div class="row">
                                @if ($principalSociete)
                                    @include('parametres.societes', ['societe' => $principalSociete])
                                @endif

                                @foreach ($activeSocietes as $societe)
                                    <div class="col-12 my-3">
                                        <div style="border-top: 3px solid black; margin-top: 1rem;"></div>
                                    </div>
                                    @include('parametres.societes')
                                @endforeach

                                @foreach ($archivedSocietes as $societe)
                                    <div class="col-12 my-3">
                                        <div style="border-top: 3px solid black; margin-top: 1rem;"></div>
                                    </div>
                                @include('parametres.societes')
                                @endforeach
                                </div>
                            </div>

                            <div class="tab-pane" id="application">
                                <div class="row">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>

    @include('parametres.societe')

@endsection

@section('script')
    <script>
        const select = document.getElementById('principale-id');
        const button = document.getElementById('modif-principale');

        let initialSelectedValue = select.value;

        select.addEventListener('change', function () {
            if (select.value !== initialSelectedValue) {
                button.removeAttribute('disabled');
            } else {
                button.setAttribute('disabled', true);
            }
        });
    </script>
    <script>
        document.getElementById("add_browse_button").addEventListener("click", function () {
            document.getElementById("add_logo_file").click();
        });
    </script>
    <script>
        document.getElementById("edit_browse_button").addEventListener("click", function () {
            document.getElementById("edit_logo_file").click();
        });

        const myForm = document.getElementById('edit-form');
        const saveButton = document.getElementById('save-button');
        const cancelButton = document.getElementById('cancel-button');
        const originalData = {!! json_encode($societe) !!};

        for (const field in originalData) {
            if (myForm[field]) {
                myForm[field].value = originalData[field];
            }
        }

        myForm.addEventListener('input', function () {
            saveButton.removeAttribute('disabled');
            cancelButton.removeAttribute('disabled');
        });

        cancelButton.addEventListener('click', function () {
            for (const field in originalData) {
                if (myForm[field]) {
                    myForm[field].value = originalData[field];
                }
            }
            saveButton.setAttribute('disabled', true);
    });
    </script>
@endsection
