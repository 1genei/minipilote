<div class="tab-pane" id="postes">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <a href="" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                data-bs-target="#standard-modal-poste"><i class="mdi mdi-plus-circle me-2"></i> Nouveau poste</a>
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
                            @if ($errors->has('poste'))
                                <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('poste') }}</strong>
                                    </div>
                                </br>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-hover w-100 dt-responsive nowrap"
                            id="tab1">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Statut</th>
                                    <th style="width: 125px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($postes as $poste)
                                    <tr>
                                        <td><a href="#" class="text-body fw-bold">{{ $poste->nom }}</a> </td>
                                        <td>
                                            @if ($poste->archive == false)
                                                <button type="button" class="btn-success btn-sm rounded-pill">Actif</button>
                                            @else
                                                <button type="button" class="btn-danger btn-sm rounded-pill">Archivé</button>
                                            @endif
                                        </td>
                                        <td>
                                            <a data-href="{{ route('poste.update', Crypt::encrypt($poste->id)) }}" style="cursor: pointer;" title="Modifier"
                                                    data-value="{{ $poste->nom }}" data-bs-toggle="modal"
                                                    data-bs-target="#edit-modal-poste" class="action-icon edit_poste text-primary">
                                                <i class="mdi mdi-square-edit-outline"></i>
                                            </a>
                                            @if ($poste->archive == false)
                                                <a data-href="{{ route('poste.archive', Crypt::encrypt($poste->id)) }}"
                                                    style="cursor: pointer;" title="Archiver"
                                                    class="action-icon archive_poste text-warning">
                                                    <i class="mdi mdi-archive-arrow-down"></i>
                                                </a>
                                            @else
                                                <a data-href="{{ route('poste.unarchive', Crypt::encrypt($poste->id)) }}"
                                                    style="cursor: pointer;" title="Restaurer"
                                                    class="action-icon unarchive_poste text-info">
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

{{-- Ajout d'un poste --}}
    <div id="standard-modal-poste" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Ajouter un poste</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('poste.store') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="col-lg-12">
                            <div class="form-floating mb-3">
                                <input type="text" name="poste" value="{{ old('poste') ? old('poste') : '' }}"
                                    class="form-control" id="floatingInput">
                                <label for="floatingInput">Poste</label>
                                @if ($errors->has('poste'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{ $errors->first('poste') }}</strong>
                                    </div>
                                @endif
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

{{-- Modification d'un poste --}}
    <div id="edit-modal-poste" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Modifier le poste</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" id="form-edit-poste">
                    <div class="modal-body">
                        @csrf
                        <div class="col-lg-12">

                            <div class="form-floating mb-3">
                                <input type="text" name="poste" value="{{ old('poste') ? old('poste') : '' }}"
                                    class="form-control" id="edit_poste">
                                <label for="edit_poste">Poste</label>
                                @if ($errors->has('poste'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>{{ $errors->first('poste') }}</strong>
                                    </div>
                                @endif
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
