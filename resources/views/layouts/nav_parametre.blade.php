<nav class="nav nav-pills justify-content-center mb-4" style="font-family: 'Comic Sans MS', 'Comic Sans', cursive; font-size: 14px;">
    <a class="nav-link {{ request()->routeIs('parametre.index') ? 'active' : '' }}" href="{{ route('parametre.index') }}">généraux</a>
    <a class="nav-link {{ request()->routeIs('parametre.planning.index') ? 'active' : '' }}" href="{{ route('parametre.planning.index') }}">Planning</a>
    <a class="nav-link {{ request()->routeIs('parametre.contact') ? 'active' : '' }}" href="{{ route('parametre.contact') }}">Contacts</a>
    <a class="nav-link {{ request()->routeIs('parametre.produit') ? 'active' : '' }}" href="{{ route('parametre.produit') }}">Catalogue</a>
    <a class="nav-link {{ request()->routeIs('voiture.index') ? 'active' : '' }}" href="{{ route('voiture.index') }}">Voitures</a>
    <a class="nav-link {{ request()->routeIs('circuit.index') ? 'active' : '' }}" href="{{ route('circuit.index') }}">Circuits</a>
</nav>


<style>
    .nav-pills .nav-link.active {
        background-color: #a89aa8;
        color: #fff;
        font-weight: bold;
        border-radius: 14px;
    }
    .nav-pills .nav-link {
        /* color: #772e7b; */
        margin: 0 8px;
        /* transition: background 0.2s, color 0.2s; */
    }
    .nav-pills .nav-link:hover {
        background: #f5f5f5;
        color: #095cb9;
    }
</style>
