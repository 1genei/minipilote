<div class="row" >

            <div class="modal-header modal-colored-header bg-dark">
                <h5 class="modal-title" id="dark-header-modalLabel">Sélectionnez les caractérisques de vos déclinaisons</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">

                <div class="row">

                    @foreach ($caracteristiques as $caracteristique)
                        <div class="collapse show mt-3 col-lg-4 col-md-6" id="">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <!-- task -->
                                    <span class="text-dark fw-bold fs-4">{{ $caracteristique->nom }}</span>
                                    <div class="mt-2" style="margin-left: 20px;">
                                        <div class="form-check">
                                            <input type="checkbox" id="tout_cocher{{ $caracteristique->id }}" name="valeurNom_{{ $caracteristique->id }}" value="" class="form-check-input check-decli">
                                            <label class="form-check-label"
                                                for="tout_cocher{{ $caracteristique->id }}">Tout cocher
                                            </label>
                                        </div>
                                        @foreach ($caracteristique->valeurcaracteristiques as $valeur)
                                            <div class="form-check">
                                                <input type="checkbox" id="valeurId{{ $valeur->id }}"
                                                    name="valeurNom_{{ $caracteristique->id }}[]"
                                                    value="{{ $valeur->id }}" class="form-check-input">
                                                <label class="form-check-label"
                                                    for="valeurId{{ $valeur->id }}">{{ $valeur->nom }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card -->
                        </div> <!-- end .collapse-->
                    @endforeach

                </div>



            </div>

</div>

<script>
$('.check-decli').on('change', function() {
    $(this).closest('.collapse').find(':checkbox').prop('checked', this.checked);
});
</script>