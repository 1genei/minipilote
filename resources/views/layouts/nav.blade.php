@php
    $curent_url = $_SERVER['REQUEST_URI'];
    $curent_url = explode('/', $curent_url);
    $li_ordre_simule_algo1 = $li_ordre_simule_algo2 = $li_ordre_simule_algo3 = $li_ordre_simule_algo4 = '';
    $li_simulations = 'false';
    
    switch ($curent_url[1]) {
        case 'ordres-simule':
            if (sizeof($curent_url) > 3) {
                switch (substr($curent_url[3], 0, 1)) {
                    case '2':
                        $li_ordre_simule_algo2 = 'menuitem-active';
                        $li_simulations = 'true';
                        break;
                    case '3':
                        $li_ordre_simule_algo3 = 'menuitem-active';
                        $li_simulations = 'true';
    
                        break;
                    case '4':
                        $li_ordre_simule_algo4 = 'menuitem-active';
                        $li_simulations = 'true';
    
                        break;
    
                    default:
                        $li_ordre_simule_algo1 = 'menuitem-active';
                        $li_simulations = 'true';
                        break;
                }
            }
            break;
    
        default:
            // dd("default");
            break;
    }
    
@endphp



<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu leftside-menu-detached">

    <div class="leftbar-user">
        <a href="javascript: void(0);">
            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image" height="42"
                class="rounded-circle shadow-sm">
            <span class="leftbar-user-name">Admin</span>
        </a>
    </div>

    <!--- Sidemenu -->
    <ul class="side-nav">

        <li class="side-nav-item">
            <a href="{{ route('welcome') }}" aria-expanded="false" aria-controls="sidebarDashboards"
                class="side-nav-link">
                <i class="mdi mdi-view-dashboard"></i>
                <span> Tableau de bord </span>
            </a>
        </li>



        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#utilisateurs" aria-expanded="false" aria-controls="utilisateurs"
                class="side-nav-link">
                <i class="mdi mdi-account-lock-open-outline"></i>
                <span> Utilisateurs </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="utilisateurs">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('utilisateur.index') }}">Gestion</a>
                    </li>
                    <li>
                        <a href="{{ route('permission.index') }}">Droits</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#contacts" aria-expanded="{{ $li_simulations }}" aria-controls="contacts"
                class="side-nav-link">
                <i class="mdi mdi-contacts-outline"></i>
                <span> Contacts</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if ($li_simulations) show @endif" id="contacts">
                <ul class="side-nav-second-level">

                    <li class="{{ $li_ordre_simule_algo1 }}">
                        <a href="{{ route('collaborateur.index') }}">Collaborateurs</a>
                        <a href="{{ route('prospect.index') }}">Prospects</a>
                        <a href="{{ route('client.index') }}">Clients</a>
                        <a href="{{ route('fournisseur.index') }}">Fournisseurs</a>
                        <a href="{{ route('contact.index') }}">Tous les contacts</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#contrats" aria-expanded="{{ $li_simulations }}"
                aria-controls="contrats" class="side-nav-link">
                <i class="mdi mdi-book-edit-outline"></i>
                <span> Contrats</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if ($li_simulations) show @endif" id="contrats">
                <ul class="side-nav-second-level">

                    <li class="{{ $li_ordre_simule_algo1 }}">
                        <a href="#">Gestion</a>
                        <a href="#">Parrainages</a>

                    </li>
                </ul>
            </div>
        </li>



        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#catalogue" aria-expanded="" aria-controls="catalogue"
                class="side-nav-link">
                <i class="mdi  mdi-beaker-outline"></i>
                <span>Catalogue</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if ($li_simulations) show @endif" id="catalogue">
                <ul class="side-nav-second-level">
                    <li class=""><a href="{{ route('produit.index') }}"> Produits </a></li>
                    <li class=""><a href="#"> Catégories </a></li>
                    <li class=""><a href="#"> Caractéristiques </a></li>
                    <li class=""><a href="#"> Stock </a></li>
                </ul>
            </div>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#affaires" aria-expanded="" aria-controls="affaires"
                class="side-nav-link">
                <i class="mdi mdi-book-edit-outline"></i>
                <span>Affaires</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if ($li_simulations) show @endif" id="affaires">
                <ul class="side-nav-second-level">

                    <li class="">
                        <a href="#">Gestion</a>
                        <a href="#"> Propositions commerciales </a>
                        <a href="#"> Devis </a>
                    </li>
                </ul>
            </div>
        </li>


        <li class="side-nav-item">
            <a href="{{ route('agenda.listing') }}" aria-expanded="false" aria-controls="sidebarDashboards"
                class="side-nav-link">
                <i class="uil-calendar-alt"></i>
                <span> Agenda </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('parametre.index') }}" aria-expanded="false" aria-controls="sidebarCrm"
                class="side-nav-link">
                <i class="uil uil-bright"></i>
                <span> Paramètres </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#affaires" aria-expanded="" aria-controls="affaires"
                class="side-nav-link">
                <i class="mdi mdi-book-edit-outline"></i>
                <span>Paramètres</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if ($li_simulations) show @endif" id="affaires">
                <ul class="side-nav-second-level">
                    <li class="">
                        <a href="{{ route('parametre.index') }}">Généraux</a>
                        <a href="{{ route('parametre.contact') }}"> Contacts </a>
                        <a href="{{ route('parametre.produit') }}"> Produits </a>
                    </li>
                </ul>
            </div>
        </li>


    </ul>


    <!-- End Sidebar -->

    <div class="clearfix"></div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->

