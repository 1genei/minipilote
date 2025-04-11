@extends('layouts.app')
@section('content')
<div class="content">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('utilisateur.index') }}">Utilisateurs</a></li>
                        <li class="breadcrumb-item active">Détails</li>
                    </ol>
                </div>
                <h4 class="page-title">Détails de l'utilisateur</h4>
            </div>
        </div>
    </div>

    <!-- Messages de succès et d'erreur -->
    <div class="row">
        <div class="col-12">
            @if (session('ok'))
                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><i class="dripicons-checkmark me-2"></i> {{ session('ok') }}</strong>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><i class="dripicons-wrong me-2"></i> {{ session('error') }}</strong>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </strong>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12" style="background:#7e7b7b; color:white!important; padding:10px">
                            <strong>Informations principales</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nom :</strong> {{ $user->contact->individu->nom }}</p>
                            <p><strong>Prénom :</strong> {{ $user->contact->individu->prenom }}</p>
                            <p><strong>Email :</strong> {{ $user->email }}</p>
                            <p><strong>Téléphone fixe :</strong> {{ $user->contact->individu->telephone_fixe }}</p>
                            <p><strong>Téléphone mobile :</strong> {{ $user->contact->individu->telephone_mobile }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Adresse :</strong> {{ $user->contact->individu->numero_voie }} {{ $user->contact->individu->nom_voie }}</p>
                            <p><strong>Complément :</strong> {{ $user->contact->individu->complement_voie }}</p>
                            <p><strong>Code postal :</strong> {{ $user->contact->individu->code_postal }}</p>
                            <p><strong>Ville :</strong> {{ $user->contact->individu->ville }}</p>
                            <p><strong>Pays :</strong> {{ $user->contact->individu->pays }}</p>
                        </div>
                    </div>

                    @if($user->contact->individu->notes)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label"><strong>Notes :</strong></label>
                                <p>{{ $user->contact->individu->notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-12" style="background:#7e7b7b; color:white!important; padding:10px">
                            <strong>Sécurité</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p>
                                <strong>Dernière connexion :</strong> 
                                @if($user->last_login_at)
                                    @php
                                        // Convertir en objet Carbon si c'est une chaîne et définir le fuseau horaire
                                        $lastLogin = is_string($user->last_login_at) 
                                            ? \Carbon\Carbon::parse($user->last_login_at)->setTimezone('Europe/Paris')
                                            : $user->last_login_at->setTimezone('Europe/Paris');
                                    @endphp
                                    {{ $lastLogin->format('d/m/Y à H:i') }}
                                    <small class="text-muted">
                                        ({{ $lastLogin->diffForHumans(['locale' => 'fr']) }})
                                    </small>
                                @else
                                    <span class="text-muted">Jamais connecté</span>
                                @endif
                            </p>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                <i class="mdi mdi-lock-reset"></i> Modifier le mot de passe
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ route('utilisateur.index') }}" class="btn btn-secondary">Retour</a>
                            <a href="{{ route('utilisateur.edit', Crypt::encrypt($user->contact_id)) }}" class="btn btn-primary">Modifier</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de modification du mot de passe -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Modification du mot de passe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('utilisateur.update-password', Crypt::encrypt($user->id)) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Affichage des erreurs spécifiques au formulaire de mot de passe -->
                    @if ($errors->has('password'))
                        <div class="alert alert-danger">
                            {{ $errors->first('password') }}
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="mdi mdi-information-outline me-1"></i>
                        Le nouveau mot de passe doit contenir au moins 8 caractères.
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" name="password" class="form-control" required>
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Modifier le mot de passe</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Fermer automatiquement les alertes après 5 secondes
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);

    // Script pour afficher/masquer le mot de passe
    document.querySelectorAll('.password-eye').forEach(function(eye) {
        eye.addEventListener('click', function(e) {
            const input = e.target.closest('.input-group').querySelector('input');
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            e.target.classList.toggle('show');
        });
    });
</script>
@endsection 