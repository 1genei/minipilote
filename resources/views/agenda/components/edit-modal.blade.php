<!-- Modal de modification de tâche -->
<div class="modal fade" id="modifier-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier la tâche</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form-edit" method="POST">
                @csrf
                <input type="hidden" name="agenda_id" id="agenda_id_mod">
                <div class="modal-body">

                    <!-- Ajout du switch pour le statut -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="task-status-switch">
                                <label class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="est_terminee" id="est_terminee_mod" value="1">
                                    <span class="form-check-label">
                                        <i class="mdi mdi-check-circle text-success me-1"></i>
                                        Marquer comme terminée
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="titre_mod" class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="titre" id="titre_mod" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="type_rappel_mod" class="form-label">Type de rappel <span class="text-danger">*</span></label>
                            <select class="form-select" name="type_rappel" id="type_rappel_mod" required>
                                <option value="">Sélectionner un type de rappel</option>
                                <option value="contacter">À contacter</option>
                                <option value="recontacter">À recontacter</option>
                                <option value="rendez-vous">Rendez-vous</option>
                                <option value="réunion">Réunion</option>
                                <option value="tâche">Tâche</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="date_deb_mod" class="form-label">Date de début <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_deb" id="date_deb_mod" required>
                        </div>
                        <div class="col-md-6">
                            <label for="date_fin_mod" class="form-label">Date de fin</label>
                            <input type="date" class="form-control" name="date_fin" id="date_fin_mod">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="heure_deb_mod" class="form-label">Heure de début</label>
                            <input type="time" class="form-control" name="heure_deb" id="heure_deb_mod">
                        </div>
                        <div class="col-md-6">
                            <label for="heure_fin_mod" class="form-label">Heure de fin</label>
                            <input type="time" class="form-control" name="heure_fin" id="heure_fin_mod">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select name="priorite" id="priorite_mod" class="form-select" required>
                                    <option value="moyenne">Moyenne</option>
                                    <option value="basse">Basse</option>
                                    <option value="haute">Haute</option>
                                </select>
                                <label for="priorite_mod">Priorité <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        @if(isset($contacts) && $contacts->count() > 0)
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select name="est_lie" id="est_lie_mod" class="form-select" required>
                                    <option value="Non">Non</option>
                                    <option value="Oui">Oui</option>
                                </select>
                                <label for="est_lie_mod">Lier à un contact <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        @else
                        <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                        <input type="hidden" name="est_lie" value="Oui">
                        @endif
                    </div>
                    @if(isset($contacts) && $contacts->count() > 0)
                    <div class="row mb-2 contact-select-mod" style="display: none;">
                        <div class="col-md-12">
                            <label for="contact_id_mod" class="form-label">Contact <span class="text-danger">*</span></label>
                            <select class="form-select" name="contact_id" id="contact_id_mod">
                                <option value="">Sélectionner un contact</option>
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->id }}">
                                        @if($contact->type == 'individu' && $contact->individu)
                                            {{ $contact->individu->nom }} {{ $contact->individu->prenom }}
                                        @elseif($contact->type == 'entite' && $contact->entite)
                                            {{ $contact->entite->raison_sociale }}
                                        @else
                                            Contact #{{ $contact->id }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="description_mod" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description_mod" rows="3"></textarea>
                        </div>
                    </div>

                 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Ajout des styles -->
<style>
    .task-status-switch {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .task-status-switch .form-check {
        padding-left: 0;
        margin-bottom: 0;
    }

    .task-status-switch .form-switch {
        display: flex;
        align-items: center;
    }

    .task-status-switch .form-check-input {
        height: 1.5rem;
        width: 3rem;
        margin-right: 10px;
        cursor: pointer;
    }

    .task-status-switch .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    .task-status-switch .form-check-label {
        cursor: pointer;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .task-status-switch small {
        margin-left: 3.5rem;
    }
</style>

@push('scripts')
<script>
$(document).ready(function() {
    // Gestion de l'affichage du select contact
    $('#est_lie_mod').change(function() {
        if($(this).val() == 'Oui') {
            $('.contact-select-mod').show();
            $('#contact_id_mod').prop('required', true);
        } else {
            $('.contact-select-mod').hide();
            $('#contact_id_mod').prop('required', false);
        }
    });

    // Remplissage du formulaire lors de l'ouverture du modal
    $('.modifier').click(function() {
        var that = $(this);
        $('#titre_mod').val(that.attr('data-titre'));
        $('#description_mod').val(that.attr('data-description'));
        $('#date_deb_mod').val(that.attr('data-date_deb'));
        $('#date_fin_mod').val(that.attr('data-date_fin'));
        $('#heure_deb_mod').val(that.attr('data-heure_deb'));
        $('#type_rappel_mod').val(that.attr('data-type'));
        $('#priorite_mod').val(that.attr('data-priorite'));
        $('#est_lie_mod').val(that.attr('data-est_lie') == '1' ? 'Oui' : 'Non').trigger('change');
        $('#contact_id_mod').val(that.attr('data-contact_id'));
        $('#agenda_id_mod').val(that.attr('data-agenda_id'));
    });

    // Gestion du formulaire de modification
    $('#form-edit').on('submit', function(e) {
        e.preventDefault();
        
        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');
        $('.loading-overlay').fadeIn();
        
        let submitBtn = $(this).find('button[type="submit"]');
        let originalText = submitBtn.text();
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enregistrement...');
        
        let agendaId = $('#agenda_id_mod').val();
        
        $.ajax({
            url: '/agendas/update/' + agendaId,
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    $('.loading-overlay').fadeOut();
                    $('#modifier-modal').modal('hide');
                    
                    Swal.fire({
                        title: 'Succès!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        window.location.reload();
                    });
                }
            },
            error: function(xhr) {
                $('.loading-overlay').fadeOut();
                submitBtn.prop('disabled', false).text(originalText);
                
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    
                    $.each(errors, function(key, value) {
                        let input = $('[name="'+key+'"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">'+value[0]+'</div>');
                    });
                    
                    Swal.fire({
                        title: 'Erreur de validation',
                        text: 'Veuillez vérifier les champs du formulaire',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: 'Erreur!',
                        text: 'Une erreur est survenue lors de la modification',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });

    // Mise à jour du switch lors de l'ouverture du modal
    $('#modifier-modal').on('show.bs.modal', function(e) {
        let button = $(e.relatedTarget);
        let estTerminee = button.attr('data-est_terminee');
        $('#est_terminee_mod').prop('checked', estTerminee === '1');
        
        // Mettre à jour le label initial
        let label = $('#est_terminee_mod').siblings('.form-check-label');
        if (estTerminee === '1') {
            label.html('<i class="mdi mdi-check-circle text-success me-1"></i> Tâche terminée');
        } else {
            label.html('<i class="mdi mdi-check-circle text-success me-1"></i> Marquer comme terminée');
        }
    });
});
</script>
@endpush 