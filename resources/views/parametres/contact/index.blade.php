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
                            <li class="breadcrumb-item"><a href="{{ route('parametre.contact') }}">Contacts</a></li>
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
                                <a href="#types" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0 active">
                                    <i class="mdi mdi-account-details font-18"></i>
                                    <span class="d-none d-lg-block">Types des contacts</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#postes" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                    <i class="mdi mdi-badge-account font-18"></i>
                                    <span class="d-none d-lg-block">Postes</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            {{-- Onglet types de contact --}}
                            @include('parametres.contact.types')

                            {{-- Onglet postes --}}
                            @include('parametres.contact.postes')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.edit_type').click(function(e) {
            let that = $(this);
            let currentType = that.data('value');
            let currentFormAction = that.data('href');
            $('#edit_type').val(currentType);
            $('#form-edit-type').attr('action', currentFormAction);
        })
    </script>

    <script>
        // Ajout type
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $('[data-toggle="tooltip"]').tooltip();

            $('#form-add-type').submit(function(event) {
                event.preventDefault(); // Prevent form submission
                let that = $(this);

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Ajouter le type de contact',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('[data-toggle="tooltip"]').tooltip('hide');
                        $.ajax({
                            url: that.attr('action'),
                            type: 'POST',
                            data: that.serialize(),
                            success: function(data) {
                            },
                            error: function(data) {
                            }
                        }).done(function() {
                            swalWithBootstrapButtons.fire(
                                'Confirmation',
                                'Type de contact ajouté avec succès',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    document.location.reload();
                                }
                            });
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Ajout annulé',
                            'error'
                        );
                    }
                });
            });
        });
    </script>

    <script>
        // Modification type
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $('[data-toggle="tooltip"]').tooltip();

            $('#form-edit-type').submit(function(event) {
                event.preventDefault(); // Prevent form submission
                let that = $(this);

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Modifier le type de contact',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('[data-toggle="tooltip"]').tooltip('hide');
                        $.ajax({
                            url: that.attr('action'),
                            type: 'POST',
                            data: that.serialize(),
                            success: function(data) {
                            },
                            error: function(data) {
                            }
                        }).done(function() {
                            swalWithBootstrapButtons.fire(
                                'Confirmation',
                                'Type de contact modifié avec succès',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    document.location.reload();
                                }
                            });
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Modification annulée',
                            'error'
                        );
                    }
                });
            });
        });
    </script>

    <script>
        // Archiver type
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.archive_type', function(event) {
                let that = $(this)
                event.preventDefault();
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });
                swalWithBootstrapButtons.fire({
                    title: 'Archiver le type de contact',
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
                                        'Type de contact archivé avec succès',
                                        'success'
                                    )
                                    .then((result) => {
                                        if (result.isConfirmed) {
                                            document.location.reload();
                                        }
                                    })


                                // document.location.reload();
                            })
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Type de contact non archivé',
                            'error'
                        )
                    }
                });
            })
        });
    </script>

    <script>
        // Restaurer type
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.unarchive_type', function(event) {
                let that = $(this)
                event.preventDefault();
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });
                swalWithBootstrapButtons.fire({
                    title: 'Restaurer le type de contact',
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
                                        'Type de contact restauré avec succès',
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
                            'Type de contact non restauré',
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
        // Ajout poste
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $('[data-toggle="tooltip"]').tooltip();

            $('#form-add-poste').submit(function(event) {
                event.preventDefault(); // Prevent form submission
                let that = $(this);

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Ajouter le poste',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('[data-toggle="tooltip"]').tooltip('hide');
                        $.ajax({
                            url: that.attr('action'),
                            type: 'POST',
                            data: that.serialize(),
                            success: function(data) {
                            },
                            error: function(data) {
                            }
                        }).done(function() {
                            swalWithBootstrapButtons.fire(
                                'Confirmation',
                                'Poste ajouté avec succès',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    document.location.reload();
                                }
                            });
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Ajout annulé',
                            'error'
                        );
                    }
                });
            });
        });
    </script>

    <script>
        // Modification poste
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $('[data-toggle="tooltip"]').tooltip();

            $('#form-edit-poste').submit(function(event) {
                event.preventDefault(); // Prevent form submission
                let that = $(this);

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Modifier le poste',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('[data-toggle="tooltip"]').tooltip('hide');
                        $.ajax({
                            url: that.attr('action'),
                            type: 'POST',
                            data: that.serialize(),
                            success: function(data) {
                            },
                            error: function(data) {
                            }
                        }).done(function() {
                            swalWithBootstrapButtons.fire(
                                'Confirmation',
                                'Poste modifié avec succès',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    document.location.reload();
                                }
                            });
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Modification annulée',
                            'error'
                        );
                    }
                });
            });
        });
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
