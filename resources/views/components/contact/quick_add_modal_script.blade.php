<script>
    $(document).ready(function() {
        // Gestion de l'affichage des champs selon le type
        $('#contact_type').change(function() {
            if ($(this).val() === 'individu') {
                $('#individu_fields').show();
                $('#entite_fields').hide();
            } else if ($(this).val() === 'entite') {
                $('#individu_fields').hide();
                $('#entite_fields').show();
            } else {
                $('#individu_fields').hide();
                $('#entite_fields').hide();
            }
        });

        // Soumission du formulaire en AJAX
        $('#quickAddContactForm').on('submit', function(e) {
            e.preventDefault();
            
            let formData = $(this).serialize();
            
            $.ajax({
                url: '/contacts/quick-add',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Ajouter le nouveau contact au select2
                        let newOption = new Option(response.contact_name, response.contact_id, true, true);
                        $('.select2-beneficiaire').append(newOption).trigger('change');
                        
                        // Fermer la modal et réinitialiser le formulaire
                        $('#quick-add-contact-modal').modal('hide');
                        $('#quickAddContactForm')[0].reset();
                        
                        // Notification de succès
                        Swal.fire({
                            icon: 'success',
                            title: 'Succès',
                            text: 'Contact ajouté avec succès',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    
                    for (let field in errors) {
                        errorMessage += errors[field][0] + '\n';
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: errorMessage
                    });
                }
            });
        });
    }); 
</script>