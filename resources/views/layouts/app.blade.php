{{--<!DOCTYPE html>--}}
{{--<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">--}}

{{--<head>--}}


{{--    <meta charset="utf-8" />--}}
{{--    <title>Dashboard | {{config('app.name')}}</title>--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">--}}
{{--    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />--}}
{{--    <meta content="" name="author" />--}}
{{--    <meta http-equiv="X-UA-Compatible" content="IE=edge" />--}}

{{--    <!-- App favicon -->--}}
{{--    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">--}}


{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>--}}

{{--    <!-- App css -->--}}
{{--    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />--}}

{{--</head>--}}

{{--<body>--}}

{{--@include('layouts.topbar')--}}
{{--@include('layouts.leftbar')--}}
{{--<div class="page-wrapper">--}}
{{--    <div class="page-content">--}}
{{--        @if (session('success'))--}}
{{--            <div class="alert alert-success alert-dismissible fade show" role="alert">--}}
{{--                {!! session('success') !!}--}}
{{--                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        @if ($errors->any())--}}
{{--            <div class="alert alert-danger alert-dismissible fade show" role="alert">--}}
{{--                <ul class="mb-0">--}}
{{--                    @foreach ($errors->all() as $error)--}}
{{--                        <li>{{ $error }}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        @yield('content')--}}
{{--        @include('layouts.footer')--}}
{{--    </div>--}}
{{--</div>--}}

{{--<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>--}}
{{--<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>--}}

{{--<script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>--}}
{{--<script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>--}}
{{--<script src="{{asset('assets/js/pages/index.init.js')}}"></script>--}}
{{--<script src="{{asset('assets/js/DynamicSelect.js')}}"></script>--}}
{{--<script src="{{asset('assets/js/app.js')}}"></script>--}}

{{--</body>--}}
{{--</html>--}}

    <!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <title>@hasSection('title')@yield('title') | {{ config('app.name') }}@else Dashboard | {{ config('app.name') }}@endif</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Admin & Dashboard for {{ config('app.name') }}" name="description" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    {{-- Preconnects / preloads for faster first paint (optional) --}}
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Core CSS (use one source only to avoid duplicates) --}}
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" />

    {{-- Page-level styles --}}
    @stack('styles')

    <style>
        :root{
            --shp-radius: 1rem;
        }
        body{
            font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji","Segoe UI Emoji";
            background: var(--bs-body-bg);
        }
        .page-wrapper{
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 0;
            min-height: 100vh;
            overflow-x: hidden !important;
        }
        @media (max-width: 992px){
            .page-wrapper{
                grid-template-columns: 1fr;
            }
        }
        .page-content{
            padding: 1.25rem;
        }
        .content-shell{
            width: min(92vw, 1800px);
            margin-inline: auto;
        }
        .content-header{
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            border-radius: var(--shp-radius);
            background: var(--bs-tertiary-bg);
            margin-bottom: 1rem;
            padding: 1rem 1.25rem;
        }
        .content-header h1{
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }
        .card-soft{
            border: 0;
            border-radius: var(--shp-radius);
            box-shadow: 0 4px 14px rgba(0,0,0,.04);
            width: 100%;
            min-height: calc(100dvh - 170px)
        }
        /* Alerts nicer spacing */
        .alert{
            border-radius: .75rem;
        }
        /* Sticky footer spacer */
        .footer-spacer{ height: 1rem; }
        /* Theme toggle button */
        .theme-toggle{
            --size: 38px;
            width: var(--size);
            height: var(--size);
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--bs-border-color);
            background: var(--bs-body-bg);
        }
    </style>
</head>

<body>
{{-- Top bar and left sidebar remain your partials --}}
@include('layouts.topbar')

<div class="page-wrapper">
    @include('layouts.leftbar')

    <main class="page-content" role="main">
        <div class="content-shell">

            {{-- Header / breadcrumb + theme toggle --}}
            <div class="content-header">
                <div class="d-flex align-items-center gap-3">
                    <h1>@yield('page_title','Dashboard')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            @yield('breadcrumb') {{-- e.g. <li class="breadcrumb-item active">Analytics</li> --}}
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    {{-- Optional action slot --}}
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

            {{-- Main content card shell (optional, remove if your pages render their own cards) --}}
            <div class="card card-soft">
                <div class="card-body p-3 p-md-4">
                    @yield('content')
                </div>
            </div>

            <div class="footer-spacer"></div>
            @include('layouts.footer')
        </div>
    </main>
</div>

{{-- Core JS (use local only; remove CDN duplicates) --}}
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}" defer></script>
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}" defer></script>

{{-- Optional sample data & page init (guarded) --}}
<script src="{{ asset('assets/js/pages/index.init.js') }}" defer></script>
<script src="{{ asset('assets/js/DynamicSelect.js') }}" defer></script>
<script src="{{ asset('assets/js/app.js') }}" defer></script>

{{-- Icons (Bootstrap Icons) if not already in icons.min.css --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

{{-- Theme persistence + prefers-color-scheme sync --}}
<script>
    (function () {
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
            const curr = root.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-bs-theme', curr);
            localStorage.setItem('bs-theme', curr);
            updateIcon(curr);
        });

        function updateIcon(theme){
            const dark = theme === 'dark';
            if(sun && moon){
                sun.classList.toggle('d-none', !dark);
                moon.classList.toggle('d-none', dark);
            }
        }
    })();
</script>

{{-- Page-level scripts --}}
@stack('scripts')
</body>
</html>
