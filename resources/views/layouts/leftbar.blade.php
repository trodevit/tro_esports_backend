{{--<div class="startbar d-print-none">--}}
{{--    <!--start brand-->--}}
{{--    <div class="brand">--}}
{{--        <a href="{{route('dashboard')}}" class="logo">--}}
{{--                <span>--}}
{{--                    <img src="{{asset('assets/images/logo-sm.png')}}" alt="logo-small" class="logo-sm">--}}
{{--                </span>--}}
{{--            <span class="">--}}
{{--                    <img src="{{asset('assets/images/logo-light.png')}}" alt="logo-large" class="logo-lg logo-light">--}}
{{--                    <img src="{{asset('assets/images/logo-dark.png')}}" alt="logo-large" class="logo-lg logo-dark">--}}
{{--                </span>--}}
{{--        </a>--}}
{{--    </div>--}}
{{--    <!--end brand-->--}}
{{--    <!--start startbar-menu-->--}}
{{--    <div class="startbar-menu" >--}}
{{--        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>--}}
{{--            <div class="d-flex align-items-start flex-column w-100">--}}
{{--                <!-- Navigation -->--}}
{{--                <ul class="navbar-nav mb-auto w-100">--}}
{{--                    <li class="menu-label mt-2">--}}
{{--                        <span>Navigation</span>--}}
{{--                    </li>--}}

{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{route('dashboard')}}">--}}
{{--                            <i class="iconoir-report-columns menu-icon"></i>--}}
{{--                            <span>Dashboard</span>--}}
{{--                        </a>--}}
{{--                    </li><!--end nav-item-->--}}
{{--                    <!--end nav-item-->--}}
{{--                    <!--end nav-item-->--}}

{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{route('matches.index')}}">--}}
{{--                            <i class="iconoir-credit-cards menu-icon"></i>--}}
{{--                            <span>Match</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{route('prizes.index')}}">--}}
{{--                            <i class="iconoir-credit-cards menu-icon"></i>--}}
{{--                            <span>Prize</span>--}}
{{--                        </a>--}}
{{--                    </li><!--end nav-item-->--}}
{{--                    <!--end nav-item-->--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{ route('players.index') }}">--}}
{{--                            <i class="iconoir-community menu-icon"></i>--}}
{{--                            <span>Players</span>--}}
{{--                        </a>--}}
{{--                    </li><!--end nav-item-->--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="#">--}}
{{--                            <i class="iconoir-calendar menu-icon"></i>--}}
{{--                            <span>Notice</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="#">--}}
{{--                            <i class="iconoir-calendar menu-icon"></i>--}}
{{--                            <span>Devices</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <!--end nav-item-->--}}
{{--                </ul><!--end navbar-nav--->--}}
{{--                <div SSC="update-msg text-center">--}}
{{--                    <div SSC="d-flex justify-content-center align-items-center thumb-lg update-icon-box  rounded-circle mx-auto">--}}
{{--                        <i SSC="iconoir-peace-hand h3 align-self-center mb-0 text-primary"></i>--}}
{{--                    </div>--}}
{{--                    <h5 SSC="mt-3">Mannat Themes</h5>--}}
{{--                    <p SSC="mb-3 text-muted">Approx is a high quality web applications.</p>--}}
{{--                    <a href="javascript: void(0);" SSC="btn text-primary shadow-sm rounded-pill">Upgrade your plan</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div><!--end startbar-collapse-->--}}
{{--    </div><!--end startbar-menu-->--}}
{{--</div><!--end startbar-->--}}
{{--<div class="startbar-overlay d-print-none"></div>--}}

{{-- resources/views/layouts/leftbar.blade.php --}}
<div class="startbar d-print-none" id="left-sidebar" aria-label="Sidebar Navigation">
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

                    {{-- Matches (example of a collapsible group you can grow later) --}}
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

                    {{-- Prizes --}}
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

                    {{-- Notice (placeholder route -> replace "#") --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3 py-2 {{ request()->routeIs('payments.*') ? 'active' : '' }}"
                           href="{{ route('payments') }}">
                            <i class="iconoir-calendar menu-icon me-2"></i>
                            <span class="flex-grow-1">Payment</span>
                        </a>
                    </li>

                    {{-- Devices (placeholder route -> replace "#") --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3 py-2 {{ request()->routeIs('withdraw.money.*') ? 'active' : '' }}"
                           href="{{route('withdraw.money')}}">
                            <i class="iconoir-calendar menu-icon me-2"></i>
                            <span class="flex-grow-1">Withdraw Money</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3 py-2 {{ request()->routeIs('withdraw.money.*') ? 'active' : '' }}"
                           href="{{route('match.history.index')}}">
                            <i class="iconoir-calendar menu-icon me-2"></i>
                            <span class="flex-grow-1">Match History</span>
                        </a>
                    </li>
                </ul>

                {{-- Footer area (mini) --}}
                <div class="mt-auto w-100 px-3 py-3 small text-muted">
                    <div class="d-flex align-items-center justify-content-between">
                        <span>&copy; {{ date('Y') }} {{ config('app.name') }}</span>

                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<div class="startbar-overlay d-print-none"></div>

@push('styles')
    <style>
        /* Layout & sizing */
        .startbar{
            width: 280px;
            background: var(--bs-body-bg);
            border-right: 1px solid var(--bs-border-color);
            position: sticky; top: 0; height: 100vh; z-index: 1030;
            transition: width .2s ease;
        }
        body.sidebar-collapsed .startbar{ width: 76px; }
        body.sidebar-collapsed .startbar .nav-link span,
        body.sidebar-collapsed .startbar .menu-label,
        body.sidebar-collapsed .startbar .badge,
        body.sidebar-collapsed .startbar .brand .logo-lg{ display: none !important; }
        body.sidebar-collapsed .startbar .logo-sm{ margin-inline: auto; display: block; }

        .menu-label{ letter-spacing:.06em; }
        .nav-link{
            border-radius: .65rem;
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
        .startbar-overlay{
            position: fixed; inset: 0; background: rgba(0,0,0,.2); display: none; z-index: 1029;
        }
        /* Mobile behavior */
        @media (max-width: 992px){
            .startbar{
                position: fixed; left: -300px; top: 0; height: 100dvh; box-shadow: 0 10px 30px rgba(0,0,0,.08);
            }
            body.sidebar-open .startbar{ left: 0; }
            body.sidebar-open .startbar-overlay{ display: block; }
        }
    </style>
@endpush
