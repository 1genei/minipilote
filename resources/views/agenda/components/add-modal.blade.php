@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<!-- Modal d'ajout de tâche -->
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="add-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter une tâche</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form-add" action="{{ route('agenda.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="titre" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="type_rappel" class="form-label">Type de rappel <span class="text-danger">*</span></label>
                            <select class="form-select" name="type_rappel" required>
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
                            <label for="date_deb" class="form-label">Date de début <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_deb" required>
                        </div>
                        <div class="col-md-6">
                            <label for="date_fin" class="form-label">Date de fin</label>
                            <input type="date" class="form-control" name="date_fin">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="heure_deb" class="form-label">Heure de début</label>
                            <input type="time" class="form-control" name="heure_deb">
                        </div>
                        <div class="col-md-6">
                            <label for="heure_fin" class="form-label">Heure de fin</label>
                            <input type="time" class="form-control" name="heure_fin">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="priorite" class="form-label">Priorité <span class="text-danger">*</span></label>
                            <select class="form-select" name="priorite" required>
                                <option value="moyenne" selected>Moyenne</option>
                                <option value="basse">Basse</option>
                                <option value="haute">Haute</option>
                            </select>
                        </div>
                       
                        <div class="col-md-6">
                            <label for="est_lie" class="form-label">Lier à un contact <span class="text-danger">*</span></label>
                            <select class="form-select" name="est_lie" required>
                                <option value="Non">Non</option>
                                <option value="Oui">Oui</option>
                            </select>
                        </div>
                     
                    </div>
                    
                    <div class="row mb-2 contact-select" style="display: none;">
                        <div class="col-md-12">
                            <label for="contact_id" class="form-label ">Contact <span class="text-danger">*</span></label>
                            <select class="form-select" name="contact_id" id="contact_id">
                                <option value="">Sélectionner un contact</option>
                            </select>
                        </div>
                    </div>
              
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
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
@include('components.contact.add_select2_script')
@push('scripts')
    {{-- S'assurer que jQuery est chargé avant Select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            initContactsSelect2('#contact_id', '#add-modal');
            
            // Gestion de l'affichage du select contact
            $('select[name="est_lie"]').change(function() {
                if($(this).val() == 'Oui') {
                    $('.contact-select').show();
                    $('select[name="contact_id"]').prop('required', true);
                } else {
                    $('.contact-select').hide();
                    $('select[name="contact_id"]').prop('required', false);
                }
            });

            // Gestion du formulaire d'ajout
            $('#form-add').on('submit', function(e) {
                e.preventDefault();
                
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');
                $('.loading-overlay').fadeIn();
                
                let submitBtn = $(this).find('button[type="submit"]');
                let originalText = submitBtn.text();
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enregistrement...');
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            $('.loading-overlay').fadeOut();
                            $('#add-modal').modal('hide');                            
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
                                text: 'Une erreur est survenue lors de l\'enregistrement',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>

    <style>
        /* Styles pour Select2 dans la modal */
        .select2-container {
            z-index: 100000;
        }
        
        .modal {
            z-index: 99999;
        }
        
        .select2-dropdown {
            z-index: 100001;
        }
    </style>
@endpush 