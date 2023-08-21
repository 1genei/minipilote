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
                                    <i class="mdi mdi-account-circle font-18"></i>
                                    <span class="d-none d-lg-block">Type des contacts</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#postes" data-bs-toggle="tab" aria-expanded="true"
                                    class="nav-link rounded-0">
                                    <i class="mdi mdi-truck-fast font-18"></i>
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


