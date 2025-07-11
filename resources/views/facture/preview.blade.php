@extends('layouts.app')

@section('title', 'Prévisualisation de la facture')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('facture.index') }}">Factures</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('facture.create') }}">Créer</a></li>
                        <li class="breadcrumb-item active">Prévisualisation</li>
                    </ol>
                </div>
                <h4 class="page-title">Prévisualisation de la facture</h4>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible text-center border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible text-center border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ session('error') }}</strong>
        </div>
    @endif

    <!-- Message informatif sur la sauvegarde des données -->
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <i class="mdi mdi-information-outline me-1"></i>
        <strong>Prévisualisation :</strong> Vos données sont sauvegardées temporairement. 
        Vous pouvez revenir à la modification pour les ajuster si nécessaire.
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title mb-0">
                            <i class="mdi mdi-eye me-1"></i> Aperçu de la facture
                        </h4>
                        <div class="btn-group" role="group">
                           
                            <a href="{{ $pdfUrl }}" class="btn btn-outline-info btn-sm" target="_blank">
                                <i class="mdi mdi-download me-1"></i> Télécharger
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-end align-items-center">
                                
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('facture.create') }}?restore_preview=1" class="btn btn-secondary">
                                            <i class="mdi mdi-arrow-left me-1"></i> Revenir à la modification
                                        </a>
                                        <form action="{{ route('facture.preview.validate') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="mdi mdi-check me-1"></i> Valider et créer la facture
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <!-- PDF Viewer -->
                    <div class="pdf-container" style="height: 800px; overflow: hidden;">
                        <iframe 
                            src="{{ $pdfUrl }}" 
                            width="100%" 
                            height="100%" 
                            frameborder="0"
                            style="border: none;">
                        </iframe>
                    </div>
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

    // Confirmation avant validation
    $('form[action*="validate"]').on('submit', function(e) {
        if (!confirm('Êtes-vous sûr de vouloir créer cette facture ?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
@endsection 