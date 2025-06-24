@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/css/vendor/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .planning-container {
        display: flex;
        gap: 20px;
        padding: 20px;
        height: calc(100vh - 100px);
    }

    .commandes-list {
        flex: 0 0 350px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        overflow-y: auto;
    }

    .planning-grid {
        flex: 1;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        overflow-x: auto;
    }

    .commande-card {
        padding: 15px;
        margin: 10px;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 4px solid #727cf5;
    }

    .produit-item {
        margin: 8px 0;
        padding: 8px;
        background: #fff;
        border-radius: 4px;
        border: 1px solid #e3e3e3;
        cursor: move;
        transition: all 0.2s;
    }

    .produit-item:hover {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transform: translateY(-1px);
    }

    .planning-header {
        display: flex;
        padding: 10px;
        border-bottom: 1px solid #e3e3e3;
        position: sticky;
        top: 0;
        background: #fff;
        z-index: 10;
    }

    .time-slot {
        flex: 0 0 120px;
        text-align: center;
        padding: 5px;
        font-weight: 500;
    }

    .planning-body {
        display: flex;
    }

    .time-column {
        flex: 0 0 120px;
        min-height: 400px;
        border-right: 1px solid #e3e3e3;
        position: relative;
    }

    .time-cell {
        height: 40px;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s;
    }

    .time-cell:hover {
        background: #f8f9fa;
    }

    .time-cell.droppable {
        background: #e8f0fe;
    }

    .planning-event {
        position: absolute;
        left: 5px;
        right: 5px;
        background: #727cf5;
        color: #fff;
        padding: 5px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 5;
        cursor: pointer;
        transition: all 0.2s;
    }

    .planning-event:hover {
        transform: scale(1.02);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .beneficiaire-tag {
        display: inline-block;
        padding: 2px 8px;
        background: #cfd4ee;
        border-radius: 12px;
        font-size: 12px;
        margin-left: 8px;
    }

    .search-box {
        padding: 15px;
        border-bottom: 1px solid #e3e3e3;
    }

    .commande-numero {
        font-weight: 600;
        color: #6c757d;
        font-size: 14px;
    }

    .empty-message {
        text-align: center;
        padding: 20px;
        color: #6c757d;
    }

    .planning-scroll-x {
        overflow-x: auto;
        width: 100%;
    }
    table.planning-table {
        border-collapse: collapse;
        width: 100%;
        min-width: 1200px;
    }
    .planning-table th, .planning-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }
    .planning-table th {
        background-color: #f0f0f0;
    }
    .hour-col {
        width: 60px;
        min-width: 60px;
    }
    .minute-col {
        width: 40px;
        min-width: 40px;
    }
    .car-col {
        min-width: 180px;
    }
    .prestation-cell.droppable {
        background: #f8fafd;
        min-width: 120px;
        transition: background 0.2s;
    }
    .prestation-cell.droppable.drag-over {
        background: #e3f2fd;
    }
    .produit-item[draggable="true"] {
        cursor: grab;
        background: #fff;
        border: 1.5px solid #727cf5;
        border-radius: 5px;
        margin-bottom: 5px;
        box-shadow: 0 2px 6px rgba(114,124,245,0.08);
        transition: box-shadow 0.2s, background 0.2s;
    }
    .produit-item.dragging {
        opacity: 0.5;
        box-shadow: 0 4px 12px rgba(114,124,245,0.25);
    }
    .planned-produit {
        background: #e3f0ff;
        border: 2px solid #3d73dd;
        color: #1a237e;
        border-radius: 6px;
        padding: 6px 10px;
        margin: 2px 0;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(61,115,221,0.10);
    }
</style>
@endsection

