@extends('layouts.app')

@section('content')
<div class="content">
    <!-- En-tête de la page -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('commande.index') }}">Commandes</a></li>
                        <li class="breadcrumb-item active">Détails</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    Commande N° {{ $commande->numero_commande }}
                    <span class="badge bg-{{ $commande->statut_commande == 'Annulée' ? 'danger' : ($commande->statut_commande == 'Exécutée' ? 'success' : 'info') }}">
                        {{ $commande->statut_commande }}
                    </span>
                </h4>
            </div>
        </div>
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">

                        <div class="col-sm-2 ">
                            <a href="{{ URL::previous() }}" type="button" class="btn btn-outline-primary">
                                <i class="uil-arrow-left"></i>
                                Retour
                            </a>
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

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div>
    </div>



    <!-- Boutons d'action -->
    <div class="row mb-2">
        <div class="col-sm-8">
           
            <a href="{{ route('commande.edit', Crypt::encrypt($commande->id)) }}" class="btn btn-primary me-2">
                <i class="mdi mdi-pencil me-1"></i> Modifier
            </a>
            @can('permission', 'archiver-commande')
                @if(!$commande->archive)
                    <button class="btn btn-danger archive_commande"  data-href="{{ route('commande.archiver', Crypt::encrypt($commande->id)) }}">
                        <i class="mdi mdi-archive-arrow-down me-1"></i> Archiver la commande
                    </button>
                @else
                    <button class="btn btn-success desarchiver_commande" data-href="{{ route('commande.desarchiver', Crypt::encrypt($commande->id)) }}">
                        <i class="mdi mdi-archive-arrow-up me-1"></i> Désarchiver la commande
                    </button>
                @endif
            @endcan
            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#envoiEmailModal">
                <i class="mdi mdi-email-send me-1"></i> Envoyer par email
            </button>
            <a href="{{ route('commande.telecharger', Crypt::encrypt($commande->id)) }}" class="btn btn-info">
                <i class="mdi mdi-download me-1"></i> Télécharger PDF
            </a>
        </div>
        <div class="col-sm-4">
            <div class="card" style="background-color: rgb(88 96 133) !important">
                <div class="card-body" style="padding: 0.5rem 0.9rem;">
                    <div class="row align-items-center" style="font-size: 10px;">
                        <div class="col-7">
                            <h4 class="text-white mb-0">Montant TTC :</h4>
                        </div>
                        <div class="col-5 text-end">
                            <h3 class="text-white mb-0">{{ number_format($commande->net_a_payer, 2, ',', ' ') }} €</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Contenu principal -->
    <div class="row">
        <!-- Informations générales -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Informations générales</h4>
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row" width="35%">Date de commande :</th>
                                    <td>{{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Mode de paiement :</th>
                                    <td>{{ $commande->mode_paiement }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Statut paiement :</th>
                                    <td>
                                        <span class="badge bg-{{ $commande->statut_paiement == 'Payée' ? 'success' : ($commande->statut_paiement == 'Partiellement payée' ? 'warning' : 'danger') }}">
                                            {{ $commande->statut_paiement }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Date réalisation prévue :</th>
                                    <td>{{ $commande->date_realisation_prevue ? \Carbon\Carbon::parse($commande->date_realisation_prevue)->format('d/m/Y') : 'Non définie' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">TVA :</th>
                                    <td>{{ $commande->sans_tva ? 'Non applicable' : 'Applicable' }}</td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations client -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Client</h4>
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row" width="35%">Nom :</th>
                                    <td>
                                        @if($commande->client?->type == 'individu')
                                            {{ $commande->client?->individu->nom }} {{ $commande->client?->individu->prenom }}
                                        @else
                                            {{ $commande->client?->entite->raison_sociale }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Type :</th>
                                    <td>{{ $commande->client?->type }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations provenance -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Provenance</h4>
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row" width="35%">Source :</th>
                                    <td>{{ $commande->origine_commande ?: 'Non spécifiée' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">N° d'origine :</th>
                                    <td>{{ $commande->numero_origine ?: 'Non spécifié' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Date d'origine :</th>
                                    <td>{{ $commande->date_origine_commande ? \Carbon\Carbon::parse($commande->date_origine_commande)->format('d/m/Y') : 'Non spécifiée' }}</td>
                                </tr>
                                @if($commande->devi_id)
                                <tr>
                                    <th scope="row" class="text-primary">provenant du devis :</th>
                                    <td>
                                        <a href="{{ route('devis.show', Crypt::encrypt($commande->devi_id)) }}" class="text-primary" target="_blank" style="font-size: 16px;">
                                            n° {{ $commande->devi?->numero_devis }}
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des produits -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Produits commandés</h4>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire HT</th>
                                    <th>Remise</th>
                                    <th>TVA</th>
                                    <th>Montant HT</th>
                                    <th>Montant TTC</th>
                                    <th>Bénéficiaire</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commande->produits as $produit)
                                    <tr>
                                        <td>{{ $produit->nom }}</td>
                                        <td>{{ $produit->pivot->quantite }}</td>
                                        <td>{{ number_format($produit->pivot->prix_unitaire, 2, ',', ' ') }} €</td>
                                        <td>
                                            @if($produit->pivot->remise > 0)
                                                @if($produit->pivot->taux_remise)
                                                    {{ $produit->pivot->taux_remise }}%
                                                @else
                                                    {{ number_format($produit->pivot->remise, 2, ',', ' ') }} €
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $produit->pivot->taux_tva }}%</td>
                                        <td>{{ number_format($produit->pivot->montant_ht, 2, ',', ' ') }} €</td>
                                        <td>{{ number_format($produit->pivot->montant_ttc, 2, ',', ' ') }} €</td>
                                        <td>
                                            @if($produit->pivot->beneficiaire_id)
                                                @php 
                                                    $beneficiaire = App\Models\Contact::find($produit->pivot->beneficiaire_id);
                                                @endphp
                                                @if($beneficiaire->type == 'individu')
                                                    <span class="badge bg-info">{{ $beneficiaire->individu->nom }} {{ $beneficiaire->individu->prenom }}</span>
                                                @else
                                                    <span class="badge bg-success">{{ $beneficiaire->entite->raison_sociale }}</span>
                                                @endif
                                            @else
                                                -
                                            @endif
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

    <!-- Résumé financier -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Résumé financier</h4>
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row" width="50%">Total HT :</th>
                                    <td class="text-end">{{ number_format($commande->montant_ht, 2, ',', ' ') }} €</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total remises :</th>
                                    <td class="text-end text-danger">- {{ number_format($commande->montant_remise, 2, ',', ' ') }} €</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total TVA :</th>
                                    <td class="text-end">{{ number_format($commande->montant_tva, 2, ',', ' ') }} €</td>
                                </tr>
                                <tr class="border-top">
                                    <th scope="row"><h4 class="m-0">Net à payer :</h4></th>
                                    <td class="text-end"><h4 class="m-0">{{ number_format($commande->net_a_payer, 2, ',', ' ') }} €</h4></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Envoi Email -->
<div class="modal fade" id="envoiEmailModal" tabindex="-1" aria-labelledby="envoiEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="envoiEmailModalLabel">Envoyer la commande par email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('commande.envoyer_mail', Crypt::encrypt($commande->id)) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                            value="{{ $commande->client?->type == 'individu' ? $commande->client?->individu->email : $commande->client?->entite->email }}" 
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message (optionnel)</label>
                        <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
    @include('partials._sidebar_collapse')
   
    <script>
        // Archiver/Désarchiver une commande
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            
            // Archiver
            $('body').on('click', 'button.archive_commande', function(event) {
                event.preventDefault()
                
                const button = $(this)
                
                Swal.fire({
                    title: 'Archiver la commande',
                    text: "Êtes-vous sûr de vouloir archiver cette commande ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, archiver',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: button.data('href'),
                            type: 'POST',
                            success: function() {
                                window.location.href = "{{ route('commande.index') }}";
                            },
                            error: function() {
                                Swal.fire(
                                    'Erreur !',
                                    'Une erreur est survenue lors de l\'archivage.',
                                    'error'
                                )
                            }
                        })
                    }
                })
            })
            
            // Désarchiver
            $('body').on('click', 'button.desarchiver_commande', function(event) {
                event.preventDefault()
                
                const button = $(this)
                
                Swal.fire({
                    title: 'Désarchiver la commande',
                    text: "Êtes-vous sûr de vouloir désarchiver cette commande ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, désarchiver',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: button.data('href'),
                            type: 'POST',
                            success: function() {
                                window.location.href = "{{ route('commande.index') }}";
                            },
                            error: function() {
                                Swal.fire(
                                    'Erreur !',
                                    'Une erreur est survenue lors du désarchivage.',
                                    'error'
                                )
                            }
                        })
                    }
                })
            })
        })
    </script>
    
@endsection
