@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="content">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('parametre.index') }}">Paramètres</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('parametre.planning.index') }}">Modèles de planning</a></li>
                        <li class="breadcrumb-item active">Archives</li>
                    </ol>
                </div>
                <h4 class="page-title">Modèles de planning archivés</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Alert -->
    <div class="row">
        <div class="col-12">
            @if (session('ok'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('ok') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <a href="{{ route('parametre.planning.index') }}" class="btn btn-light mb-2">
                                <i class="mdi mdi-arrow-left me-1"></i> Retour aux modèles actifs
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap" id="modeles-archives-datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Circuit</th>
                                    <th>Horaires</th>
                                    <th>Sessions</th>
                                    <th>Pause</th>
                           
                                    <th style="width: 85px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modeles as $modele)
                                <tr>
                                    <td>{{ $modele->nom }}</td>
                                    <td>{{ $modele->circuit?->nom }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($modele->heure_debut)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($modele->heure_fin)->format('H:i') }}
                                    </td>
                                    <td>
                                        {{ $modele->duree_session }}min 
                                        ({{ $modele->nb_creneau_par_session }} créneaux)
                                    </td>
                                    <td>
                                        @if($modele->a_pause)
                                            {{ \Carbon\Carbon::parse($modele->heure_debut_pause)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($modele->heure_fin_pause)->format('H:i') }}
                                        @else
                                            Non
                                        @endif
                                    </td>
                             
                                    <td class="table-action">
                                        <button type="button" class="btn btn-success btn-sm restore-model"
                                                data-model-id="{{ $modele->id }}">
                                            <i class="mdi mdi-restore"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>

<script>
$(document).ready(function() {
    // Initialisation de la DataTable
    $('#modeles-archives-datatable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        }
    });

    // Gestion de la restauration
    $('.restore-model').click(function() {
        const modelId = $(this).data('model-id');
        
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Voulez-vous restaurer ce modèle de planning ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, restaurer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/parametres/planning/${modelId}/restaurer`;
            }
        });
    });
});
</script>
@endsection 