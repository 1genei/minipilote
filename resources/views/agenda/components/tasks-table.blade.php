<div class="row mb-3">
    <div class="col-sm-4">
        <form action="{{ $route }}" method="GET" class="search-form">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="mdi mdi-magnify"></i>
                </button>
                @if(request('search'))
                    <a href="{{ $route }}" class="btn btn-danger">
                        <i class="mdi mdi-close"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
    <div class="col-sm-8">
        <form action="{{ $route }}" method="GET" class="d-flex gap-2">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            
            <select name="type_rappel" class="form-select" style="width: auto" onchange="this.form.submit()">
                <option value="all">Tous les types</option>
                @foreach($types_rappel as $type)
                    <option value="{{ $type }}" {{ request('type_rappel') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>

            <select name="priorite" class="form-select" style="width: auto" onchange="this.form.submit()">
                <option value="all" {{ request('priorite') == 'all' ? 'selected' : '' }}>Toutes les priorités</option>
                <option value="basse" {{ request('priorite') == 'basse' ? 'selected' : '' }}>Priorité basse</option>
                <option value="moyenne" {{ request('priorite') == 'moyenne' ? 'selected' : '' }}>Priorité moyenne</option>
                <option value="haute" {{ request('priorite') == 'haute' ? 'selected' : '' }}>Priorité haute</option>
            </select>

            <select name="date_sort" class="form-select" style="width: auto" onchange="this.form.submit()">
                <option value="">Trier par date</option>
                <option value="asc" {{ request('date_sort') == 'asc' ? 'selected' : '' }}>Date ↑</option>
                <option value="desc" {{ request('date_sort') == 'desc' ? 'selected' : '' }}>Date ↓</option>
            </select>

            @if(request('priorite') || request('date_sort') || request('type_rappel'))
                <a href="{{ $route }}" 
                   class="btn btn-danger">
                    Réinitialiser les filtres
                </a>
            @endif
        </form>
    </div>
</div>



<div class="row">
    <div class="col-sm-8 text-sm-end">
        <div class="text-muted">
            Affichage de <span class="fw-semibold">{{ $agendas->firstItem() }}</span> 
            à <span class="fw-semibold">{{ $agendas->lastItem() }}</span> 
            sur <span class="fw-semibold">{{ $agendas->total() }}</span> tâches
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="media">


                <div style="display:flex; flex-direction: row; justify-content:space-around; ">

                    
                    <div class="media-left media-middle">
                        <i class="ti-list f-s-48 color-success m-r-1"></i>
                        <label for="">
                            <a style="font-weight: bold; color:#14893f"
                                href="{{ route('agenda.listing_a_faire') }}">Tâches à faire
                                <span
                                    class="badge bg-danger rounded-pill">{{ \App\Models\Agenda::nb_taches('a_faire') }}</span>
                            </a>
                            @if($route == route('agenda.listing_a_faire'))
                            <hr style="border-top: 5px solid #240c9a; margin-top: 10px">
                            @endif
                        </label>
                    </div>

                    <div class="media-left media-middle">
                        <i class="ti-list f-s-48 color-danger m-r-1"></i>
                        <label for="">
                            <a style="font-weight: bold; color:#8b0f06;"
                                href="{{ route('agenda.listing_en_retard') }}">Tâches en retard
                                <span
                                    class="badge bg-danger rounded-pill">{{ \App\Models\Agenda::nb_taches('en_retard') }}</span>
                            </a>
                        </label>
                        @if($route == route('agenda.listing_en_retard'))
                        <hr style="border-top: 5px solid #240c9a; margin-top: 10px">
                        @endif
                    </div>
                    
                    <div class="media-left media-middle">
                        <i class="ti-list f-s-48 color-primary m-r-1"></i>
                        <label for="">
                            <a style="font-weight: bold; color:#2483ac; font-size:18px"
                                href="{{ route('agenda.listing') }}">Toutes les tâches
                                <span
                                    class="badge bg-danger rounded-pill ">{{ \App\Models\Agenda::nb_taches('toutes') }}
                                </span>

                            </a>
                        </label>
                        @if($route == route('agenda.listing'))
                        <hr style="border-top: 5px solid #240c9a; margin-top: 10px">
                        @endif
                    </div>


                </div>

                <div class="col-lg-12">
                    <div class="card alert">

                        <div class="recent-comment ">



                            <div class="table-responsive">
                                <table class="table table-centered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="col-statut sortable">Statut</th>
                                            <th class="col-date sortable">Date & Heure</th>
                                            <th class="col-priorite sortable">Priorité</th>
                                            <th class="col-titre sortable">Titre & Description</th>
                                            <th class="col-contact sortable">Contact lié</th>
                                            @if(in_array(Auth::user()?->role?->nom, ['Admin', 'SuperAdmin']))
                                                <th class="col-assigne sortable">Assigné à</th>
                                            @endif
                                            <th class="col-actions">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agendas as $agenda)
                                            <tr>
                                                <td>
                                                    @if ($agenda->est_terminee)
                                                        <span class="badge bg-success-subtle text-success">Terminée</span>
                                                            @else
                                                        @if ($agenda->date_deb < date('Y-m-d'))
                                                            <span class="badge bg-danger-subtle text-danger">En retard</span>
                                                        @else
                                                            <span class="badge bg-warning-subtle text-warning">À faire</span>
                                                            @endif
                                                        @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="mdi mdi-calendar me-1 text-muted"></i>
                                                        <p class="mb-0">{{ \Carbon\Carbon::parse($agenda->date_deb)->format('d/m/Y') }}</p>
                                                    </div>
                                                    <div class="d-flex align-items-center mt-1">
                                                        <i class="mdi mdi-clock-outline me-1 text-muted"></i>
                                                        <p class="mb-0">{{ $agenda->heure_deb }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    @switch($agenda->priorite)
                                                        @case('haute')
                                                            <i class="mdi mdi-arrow-up-bold text-danger" data-bs-toggle="tooltip" title="Haute"></i>
                                                            @break
                                                        @case('moyenne')
                                                            <i class="mdi mdi-arrow-right-bold text-warning" data-bs-toggle="tooltip" title="Moyenne"></i>
                                                            @break
                                                        @default
                                                            <i class="mdi mdi-arrow-down-bold text-success" data-bs-toggle="tooltip" title="Basse"></i>
                                                    @endswitch
                                                        <span class="text-muted">{{ $agenda->priorite }}
                                                        </span>
                                                </td>

                                                <td>
                                                    @switch($agenda->type_rappel)
                                                        @case('rendez-vous')
                                                            <span class="badge bg-primary">
                                                                <i class="mdi mdi-calendar-clock me-1"></i> Rendez-vous
                                                            </span>
                                                            @break
                                                        @case('contacter')
                                                            <span class="badge bg-info">
                                                                <i class="mdi mdi-phone me-1"></i> À contacter
                                                            </span>
                                                            @break
                                                        @case('recontacter')
                                                            <span class="badge bg-warning">
                                                                <i class="mdi mdi-phone-return me-1"></i> À recontacter
                                                            </span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary">
                                                                <i class="mdi mdi-checkbox-marked-circle-outline me-1"></i> Autre
                                                            </span>
                                                    @endswitch

                                                    <h6 class="mb-1 mt-2">{{ $agenda->titre }}</h6>
                                                    <p class="text-muted mb-0">{{ $agenda->description }}</p>
                                                </td>

                                                <td>
                                                    @if ($agenda->est_lie && $agenda->contact)
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <i class="mdi mdi-account-circle text-muted font-14"></i>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2">
                                                                
                                                                <a href="{{ route('contact.show', Crypt::encrypt($agenda->contact->id)) }}">
                                                                <h6 class="mt-0 mb-1">
                                                                    @if ($agenda->contact->type == 'individu' && $agenda->contact->individu)
                                                                        {{ $agenda->contact->individu->nom }} {{ $agenda->contact->individu->prenom }}
                                                                    @elseif($agenda->contact->type == 'entite' && $agenda->contact->entite)
                                                                        {{ $agenda->contact->entite->raison_sociale }}
                                                                    @else
                                                                        Contact #{{ $agenda->contact->id }}
                                                                    @endif
                                                                </h6>
                                                                </a>
                                                                <p class="text-muted mb-0">
                                                                    <i class="mdi mdi-phone me-1"></i>
                                                                    {{ $agenda->contact->individu?->telephone_mobile ?? 'Non renseigné' }}
                                                                </p>
                                                                <p class="text-muted mb-0">
                                                                    <i class="mdi mdi-email me-1"></i>
                                                                    {{ $agenda->contact->individu?->email ?? 'Non renseigné' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Aucun contact lié</span>
                                                    @endif
                                                </td>
                                                @if(in_array(Auth::user()?->role?->nom, ['Admin', 'SuperAdmin']))
                                                <td>
                                                    @if ($agenda->user)
                                                        <div class="d-flex align-items-center">
                                                           
                                                            <div class="flex-grow-1 ms-2">
                                                                <h6 class="mt-0 mb-1">
                                                                    {{ $agenda->user->contact?->individu?->prenom ?? '' }}
                                                                    {{ $agenda->user->contact?->individu?->nom ?? '' }}
                                                                </h6>
                                                                <p class="text-muted mb-0">
                                                                    {{ $agenda->user->role?->nom ?? 'Rôle non défini' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Non assigné</span>
                                                    @endif
                                                </td>

                                                @endif

                                                <td class="table-action">
                                                    @can('permission', 'modifier-agenda')
                                                        <a href="javascript:void(0);" 
                                                           class="action-icon modifier" 
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#modifier-modal"
                                                           data-href="{{ route('agenda.update', $agenda->id) }}"
                                                            data-titre="{{ $agenda->titre }}"
                                                            data-description="{{ $agenda->description }}"
                                                           data-date_deb="{{ \Carbon\Carbon::parse($agenda->date_deb)->format('Y-m-d') }}"
                                                           data-date_fin="{{ \Carbon\Carbon::parse($agenda->date_fin)->format('Y-m-d') }}"
                                                            data-heure_deb="{{ $agenda->heure_deb }}"
                                                            data-type="{{ $agenda->type_rappel }}"
                                                           data-priorite="{{ $agenda->priorite }}"
                                                           data-est_lie="{{ $agenda->est_lie }}"
                                                           data-est_terminee="{{ $agenda->est_terminee }}"
                                                           data-agenda_id="{{ $agenda->id }}"
                                                           data-contact_id="{{ $agenda->contact_id }}">
                                                            <i class="mdi mdi-square-edit-outline"></i>
                                                        </a>
                                                    @endcan

                                                    @can('permission', 'supprimer-agenda')
                                                        <a href="javascript:void(0);"
                                                           class="action-icon delete text-danger" 
                                                           data-href="{{ route('agenda.destroy', $agenda->id) }}">
                                                            <i class="mdi mdi-delete"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Laravel -->
                            <div class="d-flex justify-content-center">
                                {{ $agendas->links('pagination::bootstrap-5') }}
                            </div>

                        </div>
                    </div>
                    <!-- /# card -->
                </div>



                <hr>


            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Script de tri
document.addEventListener('DOMContentLoaded', function() {
    const getCellValue = (tr, idx) => {
        const cell = tr.children[idx];
        return cell ? cell.innerText || cell.textContent : '';
    };

    const comparer = (idx, asc) => (a, b) => {
        const v1 = getCellValue(asc ? a : b, idx);
        const v2 = getCellValue(asc ? b : a, idx);
        return v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) 
            ? v1 - v2 
            : v1.toString().localeCompare(v2);
    };

    document.querySelectorAll('th.sortable').forEach(th => {
        th.addEventListener('click', () => {
            const table = th.closest('table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const index = Array.from(th.parentElement.children).indexOf(th);
            
            th.parentElement.querySelectorAll('th').forEach(header => {
                if (header !== th) {
                    header.classList.remove('asc', 'desc');
                }
            });
            
            const isAsc = th.classList.toggle('asc');
            th.classList.toggle('desc', !isAsc);
            
            rows.sort(comparer(index, isAsc));
            tbody.append(...rows);
        });
    });
});
</script>

<script>
    // Script de suppression
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('[data-toggle="tooltip"]').tooltip();

        $('body').on('click', 'a.delete', function(event) {
            let that = $(this);
            event.preventDefault();

            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            });

            swalWithBootstrapButtons.fire({
                title: 'Supprimer',
                text: "Confirmer ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                cancelButtonText: 'Non',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('[data-toggle="tooltip"]').tooltip('hide');
                    $.ajax({
                            url: that.attr('data-href'),
                            type: 'PUT',
                            success: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Supprimée',
                                '',
                                'success'
                            );
                            document.location.reload();
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Annulée',
                        'Tâche non supprimée :)',
                        'error'
                    );
                }
            });
        });
    });

    
</script>
@endpush 