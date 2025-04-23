<div>
    @if($tasks->isEmpty())
        <div class="text-center text-muted mt-3">
            <i class="mdi mdi-calendar-blank h3"></i>
            <p>Aucune tâche pour le moment</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-centered table-hover mb-0">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Dates</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr @if($task->est_terminee) style="background-color: #f0f0f0; text-decoration: line-through;" @endif>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-checkbox-marked-circle-outline text-{{ $this->getStatusColor($task) }} me-2"></i>
                                    <span>{{ $task->titre }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <small class="text-muted">Début: {{ \Carbon\Carbon::parse($task->date_deb)->format('d/m/Y') }}
                                        @if($task->heure_deb)
                                            à {{ $task->heure_deb }}
                                        @endif
                                    </small>
                                    <small class="text-muted">Fin: {{ \Carbon\Carbon::parse($task->date_fin)->format('d/m/Y') }}
                                        @if($task->heure_fin)
                                            à {{ $task->heure_fin }}
                                        @endif
                                    </small>
                                </div>
                            </td>
                            <td>
                                @switch($task->priorite)
                                    @case('haute')
                                        <span class="badge bg-danger">Haute</span>
                                        @break
                                    @case('basse')
                                        <span class="badge bg-info">Basse</span>
                                        @break
                                    @default
                                        <span class="badge bg-warning">Moyenne</span>
                                @endswitch
                            </td>
                            <td>
                                @if($task->est_terminee)
                                    <span class="badge bg-success">Terminée</span>
                                @else
                                    @if($task->date_fin < now()->format('Y-m-d'))
                                        <span class="badge bg-danger">En retard</span>
                                    @else
                                        <span class="badge bg-primary">En cours</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($task->description)
                                    <span data-bs-toggle="tooltip" title="{{ $task->description }}">
                                        {{ Str::limit($task->description, 30) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-light btn-sm modifier" data-bs-toggle="modal"          data-bs-target="#modifier-modal" 
                                        data-titre="{{ $task->titre }}"
                                        data-type="{{ $task->type_rappel }}"
                                        data-est_terminee="{{ $task->est_terminee }}"
                                        data-date_deb="{{ \Carbon\Carbon::parse($task->date_deb)->format('Y-m-d') }}"
                                        data-heure_deb="{{ $task->heure_deb }}"
                                        data-date_fin="{{ \Carbon\Carbon::parse($task->date_fin)->format('Y-m-d') }}"
                                        data-heure_fin="{{ $task->heure_fin }}"
                                        data-priorite="{{ $task->priorite }}"
                                        data-description="{{ $task->description }}"
                                        data-est_lie="{{ $task->est_lie }}"
                                        data-contact_id="{{ $task->contact_id }}"
                                        data-agenda_id="{{ $task->id }}"
                                        data-href="{{ route('agenda.update', $task->id) }}"                                    
                                        >
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    @can('permission', 'supprimer-agenda')
                                        <a href="javascript:void(0);"
                                            class="action-icon delete text-danger" 
                                            data-href="{{ route('agenda.destroy', $task->id) }}">
                                            <i class="mdi mdi-delete"></i>
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div> 

@push('scripts') 

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