@section('content')
<div class="content">
    <!-- En-tête de la page -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <div class="d-flex">
                        <input type="date" class="form-control me-2" id="planning-date" value="{{ date('Y-m-d') }}">
                        <button type="button" class="btn btn-primary" id="refresh-planning">
                            <i class="mdi mdi-refresh me-1"></i> Actualiser
                        </button>
                    </div>
                </div>
                <h2 class="page-title">Plannifiez vos prestations</h2>
            </div>
        </div>
    </div>



    

    <div class="planning-container">
        <!-- Liste des commandes -->
        <div class="commandes-list">
            <div class="search-box">
                <input type="text" class="form-control" placeholder="Rechercher une commande..." id="search-commande">
            </div>
            
            @forelse($commandes as $commande)
                <div class="commande-card">
                    <div class="commande-numero">
                        Commande N°{{ $commande->numero_commande }}
                        @if($commande->client)
                            <small class="text-muted">
                                - {{ $commande->client->type == 'individu' ? 
                                    $commande->client->individu->nom . ' ' . $commande->client->individu->prenom :
                                    $commande->client->entite->raison_sociale }}
                            </small>
                        @endif
                    </div>
                    @foreach($commande->produits as $produit)
                        <div class="produit-item" 
                             draggable="true" 
                             data-produit-id="{{ $produit->id }}"
                             data-commande-id="{{ $commande->id }}"
                             data-beneficiaire-id="{{ $produit->pivot->beneficiaire_id ?? '' }}">
                            <div>{{ $produit->nom }}</div>
                            @if($produit->pivot->beneficiaire_id)
                                @php
                                    $beneficiaire = App\Models\Contact::find($produit->pivot->beneficiaire_id);
                                @endphp
                                @if($beneficiaire)
                                    <span class="beneficiaire-tag">
                                        {{ $beneficiaire->type == 'individu' ? 
                                            $beneficiaire->individu?->nom . ' ' . $beneficiaire->individu?->prenom :
                                            $beneficiaire->entite?->raison_sociale }}
                                    </span>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="empty-message">
                    <i class="mdi mdi-information-outline me-1"></i>
                    Aucune commande à afficher
                </div>
            @endforelse
        </div>

        <!-- Grille du planning -->
        @php
            $creneaux = [];
            for($hour=9; $hour<=12; $hour++) {
                foreach([0,20,40] as $minute) {
                    $creneaux[] = [
                        'hour' => $hour,
                        'minute' => sprintf('%02d', $minute)
                    ];
                }
            }
            $voitures = ['MITJET', 'BMW', 'GINETTA', 'AUDI'];
        @endphp
        <div class="planning-scroll-x">
            <table class="planning-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="hour-col" style="vertical-align:middle;">Heure</th>
                        <th rowspan="2" class="minute-col" style="vertical-align:middle;">Minute</th>
                        @foreach($voitures as $voiture)
                            <th colspan="2" class="car-col">Voiture {{ $voiture }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($voitures as $voiture)
                            <th style="width:120px">Instructeur</th>
                            <th>Prestation</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($creneaux as $i => $creneau)
                        <tr>
                            {{-- Affiche l'heure uniquement sur la première ligne du bloc d'une heure --}}
                            @if($i % 3 == 0)
                                <td rowspan="3" class="hour-col" style="vertical-align:middle;font-weight:bold;font-size:16px;">{{ $creneau['hour'] }}h</td>
                            @endif
                            <td class="minute-col">{{ $creneau['minute'] }}</td>
                            @foreach($voitures as $voiture)
                                <td class="instructeur-cell" data-voiture="{{ $voiture }}" data-hour="{{ $creneau['hour'] }}" data-minute="{{ $creneau['minute'] }}"></td>
                                <td class="prestation-cell droppable" data-voiture="{{ $voiture }}" data-hour="{{ $creneau['hour'] }}" data-minute="{{ $creneau['minute'] }}"></td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/planning.js') }}"></script>
<script>
// Drag & Drop de base
let dragged = null;

document.querySelectorAll('.produit-item[draggable="true"]').forEach(item => {
    item.addEventListener('dragstart', function(e) {
        dragged = this;
        this.classList.add('dragging');
    });
    item.addEventListener('dragend', function(e) {
        dragged = null;
        this.classList.remove('dragging');
    });
});

document.querySelectorAll('.prestation-cell.droppable').forEach(cell => {
    cell.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });
    cell.addEventListener('dragleave', function(e) {
        this.classList.remove('drag-over');
    });
    cell.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        if (dragged) {
            // On clone le produit pour garder l'original dans la liste
            let clone = dragged.cloneNode(true);
            clone.classList.add('planned-produit');
            clone.classList.remove('dragging');
            clone.setAttribute('draggable', 'false');
            this.appendChild(clone);
        }
    });
});
</script>
@endsection 