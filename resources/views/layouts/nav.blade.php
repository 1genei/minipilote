@php
    $seg  = Request::segment(1) ?? '';
    $seg2 = Request::segment(2) ?? '';

    $activeId = match($seg) {
        '', 'welcome'                                           => 'dashboard',
        'utilisateurs', 'roles', 'permissions'                 => 'utilisateurs',
        'collaborateurs','clients','prospects',
        'fournisseurs','contacts'                              => 'contacts',
        'planning'                                             => 'planning',
        'produits','stocks','categories','caracteristiques'    => 'catalogue',
        'devis','commandes','factures'                         => 'affaires',
        'evenements'                                           => 'evenements',
        'prestations'                                          => 'prestations',
        'agendas'                                              => 'agenda',
        'parametres'                                           => 'parametres',
        default                                                => '',
    };

    $activeChild = match(true) {
        $seg === 'utilisateurs'                    => 'Gestion',
        in_array($seg, ['roles','permissions'])    => 'Droits',
        $seg === 'collaborateurs'                  => 'Collaborateurs',
        $seg === 'clients'                         => 'Clients',
        $seg === 'prospects'                       => 'Prospects',
        $seg === 'fournisseurs'                    => 'Fournisseurs',
        $seg === 'contacts'                        => 'Tous les contacts',
        $seg === 'produits'                        => 'Produits',
        $seg === 'caracteristiques'                => 'Caractéristiques',
        $seg === 'devis'                           => 'Devis',
        $seg === 'commandes'                       => 'Commandes',
        $seg === 'factures'                        => 'Factures',
        default                                    => '',
    };
@endphp

{{-- Initialise la largeur avant le premier paint --}}
<script>
(function(){
    var w = localStorage.getItem('mpMode')==='expanded' ? '256px' : '96px';
    document.documentElement.style.setProperty('--mp-rail-w', w);
})();

window.mpNav = function(activeId) {
    return {
        expanded: localStorage.getItem('mpMode') === 'expanded',
        openSec:  {},
        flyItem:  null,
        flyTop:   0,
        flyTimer: null,

        init() {
            if (activeId) this.openSec[activeId] = true;
            this._applyWidth();
        },
        _applyWidth() {
            var w = this.expanded ? '256px' : '96px';
            document.documentElement.style.setProperty('--mp-rail-w', w);
        },
        toggle() {
            this.expanded = !this.expanded;
            this._applyWidth();
            localStorage.setItem('mpMode', this.expanded ? 'expanded' : 'rail');
            if (!this.expanded) this.flyItem = null;
        },
        toggleSec(id) {
            if (!this.expanded) return;
            this.openSec[id] = !this.openSec[id];
        },
        hover(event, id) {
            if (this.expanded) { this.flyItem = null; return; }
            clearTimeout(this.flyTimer);
            if (!id) { this.flyItem = null; return; }
            var rect = event.currentTarget.getBoundingClientRect();
            this.flyTop = rect.top;
            this.flyItem = id;
        },
        leave() {
            var self = this;
            self.flyTimer = setTimeout(function(){ self.flyItem = null; }, 180);
        },
        cancelLeave() {
            clearTimeout(this.flyTimer);
        },
    };
};
</script>

<style>
[x-cloak] { display: none !important; }

/* ===== CSS VARIABLES ===== */
:root {
    --mp-accent:      #2d1b5e;
    --mp-accent-tint: #ece8f6;
    --mp-on-accent:   #fff;
    --ink-900: #15131c;
    --ink-700: #3a3543;
    --ink-500: #67616f;
    --ink-300: #9c97a3;
    --ink-200: #d9d6df;
    --ink-100: #ececef;
    --ink-050: #f6f5f9;
    --mp-rail-w:    96px;
    --mp-topbar-h:  56px;
}

/* ===== LAYOUT OVERRIDE ===== */
body[data-layout=detached] .leftside-menu,
.mp-sidebar {
    position:  fixed !important;
    top: 0 !important; left: 0 !important; bottom: 0 !important;
    width:     var(--mp-rail-w) !important;
    min-width: var(--mp-rail-w) !important;
    max-width: none !important;
    margin: 0 !important; padding: 0 !important;
    background: #fff !important;
    border-right: 1px solid var(--ink-100) !important;
    transition: width .18s ease !important;
    overflow: visible !important;
    z-index: 100 !important;
    display: flex !important;
    flex-direction: column !important;
}

