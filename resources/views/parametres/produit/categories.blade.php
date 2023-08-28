<div class="tab-pane show active" id="categories">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <a href="" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                data-bs-target="#standard-modal-categorie"><i
                                    class="mdi mdi-plus-circle me-2"></i>Nouvelle catégorie</a>
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
                            @if ($errors->has('categorie'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>{{ $errors->first('categorie') }}</strong>
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
                                    <th>Description</th>
                                    <th>Statut</th>
                                    <th style="width: 125px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $categorie)
                                    @if ($categorie->niveau == 1)
                                        @include('parametres.produit.categorie', [
                                            'categorie' => $categorie,
                                        ])
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Ajout d'une categorie --}}
<div id="standard-modal-categorie" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter une catégorie</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('categorieproduit.store') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <div class="m-2">
                                <label for="inputNom">Nom</label>
                                <input type="text" name="nom" class="form-control" id="inputNom" value="">
                            </div>
                            <div class="m-2">
                                <label for="inputParent">Catégorie parent</label>
                                <select name="parent_id" class="form-control" id="inputParent">
                                    <option value="">Aucune</option>
                                    @foreach ($categories as $categorie)
                                        @if (!$categorie->parent)
                                            <optgroup label="{{ hierarchie($categorie) }}">
                                                @foreach (allSub($categorie) as $sscategorie)
                                                    <option value="{{ $sscategorie->id }}">
                                                        {{ hierarchie($sscategorie) }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="m-2">
                                <label for="inputDescription">Description</label>
                                <textarea name="description" class="form-control" id="inputDescription" rows="4" value=""></textarea>
                            </div>
                            @if ($errors->has('categorie'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>{{ $errors->first('categorie') }}</strong>
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

{{-- Modification d'une categorie --}}
<div id="edit-modal-categorie" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Modifier la catégorie</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="form-edit-categorie">
                <div class="modal-body">
                    @csrf
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <div class="m-2">
                                <label for="inputNomEdit">Nom</label>
                                <input type="text" name="nom" class="form-control" id="inputNomEdit"
                                    value="">
                            </div>
                            <div class="m-2">
                                <label for="inputParentEdit">Catégorie parent</label>
                                <select name="parent_id" class="form-control" id="inputParentEdit">
                                    <option value="">Aucune</option>
                                    @foreach ($categories as $categorie)
                                        @if (!$categorie->parent)
                                            <optgroup label="{{ $categorie->nom }}">
                                                @foreach (allSub($categorie) as $sscategorie)
                                                    <option value="{{ $sscategorie->id }}">
                                                        {{ hierarchie($sscategorie) }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="m-2">
                                <label for="inputDescriptionEdit">Description</label>
                                <textarea name="description" class="form-control" id="inputDescriptionEdit" rows="4" value=""></textarea>
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


<?php
function hierarchie($categorie)
{
    $hierarchy = $categorie->nom;

    $parent = $categorie->parent;
    while ($parent) {
        $hierarchy = $parent->nom . ' > ' . $hierarchy;
        $parent = $parent->parent;
    }

    return $hierarchy;
}

function allSub($categorie)
{
    $subcategories = collect([$categorie]);

    foreach ($categorie->sscategories as $sscategorie) {
        $subcategories = $subcategories->concat(allSub($sscategorie));
    }

    return $subcategories;
}

function allExcept($categories, $except)
{
    $filteredCategories = collect();

    foreach ($categories as $categorie) {
        if ($categorie->id != $except->id && !$except->estFils($categorie)) {
            $filteredCategories->push($categorie);
        }
    }

    return $filteredCategories;
}
?>

@section('script')
    <script>
        $('.edit_categorie').click(function(e) {
            let that = $(this)
            let currentNom = that.data('nom');
            let currentParentId = that.data('parent_id');
            let currentDescription = that.data('description');
            let currentFormAction = that.data('href');

            console.log(currentParentId);
            if (currentParentId)
                $('#parent_id option[value=' + currentParentId + ']').attr("selected", true);

            $('#inputNomEdit').val(currentNom);
            $('#inputParentEdit').val(currentParentId);
            $('#inputDescriptionEdit').val(currentDescription);

            $('#form-edit-categorie').attr('action', currentFormAction);
        });
    </script>

    <script>
        // Archiver categorie
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.archive_categorie', function(event) {
                let that = $(this)
                event.preventDefault();
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });
                swalWithBootstrapButtons.fire({
                    title: 'Archiver la catégorie ?',
                    text: "Toutes les sous-catégories seront archivées",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
                                type: 'PUT',
                                success: function(data) {
                                    // document.location.reload();
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            })
                            .done(function() {

                                swalWithBootstrapButtons.fire(
                                        'Confirmation',
                                        'Catégorie archivée avec succès',
                                        'success'
                                    )
                                    .then((result) => {
                                        if (result.isConfirmed) {
                                            document.location.reload();
                                        }
                                    })
                            })
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Catégorie non archivée',
                            'error'
                        )
                    }
                });
            })
        });
    </script>

    <script>
        // Restaurer categorie
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.unarchive_categorie', function(event) {
                let that = $(this)
                event.preventDefault();
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });
                swalWithBootstrapButtons.fire({
                    title: 'Restaurer la catégorie ?',
                    text: "Toutes les sous catégories seront restaurées",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
                                type: 'POST',
                                success: function(data) {
                                    // document.location.reload();
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            })
                            .done(function() {
                                swalWithBootstrapButtons.fire(
                                        'Confirmation',
                                        'Catégorie restaurée avec succès',
                                        'success'
                                    )
                                    .then((result) => {
                                        if (result.isConfirmed) {
                                            document.location.reload();
                                        }
                                    })
                            })
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Catégorie non restaurée',
                            'error'
                        )
                    }
                });
            })
        });
    </script>

    <script>
        $('.edit_poste').click(function(e) {
            let that = $(this);
            let currentPoste = that.data('value');
            let currentFormAction = that.data('href');
            $('#edit_poste').val(currentPoste);
            $('#form-edit-poste').attr('action', currentFormAction);
        })
    </script>

    <script>
        // Archiver poste
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.archive_poste', function(event) {
                let that = $(this)
                event.preventDefault();
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });
                swalWithBootstrapButtons.fire({
                    title: 'Archiver le poste',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
                                type: 'PUT',
                                success: function(data) {
                                    // document.location.reload();
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            })
                            .done(function() {
                                swalWithBootstrapButtons.fire(
                                        'Confirmation',
                                        'Poste archivé avec succès',
                                        'success'
                                    )
                                    .then((result) => {
                                        if (result.isConfirmed) {
                                            document.location.reload();
                                        }
                                    })
                            })
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Poste non archivé',
                            'error'
                        )
                    }
                });
            })
        });
    </script>

    <script>
        // Restaurer poste
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.unarchive_poste', function(event) {
                let that = $(this)
                event.preventDefault();
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });
                swalWithBootstrapButtons.fire({
                    title: 'Restaurer le poste',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
                                type: 'POST',
                                success: function(data) {
                                    // document.location.reload();
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            })
                            .done(function() {

                                swalWithBootstrapButtons.fire(
                                        'Confirmation',
                                        ' Poste restauré avec succès',
                                        'success'
                                    )
                                    .then((result) => {
                                        if (result.isConfirmed) {
                                            document.location.reload();
                                        }
                                    })
                            })
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Poste non restauré',
                            'error'
                        )
                    }
                });
            })
        });
    </script>
@endsection
