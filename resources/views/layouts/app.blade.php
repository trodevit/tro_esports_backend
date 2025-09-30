{{-- resources/views/layouts/app.blade.php --}}
    <!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <title>
        @hasSection('title')@yield('title') | {{ config('app.name') }}@else
            Dashboard | {{ config('app.name') }}@endif
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Admin & Dashboard for {{ config('app.name') }}" name="description" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    {{-- Fonts (fast path) --}}
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Core CSS (single source to avoid duplicates) --}}
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" />

    {{-- Bootstrap Icons (if not included by icons.min.css) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Page-level styles --}}
    @stack('styles')

    <style>
        :root{
            --sidebar-w: 260px;
            --radius: 1rem;
            --shell-max: 1800px;
        }
        /* Base */
        html, body { height: 100%; }
        body{
            font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji","Segoe UI Emoji";
            background: var(--bs-body-bg);
            -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        /* Layout */
        .page-wrapper{
            display: grid;
            grid-template-columns: var(--sidebar-w) 1fr;
            min-height: 100dvh;
            width: 100%;
        }
        .page-content{
            padding: clamp(.75rem, 1.2vw, 1.25rem);
        }
        .content-shell{
            width: min(92vw, var(--shell-max));
            margin-inline: auto;
        }

        /* Header block */
        .content-header{
            display: flex; align-items: center; justify-content: space-between; gap: .75rem;
            border-radius: var(--radius);
            background: var(--bs-tertiary-bg);
            margin-bottom: 1rem;
            padding: .875rem 1rem;
        }
        .content-header h1{
            margin: 0;
            font-size: clamp(1.125rem, 1.6vw, 1.5rem);
            font-weight: 700;
        }

        /* Card shell */
        .card-soft{
            border: 0; border-radius: var(--radius);
            box-shadow: 0 4px 14px rgba(0,0,0,.04);
            width: 100%;
            min-height: calc(100dvh - 170px);
        }

        /* Tables: safe horizontal scroll on narrow screens */
        .table-responsive{ overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .table{ width: 100%; }

        /* Images & media safe sizing */
        img, svg, canvas, video{ max-width: 100%; height: auto; }

        /* Sidebar (desktop) */
        .leftbar{
            width: var(--sidebar-w);
            min-height: 100%;
        }

        /* Slide-in sidebar on < 992px */
        @media (max-width: 991.98px){
            .page-wrapper{ grid-template-columns: 1fr; }
            .leftbar{
                position: fixed; inset: 0 auto 0 0;
                width: var(--sidebar-w);
                height: 100dvh;
                background: var(--bs-body-bg);
                box-shadow: 0 0 30px rgba(0,0,0,.12);
                transform: translateX(-100%);
                transition: transform .25s ease;
                z-index: 1050;
                overflow-y: auto; -webkit-overflow-scrolling: touch;
            }
            body.sidebar-open .leftbar{ transform: translateX(0); }
            .content-page, .page-content{ margin-left: 0 !important; }
            .topbar .mobile-menu-btn{ display: inline-flex !important; }
            .sidebar-backdrop{
                position: fixed; inset: 0;
                background: rgba(0,0,0,.35);
                z-index: 1040;
                opacity: 0; pointer-events: none;
                transition: opacity .2s ease;
            }
            body.sidebar-open .sidebar-backdrop{ opacity: 1; pointer-events: auto; }
        }

        /* Touch-friendly paddings on small devices */
        @media (max-width: 575.98px){
            .card .card-body{ padding: 1rem; }
            .p-4{ padding: 1.25rem !important; }
            .content-header{ flex-wrap: wrap; gap: .5rem; }
            .breadcrumb{ font-size: .9rem; }
        }

        /* Footer niceties */
        .footer-spacer{ height: 1rem; }
        .site-footer{ font-size: .95rem; }
        @media (max-width: 575.98px){
            .site-footer .row{ row-gap: .5rem; }
            .site-footer .text-end{ text-align: left !important; }
        }

        /* Theme toggle */
        .theme-toggle{
            --size: 38px;
            width: var(--size); height: var(--size);
            border-radius: 999px;
            display: inline-flex; align-items: center; justify-content: center;
            border: 1px solid var(--bs-border-color);
            background: var(--bs-body-bg);
        }

        /* Reduce motion preference */
        @media (prefers-reduced-motion: reduce){
            * { animation-duration: .001ms !important; animation-iteration-count: 1 !important; transition-duration: .001ms !important; scroll-behavior: auto !important; }
        }
    </style>
</head>

<body>
<a class="visually-hidden-focusable position-absolute top-0 start-0 p-2" href="#mainContent">Skip to content</a>

{{-- Topbar & Sidebar --}}
@include('layouts.topbar') {{-- Ensure the topbar has a button with id="togglemenu" for mobile --}}
<div class="page-wrapper">
    @include('layouts.leftbar')

    <main class="page-content" id="mainContent" role="main">
        <div class="content-shell">

            {{-- Header + breadcrumb + theme toggle --}}
            <div class="content-header">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <h1>@yield('page_title','Dashboard')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            @yield('breadcrumb') {{-- e.g. <li class="breadcrumb-item active">Analytics</li> --}}
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    @yield('header_actions')
                    <button class="theme-toggle" id="themeToggle" type="button" aria-label="Toggle theme">
                        <i class="bi bi-sun-fill d-none" id="iconSun" aria-hidden="true"></i>
                        <i class="bi bi-moon-stars-fill" id="iconMoon" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            {{-- Flash + errors --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! session('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Content --}}
            <div class="card card-soft">
                <div class="card-body p-3 p-md-4">
                    {{-- Wrap tables in .table-responsive automatically if a page forgets --}}
                    <div class="table-responsive">
                        @yield('content')
                    </div>
                </div>
            </div>

            <div class="footer-spacer"></div>
            @include('layouts.footer')
        </div>
    </main>
</div>

{{-- Backdrop for mobile sidebar --}}
<div class="sidebar-backdrop" id="sidebarBackdrop" aria-hidden="true"></div>

{{-- Core JS (defer for faster paint) --}}
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}" defer></script>
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}" defer></script>
<script src="{{ asset('assets/js/pages/index.init.js') }}" defer></script>
<script src="{{ asset('assets/js/DynamicSelect.js') }}" defer></script>
<script src="{{ asset('assets/js/app.js') }}" defer></script>

{{-- Theme persistence & mobile sidebar logic --}}
<script>
    (function () {
        // Theme toggle
        const root = document.documentElement;
        const btn  = document.getElementById('themeToggle');
        const sun  = document.getElementById('iconSun');
        const moon = document.getElementById('iconMoon');

        const stored = localStorage.getItem('bs-theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const initial = stored || (prefersDark ? 'dark' : 'light');
        root.setAttribute('data-bs-theme', initial);
        updateIcon(initial);

        btn?.addEventListener('click', () => {
            const next = root.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-bs-theme', next);
            localStorage.setItem('bs-theme', next);
            updateIcon(next);
        });

        function updateIcon(theme){
            const dark = theme === 'dark';
            sun?.classList.toggle('d-none', !dark);
            moon?.classList.toggle('d-none', dark);
        }

        // Mobile sidebar toggle
        const toggleBtn = document.getElementById('togglemenu'); // ensure this exists in topbar
        const backdrop  = document.getElementById('sidebarBackdrop');

        function closeSidebar(){
            document.body.classList.remove('sidebar-open');
            toggleBtn?.setAttribute('aria-expanded', 'false');
        }
        toggleBtn?.setAttribute('aria-controls','leftSidebar');
        toggleBtn?.setAttribute('aria-expanded','false');

        toggleBtn?.addEventListener('click', function(){
            const open = document.body.classList.toggle('sidebar-open');
            toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        backdrop?.addEventListener('click', closeSidebar);

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeSidebar();
        });

        // Trap focus inside sidebar when open (basic)
        document.addEventListener('focusin', (e) => {
            if (!document.body.classList.contains('sidebar-open')) return;
            const sidebar = document.querySelector('.leftbar');
            if (sidebar && !sidebar.contains(e.target)) {
                sidebar.querySelector('a, button, [tabindex]:not([tabindex="-1"])')?.focus();
            }
        });
    })();
</script>

{{-- Page-level scripts --}}
@stack('scripts')
</body>
</html>
