<!-- Topbar Start -->
<style>
    .navbar-custom .topbar-menu .nav-link {
        color: #fff;
    }
</style>


<div class="navbar-custom topnav-navbar topnav-navbar-dark" style="background-color:#23b8f1;">
    <div class="container-fluid">

        <!-- LOGO -->
        <a href="#" class="topnav-logo">
            <span class="topnav-logo-lg">
                {{-- <img src="{{ asset('images/logo.png') }}" alt="" height="50"> --}}
                <span style="color: #fff; font-size:20px; font-weight: bold;">{{ env('APP_NAME') }}</span>
            </span>
            <span class="topnav-logo-sm">
                {{-- <img src="{{ asset('images/logo.png') }}" alt="" height="30"> --}}
                <span style="color: #fff; font-size:20px; font-weight: bold;">{{ env('APP_NAME') }}</span>

            </span>
        </a>

        <ul class="list-unstyled topbar-menu float-end mb-0">

            <li class="dropdown notification-list d-xl-none">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i class="dripicons-search noti-icon" style="color:#fff"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                    <form class="p-3">
                        <input type="text" class="form-control" placeholder="Search ..."
                            aria-label="Recipient's username">
                    </form>
                </div>
            </li>



            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                    id="topbar-notifydrop" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="dripicons-bell noti-icon"></i>
                    <span class="noti-icon-badge"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg"
                    aria-labelledby="topbar-notifydrop">

                    <!-- item-->
                    <div class="dropdown-item noti-title px-3">
                        <h5 class="m-0">
                            <span class="float-end">
                                <a href="javascript: void(0);" class="text-dark">
                                    {{-- <small>Clear All</small> --}}
                                </a>
                            </span>Notification
                        </h5>
                    </div>

                    <div class="px-3" style="max-height: 300px;" data-simplebar>

                        <h5 class="text-muted font-13 fw-normal mt-0">Aujourd'hui</h5>
                        <!-- item-->


                        <!-- item-->
                        <a href="javascript:void(0);"
                            class="dropdown-item p-0 notify-item card read-noti shadow-none mb-2">
                            <div class="card-body">
                                <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="notify-icon bg-info">
                                            <i class="mdi mdi-account-plus"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 text-truncate ms-2">
                                        <h5 class="noti-item-title fw-semibold font-14">Admin <small
                                                class="fw-normal text-muted ms-1">Il y'a 1 heure</small></h5>
                                        <small class="noti-item-subtitle text-muted">Nouvelle utilisateur créé</small>
                                    </div>
                                </div>
                            </div>
                        </a>




                        <div class="text-center">
                            <i class="mdi mdi-dots-circle mdi-spin text-muted h3 mt-0"></i>
                        </div>
                    </div>

                    <!-- All-->
                    <a href="javascript:void(0);"
                        class="dropdown-item text-center text-primary notify-item border-top border-light py-2">
                        Tout afficher
                    </a>

                </div>
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
                    id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image"
                            class="rounded-circle">
                    </span>
                    <span>
                        <span class="account-user-name">{{ Auth::user()?->name }}</span>

                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown"
                    aria-labelledby="topbar-userdrop">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Bienvenue !</h6>
                    </div>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-circle me-1"></i>
                        <span>Mon compte</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-edit me-1"></i>
                        <span>paramètre</span>
                    </a>



                    <!-- item-->
                    <a href="javascript:void(0);"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                        class="dropdown-item notify-item">
                        <i class="mdi mdi-logout me-1"></i>
                        <span>Se déconnecter</span>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hide">
                            @csrf
                        </form>
                    </a>




                </div>
            </li>

        </ul>

        <a class="button-menu-mobile disable-btnx">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </a>

    </div>
</div>
<!-- end Topbar -->
