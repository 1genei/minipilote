<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />

    <title>@yield('title') | {{ env('APP_NAME') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="minipilote" name="description" />
    <meta content="1genei" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app-modern.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    @yield('css')

</head>

<body class="loading" data-layout-color="light" data-layout="detached" data-rightbar-onstart="true">

    @include('layouts.topbar')

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- Begin page -->
        <div class="wrapper">

            @include('layouts.nav')
            <div class="content-page">
