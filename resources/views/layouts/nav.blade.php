@php
    $curent_url = $_SERVER['REQUEST_URI'];
    $curent_url = explode('/', $curent_url);
    
    $li_dashboard = $li_utilisateur = $li_utilisateur_droit = $li_ordre_simule_algo1 = $li_ordre_simule_algo2 = $li_ordre_simule_algo3 = $li_ordre_simule_algo4 = $li_contact_collaborateur = $li_contact_prospect = $li_contact_client = $li_contact_fournisseur = $li_contact = $li_contrat_parrainage = $li_contrat = $li_catalogue_produit = $li_catalogue_stock = $li_catalogue_categorie = $li_catalogue_caracteristique = $li_parametre_contact = $li_parametre_generaux = $li_parametre_produit = '';
    $li_simulations = $li_utilisateur_show = $li_contact_show = $li_contrat_show = $li_catalogue_show = $li_parametre_show = false;
    
    switch ($curent_url[1]) {
        case '/':
            $li_dashboard = 'menuitem-active';
            break;
    
        // Utilisateurs
        case 'utilisateurs':
            $li_utilisateur = 'menuitem-active';
            $li_utilisateur_show = true;
            break;
        case 'roles':
            $li_utilisateur_droit = 'menuitem-active';
            $li_utilisateur_show = true;
            break;
        case 'permissions':
            $li_utilisateur_droit = 'menuitem-active';
            $li_utilisateur_show = true;
            break;
    
        // Contacts
        case 'collaborateurs':
            $li_contact_collaborateur = 'menuitem-active';
            $li_contact_show = true;
            break;
        case 'clients':
            $li_contact_client = 'menuitem-active';
            $li_contact_show = true;
            break;
        case 'prospects':
            $li_contact_prospect = 'menuitem-active';
            $li_contact_show = true;
            break;
        case 'fournisseurs':
            $li_contact_fournisseur = 'menuitem-active';
            $li_contact_show = true;
            break;
        case 'contacts':
            $li_contact = 'menuitem-active';
            $li_contact_show = true;
            break;
    
        // Contrats
        case 'contrats':
            $li_contrat = 'menuitem-active';
            $li_contrat_show = true;
            break;
        case 'parrainages':
            $li_contrat_parrainage = 'menuitem-active';
            $li_contrat_show = true;
            break;
    
        // Catalogue
        case 'produits':
            $li_catalogue_produit = 'menuitem-active';
            $li_catalogue_show = true;
            break;
        case 'stocks':
            $li_catalogue_stock = 'menuitem-active';
            $li_catalogue_show = true;
            break;
        case 'categories':
            $li_catalogue_categorie = 'menuitem-active';
            $li_catalogue_show = true;
            break;
        case 'fournisseurs':
            $li_catalogue_fournisseur = 'menuitem-active';
            $li_catalogue_show = true;
            break;
        case 'caracteristiques':
            $li_catalogue_caracteristique = 'menuitem-active';
            $li_catalogue_show = true;
            break;
    
        // Paramètres
        case 'parametres':
            if (sizeof($curent_url) > 2) {
                if ($curent_url[2] == 'contact') {
                    $li_parametre_contact = 'menuitem-active';
                } elseif ($curent_url[2] == 'produit') {
                    $li_parametre_produit = 'menuitem-active';
                }
            } else {
                $li_parametre_generaux = 'menuitem-active';
            }
    
            $li_parametre_show = true;
            break;
    
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

        <li class="side-nav-item {{ $li_dashboard }}">
            <a href="{{ route('welcome') }}" aria-expanded="false" aria-controls="sidebarDashboards"
                class="side-nav-link">
                <i class="mdi mdi-view-dashboard"></i>
                <span> Tableau de bord </span>
            </a>
        </li>



        <li class="side-nav-item {{ $li_utilisateur }} {{ $li_utilisateur_droit }} ">
            <a data-bs-toggle="collapse" href="#utilisateurs" aria-expanded="false" aria-controls="utilisateurs"
                class="side-nav-link">
                <i class="mdi mdi-account-lock-open-outline"></i>
                <span> Utilisateurs </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if ($li_utilisateur_show) show @endif " id="utilisateurs">
                <ul class="side-nav-second-level">
                    <li class="{{ $li_utilisateur }}">
                        <a href="{{ route('utilisateur.index') }}">Gestion</a>
                    </li>
                    <li class="{{ $li_utilisateur_droit }}">
                        <a href="{{ route('permission.index') }}">Droits</a>
                    </li>
                </ul>
            </div>
        </li>

        <li
            class="side-nav-item {{ $li_contact_collaborateur }} {{ $li_contact_prospect }} {{ $li_contact_client }} {{ $li_contact_fournisseur }} {{ $li_contact }}">
            <a data-bs-toggle="collapse" href="#contacts" aria-expanded="false" aria-controls="contacts"
                class="side-nav-link">
                <i class="mdi mdi-contacts-outline"></i>
                <span> Contacts</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if ($li_contact_show) show @endif" id="contacts">
                <ul class="side-nav-second-level">
                    <li class="{{ $li_contact_collaborateur }}">
                        <a href="{{ route('collaborateur.index') }}">Collaborateurs</a>
                    </li>
                    <li class="{{ $li_contact_prospect }}">
                        <a href="{{ route('prospect.index') }}">Prospects</a>
                    </li>
                    <li class="{{ $li_contact_client }}">
                        <a href="{{ route('client.index') }}">Clients</a>
                    </li>
                    <li class="{{ $li_contact_fournisseur }}">
                        <a href="{{ route('fournisseur.index') }}">Fournisseurs</a>
                    </li>
                    <li class="{{ $li_contact }}">
                        <a href="{{ route('contact.index') }}">Tous les contacts</a>
                    </li>

                </ul>
            </div>
        </li>



        <li class="side-nav-item {{ $li_contrat_parrainage }} {{ $li_contrat }} ">
            <a data-bs-toggle="collapse" href="#contrats" aria-expanded="" aria-controls="contrats"
                class="side-nav-link">
                <i class="mdi mdi-book-edit-outline"></i>
                <span> Contrats</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if ($li_contrat_show) show @endif" id="contrats">
                <ul class="side-nav-second-level">

                    <li class="{{ $li_contrat }}">
                        <a href="#">Gestion</a>
                    </li>
                    <li class="{{ $li_contrat_parrainage }}">
                        <a href="#">Parrainages</a>

                    </li>
                </ul>
            </div>
        </li>



        <li
            class="side-nav-item {{ $li_catalogue_produit }} {{ $li_catalogue_stock }} {{ $li_catalogue_categorie }} {{ $li_catalogue_caracteristique }}">
            <a data-bs-toggle="collapse " href="#catalogue" aria-expanded="" aria-controls="catalogue"
                class="side-nav-link">
                <i class="mdi  mdi-beaker-outline"></i>
                <span>Catalogue</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if ($li_catalogue_show) show @endif" id="catalogue">
                <ul class="side-nav-second-level">
                    <li class="{{ $li_catalogue_produit }}"><a href="{{ route('produit.index') }}"> Produits </a></li>
                    <li class="{{ $li_catalogue_stock }}"><a href="#"> Stock </a></li>
                    <li class="{{ $li_catalogue_categorie }}"><a href="#"> Catégories </a></li>
                    <li class="{{ $li_catalogue_caracteristique }}">
                        <a href="{{ route('caracteristique.index') }}">Caractéristiques </a>
                    </li>
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
            <div class="collapse " id="affaires">
                <ul class="side-nav-second-level">
                    <li class=""><a href="#">Gestion</a> </li>
                    <li> <a href="#"> Propositions commerciales </a></li>
                    <li> <a href="#"> Devis </a></li>
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

        <li
            class="side-nav-item {{ $li_parametre_contact }} {{ $li_parametre_generaux }} {{ $li_parametre_produit }} ">
            <a data-bs-toggle="collapse" href="#parametres" aria-expanded="" aria-controls="parametres"
                class="side-nav-link">
                <i class="uil uil-bright"></i>
                <span>Paramètres</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if ($li_parametre_show) show @endif" id="parametres">
                <ul class="side-nav-second-level">
                    <li class="{{ $li_parametre_generaux }}"><a href="{{ route('parametre.index') }}">Généraux</a>
                    </li>
                    <li class="{{ $li_parametre_contact }}"> <a href="{{ route('parametre.contact') }}"> Contacts
                        </a></li>
                    <li class="{{ $li_parametre_produit }}"> <a href="{{ route('parametre.produit') }}"> Produits
                        </a></li>
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
        color: #f9c851 !important;
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


    /* SWEETALERT */

    /* Mettre espace entre les deux btn OUI et NON */
    .swal2-cancel {
        margin-left: 5px;
    }
</style>
