@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
@endsection

@section('title', 'Ajout client')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Clients</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Clients</h4>
                </div>
            </div>

            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 ">
                                {{-- <a href="{{ URL::previous() }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Retour</a> --}}
                                <a href="{{ route('client.index') }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Clients</a>

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
            </div>
        </div>
        <!-- end page title -->

        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">



                        <!-- end row-->
                        <div class="row">

                            <div class="col-6">
                                @if (session('message'))
                                    <div class="alert alert-success text-secondary alert-dismissible ">
                                        <i class="dripicons-checkmark me-2"></i>
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <a href="#" class="alert-link"><strong> {{ session('message') }}</strong></a>
                                    </div>
                                @endif


                            </div>
                        </div>


                        <div class="row">

                            <div class="row justify-content-between">
                                <div class="col-4">

                                </div>
                                <div class="col-4">

                                    <a href="" type="button" class="btn btn-secondary"><i class="uil-plus"></i>
                                        Publié</a>

                                </div>
                            </div>




                        </div>

                        <form action="{{ route('produit.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    {{-- <h4 class="modal-title" id="">Modifier l'article</h4> --}}
                                    <br>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <br>


                                    @csrf

                                    <div class="row">
                                        <div class="col-8">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="titre" class="form-label">Titre *</label>
                                                    <input type="text" class="form-control" name="titre"
                                                        value="{{ old('titre') }}" id="titre" required>
                                                    @if ($errors->has('titre'))
                                                        <br>
                                                        <div class="alert alert-danger" role="alert">
                                                            <i class="dripicons-wrong me-2"></i>
                                                            <strong>{{ $errors->first('titre') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="contenu" class="form-label">Contenu *</label>

                                                <textarea rows="50" id="contenu" name="contenu" required> </textarea>
                                            </div>
                                        </div>


                                        <div class="col-4">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="categorie_id" class="form-label">Catégorie *</label>
                                                    <select name="categorie_id" id="categorie_id" class="form-select"
                                                        required>
                                                        <option value=""></option>
                                                        {{-- @foreach ($categories as $categorie)
                                                            <option value="{{ $categorie->id }}">{{ $categorie->nom }}
                                                            </option>
                                                        @endforeach --}}
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <label for="images" class="form-label">Image(s)</label>

                                                <div class="fallback">
                                                    <input name="images[]" class=" btn btn-danger image-multiple"
                                                        accept="image/*" type="file" multiple />
                                                </div>

                                            </div>



                                        </div>
                                    </div>



                                </div>
                                <div class="modal-footer"
                                    style="position: fixed;bottom: 10px; margin: 0;  left: 50%; z-index:1 ;">
                                    <a class="btn btn-light btn-lg " href="{{ route('produit.index') }}">Annuler</a>
                                    <button type="submit"
                                        class="btn btn-dark btn-flat btn-addon btn-lg ">Enregistrer</button>
                                </div>


                            </div>
                        </form>



                        <style>
                            .select2-container .select2-selection--single {
                                height: calc(1.69em + 0.9rem + 2px);
                            }
                        </style>



                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->





    </div> <!-- End Content -->
@endsection

@section('script')

@endsection
