<form action="{{ route('societe.update', Crypt::encrypt($societe->id)) }}" method="POST" id="edit-form">
    <div class="modal-header d-flex justify-content-between">    
        <h3>{{ $societe->est_societe_principale ? $societe->raison_sociale.' (principale)' : ($societe->archive ? $societe->raison_sociale.' (archivée)' : $societe->raison_sociale) }}</h3>
        <div class="d-flex align-items-center">
        @if (!$societe->est_societe_principale)
            @if (!$societe->archive)
                <span id="tooltip-archive">
                    <a data-href="{{ route('societe.archive', Crypt::encrypt($societe->id)) }}" style="cursor: pointer;" class="action-icon text-warning archive_societe""
                        data-bs-container="#tooltip-archive" data-bs-toggle="tooltip" data-bs-placement="top" title="Archiver">
                        <i class="mdi mdi-archive-arrow-down" style="font-size: 2rem;"></i>
                    </a>
                </span>
            @else
                <span id="tooltip-unarchive">
                    <a data-href="{{ route('societe.unarchive', Crypt::encrypt($societe->id)) }}" style="cursor: pointer;" class="action-icon text-info unarchive_societe"
                        data-bs-container="#tooltip-unarchive" data-bs-toggle="tooltip" data-bs-placement="top" title="Restaurer">
                        <i class="mdi mdi-archive-arrow-up" style="font-size: 2rem;"></i>
                    </a>
                </span>
            @endif
        @endif
    </div>
    </div>
    <div class="modal-body">
        @csrf
        <div class="col-lg-12">
            <div class="form-floating mb-3">
                <div class="m-2">
                    <label for="raison_sociale">Raison Sociale</label>
                    <input type="text" name="raison_sociale" class="form-control w-75" value="{{ $societe->raison_sociale }}" />
                </div>
                <div class="m-2">
                    <label for="numero_sirete">Numéro de SIRET</label>
                    <input type="text" name="numero_siret" class="form-control w-75" value="{{ $societe->numero_siret }}" />
                </div>
                <div class="m-2">
                    <label for="logo">Logo</label>
                    <div>
                        @if ($societe->logo)
                            <img src="{{ $societe->logo }}" alt="Current Logo" style="width: 200px;" />
                        @else
                            <p>Pas de logo chargé</p>
                        @endif
                    </div>
                    <div>
                        <input type="file" name="edit_logo_file" id="edit_logo_file" accept="image/*" style="display: none;" />
                        <button type="button" id="edit_browse_button" class="btn btn-success">Parcourir</button>
                    </div>
                </div>
                <div class="m-2">
                    <label for="capital">Capital</label>
                    <input type="number" name="capital" class="form-control w-75" value="{{ $societe->capital }}" />
                </div>
                <div class="m-2">
                    <label for="gerant">Gérant</label>
                    <input type="text" name="gerant" class="form-control w-75" value="{{ $societe->gerant }}" />
                </div>
                <div class="m-2">
                    <label for="raison_sociale">Numéro de TVA</label>
                    <input type="text" name="numero_tva" class="form-control w-75" value="{{ $societe->numero_tva }}" />
                </div>
                <div class="m-2">
                    <label for="email">Adresse mail</label>
                    <input type="text" name="email" class="form-control w-75" value="{{ $societe->email }}" />
                </div>
                <div class="m-2">
                    <label for="telephone">Numéro de téléphone</label>
                    <input type="text" name="telephone" class="form-control w-75" value="{{ $societe->telephone }}" />
                </div>
                <div class="m-2">
                    <label for="adresse">Adresse postale</label>
                    <input type="text" name="adresse" class="form-control w-75" value="{{ $societe->adresse }}" />
                </div>
                <div class="m-2">
                    <label for="complement_adresse">Complément d'adresse</label>
                    <input type="text" name="complement_adresse" class="form-control w-75" value="{{ $societe->complement_adresse }}" />
                </div>
                <div class="m-2">
                    <label for="ville">Ville</label>
                    <input type="text" name="ville" class="form-control w-75" value="{{ $societe->ville }}" />
                </div>
                <div class="m-2">
                    <label for="code_postal">Code postal</label>
                    <input type="text" name="code_postal" class="form-control w-75" value="{{ $societe->code_postal }}" />
                </div>
                <div class="m-2">
                    <label for="pays">Pays</label>
                    <input type="text" name="pays" class="form-control w-75" value="{{ $societe->pays }}" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="save-button" disabled>Sauvegarder</button>
        <button type="button" class="btn btn-light" id="cancel-button">Annuler</button>
    </div>
</form>

<script>
    document.getElementById("edit_browse_button").addEventListener("click", function () {
        document.getElementById("edit_logo_file").click();
    });

    const myForm = document.getElementById('edit-form');
    const saveButton = document.getElementById('save-button');
    const cancelButton = document.getElementById('cancel-button');
    const originalData = {!! json_encode($societe) !!};

    for (const field in originalData) {
        if (myForm[field]) {
            myForm[field].value = originalData[field];
        }
    }

    myForm.addEventListener('input', function () {
        saveButton.removeAttribute('disabled');
        cancelButton.removeAttribute('disabled');
    });

    cancelButton.addEventListener('click', function () {
        for (const field in originalData) {
            if (myForm[field]) {
                myForm[field].value = originalData[field];
            }
        }
        saveButton.setAttribute('disabled', true);
    });
</script>
