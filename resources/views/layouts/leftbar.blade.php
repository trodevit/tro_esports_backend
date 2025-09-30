{{-- resources/views/layouts/leftbar.blade.php --}}
<div class="startbar d-print-none" id="leftSidebar" aria-label="Sidebar Navigation" aria-hidden="false">
    <!-- Brand -->
    <div class="brand px-3 py-2 border-bottom">
        <a href="{{ route('dashboard') }}" class="logo d-inline-flex align-items-center text-decoration-none">
            <span class="me-2">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="{{ config('app.name') }} logo" class="logo-sm" width="32" height="32">
            </span>
            <span class="d-none d-lg-inline-flex align-items-center">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="{{ config('app.name') }} light" class="logo-lg logo-light" height="22">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="{{ config('app.name') }} dark" class="logo-lg logo-dark" height="22">
            </span>
        </a>
    </div>

    <!-- Menu -->
    <div class="startbar-menu">
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <nav class="d-flex flex-column w-100" role="navigation">
                <ul class="navbar-nav mb-auto w-100 py-2">
                    <li class="menu-label px-3 mt-2 text-muted text-uppercase small fw-semibold">
                        Navigation
                    </li>

                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3 py-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            <i class="iconoir-report-columns menu-icon me-2"></i>
                            <span class="flex-grow-1">Dashboard</span>
                        </a>
                    </li>

                    {{-- Match --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3 py-2 {{ request()->routeIs('matches.*') ? 'active' : '' }}"
                           href="{{ route('matches.index') }}">
                            <i class="iconoir-credit-cards menu-icon me-2"></i>
                            <span class="flex-grow-1">Match</span>
                            @isset($matchCount)
                                <span class="badge bg-primary-subtle text-primary ms-2">{{ $matchCount }}</span>
                            @endisset
                        </a>
                    </li>

                    {{-- Prize --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3 py-2 {{ request()->routeIs('prizes.*') ? 'active' : '' }}"
                           href="{{ route('prizes.index') }}">
                            <i class="iconoir-credit-cards menu-icon me-2"></i>
                            <span class="flex-grow-1">Prize</span>
                        </a>
                    </li>

                    {{-- Players --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3 py-2 {{ request()->routeIs('players.*') ? 'active' : '' }}"
                           href="{{ route('players.index') }}">
                            <i class="iconoir-community menu-icon me-2"></i>
                            <span class="flex-grow-1">Players</span>
                            @isset($playerCount)
                                <span class="badge bg-success-subtle text-success ms-2">{{ $playerCount }}</span>
                            @endisset
                        </a>
                    </li>

                    {{-- Payment --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3 py-2 {{ request()->routeIs('payments.*') ? 'active' : '' }}"
                           href="{{ route('payments') }}">
                            <i class="iconoir-calendar menu-icon me-2"></i>
                            <span class="flex-grow-1">Payment</span>
                        </a>
                    </li>

                    {{-- Withdraw Money --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3 py-2 {{ request()->routeIs('withdraw.money.*') ? 'active' : '' }}"
                           href="{{ route('withdraw.money') }}">
                            <i class="iconoir-calendar menu-icon me-2"></i>
                            <span class="flex-grow-1">Withdraw Money</span>
                        </a>
                    </li>

                    {{-- Match History --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3 py-2 {{ request()->routeIs('match.history.*') ? 'active' : '' }}"
                           href="{{ route('match.history.index') }}">
                            <i class="iconoir-calendar menu-icon me-2"></i>
                            <span class="flex-grow-1">Match History</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3 py-2 {{ request()->routeIs('match.history.*') ? 'active' : '' }}"
                           href="{{ route('contact.us') }}">
                            <i class="iconoir-calendar menu-icon me-2"></i>
                            <span class="flex-grow-1">Contact Us</span>
                        </a>
                    </li>
                </ul>

                {{-- Footer --}}
                <div class="mt-auto w-100 px-3 py-3 small text-muted">
                    <div class="d-flex align-items-center justify-content-between">
                        <span>&copy; {{ date('Y') }} {{ config('app.name') }}</span>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

{{-- Backdrop (mobile) --}}
<div class="startbar-overlay d-print-none" id="startbarBackdrop" aria-hidden="true"></div>

@push('styles')
    <style>
        :root{
            --sidebar-w: 280px;
            --sidebar-collapsed-w: 76px;
            --radius: .65rem;
        }

        /* Base sidebar */
        .startbar{
            width: var(--sidebar-w);
            background: var(--bs-body-bg);
            border-right: 1px solid var(--bs-border-color);
            position: sticky; top: 0;
            height: 100vh;
            z-index: 1030;
            transition: width .2s ease, left .25s ease, transform .25s ease;
            will-change: width, transform;
        }

        /* Collapse to icons on >= lg when body has .sidebar-collapsed */
        @media (min-width: 992px){
            body.sidebar-collapsed .startbar{ width: var(--sidebar-collapsed-w); }
            body.sidebar-collapsed .startbar .nav-link span,
            body.sidebar-collapsed .startbar .menu-label,
            body.sidebar-collapsed .startbar .badge,
            body.sidebar-collapsed .startbar .brand .logo-lg{ display: none !important; }
            body.sidebar-collapsed .startbar .logo-sm{ margin-inline: auto; display: block; }
            body.sidebar-collapsed .startbar .nav-link{ justify-content: center; }
            body.sidebar-collapsed .startbar .menu-icon{ margin-inline: 0 !important; }
        }

        .menu-label{ letter-spacing:.06em; }
        .nav-link{
            border-radius: var(--radius);
            color: var(--bs-body-color);
            transition: background-color .15s ease, color .15s ease;
        }
        .nav-link .menu-icon{ font-size: 1.125rem; width: 1.5rem; text-align: center; }
        .nav-link:hover{ background: var(--bs-tertiary-bg); color: var(--bs-body-color); }
        .nav-link.active{
            background: var(--bs-primary-bg-subtle);
            color: var(--bs-primary);
            font-weight: 600;
        }

        .logo-sm{ display: block; }
        .logo-lg.logo-dark{ display: none; }
        [data-bs-theme="dark"] .logo-lg.logo-light{ display: none; }
        [data-bs-theme="dark"] .logo-lg.logo-dark{ display: inline-block; }

        /* Backdrop */
        .startbar-overlay{
            position: fixed; inset: 0;
            background: rgba(0,0,0,.35);
            display: none;
            z-index: 1029;
            opacity: 0;
            transition: opacity .2s ease;
        }

        /* Mobile slide-in behavior */
        @media (max-width: 991.98px){
            .startbar{
                position: fixed;
                left: -310px; top: 0;
                height: 100dvh;
                box-shadow: 0 10px 30px rgba(0,0,0,.12);
            }
            body.sidebar-open .startbar{ left: 0; }
            body.sidebar-open .startbar-overlay{
                display: block; opacity: 1;
            }
        }

        /* Touch-friendly spacing on small screens */
        @media (max-width: 575.98px){
            .nav-link{ padding: .75rem .875rem; }
            .menu-label{ padding-inline: .875rem !important; }
            .brand{ padding-inline: .875rem !important; }
        }

        /* Reduce motion preference */
        @media (prefers-reduced-motion: reduce){
            *{ transition-duration: .001ms !important; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function(){
            // Expect a mobile toggle button in your topbar:
            // <button id="togglemenu" class="btn btn-sm btn-outline-secondary mobile-menu-btn d-lg-none" aria-label="Toggle sidebar">
            //   <i class="bi bi-list"></i>
            // </button>
            const sidebar   = document.getElementById('leftSidebar');
            const backdrop  = document.getElementById('startbarBackdrop');
            const toggleBtn = document.getElementById('togglemenu');

            function openSidebar(){
                document.body.classList.add('sidebar-open');
                sidebar?.setAttribute('aria-hidden', 'false');
                toggleBtn?.setAttribute('aria-expanded', 'true');
            }
            function closeSidebar(){
                document.body.classList.remove('sidebar-open');
                sidebar?.setAttribute('aria-hidden', 'true');
                toggleBtn?.setAttribute('aria-expanded', 'false');
            }
            function toggleSidebar(){
                if(document.body.classList.contains('sidebar-open')) closeSidebar();
                else openSidebar();
            }

            // Wire events
            toggleBtn?.setAttribute('aria-controls','leftSidebar');
            toggleBtn?.setAttribute('aria-expanded','false');
            toggleBtn?.addEventListener('click', toggleSidebar);
            backdrop?.addEventListener('click', closeSidebar);

            // Close on ESC
            document.addEventListener('keydown', (e) => {
                if(e.key === 'Escape') closeSidebar();
            });

            // Trap focus inside sidebar when open (basic)
            document.addEventListener('focusin', (e) => {
                if (!document.body.classList.contains('sidebar-open')) return;
                if (sidebar && !sidebar.contains(e.target)) {
                    const focusable = sidebar.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
                    focusable?.focus();
                }
            });

            // Optional: auto-close on route change via Turbolinks/Livewire/etc. (no-op if not present)
            document.addEventListener('turbo:visit', closeSidebar);
        })();
    </script>
@endpush
