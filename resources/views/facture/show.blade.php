@extends('layouts.app')

@section('title', 'Facture ' . $facture->numero)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('facture.index') }}">Factures</a></li>
                        <li class="breadcrumb-item active">Facture {{ $facture->numero }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Facture {{ $facture->numero }}</h4>
            </div>
        </div>
    </div>
    <!-- retourner vers la page des factures -->
    <div class="row">
        <div class="col-12">
            <a href="{{ route('facture.index') }}" class="btn btn-primary">
                <i class="mdi mdi-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title mb-0">
                            <i class="mdi mdi-file-document me-1"></i> Facture {{ $facture->numero }}
                        </h4>
                        <div class="btn-group" role="group">
                     
                            @if($facture->url_pdf)
                                <a href="{{ asset('storage/' . $facture->url_pdf) }}" class="btn btn-outline-info btn-sm" target="_blank">
                                    <i class="mdi mdi-download me-1"></i> Télécharger
                                </a>
                            @endif
                        
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Informations de la facture -->
                    <div class="p-3 border-bottom bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-2">Informations de la facture</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">Numéro :</small><br>
                                        <strong>{{ $facture->numero }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Date :</small><br>
                                        <strong>{{ $facture->date->format('d/m/Y') }}</strong>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <small class="text-muted">Type :</small><br>
                                        <strong>{{ ucfirst($facture->type) }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Statut de paiement:</small><br>
                                        <span class="badge bg-{{ $facture->statut_paiement === 'payée' ? 'success' : 'warning' }}">
                                            {{ ucfirst($facture->statut_paiement) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-2">Montants</h6>
                                <div class="row">
                                    <div class="col-4">
                                        <small class="text-muted">HT :</small><br>
                                        <strong>{{ number_format($facture->montant_ht, 2, ',', ' ') }} €</strong>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted">TVA :</small><br>
                                        <strong>{{ number_format($facture->montant_tva, 2, ',', ' ') }} €</strong>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted">TTC :</small><br>
                                        <strong class="text-primary">{{ number_format($facture->montant_ttc, 2, ',', ' ') }} €</strong>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    {{-- <div class="col-6">
                                        <small class="text-muted">Net à payer :</small><br>
                                        <strong class="text-success">{{ number_format($facture->net_a_payer, 2, ',', ' ') }} €</strong>
                                    </div> --}}
                                    <div class="col-6">
                                        <small class="text-muted">Reste à payer :</small><br>
                                        <strong class="text-{{ $facture->montant_restant_a_payer > 0 ? 'danger' : 'success' }}">
                                            {{ number_format($facture->montant_restant_a_payer, 2, ',', ' ') }} €
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PDF Viewer -->
                    @if($facture->url_pdf)
                        <div class="pdf-container" style="height: 600px; overflow: hidden;">
                            <iframe 
                                src="{{ asset('storage/' . $facture->url_pdf) }}" 
                                width="100%" 
                                height="100%" 
                                frameborder="0"
                                style="border: none;">
                            </iframe>
                        </div>
                    @else
                        <div class="p-5 text-center">
                            <i class="mdi mdi-file-pdf-outline" style="font-size: 4rem; color: #dc3545;"></i>
                            <h5 class="mt-3">Aucun PDF disponible</h5>
                            <p class="text-muted">Le PDF de cette facture n'a pas encore été généré.</p>
                            <a href="{{ route('facture.edit', Crypt::encrypt($facture->id)) }}" class="btn btn-primary">
                                <i class="mdi mdi-pencil me-1"></i> Modifier la facture
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn-group, .page-title-box, .card-header, .card-footer {
        display: none !important;
    }
    .pdf-container {
        height: 100vh !important;
    }
}

.pdf-container {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
}

.pdf-container iframe {
    background: white;
}
</style>

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-resize du PDF container
    function resizePdfContainer() {
        var windowHeight = $(window).height();
        var offset = $('.pdf-container').offset().top;
        var padding = 100; // Espace pour les boutons et marges
        var newHeight = windowHeight - offset - padding;
        $('.pdf-container').height(Math.max(600, newHeight));
    }

    $(window).resize(resizePdfContainer);
    resizePdfContainer();
});
</script>
@endpush
@endsection 