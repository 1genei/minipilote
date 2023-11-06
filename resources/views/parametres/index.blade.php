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
                                <a href="#application" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
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
                                $societes = [];
                                if ($principalSociete) {
                                    $societes[] = $principalSociete;
                                }
                                $societes = array_merge($societes, $activeSocietes, $archivedSocietes);
                            @endphp
                            <div class="tab-pane show active" id="societes">

                                <div class="row mt-1 mb-2">
                                    <div class="col-sm-5">
                                        <a href="#add-societe" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                            data-bs-target="#standard-modal-societe"><i
                                                class="mdi mdi-plus-circle me-2"></i> Nouvelle société</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        @if (session('message'))
                                            <div class="alert alert-success text-secondary alert-dismissible ">
                                                <i class="dripicons-checkmark me-2"></i>
                                                <a href="#" class="close" data-dismiss="alert"
                                                    aria-label="close">&times;</a>
                                                <a href="#" class="alert-link"><strong>
                                                        {{ session('message') }}</strong></a>
                                            </div>
                                        @endif
                                        @if ($errors->has('societe'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
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
                                            @foreach ($societes as $societe)
                                                <option
                                                    value="{{ route('societe.principale', Crypt::encrypt($societe->id)) }}"
                                                    {{ $societe->est_societe_principale ? 'selected' : '' }}>
                                                    {{ $societe->est_societe_principale ? $societe->raison_sociale . ' (principale)' : ($societe->archive ? $societe->raison_sociale . ' (archivée)' : $societe->raison_sociale) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button id="modif-principale" class="btn btn-primary mt-2">Modifier</button>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($societes as $index => $societe)
                                        @if (!$societe->est_societe_principale)
                                            <div class="col-12 my-3">
                                                <div style="border-top: 3px solid black; margin-top: 1rem;"></div>
                                            </div>
                                        @endif
                                        @include('parametres.societes', ['index' => $index])
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
    @include('components.contact.add_script')


    <script>
        // document.getElementById("add_browse_button").addEventListener("click", function() {
        //     document.getElementById("add_logo_file").click();
        // });
    </script>
    <script>
        const societes = @json($societes);
        const myForms = [];
        const saveButtons = [];
        const cancelButtons = [];
        const originalDatas = [];
        for (let i = 0; i < societes.length; i++) {
            document.getElementById(`edit-browse-button-${i}`).addEventListener("click", function() {
                document.getElementById(`edit-logo-file-${i}`).click();
            });

            myForms.push(document.getElementById(`edit-form-${i}`));
            saveButtons.push(document.getElementById(`save-button-${i}`));
            cancelButtons.push(document.getElementById(`cancel-button-${i}`));
            originalDatas.push(societes[i]);

            for (const field in originalDatas[i]) {
                if (myForms[i][field]) {
                    myForms[i][field].value = originalDatas[i][field];
                }
            }

            myForms[i].addEventListener('input', function() {
                saveButtons[i].removeAttribute('disabled');
                cancelButtons[i].removeAttribute('disabled');
            });

            cancelButtons[i].addEventListener('click', function() {
                for (const field in originalDatas[i]) {
                    if (myForms[i][field]) {
                        myForms[i][field].value = originalDatas[i][field];
                    }
                }
                saveButtons[i].setAttribute('disabled', true);
            });
        }
    </script>

    <script>
        // Société principale
        $(function() {
            const select = document.getElementById('principale-id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#modif-principale').click(function() {

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Changer la société principale',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: select.value,
                            type: 'POST',
                            success: function(data) {},
                            error: function(data) {}
                        }).done(function() {
                            swalWithBootstrapButtons.fire(
                                'Confirmation',
                                'Société principale changée avec succès',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    document.location.reload();
                                }
                            });
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Modification annulée',
                            'error'
                        );
                    }
                });
            });
        });
    </script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('submit', 'form.edit-societe', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Modifier la société',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                            url: that.attr('action'),
                            type: 'POST',
                            data: that.serialize(),
                            success: function(data) {},
                            error: function(data) {
                                console.log(data);
                            }
                        }).done(function() {
                            swalWithBootstrapButtons.fire(
                                'Confirmation',
                                'Société modifiée avec succès',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    document.location.reload();
                                }
                            });
                        });
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Modification annulée',
                            'error'
                        )
                    }
                });
            })

        });
    </script>


@endsection
