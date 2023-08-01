@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Fournisseurs</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Fournisseurs</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <style>
            body {

                font-size: 14px;
            }
        </style>

        <!-- end row-->


        <div class="row">
            <div class="col-lg-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 mr-14 ">
                                {{-- <a href="{{route('permission.index')}}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Permissions</a> --}}
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

                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-5">
                                <a href="{{ route('fournisseur.create') }}" class="btn btn-primary mb-2">
                                    <i class="mdi mdi-plus-circle me-2"></i>
                                    Nouveau fournisseur
                                </a>
                            </div>
                            <div class="col-sm-7">

                            </div><!-- end col-->
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
                                @if ($errors->has('role'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </div>
                                @endif
                                <div id="div-role-message"
                                    class="alert alert-success text-secondary alert-dismissible fade in">
                                    <i class="dripicons-checkmark me-2"></i>
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <a href="#" class="alert-link"><strong> <span
                                                id="role-message"></span></strong></a>
                                </div>

                            </div>
                        </div>

                        <ul class="nav nav-tabs nav-bordered mb-3">
                            <li class="nav-item">
                                <a href="#home-b1" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Individus</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b1" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Entités</span>
                                </a>
                            </li>

                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane show active" id="home-b1">
                            @include('fournisseur.index_individu', ['data' => $contactindividus])
                            </div>
                            <div class="tab-pane " id="profile-b1">
                                @include('fournisseur.index_entite')

                            </div>

                        </div>






                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

        {{-- Ajout d'un rôle --}}
        <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Ajouter un fournisseur</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('fournisseur.store') }}" method="post">
                        <div class="modal-body">

                            @csrf

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <select name="type" id="type" class="form-select">
                                            <option value="individu">individu</option>
                                            <option value="entité">entité</option>
                                        </select>
                                        <label for="floatingInput">Type</label>
                                        @if ($errors->has('type'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email"
                                            value="{{ old('email') ? old('email') : '' }}" class="form-control"
                                            id="floatingInput" required>
                                        <label for="floatingInput">Email</label>
                                        @if ($errors->has('email'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <br>

                            <hr><br>

                            <div class="row">

                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nom" value="{{ old('nom') ? old('nom') : '' }}"
                                            class="form-control" id="floatingInput" required>
                                        <label for="floatingInput">Nom</label>
                                        @if ($errors->has('nom'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('nom') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 div-individu">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="prenom"
                                            value="{{ old('prenom') ? old('prenom') : '' }}" class="form-control"
                                            id="floatingInput">
                                        <label for="floatingInput">Prénom(s)</label>
                                        @if ($errors->has('prenom'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('prenom') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 div-entite">
                                    <div class="form-floating mb-3">
                                        <select name="type_entite" id="type_entite" class="form-select">
                                            <option value="entreprise">entreprise</option>
                                            <option value="CE">CE</option>
                                            <option value="association">association</option>
                                            <option value="groupe">groupe</option>
                                            <option value="autre">autre</option>
                                        </select>
                                        <label for="floatingInput">Type d'entité</label>
                                        @if ($errors->has('type_entite'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('type_entite') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                            </div>


                            <div class="row">

                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="contact1"
                                            value="{{ old('contact1') ? old('contact1') : '' }}" class="form-control"
                                            id="floatingInput">
                                        <label for="floatingInput">Téléphone1</label>
                                        @if ($errors->has('contact1'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('contact1') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="contact2"
                                            value="{{ old('contact2') ? old('contact2') : '' }}" class="form-control"
                                            id="floatingInput">
                                        <label for="floatingInput">Téléphone2</label>
                                        @if ($errors->has('contact2'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('contact2') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <br>
                            <hr><br>

                            <div class="row">

                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="adresse"
                                            value="{{ old('adresse') ? old('adresse') : '' }}" class="form-control"
                                            id="floatingInput">
                                        <label for="floatingInput">Adresse</label>
                                        @if ($errors->has('adresse'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('adresse') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>


                            </div>

                            <div class="row">

                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="code_postal"
                                            value="{{ old('code_postal') ? old('code_postal') : '' }}"
                                            class="form-control" id="floatingInput">
                                        <label for="floatingInput">Code postal</label>
                                        @if ($errors->has('code_postal'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('code_postal') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="ville"
                                            value="{{ old('ville') ? old('ville') : '' }}" class="form-control"
                                            id="floatingInput">
                                        <label for="floatingInput">Ville</label>
                                        @if ($errors->has('ville'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('ville') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>

                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        {{-- Modification d'un rôle --}}
        <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Modifier le fournisseur</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="" method="post" id="form-edit">
                        <div class="modal-body">

                            @csrf

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <select name="type" id="edit-type" class="form-select">
                                            <option value="individu">individu</option>
                                            <option value="entité">entité</option>
                                        </select>
                                        <label for="floatingInput">Type</label>
                                        @if ($errors->has('type'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email"
                                            value="{{ old('email') ? old('email') : '' }}" class="form-control"
                                            id="edit-email" required>
                                        <label for="floatingInput">Email</label>
                                        @if ($errors->has('email'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <br>

                            <hr><br>

                            <div class="row">

                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nom" value="{{ old('nom') ? old('nom') : '' }}"
                                            class="form-control" id="edit-nom" required>
                                        <label for="floatingInput">Nom</label>
                                        @if ($errors->has('nom'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('nom') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 div-edit-individu">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="prenom"
                                            value="{{ old('prenom') ? old('prenom') : '' }}" class="form-control"
                                            id="edit-prenom">
                                        <label for="floatingInput">Prénom(s)</label>
                                        @if ($errors->has('prenom'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('prenom') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 div-edit-entite">
                                    <div class="form-floating mb-3">
                                        <select name="type_entite" id="edit-type_entite" class="form-select">
                                            <option value="entreprise">entreprise</option>
                                            <option value="CE">CE</option>
                                            <option value="association">association</option>
                                            <option value="groupe">groupe</option>
                                            <option value="autre">autre</option>
                                        </select>
                                        <label for="floatingInput">Type d'entité</label>
                                        @if ($errors->has('type_entite'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('type_entite') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                            </div>


                            <div class="row">

                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="contact1"
                                            value="{{ old('contact1') ? old('contact1') : '' }}" class="form-control"
                                            id="edit-contact1">
                                        <label for="floatingInput">Téléphone1</label>
                                        @if ($errors->has('contact1'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('contact1') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="contact2"
                                            value="{{ old('contact2') ? old('contact2') : '' }}" class="form-control"
                                            id="edit-contact2">
                                        <label for="floatingInput">Téléphone2</label>
                                        @if ($errors->has('contact2'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('contact2') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <br>
                            <hr><br>

                            <div class="row">

                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="adresse"
                                            value="{{ old('adresse') ? old('adresse') : '' }}" class="form-control"
                                            id="edit-adresse">
                                        <label for="floatingInput">Adresse</label>
                                        @if ($errors->has('adresse'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('adresse') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>


                            </div>

                            <div class="row">

                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="code_postal"
                                            value="{{ old('code_postal') ? old('code_postal') : '' }}"
                                            class="form-control" id="edit-code_postal">
                                        <label for="floatingInput">Code postal</label>
                                        @if ($errors->has('code_postal'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('code_postal') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" name="ville"
                                            value="{{ old('ville') ? old('ville') : '' }}" class="form-control"
                                            id="edit-ville">
                                        <label for="floatingInput">Ville</label>
                                        @if ($errors->has('ville'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('ville') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-success">Modifier</button>

                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    </div> <!-- End Content -->
@endsection

@section('script')
    {{-- selection des statuts du fournisseur --}}

    <script>
        $('#client').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#fournisseur').prop('checked', false);
            }

        });

        $('#fournisseur').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#client').prop('checked', false);
            }

        });
    </script>

    {{-- selection du type de fournisseur --}}

    <script>
        $('.div-entite').hide();

        $('#type').change(function(e) {

            if (e.currentTarget.value == "entité") {
                $('.div-entite').show();
                $('.div-individu').hide();

            } else {
                $('.div-entite').hide();
                $('.div-individu').show();
            }

        });
    </script>


    {{-- Modification d'un fournisseur --}}
    <script>
        $('.edit-contact').click(function(e) {

            let that = $(this);

            $('#edit-nom').val(that.data('nom'));
            $('#edit-prenom').val(that.data('prenom'));


            $('#edit-email').val(that.data('email'));
            $('#edit-contact1').val(that.data('contact1'));
            $('#edit-contact2').val(that.data('contact2'));
            $('#edit-adresse').val(that.data('adresse'));
            $('#edit-code_postal').val(that.data('code-postal'));
            $('#edit-ville').val(that.data('ville'));


            let currentFormAction = that.data('href');
            $('#form-edit').attr('action', currentFormAction);




            //    selection du type de fournisseur


            let currentType = that.data('type-contact');
            let currentTypeentite = that.data('typeentite');

            console.log(currentType);

            $('#edit-type option[value=' + currentType + ']').attr('selected', 'selected');


            if (currentType == "entité") {
                $('.div-edit-entite').show();
                $('.div-edit-individu').hide();

            } else {
                $('.div-edit-entite').hide();
                $('.div-edit-individu').show();
                console.log("yesss");
            }

            $('#edit-type').change(function(e) {

                if (e.currentTarget.value == "entité") {
                    $('.div-edit-entite').show();
                    $('.div-edit-individu').hide();

                } else {
                    $('.div-edit-entite').hide();
                    $('.div-edit-individu').show();
                }

            });


            $('#edit-type_entite option[value=' + currentTypeentite + ']').attr('selected', 'selected');



        })



        // selection des statuts du fournisseur  Modal modifier
        $('#edit-client').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#edit-fournisseur').prop('checked', false);
            }

        });

        $('#edit-fournisseur').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#edit-client').prop('checked', false);
            }

        });
    </script>


    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.archive-role', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Archiver',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: true
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
                                    'Archivé',
                                    '',
                                    'success'
                                )
                                document.location.reload();

                                // that.parents('tr').remove();
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulé',
                            'Rôle non archivé :)',
                            'error'
                        )
                    }
                });
            })

        });
    </script>

    <script>
        // Désarchiver

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.unarchive-role', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Désarchiver',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
                                // url:"/role/desarchiver/2",

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
                                    'Désarchivé',
                                    '',
                                    'success'
                                )
                                document.location.reload();
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulé',
                            'Rôle non désarchivé :)',
                            'error'
                        )
                    }
                });
            })

        });
    </script>


    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            "use strict";
            $("#tab1").
            DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    info: "Showing actions _START_ to _END_ of _TOTAL_",
                    lengthMenu: 'Afficher <select class=\'form-select form-select-sm ms-1 me-1\'><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> '
                },
                pageLength: 100,

                select: {
                    style: "multi"
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
                        document.querySelector(".dataTables_wrapper .row").querySelectorAll(".col-md-6")
                        .forEach(function(e) {
                            e.classList.add("col-sm-6"), e.classList.remove("col-sm-12"), e
                                .classList.remove("col-md-6")
                        })
                }
            })
        });
    </script>
@endsection
