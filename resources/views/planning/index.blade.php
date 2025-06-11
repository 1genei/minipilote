@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/css/vendor/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .planning-container {
        display: flex;
        gap: 20px;
        padding: 20px;
        height: calc(100vh - 150px);
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
        <div class="planning-grid">
            <div class="planning-header">
                @for($hour = 9; $hour <= 20; $hour++)
                    @for($minute = 0; $minute < 60; $minute += 20)
                        <div class="time-slot">
                            {{ sprintf('%02d:%02d', $hour, $minute) }}
                        </div>
                    @endfor
                @endfor
            </div>
            <div class="planning-body">
                @for($hour = 9; $hour <= 20; $hour++)
                    @for($minute = 0; $minute < 60; $minute += 20)
                        <div class="time-column">
                            <div class="time-cell" data-time="{{ sprintf('%02d:%02d', $hour, $minute) }}"></div>
                        </div>
                    @endfor
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/planning.js') }}"></script>
@endsection 