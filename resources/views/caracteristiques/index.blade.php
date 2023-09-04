@extends('layouts.app')
@section('css')
@endsection

@section('title', 'Caractéristiques')

@section('content')
<div class="content">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('caracteristique.index')}}">Caractéristiques</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Caractéristiques</h4>
                </div>
            </div>
        </div>

        <style>
            body {

                font-size: 13px;
            }
        </style>
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

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex justify-content-start">
                                <a href="#" class="btn btn-primary mb-2">
                                    <i class="mdi mdi-plus-circle me-2"></i> Nouvelle caractéristique
                                </a>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('caracteristique.archives') }}" class="btn btn-warning mb-2">
                                    <i class="mdi mdi-archive me-2"></i> Caractéristiques archivées
                                </a>
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
                                @if ($errors->has('caracteristique'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('caracteristique') }}</strong>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div>
                            <livewire:caracteristique.caracteristiques-table />
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection