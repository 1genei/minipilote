@extends('layouts.app')

@section('title', 'Import des contacts')

@section('content')
<div class="content">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('contact.index') }}">Contacts</a></li>
                        <li class="breadcrumb-item active">Import</li>
                    </ol>
                </div>
                <h4 class="page-title">Import des contacts</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <a href="{{ route('contact.index') }}" class="btn btn-outline-primary">
                                <i class="uil-arrow-left"></i> Retour
                            </a>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-6">
                            <form action="{{ route('contact.import.process') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="csv_file" class="form-label">Fichier CSV</label>
                                    <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="mdi mdi-upload me-1"></i> Importer
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-6">
                            <div class="card border">
                                <div class="card-body">
                                    <h5 class="card-title">Format du fichier CSV</h5>
                                    <p class="card-text">Le fichier CSV doit contenir les colonnes suivantes :</p>
                                    <ul class="list-unstyled">
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>prénom</li>
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>nom</li>
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>entreprise</li>
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>site web entreprise</li>
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Email</li>
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>LinkedIn</li>
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>fonction</li>
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>région</li>
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>ville</li>
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Pays</li>
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>téléphone</li>
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Secteur d'activité</li>
                                        <li><i class="mdi mdi-check-circle text-success me-2"></i>nombre d'employé</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 