.content-page {
    margin-left: var(--mp-rail-w) !important;
    margin-top:  var(--mp-topbar-h) !important;
    transition:  margin-left .18s ease !important;
    padding: 12px 18px 24px !important;
    min-height: calc(100vh - var(--mp-topbar-h)) !important;
    background: #f3f2f7 !important;
}

/* ===== RAIL TOP ===== */
.mp-rail-top {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 10px; min-height: 60px; flex: 0 0 auto;
    border-bottom: 1px solid var(--ink-100);
}
.mp-brand-mark {
    width: 34px; height: 34px; border-radius: 9px;
    background: var(--mp-accent); color: var(--mp-on-accent);
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 17px; flex: 0 0 auto;
    box-shadow: 0 2px 6px rgba(21,19,28,.20);
}
.mp-brand-word {
    font-weight: 800; font-size: 14px; letter-spacing: -.01em;
    color: var(--ink-900); white-space: nowrap; margin-left: 8px;
}
.mp-hamburger {
    width: 30px; height: 30px; border: 0; border-radius: 7px;
    background: transparent; color: var(--ink-500); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex: 0 0 auto; padding: 0;
}
.mp-hamburger:hover { background: var(--ink-050); color: var(--ink-900); }

/* ===== SCROLL AREA ===== */
.mp-rail-scroll {
    flex: 1 1 auto; overflow-y: auto; overflow-x: visible;
    padding: 8px 8px 16px;
    display: flex; flex-direction: column; gap: 2px;
}
.mp-rail-scroll::-webkit-scrollbar { width: 4px; }
.mp-rail-scroll::-webkit-scrollbar-thumb { background: var(--ink-200); border-radius: 4px; }

/* ===== NAV ITEM (rail = column) ===== */
.mp-item {
    position: relative; width: 100%; border: 0; background: transparent;
    cursor: pointer; color: var(--ink-700); font-family: inherit;
    display: flex; align-items: center;
    border-radius: 10px;
    transition: background .12s ease, color .12s ease;
    text-decoration: none !important;
    /* rail: column */
    flex-direction: column; gap: 2px; padding: 8px 4px; text-align: center;
}
.mp-item-tile {
    display: flex; align-items: center; justify-content: center;
    width: 34px; height: 28px; border-radius: 7px; color: inherit; flex: 0 0 auto;
}
.mp-item-label {
    font-size: 10px; font-weight: 500; line-height: 1.2;
    color: var(--ink-700); width: 100%;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.mp-item:hover { background: var(--ink-050); }

/* ---- Fidèle: active state ---- */
.mp-item.is-active {
    background: #fff;
    box-shadow: 0 1px 4px rgba(21,19,28,.10), 0 0 0 1px rgba(21,19,28,.05);
}
.mp-item.is-active .mp-item-tile { color: var(--mp-accent); }
.mp-item.is-active .mp-item-label { color: var(--ink-900); font-weight: 700; }
.mp-item.is-active::before {
    content: ""; position: absolute; left: -8px; top: 50%; transform: translateY(-50%);
    width: 3px; height: 22px; border-radius: 3px; background: var(--mp-accent);
}

/* ===== EXPANDED MODE (row) ===== */
.mp-mode-expanded .mp-item {
    flex-direction: row; text-align: left; gap: 10px; padding: 9px 12px;
}
.mp-mode-expanded .mp-item-tile { width: 20px; height: 20px; }
.mp-mode-expanded .mp-item-label {
    font-size: 12.5px; font-weight: 600; flex: 1;
    display: flex; align-items: center; justify-content: space-between;
    white-space: normal;
}
.mp-mode-expanded .mp-item.is-active::before { height: 28px; }

.mp-acc-arrow { color: var(--ink-300); display: flex; transition: transform .15s ease; }
.mp-acc-arrow.is-open { transform: rotate(180deg); }

/* ===== ACCORDION ===== */
.mp-acc-list {
    list-style: none; margin: 2px 0 4px; padding: 0;
    display: flex; flex-direction: column;
}
.mp-acc-list li a {
    display: block; text-decoration: none; color: var(--ink-500);
    font-size: 11.5px; font-weight: 500;
    padding: 6px 10px 6px 42px; border-radius: 8px;
    border-left: 2px solid var(--ink-100); margin-left: 18px;
}
.mp-acc-list li a:hover { color: var(--ink-900); background: var(--ink-050); }
.mp-acc-list li a.is-active { color: var(--mp-accent); font-weight: 700; border-left-color: var(--mp-accent); }

/* ===== FLYOUT ===== */
.mp-flyout {
    position: fixed; left: var(--mp-rail-w); z-index: 9999;
    min-width: 200px;
    background: #fff; border: 1px solid var(--ink-100); border-radius: 12px;
    box-shadow: 0 16px 44px -12px rgba(21,19,28,.28), 0 2px 8px rgba(21,19,28,.06);
    padding: 8px; margin-left: 6px;
    animation: mpFlyIn .13s ease;
}
@keyframes mpFlyIn {
    from { opacity: 0; transform: translateX(-6px); }
    to   { opacity: 1; transform: none; }
}
.mp-flyout-title {
    font-size: 10px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
    color: var(--ink-300); padding: 4px 10px 8px;
}
.mp-flyout-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 1px; }
.mp-flyout-list a {
    display: block; text-decoration: none; color: var(--ink-700);
    font-size: 12.5px; font-weight: 500; padding: 7px 10px; border-radius: 8px;
}
.mp-flyout-list a:hover { background: var(--ink-050); color: var(--ink-900); }
.mp-flyout-list a.is-active { background: var(--mp-accent-tint); color: var(--mp-accent); font-weight: 700; }

