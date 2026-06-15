<div class="table-responsive">
    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
        <thead>
            <tr>
                <th>Type</th>
                <th>Libellé</th>
                <th>Description</th>
                <th>Montant HT</th>
                <th>TVA</th>
                <th>Montant TTC</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($depenses as $depense)
                <tr>
                    <td><span class="text-primary">{{ $depense->type }}</span></td>
                    <td><span class="text-secondary">{{ $depense->libelle }}</span></td>
                    <td>{{ $depense->description }}</td>
                    <td>{{ number_format($depense->montant_ht, 2, ',', ' ') }} €</td>
                    <td>
                        @if($depense->soumis_tva)
                            {{ number_format($depense->montant_tva, 2, ',', ' ') }} €
                            <small class="text-muted">({{ $depense->taux_tva }}%)</small>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ number_format($depense->montant_ttc, 2, ',', ' ') }} €</td>
                    <td>{{ $depense->date_depense?->format('d/m/Y') }}</td>
                    <td>
                        <a type="button" data-bs-toggle="modal" data-bs-target="#modif-depense"
                            data-type="{{ $depense->type }}"
                            data-libelle="{{ $depense->libelle }}"
                            data-description="{{ $depense->description }}"
                            data-montant_ht="{{ $depense->montant_ht }}"
                            data-taux_tva="{{ $depense->taux_tva }}"
                            data-soumis_tva="{{ $depense->soumis_tva ? '1' : '0' }}"
                            data-date_depense="{{ $depense->date_depense?->format('Y-m-d') }}"
                            data-href="{{ route('depense.update', Crypt::encrypt($depense->id)) }}"
                            class="btn btn-primary btn-sm edit-depense">
                            <i class="mdi mdi-square-edit-outline"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


{{-- Modal Ajout d'une dépense --}}
<div id="ajout-depense" class="modal fade" tabindex="-1" aria-labelledby="ajout-depense-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-dark">
                <h4 class="modal-title" id="ajout-depense-label">Ajouter une charge liée à {{ $evenement->nom }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('depense.store') }}" method="post" id="form-ajout-depense">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="evenement_id" value="{{ $evenement->id }}">
                    <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="type" required>
                                <option value="">-- Sélectionnez --</option>
                                <option value="Evènement">Evènement</option>
                                <option value="Circuit">Circuit</option>
                                <option value="Voiture">Voiture</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label class="form-label">Libellé <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="libelle" required>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="date">
                        </div>
                        <div class="mb-3 col-lg-6 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input tva-checkbox" type="checkbox" name="soumis_tva"
                                    id="add_soumis_tva" checked>
                                <label class="form-check-label" for="add_soumis_tva">Soumis à la TVA</label>
                            </div>
                        </div>
                        <div class="mb-3 col-lg-4">
                            <label class="form-label">Montant HT (€) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control montant-ht-input"
                                name="montant_ht" required>
                        </div>
                        <div class="mb-3 col-lg-4 tva-fields">
                            <label class="form-label">Taux TVA</label>
                            <select class="form-select taux-tva-select" name="taux_tva">
                                <option value="20" selected>20 %</option>
                                <option value="10">10 %</option>
                                <option value="5.5">5,5 %</option>
                                <option value="2.1">2,1 %</option>
                                <option value="0">0 %</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-4">
                            <label class="form-label">Montant TTC (€)</label>
                            <input type="number" step="0.01" class="form-control montant-ttc-display" readonly
                                tabindex="-1" style="background:#f0f0f0">
                        </div>
                        <div class="mb-3 col-lg-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-dark">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Modification d'une dépense --}}
<div id="modif-depense" class="modal fade" tabindex="-1" aria-labelledby="modif-depense-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-dark">
                <h4 class="modal-title" id="modif-depense-label">Modifier la charge</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="edit_form" method="post">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="evenement_id" value="{{ $evenement->id }}">
                    <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_type" name="type" required>
                                <option value="">-- Sélectionnez --</option>
                                <option value="Evènement">Evènement</option>
                                <option value="Circuit">Circuit</option>
                                <option value="Voiture">Voiture</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label class="form-label">Libellé <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_libelle" name="libelle" required>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" id="edit_date" name="date">
                        </div>
                        <div class="mb-3 col-lg-6 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input tva-checkbox" type="checkbox" name="soumis_tva"
                                    id="edit_soumis_tva" checked>
                                <label class="form-check-label" for="edit_soumis_tva">Soumis à la TVA</label>
                            </div>
                        </div>
                        <div class="mb-3 col-lg-4">
                            <label class="form-label">Montant HT (€) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control montant-ht-input"
                                id="edit_montant_ht" name="montant_ht" required>
                        </div>
                        <div class="mb-3 col-lg-4 tva-fields">
                            <label class="form-label">Taux TVA</label>
                            <select class="form-select taux-tva-select" id="edit_taux_tva" name="taux_tva">
                                <option value="20">20 %</option>
                                <option value="10">10 %</option>
                                <option value="5.5">5,5 %</option>
                                <option value="2.1">2,1 %</option>
                                <option value="0">0 %</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-4">
                            <label class="form-label">Montant TTC (€)</label>
                            <input type="number" step="0.01" class="form-control montant-ttc-display" readonly
                                tabindex="-1" style="background:#f0f0f0">
                        </div>
                        <div class="mb-3 col-lg-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-dark">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Calcul TTC dans un modal donné
function calculerTTC(modal) {
    const ht      = parseFloat(modal.querySelector('.montant-ht-input').value) || 0;
    const soumis  = modal.querySelector('.tva-checkbox').checked;
    const taux    = soumis ? parseFloat(modal.querySelector('.taux-tva-select').value) || 0 : 0;
    const ttc     = soumis ? Math.round(ht * (1 + taux / 100) * 100) / 100 : ht;
    modal.querySelector('.montant-ttc-display').value = ttc > 0 ? ttc.toFixed(2) : '';
}

function toggleTvaFields(modal) {
    const soumis = modal.querySelector('.tva-checkbox').checked;
    modal.querySelectorAll('.tva-fields').forEach(el => {
        el.style.opacity  = soumis ? '1' : '0.4';
        el.style.pointerEvents = soumis ? '' : 'none';
    });
    calculerTTC(modal);
}

document.querySelectorAll('#ajout-depense, #modif-depense').forEach(function(modal) {
    modal.querySelector('.tva-checkbox').addEventListener('change', () => toggleTvaFields(modal));
    modal.querySelector('.montant-ht-input').addEventListener('input', () => calculerTTC(modal));
    modal.querySelector('.taux-tva-select').addEventListener('change', () => calculerTTC(modal));
    // Init au chargement
    toggleTvaFields(modal);
});

// Pré-remplir modal modification
document.querySelectorAll('.edit-depense').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const modal  = document.getElementById('modif-depense');
        const form   = document.getElementById('edit_form');

        form.action = this.dataset.href;
        document.getElementById('edit_type').value        = this.dataset.type;
        document.getElementById('edit_libelle').value     = this.dataset.libelle;
        document.getElementById('edit_description').value = this.dataset.description || '';
        document.getElementById('edit_date').value        = this.dataset.date_depense || '';
        document.getElementById('edit_montant_ht').value  = this.dataset.montant_ht || '';

        const soumis = this.dataset.soumis_tva === '1';
        document.getElementById('edit_soumis_tva').checked = soumis;

        const tauxSelect = document.getElementById('edit_taux_tva');
        const taux = this.dataset.taux_tva || '20';
        const opt = tauxSelect.querySelector(`option[value="${taux}"]`);
        if (opt) opt.selected = true;

        toggleTvaFields(modal);
    });
});
</script>
