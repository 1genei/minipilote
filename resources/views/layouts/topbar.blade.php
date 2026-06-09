<style>
.mp-topbar {
    position: fixed;
    top: 0; left: var(--mp-rail-w, 96px); right: 0;
    height: var(--mp-topbar-h, 56px);
    background: #fff;
    border-bottom: 1px solid var(--ink-100, #ececef);
    display: flex; align-items: center;
    padding: 0 20px; gap: 14px;
    z-index: 90;
    transition: left .18s ease;
}
.mp-topbar-brand {
    display: flex; align-items: center; gap: 8px;
    font-weight: 700; font-size: 14px; color: var(--ink-900, #15131c);
    white-space: nowrap;
}
.mp-topbar-sep { color: var(--ink-200, #d9d6df); }
.mp-topbar-sub { font-size: 11.5px; color: var(--ink-500, #67616f); white-space: nowrap; }

.mp-top-right { margin-left: auto; display: flex; align-items: center; gap: 4px; }

.mp-top-btn {
    width: 36px; height: 36px; border: 0; border-radius: 8px;
    background: transparent; cursor: pointer; position: relative;
    color: var(--ink-500, #67616f);
    display: flex; align-items: center; justify-content: center;
}
.mp-top-btn:hover { background: var(--ink-050, #f6f5f9); color: var(--ink-900, #15131c); }

.mp-avatar-btn {
    width: 34px; height: 34px; border-radius: 50%; border: 0; cursor: pointer;
    background: var(--mp-accent, #2d1b5e); color: #fff;
    font-weight: 700; font-size: 12px; margin-left: 4px;
    display: flex; align-items: center; justify-content: center;
}
.mp-avatar-btn:hover { filter: brightness(1.1); }

/* Surcharge du menu déroulant Bootstrap */
.mp-topbar .dropdown-menu { font-size: 12px; min-width: 180px; }
</style>

<div class="mp-topbar">

    <div class="mp-topbar-brand">
        <span>Minipilote</span>
    </div>
    <span class="mp-topbar-sep">|</span>
    <span class="mp-topbar-sub">Gestion de pilotage automobile</span>

    <div class="mp-top-right">

        {{-- Notifications --}}
        <div class="dropdown">
            <button class="mp-top-btn" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6.4 10a5.6 5.6 0 0 1 11.2 0c0 4 1.6 5.6 1.6 5.6H4.8S6.4 14 6.4 10z"/>
                    <path d="M9.9 18.6a2.2 2.2 0 0 0 4.2 0"/>
                </svg>
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">
                <div class="dropdown-item noti-title px-3">
                    <h6 class="m-0">Notifications</h6>
                </div>
                <a href="javascript:void(0);" class="dropdown-item notify-item card read-noti shadow-none mb-2 px-3">
                    <div class="d-flex align-items-center gap-2 py-1">
                        <div class="notify-icon bg-info"><i class="mdi mdi-account-plus"></i></div>
                        <div>
                            <div class="fw-semibold" style="font-size:12px;">Admin <small class="text-muted fw-normal">Il y a 1h</small></div>
                            <small class="text-muted">Nouvel utilisateur créé</small>
                        </div>
                    </div>
                </a>
                <a href="javascript:void(0);" class="dropdown-item text-center text-primary border-top py-2">
                    Tout afficher
                </a>
            </div>
        </div>

        {{-- Utilisateur --}}
        <div class="dropdown">
            <button class="mp-avatar-btn" data-bs-toggle="dropdown" aria-expanded="false"
                    title="{{ Auth::user()?->name }}">
                @php
                    $initiales = collect(explode(' ', Auth::user()?->name ?? ''))->map(fn($p) => strtoupper(substr($p,0,1)))->take(2)->implode('');
                @endphp
                {{ $initiales ?: 'U' }}
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">
                <div class="dropdown-header px-3 py-2">
                    <div class="fw-bold" style="font-size:12px;">{{ Auth::user()?->name }}</div>
                    <small class="text-muted">{{ Auth::user()?->email }}</small>
                </div>
                <div class="dropdown-divider"></div>
                <a href="javascript:void(0);" class="dropdown-item">
                    <i class="mdi mdi-account-circle me-2"></i>Mon compte
                </a>
                <div class="dropdown-divider"></div>
                <a href="javascript:void(0);"
                   onclick="event.preventDefault(); document.getElementById('logout-form-top').submit();"
                   class="dropdown-item text-danger">
                    <i class="mdi mdi-logout me-2"></i>Se déconnecter
                </a>
                <form id="logout-form-top" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

    </div>
</div>