/* ===== GLOBAL STYLES (repris de l'ancien nav) ===== */
.text-muted  { color: #252121 !important; }
.table       { color: #252121 !important; }

.nav-pills .nav-link.active,
.nav-pills .show > .nav-link { background-color: #6c757d !important; }

.swal2-cancel { margin-left: 5px; }

body { font-size: 12px !important; }
.btn { font-size: 12px; }
.dropdown-menu { font-size: 12px; }
.page-title-box .page-title { font-size: 12px; }
</style>

<div class="leftside-menu mp-sidebar"
     x-data="mpNav('{{ $activeId }}')"
     x-init="init()"
     :class="expanded ? 'mp-mode-expanded' : 'mp-mode-rail'">

    {{-- TOP --}}
    <div class="mp-rail-top">
        <div style="display:flex;align-items:center;overflow:hidden;">
            <div class="mp-brand-mark">M</div>
            <span class="mp-brand-word" x-show="expanded" x-cloak>Minipilote</span>
        </div>
        <button class="mp-hamburger" @click="toggle()" title="Replier / déplier">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                <path d="M4 6.5h16M4 12h16M4 17.5h16"/>
            </svg>
        </button>
    </div>

    {{-- SCROLL --}}
    <div class="mp-rail-scroll">

        @can('permission', 'afficher-dashboard')
        <a href="{{ route('welcome') }}"
           class="mp-item {{ $activeId === 'dashboard' ? 'is-active' : '' }}"
           @mouseenter="hover($event, null)" @mouseleave="leave()">
            <span class="mp-item-tile">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7.5" height="7.5" rx="1.6"/>
                    <rect x="13.5" y="3" width="7.5" height="7.5" rx="1.6"/>
                    <rect x="3" y="13.5" width="7.5" height="7.5" rx="1.6"/>
                    <rect x="13.5" y="13.5" width="7.5" height="7.5" rx="1.6"/>
                </svg>
            </span>
            <span class="mp-item-label" x-text="expanded ? 'Tableau de bord' : 'Accueil'"></span>
        </a>
        @endcan

        @can('permission', 'afficher-utilisateur')
        <div @mouseenter="hover($event, 'utilisateurs')" @mouseleave="leave()">
            <button class="mp-item {{ $activeId === 'utilisateurs' ? 'is-active' : '' }}"
                    @click="toggleSec('utilisateurs')">
                <span class="mp-item-tile">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="8" r="3.1"/>
                        <path d="M3.6 19.5c0-3 2.4-5 5.4-5s5.4 2 5.4 5"/>
                        <path d="M16 5.3a3 3 0 0 1 0 5.4"/><path d="M17.4 14.7c2.1.5 3.7 2.3 3.7 4.8"/>
                    </svg>
                </span>
                <span class="mp-item-label" x-show="!expanded">Utilisateurs</span>
                <span class="mp-item-label" x-show="expanded" x-cloak>
                    Utilisateurs
                    <span class="mp-acc-arrow" :class="openSec.utilisateurs ? 'is-open' : ''">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M5.5 9l6.5 6.5L18.5 9"/></svg>
                    </span>
                </span>
            </button>
            <ul class="mp-acc-list" x-show="expanded && openSec.utilisateurs" x-cloak>
                @can('permission', 'afficher-utilisateur')
                <li><a href="{{ route('utilisateur.index') }}" class="{{ $activeChild === 'Gestion' ? 'is-active' : '' }}">Gestion</a></li>
                @endcan
                @can('permission', 'afficher-droit')
                <li><a href="{{ route('permission.index') }}" class="{{ $activeChild === 'Droits' ? 'is-active' : '' }}">Droits</a></li>
                @endcan
            </ul>
        </div>
        @endcan

        @can('permission', 'afficher-contact')
        <div @mouseenter="hover($event, 'contacts')" @mouseleave="leave()">
            <button class="mp-item {{ $activeId === 'contacts' ? 'is-active' : '' }}"
                    @click="toggleSec('contacts')">
                <span class="mp-item-tile">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3.4" y="4.6" width="17.2" height="14.8" rx="2.2"/>
                        <circle cx="9" cy="10.2" r="2.1"/>
                        <path d="M5.9 15.8c0-1.7 1.4-2.9 3.1-2.9s3.1 1.2 3.1 2.9"/>
                        <path d="M14.7 9.2h3.9M14.7 12.2h3.9M14.7 15.2h2.6"/>
                    </svg>
                </span>
                <span class="mp-item-label" x-show="!expanded">Contacts</span>
                <span class="mp-item-label" x-show="expanded" x-cloak>
                    Contacts
                    <span class="mp-acc-arrow" :class="openSec.contacts ? 'is-open' : ''">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M5.5 9l6.5 6.5L18.5 9"/></svg>
                    </span>
                </span>
            </button>
            <ul class="mp-acc-list" x-show="expanded && openSec.contacts" x-cloak>
                @can('permission', 'afficher-collaborateur')
                <li><a href="{{ route('collaborateur.index') }}" class="{{ $activeChild === 'Collaborateurs' ? 'is-active' : '' }}">Collaborateurs</a></li>
                @endcan
                @can('permission', 'afficher-prospect')
                <li><a href="{{ route('prospect.index') }}" class="{{ $activeChild === 'Prospects' ? 'is-active' : '' }}">Prospects</a></li>
                @endcan
                @can('permission', 'afficher-client')
                <li><a href="{{ route('client.index') }}" class="{{ $activeChild === 'Clients' ? 'is-active' : '' }}">Clients</a></li>
                @endcan
                @can('permission', 'afficher-fournisseur')
                <li><a href="{{ route('fournisseur.index') }}" class="{{ $activeChild === 'Fournisseurs' ? 'is-active' : '' }}">Fournisseurs</a></li>
                @endcan
                @can('permission', 'afficher-tous-les-contacts')
                <li><a href="{{ route('contact.index') }}" class="{{ $activeChild === 'Tous les contacts' ? 'is-active' : '' }}">Tous les contacts</a></li>
                @endcan
            </ul>
        </div>
        @endcan

        <a href="{{ route('planning.index') }}"
           class="mp-item {{ $activeId === 'planning' ? 'is-active' : '' }}"
           @mouseenter="hover($event, null)" @mouseleave="leave()">
            <span class="mp-item-tile">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3.4" y="5" width="17.2" height="15" rx="2.2"/>
                    <path d="M3.4 9.4h17.2"/><path d="M8 3.4v3.2M16 3.4v3.2"/>
                    <circle cx="12" cy="14.4" r="3"/><path d="M12 12.9v1.6l1.1.8"/>
                </svg>
            </span>
            <span class="mp-item-label">Planning</span>
        </a>

        @can('permission', 'afficher-produit')
        <div @mouseenter="hover($event, 'catalogue')" @mouseleave="leave()">
            <button class="mp-item {{ $activeId === 'catalogue' ? 'is-active' : '' }}"
                    @click="toggleSec('catalogue')">
                <span class="mp-item-tile">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3.2 20 7.4v9.2L12 20.8 4 16.6V7.4z"/>
                        <path d="M4 7.4 12 11.7l8-4.3"/><path d="M12 11.7v9.1"/>
                    </svg>
                </span>
                <span class="mp-item-label" x-show="!expanded">Catalogue</span>
                <span class="mp-item-label" x-show="expanded" x-cloak>
                    Catalogue
                    <span class="mp-acc-arrow" :class="openSec.catalogue ? 'is-open' : ''">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M5.5 9l6.5 6.5L18.5 9"/></svg>
                    </span>
                </span>
            </button>
            <ul class="mp-acc-list" x-show="expanded && openSec.catalogue" x-cloak>
                <li><a href="{{ route('produit.index') }}" class="{{ $activeChild === 'Produits' ? 'is-active' : '' }}">Produits</a></li>
                @can('permission', 'afficher-caracteristique-produit')
                <li><a href="{{ route('caracteristique.index') }}" class="{{ $activeChild === 'Caractéristiques' ? 'is-active' : '' }}">Caractéristiques</a></li>
                @endcan
            </ul>
        </div>
        @endcan

        @can('permission', 'afficher-affaire')
        <div @mouseenter="hover($event, 'affaires')" @mouseleave="leave()">
            <button class="mp-item {{ $activeId === 'affaires' ? 'is-active' : '' }}"
                    @click="toggleSec('affaires')">
                <span class="mp-item-tile">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13.2 4.5H7a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6.2"/>
                        <path d="M16.6 3.4 20.2 7l-7.1 7.1-3.6.5.5-3.6z"/>
                    </svg>
                </span>
                <span class="mp-item-label" x-show="!expanded">Affaires</span>
                <span class="mp-item-label" x-show="expanded" x-cloak>
                    Affaires
                    <span class="mp-acc-arrow" :class="openSec.affaires ? 'is-open' : ''">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M5.5 9l6.5 6.5L18.5 9"/></svg>
                    </span>
                </span>
            </button>
            <ul class="mp-acc-list" x-show="expanded && openSec.affaires" x-cloak>
                @can('permission', 'afficher-devis')
                <li><a href="{{ route('devis.index') }}" class="{{ $activeChild === 'Devis' ? 'is-active' : '' }}">Devis</a></li>
                @endcan
                @can('permission', 'afficher-commande')
                <li><a href="{{ route('commande.index') }}" class="{{ $activeChild === 'Commandes' ? 'is-active' : '' }}">Commandes</a></li>
                @endcan
                @can('permission', 'afficher-facture')
                <li><a href="{{ route('facture.index') }}" class="{{ $activeChild === 'Factures' ? 'is-active' : '' }}">Factures</a></li>
                @endcan
            </ul>
        </div>
        @endcan

        @can('permission', 'afficher-evenement')
        <a href="{{ route('evenement.index') }}"
           class="mp-item {{ $activeId === 'evenements' ? 'is-active' : '' }}"
           @mouseenter="hover($event, null)" @mouseleave="leave()">
            <span class="mp-item-tile">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3.4l1.9 4.8 4.8 1.8-4.8 1.9L12 16.7l-1.9-4.8L5.3 10l4.8-1.8z"/>
                    <path d="M18.2 15.1l.6 1.7 1.7.6-1.7.6-.6 1.7-.6-1.7-1.7-.6 1.7-.6z"/>
                </svg>
            </span>
            <span class="mp-item-label">Événements</span>
        </a>
        @endcan

        @can('permission', 'afficher-prestation')
        <a href="{{ route('prestation.index') }}"
           class="mp-item {{ $activeId === 'prestations' ? 'is-active' : '' }}"
           @mouseenter="hover($event, null)" @mouseleave="leave()">
            <span class="mp-item-tile">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.8 4.6a3.6 3.6 0 0 0-4.9 4.6l-5.3 5.3a1.7 1.7 0 0 0 2.4 2.4l5.3-5.3a3.6 3.6 0 0 0 4.6-4.9l-2.1 2.1-2-.1-.1-2z"/>
                </svg>
            </span>
            <span class="mp-item-label">Prestations</span>
        </a>
        @endcan

        @can('permission', 'afficher-agenda')
        <a href="{{ route('agenda.listing') }}"
           class="mp-item {{ $activeId === 'agenda' ? 'is-active' : '' }}"
           @mouseenter="hover($event, null)" @mouseleave="leave()">
            <span class="mp-item-tile">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3.4" y="5" width="17.2" height="15" rx="2.2"/>
                    <path d="M3.4 9.4h17.2"/><path d="M8 3.4v3.2M16 3.4v3.2"/>
                    <path d="M7 13h4.5M7 16.2h8"/>
                </svg>
            </span>
            <span class="mp-item-label">Agenda</span>
        </a>
        @endcan

        @can('permission', 'afficher-parametre')
        <a href="{{ route('parametre.index') }}"
           class="mp-item {{ $activeId === 'parametres' ? 'is-active' : '' }}"
           @mouseenter="hover($event, null)" @mouseleave="leave()">
            <span class="mp-item-tile">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M12 3.4v2.3M12 18.3v2.3M5.4 5.4l1.7 1.7M16.9 16.9l1.7 1.7M3.4 12h2.3M18.3 12h2.3M5.4 18.6l1.7-1.7M16.9 7.1l1.7-1.7"/>
                </svg>
            </span>
            <span class="mp-item-label">Paramètres</span>
        </a>
        @endcan

    </div>{{-- /mp-rail-scroll --}}

    {{-- FLYOUTS (position:fixed, rail mode seulement) --}}

    @can('permission', 'afficher-utilisateur')
    <div class="mp-flyout" x-show="flyItem === 'utilisateurs'" x-cloak
         :style="`top:${flyTop}px`"
         @mouseenter="cancelLeave()" @mouseleave="leave()">
        <div class="mp-flyout-title">Utilisateurs</div>
        <ul class="mp-flyout-list">
            @can('permission', 'afficher-utilisateur')
            <li><a href="{{ route('utilisateur.index') }}" class="{{ $activeChild === 'Gestion' ? 'is-active' : '' }}">Gestion</a></li>
            @endcan
            @can('permission', 'afficher-droit')
            <li><a href="{{ route('permission.index') }}" class="{{ $activeChild === 'Droits' ? 'is-active' : '' }}">Droits</a></li>
            @endcan
        </ul>
    </div>
    @endcan

    @can('permission', 'afficher-contact')
    <div class="mp-flyout" x-show="flyItem === 'contacts'" x-cloak
         :style="`top:${flyTop}px`"
         @mouseenter="cancelLeave()" @mouseleave="leave()">
        <div class="mp-flyout-title">Contacts</div>
        <ul class="mp-flyout-list">
            @can('permission', 'afficher-collaborateur')
            <li><a href="{{ route('collaborateur.index') }}" class="{{ $activeChild === 'Collaborateurs' ? 'is-active' : '' }}">Collaborateurs</a></li>
            @endcan
            @can('permission', 'afficher-prospect')
            <li><a href="{{ route('prospect.index') }}" class="{{ $activeChild === 'Prospects' ? 'is-active' : '' }}">Prospects</a></li>
            @endcan
            @can('permission', 'afficher-client')
            <li><a href="{{ route('client.index') }}" class="{{ $activeChild === 'Clients' ? 'is-active' : '' }}">Clients</a></li>
            @endcan
            @can('permission', 'afficher-fournisseur')
            <li><a href="{{ route('fournisseur.index') }}" class="{{ $activeChild === 'Fournisseurs' ? 'is-active' : '' }}">Fournisseurs</a></li>
            @endcan
            @can('permission', 'afficher-tous-les-contacts')
            <li><a href="{{ route('contact.index') }}" class="{{ $activeChild === 'Tous les contacts' ? 'is-active' : '' }}">Tous les contacts</a></li>
            @endcan
        </ul>
    </div>
    @endcan

    @can('permission', 'afficher-produit')
    <div class="mp-flyout" x-show="flyItem === 'catalogue'" x-cloak
         :style="`top:${flyTop}px`"
         @mouseenter="cancelLeave()" @mouseleave="leave()">
        <div class="mp-flyout-title">Catalogue</div>
        <ul class="mp-flyout-list">
            <li><a href="{{ route('produit.index') }}" class="{{ $activeChild === 'Produits' ? 'is-active' : '' }}">Produits</a></li>
            @can('permission', 'afficher-caracteristique-produit')
            <li><a href="{{ route('caracteristique.index') }}" class="{{ $activeChild === 'Caractéristiques' ? 'is-active' : '' }}">Caractéristiques</a></li>
            @endcan
        </ul>
    </div>
    @endcan

    @can('permission', 'afficher-affaire')
    <div class="mp-flyout" x-show="flyItem === 'affaires'" x-cloak
         :style="`top:${flyTop}px`"
         @mouseenter="cancelLeave()" @mouseleave="leave()">
        <div class="mp-flyout-title">Affaires</div>
        <ul class="mp-flyout-list">
            @can('permission', 'afficher-devis')
            <li><a href="{{ route('devis.index') }}" class="{{ $activeChild === 'Devis' ? 'is-active' : '' }}">Devis</a></li>
            @endcan
            @can('permission', 'afficher-commande')
            <li><a href="{{ route('commande.index') }}" class="{{ $activeChild === 'Commandes' ? 'is-active' : '' }}">Commandes</a></li>
            @endcan
            @can('permission', 'afficher-facture')
            <li><a href="{{ route('facture.index') }}" class="{{ $activeChild === 'Factures' ? 'is-active' : '' }}">Factures</a></li>
            @endcan
        </ul>
    </div>
    @endcan

</div>{{-- /mp-sidebar --}}
