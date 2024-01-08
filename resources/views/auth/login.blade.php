<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Connexion | {{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

</head>

<body class="loading authentication-bg" data-layout-config='{"darkMode":false}'>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <a href="#" style="color: #fff; font-size:25px; font-weight: bold;">
                                {{-- <span><img src="assets/images/logo.png" alt="" height="18"></span> --}}
                                {{ env('APP_NAME') }}
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 fw-bold">Connexion</h4>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Session Status -->
                                <x-auth-session-status class="mb-4" :status="session('status')" />
                                <!-- Validation Errors -->
                                <x-auth-validation-errors class="mb-4" :errors="$errors" class="text-danger" />

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email </label>
                                    <input class="form-control" type="email" name="email" id="emailaddress"
                                        required="">
                                </div>

                                <div class="mb-3">
                                    <a href="{{ route('password.email') }}" class="text-muted float-end"><small>Mot de
                                            passe oublié ?</small></a>
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="password" id="password" class="form-control">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                        <label class="form-check-label" for="checkbox-signin">Se souvenir de moi</label>
                                    </div>
                                </div>

                                <div class="mb-3 text-center">
                                    <button class="btn btn-primary" type="submit"> Se connecter </button>
                                </div>

                                {{-- <div class="mb-3 mt-15 text-center">
                                    <a href="{{ route('logino365') }}" class="btn btn-danger" type="submit"> Se
                                        connecter avec Office 365</a>
                                </div> --}}
                            </form>

                            @if (session('error'))
                                <div class="alert alert-danger mt-10 ">
                                    <strong> {{ session('error') }} </strong>
                                </div>
                            @endif
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        <script>
            document.write(new Date().getFullYear())
        </script> © {{ env('APP_NAME') }}
    </footer>

    <!-- bundle -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

</body>

</html>
