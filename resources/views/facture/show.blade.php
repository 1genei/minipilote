@extends('layouts.app')

@section('title', 'Facture ' . $facture->numero)

@section('content')
<div class="content">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('facture.index') }}">Factures</a></li>
                        <li class="breadcrumb-item active">{{ $facture->numero }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Facture {{ $facture->numero }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @if (session('success'))
        <div class="alert alert-success alert-dismissible text-center border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <div class="row">
        <!-- Informations principales -->
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">
                    <h4 class="mb-0 mt-2">
                        {{ $facture->numero }}
                        <span class="badge bg-{{ $facture->type === 'client' ? 'success' : ($facture->type === 'fournisseur' ? 'warning' : 'info') }}">
                            {{ ucfirst($facture->type) }}
                        </span>
                        <a href="{{ route('facture.edit', Crypt::encrypt($facture->id)) }}" class="text-muted">
                            <i class="mdi mdi-square-edit-outline ms-2"></i>
                        </a>
                    </h4>
                    <p class="text-muted mt-2">{{ \Carbon\Carbon::parse($facture->date)->format('d/m/Y') }}</p>

                    <div class="text-start mt-3">
                        <h5 class="text-muted mb-2">Description :</h5>
                        <p class="text-muted mb-3">{{ $facture->description ?: 'Aucune description' }}</p>
                    </div>

                    @if($facture->notes)
                        <div class="text-start mt-3">
                            <h5 class="text-muted mb-2">Notes :</h5>
                            <p class="text-muted mb-3">{{ $facture->notes }}</p>
                        </div>
                    @endif

                    <!-- Informations du client/fournisseur -->
                    @if($facture->client)
                        <h5 class="header-title">Client : 
                            <span class="text-muted">
                                @if($facture->client->type === 'individu')
                                    {{ $facture->client->individu->nom }} {{ $facture->client->individu->prenom }}
                                @else
                                    {{ $facture->client->entite->raison_sociale }}
                                @endif
                            </span>
                        </h5>
                    @endif

                    @if($facture->fournisseur)
                        <h5 class="header-title">Fournisseur : 
                            <span class="text-muted">
                                @if($facture->fournisseur->type === 'individu')
                                    {{ $facture->fournisseur->individu->nom }} {{ $facture->fournisseur->individu->prenom }}
                                @else
                                    {{ $facture->fournisseur->entite->raison_sociale }}
                                @endif
                            </span>
                        </h5>
                    @endif

                    @if($facture->numero_origine)
                        <h5 class="header-title">Numéro origine : 
                            <span class="text-muted">{{ $facture->numero_origine }}</span>
                        </h5>
                    @endif
                </div>
            </div>

            <!-- Statut et actions -->
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Statut</h4>
                    
                    <div class="mb-3">
                        <label class="form-label">Statut de la facture</label>
                        <div>
                            @php
                                $statutBadges = [
                                    'brouillon' => 'secondary',
                                    'envoyee' => 'info',
                                    'payee' => 'success',
                                    'annulee' => 'danger'
                                ];
                                $statutLabels = [
                                    'brouillon' => 'Brouillon',
                                    'envoyee' => 'Envoyée',
                                    'payee' => 'Payée',
                                    'annulee' => 'Annulée'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statutBadges[$facture->statut] ?? 'secondary' }}">
                                {{ $statutLabels[$facture->statut] ?? $facture->statut }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Statut de paiement</label>
                        <div>
                            @php
                                $paiementBadges = [
                                    'payée' => 'success',
                                    'partiellement payée' => 'warning',
                                    'attente paiement' => 'danger'
                                ];
                                $paiementLabels = [
                                    'payée' => 'Payée',
                                    'partiellement payée' => 'Partiellement payée',
                                    'attente paiement' => 'Attente paiement'
                                ];
                            @endphp
                            <span class="badge bg-{{ $paiementBadges[$facture->statut_paiement] ?? 'secondary' }}">
                                {{ $paiementLabels[$facture->statut_paiement] ?? $facture->statut_paiement }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-grid gap-2">
                        @if($facture->type === 'client')
                            <a href="{{ route('facture.pdf', Crypt::encrypt($facture->id)) }}" class="btn btn-primary">
                                <i class="mdi mdi-file-pdf me-1"></i> Générer PDF
                            </a>
                        @endif
                        
                        @if($facture->statut_paiement !== 'payee')
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paiement-modal">
                                <i class="mdi mdi-cash me-1"></i> Enregistrer un paiement
                            </button>
                        @endif

                        @if($facture->url_image)
                            <a href="{{ Storage::url($facture->url_image) }}" target="_blank" class="btn btn-info">
                                <i class="mdi mdi-file-image me-1"></i> Voir le fichier
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Détails financiers -->
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                        <li class="nav-item">
                            <a href="#montants" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                Montants
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#paiements" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                Paiements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#details" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                Détails
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Montants -->
                        <div class="tab-pane show active" id="montants">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h3 class="text-primary">{{ number_format($facture->montant_ht, 2, ',', ' ') }} €</h3>
                                            <p class="text-muted mb-0">Montant HT</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h3 class="text-info">{{ number_format($facture->montant_tva, 2, ',', ' ') }} €</h3>
                                            <p class="text-muted mb-0">TVA</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h3>{{ number_format($facture->montant_ttc, 2, ',', ' ') }} €</h3>
                                            <p class="mb-0">Montant TTC</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h3>{{ number_format($facture->montant_restant_a_payer, 2, ',', ' ') }} €</h3>
                                            <p class="mb-0">Reste à payer</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>

                        <!-- Paiements -->
                        <div class="tab-pane" id="paiements">
                            @if(count($facture->paiements) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Montant</th>
                                                <th>Mode de paiement</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($facture->paiements as $paiement)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($paiement['date'])->format('d/m/Y') }}</td>
                                                    <td>{{ number_format($paiement['montant'], 2, ',', ' ') }} €</td>
                                                    <td>{{ $paiement['mode'] ?? 'Non spécifié' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-success">
                                                <th colspan="2">Total payé</th>
                                                <th>{{ number_format($facture->montantPaye(), 2, ',', ' ') }} €</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="mdi mdi-cash-multiple text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2">Aucun paiement enregistré</p>
                                </div>
                            @endif
                        </div>

                        <!-- Détails -->
                        <div class="tab-pane" id="details">
                            @if($facture->palier && is_array($facture->palier))
                                <h5>Lignes de la facture</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Quantité</th>
                                                <th>Prix unitaire</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($facture->palier as $ligne)
                                                <tr>
                                                    <td>{{ $ligne['description'] ?? $ligne['nom'] ?? 'N/A' }}</td>
                                                    <td>{{ $ligne['quantite'] ?? 1 }}</td>
                                                    <td>{{ number_format($ligne['prix_unitaire'] ?? 0, 2, ',', ' ') }} €</td>
                                                    <td>{{ number_format($ligne['total'] ?? 0, 2, ',', ' ') }} €</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Aucun détail disponible</p>
                            @endif

                            @if($facture->commandes_liees)
                                <h5 class="mt-4">Commandes liées</h5>
                                <div class="list-group">
                                    @foreach($facture->commandesLiees() as $commande)
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Commande N°{{ $commande->numero_commande }}</h6>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') }}</small>
                                                </div>
                                                <span class="badge bg-primary">{{ number_format($commande->montant_ttc, 2, ',', ' ') }} €</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour enregistrer un paiement -->
<div class="modal fade" id="paiement-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enregistrer un paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('facture.marquer-payee', Crypt::encrypt($facture->id)) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant</label>
                        <input type="number" step="0.01" class="form-control" id="montant" name="montant" 
                               value="{{ $facture->montant_restant_a_payer }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="mode_paiement" class="form-label">Mode de paiement</label>
                        <select class="form-select" id="mode_paiement" name="mode_paiement" required>
                            <option value="">Sélectionner</option>
                            <option value="cheque">Chèque</option>
                            <option value="virement">Virement</option>
                            <option value="carte">Carte bancaire</option>
                            <option value="especes">Espèces</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_paiement" class="form-label">Date de paiement</label>
                        <input type="date" class="form-control" id="date_paiement" name="date_paiement" 
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Enregistrer le paiement</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 