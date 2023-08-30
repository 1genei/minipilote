<div class="tab-pane" id="marques">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <a href="" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                data-bs-target="#standard-modal-marque"><i
                                    class="mdi mdi-plus-circle me-2"></i>Nouvelle marque</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            @if (session('message'))
                                <div class="alert alert-success text-secondary alert-dismissible ">
                                    <i class="dripicons-checkmark me-2"></i>
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <a href="#" class="alert-link"><strong> {{ session('message') }}</strong></a>
                                </div>
                            @endif
                            @if ($errors->has('marque'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>{{ $errors->first('marque') }}</strong>
                                </div>
                                </br>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-centered table-hover w-100 dt-responsive nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Statut</th>
                                    <th style="width: 125px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($marques as $marque)
                                <tr>
                                    <td>
                                        <b>{{ $marque->nom }}</b>
                                    </td>
                                    <td>
                                        @if ($marque->archive)
                                            <button type="button" class="btn-danger btn-sm rounded-pill">Archivée</button>
                                        @else
                                            <button type="button" class="btn-success btn-sm rounded-pill">Active</button>
                                        @endif
                                    </td>
                                    <td>
                                        <a data-href="{{ route('marque.update', Crypt::encrypt($marque->id)) }}" style="cursor: pointer;"
                                            title="Modifier" data-nom="{{ $marque->nom }}" data-parent_id="{{ $marque->parent_id }}"
                                            data-description="{{ $marque->description }}" data-bs-toggle="modal"
                                            data-bs-target="#edit-modal-marque" class="action-icon edit_marque text-primary">
                                            <i class="mdi mdi-square-edit-outline"></i>
                                        </a>
                                        @if (!$marque->archive)
                                            <a data-href="{{ route('marque.archive', Crypt::encrypt($marque->id)) }}"
                                                style="cursor: pointer;" title="Archiver" class="action-icon archive_marque text-warning">
                                                <i class="mdi mdi-archive-arrow-down"></i>
                                            </a>
                                        @else
                                            <a data-href="{{ route('marque.unarchive', Crypt::encrypt($marque->id)) }}"
                                                style="cursor: pointer;" title="Restaurer" class="action-icon unarchive_marque text-info">
                                                <i class="mdi mdi-archive-arrow-up"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Ajout d'une marque --}}
<div id="standard-modal-marque" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter une marque</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('marque.store') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <div class="m-2">
                                <label for="inputNom">Nom</label>
                                <input type="text" name="nom" class="form-control" id="inputNom" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>

                </div>
            </form>

        </div>
    </div>
</div>

{{-- Modification d'une marque --}}
<div id="edit-modal-marque" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Modifier la marque</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="form-edit-marque">
                <div class="modal-body">
                    @csrf
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <div class="m-2">
                                <label for="inputNomEditMarque">Nom</label>
                                <input type="text" name="nom" class="form-control" id="inputNomEditMarque"
                                    value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>

