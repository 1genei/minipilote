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
                    
                    {{-- VOITURES --}}
                    <div class="collapse show mt-3 col-lg-4 col-md-6" id="">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- task -->
                                <span class="text-dark fw-bold fs-4">Voitures</span>
                                <div class="mt-2" style="margin-left: 20px;">
                                    {{-- <div class="form-check">
                                        <input type="checkbox" id="tout_cocher_voiture" name="tout_cocher_voiture" value="" class="form-check-input check-decli">
                                        <label class="form-check-label"
                                            for="tout_cocher_voiture">Tout cocher
                                        </label>
                                    </div> --}}
                                    @foreach ($voitures as $voiture)
                                        <div class="form-check">
                                            <input type="checkbox" id="voiture{{ $voiture->id }}" 
                                                name="voitures[]"
                                                value="{{ $voiture->id }}" class="form-check-input voitures" checked>
                                            <label class="form-check-label"
                                                for="voiture{{ $voiture->id }}">{{ $voiture->nom }}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card -->
                    </div> <!-- end voiture-->
                    
                    
                        
                    {{-- CIRCUIT --}}
                    <div class="collapse show mt-3 col-lg-4 col-md-6" id="">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- task -->
                                <span class="text-dark fw-bold fs-4">Circuits</span>
                                <div class="mt-2" style="margin-left: 20px;">
                                    {{-- <div class="form-check">
                                        <input type="checkbox" id="tout_cocher_circuit" name="tout_cocher_circuit" value="" class="form-check-input check-decli">
                                        <label class="form-check-label"
                                            for="tout_cocher_circuit">Tout cocher
                                        </label>
                                    </div> --}}
                                    @foreach ($circuits as $circuit)
                                        <div class="form-check">
                                            <input type="checkbox" id="circuit{{ $circuit->id }}" 
                                                name="circuits[]"
                                                value="{{ $circuit->id }}" class="form-check-input circuits" checked>
                                            <label class="form-check-label"
                                                for="circuit{{ $circuit->id }}">{{ $circuit->nom }}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card -->
                    </div> <!-- end .collapse-->
                    
                </div>


                <div class="collapse show mt-3 col-12" id="">
                    <div class="card mb-0">
                        <div class="card-body">
                        
                            <div class="row">
                                <div class="col-lg-6">
            
                                    <div class="col-12">
                                        <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">&nbsp;</label>
                                    </div>
                            
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="tva_id" class="form-label">Taxe</label>
                                            <select wire:model.defer="tva_id" name="tva_id" id="tva_id"
                                                class="form-select select2">
                                                @foreach ($tvas as $tva)
                                                    <option value="{{ $tva->id }}">{{ $tva->nom }}</option>
                                                @endforeach
                                                <option value="">Aucune taxe</option>
                                            </select>
                                        </div>
                                    </div>
                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                

            </div>

</div>

<script>
$('.check-decli').on('change', function() {
    $(this).closest('.collapse').find(':checkbox').prop('checked', this.checked);
});

// Check au moins une voiture
$(function(){
    var requiredCheckboxes = $('.voitures');
    requiredCheckboxes.change(function(){
  
        if(requiredCheckboxes.is(':checked')) {
            requiredCheckboxes.removeAttr('required');
        } else {
            requiredCheckboxes.attr('required', 'required');
        }
    });
});

// Check au moins un circuit
$(function(){
    var requiredCheckboxes = $('.circuits');
    requiredCheckboxes.change(function(){
    

        if(requiredCheckboxes.is(':checked')) {
            requiredCheckboxes.removeAttr('required');
        } else {
            requiredCheckboxes.attr('required', 'required');
        }
    });
});
</script>