<style>
    body[data-layout=detached] .leftside-menu {

        background: #263349 !important;
        color: #fff;
        margin-top: 0px;
        min-width: 100px;

        /* border-radius: 30px; */

    }

    body[data-layout=detached] .leftside-menu .side-nav .menuitem-active>a {
        color: #fff !important;
    }

    body[data-layout=detached] .leftside-menu .side-nav .side-nav-forth-level li a,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-second-level li a,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-third-level li a {
        color: #fff;
    }

    body[data-layout=detached] .leftside-menu .side-nav .side-nav-link {
        color: #fff !important;
    }


    /* Couleur lien menus */
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-link:active,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-link:focus,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-link:hover {
        color: #f9c851 !important;
    }

    /* Couleurs lien sous menus */
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-forth-level li a:focus,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-forth-level li a:hover,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-second-level li a:focus,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-second-level li a:hover,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-third-level li a:focus,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-third-level li a:hover {
        color: #f9c851 !important;
    }



    body[data-layout=detached][data-leftbar-compact-mode=condensed] .side-nav .side-nav-item:hover .side-nav-link {
        background: #263349;

    }

    @media (min-width: 992px) {

        body[data-layout=detached] .container-fluid,
        body[data-layout=detached] .container-lg,
        body[data-layout=detached] .container-md,
        body[data-layout=detached] .container-sm,
        body[data-layout=detached] .container-xl,
        body[data-layout=detached] .container-xxl {
            max-width: 100%;
        }
    }



    /* POLICE DE CARACTERE */



    body {
        font-size: 12px !important;

    }

    /* Menu */
    .side-nav .side-nav-link {
        font-size: 12px;
    }

    /* Sous menu */
    .side-nav-forth-level li .side-nav-link,
    .side-nav-forth-level li a,
    .side-nav-second-level li .side-nav-link,
    .side-nav-second-level li a,
    .side-nav-third-level li .side-nav-link,
    .side-nav-third-level li a {

        font-size: 12px;
    }

    /* titre des pages */
    .page-title-box .page-title {
        font-size: 12px;
    }

    .btn {
        font-size: 12px;
    }

    .dropdown-menu {
        font-size: 12px;
    }
</style>
