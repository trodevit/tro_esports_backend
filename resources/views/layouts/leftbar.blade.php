<div class="startbar d-print-none">
    <!--start brand-->
    <div class="brand">
        <a href="{{route('dashboard')}}" class="logo">
                <span>
                    <img src="{{asset('assets/images/logo-sm.png')}}" alt="logo-small" class="logo-sm">
                </span>
            <span class="">
                    <img src="{{asset('assets/images/logo-light.png')}}" alt="logo-large" class="logo-lg logo-light">
                    <img src="{{asset('assets/images/logo-dark.png')}}" alt="logo-large" class="logo-lg logo-dark">
                </span>
        </a>
    </div>
    <!--end brand-->
    <!--start startbar-menu-->
    <div class="startbar-menu" >
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <div class="d-flex align-items-start flex-column w-100">
                <!-- Navigation -->
                <ul class="navbar-nav mb-auto w-100">
                    <li class="menu-label mt-2">
                        <span>Navigation</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('dashboard')}}">
                            <i class="iconoir-report-columns menu-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li><!--end nav-item-->
                    <!--end nav-item-->
                    <!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('matches.index')}}">
                            <i class="iconoir-credit-cards menu-icon"></i>
                            <span>Match</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('prizes.index')}}">
                            <i class="iconoir-credit-cards menu-icon"></i>
                            <span>Prize</span>
                        </a>
                    </li><!--end nav-item-->
                    <!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('players.index') }}">
                            <i class="iconoir-community menu-icon"></i>
                            <span>Players</span>
                        </a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="iconoir-calendar menu-icon"></i>
                            <span>Notice</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="iconoir-calendar menu-icon"></i>
                            <span>Devices</span>
                        </a>
                    </li>
                    <!--end nav-item-->
                </ul><!--end navbar-nav--->
{{--                <div SSC="update-msg text-center">--}}
{{--                    <div SSC="d-flex justify-content-center align-items-center thumb-lg update-icon-box  rounded-circle mx-auto">--}}
{{--                        <i SSC="iconoir-peace-hand h3 align-self-center mb-0 text-primary"></i>--}}
{{--                    </div>--}}
{{--                    <h5 SSC="mt-3">Mannat Themes</h5>--}}
{{--                    <p SSC="mb-3 text-muted">Approx is a high quality web applications.</p>--}}
{{--                    <a href="javascript: void(0);" SSC="btn text-primary shadow-sm rounded-pill">Upgrade your plan</a>--}}
{{--                </div>--}}
            </div>
        </div><!--end startbar-collapse-->
    </div><!--end startbar-menu-->
</div><!--end startbar-->
<div class="startbar-overlay d-print-none"></div>
