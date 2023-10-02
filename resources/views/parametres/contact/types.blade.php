<div class="tab-pane show active" id="types">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <a href="" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                data-bs-target="#standard-modal-type"><i class="mdi mdi-plus-circle me-2"></i> Nouveau
                                type de contact</a>
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
                            @if ($errors->has('type'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>{{ $errors->first('type') }}</strong>
                                </div>
                                </br>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-hover w-100 dt-responsive nowrap" id="tab1">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Statut</th>
                                    <th style="width: 125px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $type)
                                    <tr>
                                        <td><a href="#" class="text-body fw-bold">{{ $type->type }}</a> </td>
                                        <td>
                                            @if ($type->archive == false)
                                                <span class="badge bg-success">Actif</span>
                                            @else
                                                <span class="badge bg-warning">Archivé</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a data-href="{{ route('typecontact.update', Crypt::encrypt($type->id)) }}"
                                                style="cursor: pointer;" title="Modifier"
                                                data-value="{{ $type->type }}" data-bs-toggle="modal"
                                                data-bs-target="#edit-modal-type"
                                                class="action-icon edit_type text-primary">
                                                <i class="mdi mdi-square-edit-outline"></i>
                                            </a>
                                            @if ($type->archive == false)
                                                <a data-href="{{ route('typecontact.archive', Crypt::encrypt($type->id)) }}"
                                                    style="cursor: pointer;" title="Archiver"
                                                    class="action-icon archive_type text-warning">
                                                    <i class="mdi mdi-archive-arrow-down"></i>
                                                </a>
                                            @else
                                                <a data-href="{{ route('typecontact.unarchive', Crypt::encrypt($type->id)) }}"
                                                    style="cursor: pointer;" title="Restaurer"
                                                    class="action-icon unarchive_type text-info">
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

{{-- Ajout d'un type de contact --}}
<div id="standard-modal-type" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter un type de contact</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-add-type" action="{{ route('typecontact.store') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <input type="text" name="type" value="{{ old('type') ? old('type') : '' }}"
                                class="form-control" id="floatingInput">
                            <label for="floatingInput">Type de contact</label>
                            @if ($errors->has('type'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>{{ $errors->first('type') }}</strong>
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

{{-- Modification d'un type de contact --}}
<div id="edit-modal-type" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Modifier le type de contact</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="form-edit-type">
                <div class="modal-body">
                    @csrf
                    <div class="col-lg-12">

                        <div class="form-floating mb-3">
                            <input type="text" name="type" value="{{ old('type') ? old('type') : '' }}"
                                class="form-control" id="edit_type">
                            <label for="edit_type">Type de contact</label>
                            @if ($errors->has('type'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>{{ $errors->first('type') }}</strong>
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
