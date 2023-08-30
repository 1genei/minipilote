@extends('layouts.app')
@section('css')
@endsection

@section('title', 'Paramètres')

@section('content')
    <!-- Mise en page table, confirmation sweetalert -->
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('parametre.index') }}">Paramètres</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('parametre.produit') }}">Produits</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Paramètres</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-sm-4  mr-14 ">
                                {{-- <a href="{{route('action.index')}}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Retour</a> --}}
                                <h4 class="modal-title" id="addActionModalLabel"> Modification de vos paramètres </h4>

                            </div>
                            @if (session('ok'))
                                <div class="col-6">
                                    <div class="alert alert-success alert-dismissible bg-success text-white text-center border-0 fade show"
                                        role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong> {{ session('ok') }}</strong>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#categories" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0 active">
                                    <i class="mdi mdi-folder font-18"></i>
                                    <span class="d-none d-lg-block">Catégories</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#marques" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                    <i class="mdi mdi-palette-swatch font-18"></i>
                                    <span class="d-none d-lg-block">Marques</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            {{-- Onglet catégories --}}
                            @include('parametres.produit.categories')

                            {{-- Onglet marques --}}
                            @include('parametres.produit.marques')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
        $('.edit_categorie').click(function(e) {
            let that = $(this)
            let currentNom = that.data('nom');
            let currentParentId = that.data('parent_id');
            let currentDescription = that.data('description');
            let currentFormAction = that.data('href');

            if (currentParentId)
                $('#parent_id option[value=' + currentParentId + ']').attr("selected", true);

            $('#inputNomEditCategorie').val(currentNom);
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
    <script>
        $('.edit_marque').click(function(e) {
            let that = $(this)
            let currentNom = that.data('nom');
            let currentFormAction = that.data('href');

            $('#inputNomEditMarque').val(currentNom);
            $('#form-edit-marque').attr('action', currentFormAction);
        });
    </script>

    <script>
        // Archiver marque
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.archive_marque', function(event) {
                let that = $(this)
                event.preventDefault();
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });
                swalWithBootstrapButtons.fire({
                    title: 'Archiver la marque',
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
                                        'Marque archivée avec succès',
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
                            'Marque non archivée',
                            'error'
                        )
                    }
                });
            })
        });
    </script>

    <script>
        // Restaurer marque
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.unarchive_marque', function(event) {
                let that = $(this)
                event.preventDefault();
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });
                swalWithBootstrapButtons.fire({
                    title: 'Restaurer la marque',
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
                                        'Marque restaurée avec succès',
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
                            'Marque non restaurée',
                            'error'
                        )
                    }
                });
            })
        });
    </script>
@endsection