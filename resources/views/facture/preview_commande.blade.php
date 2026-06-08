@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Prévisualisation de la facture pour la commande N°{{ $commande->numero_commande }}</h2>
    <form method="POST" action="{{ route('facture.validateFromCommande') }}">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="numero" class="form-label">Numéro de facture</label>
                <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero', $factureData['numero']) }}" required>
            </div>
            <div class="col-md-4">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $factureData['date']) }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="2">{{ old('description', $factureData['description']) }}</textarea>
        </div>
        <div class="mb-3">
            <a href="{{ route('commande.show', Crypt::encrypt($commande->id)) }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-success">Valider la facture</button>
        </div>
    </form>
    <hr>
    <h4>Prévisualisation PDF</h4>
    <iframe src="{{ $pdfUrl }}" width="100%" height="700px" style="border:1px solid #ccc;"></iframe>
</div>
@endsection 