<div class="table-responsive">
    {{-- <table class="table table-centered table-nowrap table-striped table-bordered w-100" id="dt-prestations"> --}}
    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
        <thead>
            <tr>
                <th>Type</th>
                <th>Libellé</th>
                <th>Description</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Action </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($depenses as $depense)
                <tr>
                    <td> <span class="text-primary">{{ $depense->type }}</span></td>
                    <td> <span class="text-secondary">{{ $depense->libelle }}</span></td>

                    <td><span class=""> {{ $depense->description }} </span> </td>
                    <td>{{ number_format($depense->montant, 2, ',', ' ') }} €</td>

                    <td> {{ $depense->date_depense?->format('d/m/Y') }}</td>
                    <td>
                        <a type="button" data-bs-toggle="modal" data-bs-target="#modif-depense"
                            data-type="{{ $depense->type }}" data-libelle="{{ $depense->libelle }}"
                            data-description="{{ $depense->description }}" data-montant="{{ $depense->montant }}"
                            data-date_depense="{{ $depense->date_depense?->format('Y-m-d') }}"
                            data-href="{{ route('depense.update', Crypt::encrypt($depense->id)) }}"
                            class="btn btn-primary btn-sm edit-depense"><i class="mdi mdi-square-edit-outline"></i></a>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>


{{-- 
$table->string('type')->nullable();
$table->string('libelle')->nullable();
$table->text('description')->nullable();
$table->double('montant')->nullable();
$table->date('date')->nullable();         --}}


{{-- Ajout d'une depense --}}
<div id="ajout-depense" class="modal fade" tabindex="-1" circuit="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-dark">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter une charge liée à {{ $evenement->nom }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('depense.store') }}" method="post">
                <div class="modal-body">

                    @csrf
                    <input type="hidden" name="evenement_id" value="{{ $evenement->id }}">

                    <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span> </label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">-- Sélectionnez --</option>
                                <option value="Evènement">Evènement</option>
                                <option value="Circuit">Circuit</option>
                                <option value="Voiture">Voiture</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="libelle" class="form-label">Libelle</label>
                            <input type="text" class="form-control" id="libelle" name="libelle" required>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="montant" class="form-label">Montant <span class="text-danger">*</span> </label>
                            <input type="number" step="0.01" class="form-control" id="montant" required
                                name="montant" required>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="">
                        </div>
                        <div class="mb-3 col-lg-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-dark">Enregistrer</button>
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- Modal Modification d'une dépense --}}

<div id="modif-depense" class="modal fade" tabindex="-1" circuit="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-dark">
                <h4 class="modal-title" id="standard-modalLabel">Modifier la charge liée </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('depense.store') }}" id="edit_form" method="post">
                <div class="modal-body">

                    @csrf
                    <input type="hidden" name="evenement_id" value="{{ $evenement->id }}">

                    <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="edit_type" class="form-label">Type <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="edit_type" name="type" required>
                                <option value="">-- Sélectionnez --</option>
                                <option value="Evènement">Evènement</option>
                                <option value="Circuit">Circuit</option>
                                <option value="Voiture">Voiture</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="edit_libelle" class="form-label">Libelle</label>
                            <input type="text" class="form-control" id="edit_libelle" name="libelle" required>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="edit_montant" class="form-label">Montant <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" class="form-control" id="edit_montant" required
                                name="montant" required>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="edit_date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="edit_date" name="date"
                                value="">
                        </div>
                        <div class="mb-3 col-lg-12">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-dark">Modifier</button>
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
