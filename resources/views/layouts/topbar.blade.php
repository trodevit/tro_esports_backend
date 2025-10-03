{{-- resources/views/layouts/topbar.blade.php --}}
<div class="topbar d-print-none border-bottom">
    <div class="container-fluid">
        <nav class="topbar-custom d-flex justify-content-between align-items-stretch" id="topbar-custom" role="navigation" aria-label="Global">

            {{-- Left cluster --}}
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center gap-2 mb-0">
                <li>
                    <button
                        id="togglemenu"
                        type="button"
                        class="nav-link mobile-menu-btn nav-icon btn btn-link p-0 d-inline-flex align-items-center"
                        aria-label="Toggle sidebar"
                        aria-controls="leftSidebar"
                        aria-expanded="false">
                        <i class="iconoir-menu" aria-hidden="true"></i>
                    </button>
                </li>
                <li class="d-none d-sm-flex align-items-center">
                    <h4 class="mb-0 fw-semibold text-truncate">Dashboard</h4>
                </li>
            </ul>

            {{-- Right cluster --}}
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center gap-1 gap-sm-2 mb-0">

                {{-- Language switcher --}}
                <li class="dropdown">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon d-inline-flex align-items-center" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,12" aria-label="Change language">
                        <img src="{{ asset('assets/images/flags/us_flag.jpg') }}" alt="English" class="thumb-sm rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item d-flex align-items-center" href="#"><img src="{{ asset('assets/images/flags/us_flag.jpg') }}" alt="English" height="15" class="me-2">English</a>
                        <a class="dropdown-item d-flex align-items-center" href="#"><img src="{{ asset('assets/images/flags/spain_flag.jpg') }}" alt="Spanish" height="15" class="me-2">Spanish</a>
                        <a class="dropdown-item d-flex align-items-center" href="#"><img src="{{ asset('assets/images/flags/germany_flag.jpg') }}" alt="German" height="15" class="me-2">German</a>
                        <a class="dropdown-item d-flex align-items-center" href="#"><img src="{{ asset('assets/images/flags/french_flag.jpg') }}" alt="French" height="15" class="me-2">French</a>
                    </div>
                </li>

                {{-- Theme toggle --}}
                <li class="topbar-item">
                    <button class="nav-link nav-icon btn btn-link p-0" id="light-dark-mode" type="button" aria-label="Toggle theme">
                        <i class="iconoir-half-moon dark-mode" aria-hidden="true"></i>
                        <i class="iconoir-sun-light light-mode" aria-hidden="true"></i>
                    </button>
                </li>

                {{-- Notifications --}}
                <li class="dropdown topbar-item">
                    @php $unreadCount = $unreadCount ?? 0; @endphp
                    <a class="nav-link dropdown-toggle arrow-none nav-icon position-relative" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,12" aria-label="View notifications">
                        <i class="iconoir-bell" aria-hidden="true"></i>
                        @if($unreadCount > 0)
                            <span class="alert-badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <span class="visually-hidden">{{ $unreadCount }} unread notifications</span>
              </span>
                        @endif
                    </a>

                    <div class="dropdown-menu stop dropdown-menu-end dropdown-lg py-0">
                        <div class="d-flex align-items-center justify-content-between px-3 py-3">
                            <h5 class="m-0 fs-6">Notifications</h5>
                            <a href="#" class="badge text-body-tertiary">
                                <i class="iconoir-plus-circle fs-5" aria-hidden="true"></i><span class="visually-hidden">Open notifications</span>
                            </a>
                        </div>

                        <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link mx-0 active" data-bs-toggle="tab" data-bs-target="#notif-all" type="button" role="tab" aria-selected="true">
                                    All <span class="badge bg-primary-subtle text-primary badge-pill ms-1">{{ $unreadCount }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link mx-0" data-bs-toggle="tab" data-bs-target="#notif-projects" type="button" role="tab" aria-selected="false">
                                    Projects
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link mx-0" data-bs-toggle="tab" data-bs-target="#notif-team" type="button" role="tab" aria-selected="false">
                                    Team
                                </button>
                            </li>
                        </ul>

                        <div class="ms-0" style="max-height: 260px;" data-simplebar>
                            <div class="tab-content">
                                {{-- All --}}
                                <div class="tab-pane fade show active" id="notif-all" role="tabpanel">
                                    @forelse(($notifications ?? []) as $n)
                                        <a href="{{ $n->url ?? '#' }}" class="dropdown-item py-3">
                                            <small class="float-end text-muted ps-2">{{ $n->time_ago ?? '' }}</small>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle d-inline-flex align-items-center justify-content-center">
                                                    <i class="{{ $n->icon ?? 'iconoir-bell' }} fs-4" aria-hidden="true"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 text-truncate">
                                                    <h6 class="my-0 fw-medium text-dark fs-13 text-truncate">{{ $n->title ?? 'Notification' }}</h6>
                                                    <small class="text-muted mb-0 text-truncate d-block">{{ $n->message ?? '' }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="px-3 py-4 text-center text-muted">No notifications</div>
                                    @endforelse
                                </div>

                                {{-- Projects --}}
                                <div class="tab-pane fade" id="notif-projects" role="tabpanel">
                                    @if(!empty($projectNotifications))
                                        @foreach($projectNotifications as $n)
                                            <a href="{{ $n->url ?? '#' }}" class="dropdown-item py-3">
                                                <small class="float-end text-muted ps-2">{{ $n->time_ago ?? '' }}</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle d-inline-flex align-items-center justify-content-center">
                                                        <i class="{{ $n->icon ?? 'iconoir-apple-swift' }} fs-4" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 text-truncate">
                                                        <h6 class="my-0 fw-medium text-dark fs-13 text-truncate">{{ $n->title ?? 'Project update' }}</h6>
                                                        <small class="text-muted mb-0 text-truncate d-block">{{ $n->message ?? '' }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    @else
                                        <div class="px-3 py-4 text-center text-muted">No project updates</div>
                                    @endif
                                </div>

                                {{-- Team --}}
                                <div class="tab-pane fade" id="notif-team" role="tabpanel">
                                    @if(!empty($teamNotifications))
                                        @foreach($teamNotifications as $n)
                                            <a href="{{ $n->url ?? '#' }}" class="dropdown-item py-3">
                                                <small class="float-end text-muted ps-2">{{ $n->time_ago ?? '' }}</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle d-inline-flex align-items-center justify-content-center">
                                                        <i class="{{ $n->icon ?? 'iconoir-userLayouts' }} fs-4" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 text-truncate">
                                                        <h6 class="my-0 fw-medium text-dark fs-13 text-truncate">{{ $n->title ?? 'Team activity' }}</h6>
                                                        <small class="text-muted mb-0 text-truncate d-block">{{ $n->message ?? '' }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    @else
                                        <div class="px-3 py-4 text-center text-muted">No team activity</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <a href="#" class="dropdown-item text-center text-dark fs-13 py-2">
                            View All <i class="fi-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>

                {{-- Account / Profile --}}
                <li class="dropdown topbar-item">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon d-inline-flex align-items-center" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,12" aria-label="Account">
                        <i class="las la-user-circle fs-18 me-1 align-text-bottom" aria-hidden="true"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end py-0">
                        <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                            <div class="flex-shrink-0">
                                <img src="{{ Auth::user()->avatar_url ?? asset('assets/images/users/avatar-1.jpg') }}"
                                     alt="{{ Auth::user()->name ?? 'User' }}" class="thumb-md rounded-circle">
                            </div>
                            <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                <h6 class="my-0 fw-medium text-dark fs-13 text-truncate">{{ Auth::user()->name ?? 'Guest' }}</h6>
                                <small class="text-muted mb-0 text-truncate">{{ Auth::user()->role ?? 'Member' }}</small>
                            </div>
                        </div>

                        <div class="dropdown-divider mt-0"></div>
                        <small class="text-muted px-2 pb-1 d-block">Account</small>
                        <a class="dropdown-item" href="#"><i class="las la-user fs-18 me-1 align-text-bottom"></i> Profile</a>
                        <a class="dropdown-item" href="#"><i class="las la-wallet fs-18 me-1 align-text-bottom"></i> Earnings</a>

                        <small class="text-muted px-2 py-1 d-block">Settings</small>
                        <a class="dropdown-item" href="#"><i class="las la-cog fs-18 me-1 align-text-bottom"></i> Account Settings</a>
                        <a class="dropdown-item" href="#"><i class="las la-lock fs-18 me-1 align-text-bottom"></i> Security</a>
                        <a class="dropdown-item" href="#"><i class="las la-question-circle fs-18 me-1 align-text-bottom"></i> Help Center</a>

                        <div class="dropdown-divider mb-0"></div>
                        <form action="{{ route('logout') }}" method="POST" class="dropdown-item p-0">
                            @csrf
                            <button type="submit" class="btn w-100 text-start text-danger py-2">
                                <i class="las la-power-off fs-18 me-1 align-text-bottom"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>

@push('styles')
    <style>
        .topbar { backdrop-filter: saturate(120%) blur(4px); }
        .nav-icon { line-height: 1; }
        .thumb-sm { width: 28px; height: 28px; object-fit: cover; }
        .thumb-md { width: 36px; height: 36px; object-fit: cover; }
        .alert-badge { width: 10px; height: 10px; padding: 0; }

        /* Tighten on small screens */
        @media (max-width: 575.98px){
            .topbar-custom { padding-block: .25rem; }
            .topbar-item { gap: .25rem !important; }
            .nav-link { padding: .25rem .4rem; }
            .dropdown-menu { min-width: 240px; }
            .dropdown-menu .dropdown-item { white-space: normal; }
        }

        /* Prevent dropdown overflow on very narrow screens */
        @media (max-width: 380px){
            .dropdown-menu { width: 92vw; max-width: none; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function(){
            const toggleBtn  = document.getElementById('togglemenu');
            const sidebar    = document.getElementById('leftSidebar');          // from leftbar.blade.php
            const backdrop   = document.getElementById('startbarBackdrop');     // from leftbar.blade.php
            const root       = document.documentElement;

            // Theme toggle (persist to localStorage)
            const themeBtn   = document.getElementById('light-dark-mode');
            const stored     = localStorage.getItem('bs-theme');
            if (stored) root.setAttribute('data-bs-theme', stored);
            themeBtn?.addEventListener('click', () => {
                const next = root.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                root.setAttribute('data-bs-theme', next);
                localStorage.setItem('bs-theme', next);
            });

            // Sidebar toggle: mobile = slide (sidebar-open), desktop = collapse width (sidebar-collapsed)
            function isMobile(){ return window.matchMedia('(max-width: 991.98px)').matches; }

            function openMobile(){
                document.body.classList.add('sidebar-open');
                toggleBtn?.setAttribute('aria-expanded', 'true');
                sidebar?.setAttribute('aria-hidden', 'false');
            }
            function closeMobile(){
                document.body.classList.remove('sidebar-open');
                toggleBtn?.setAttribute('aria-expanded', 'false');
                sidebar?.setAttribute('aria-hidden', 'true');
            }
            function toggleMobile(){ document.body.classList.contains('sidebar-open') ? closeMobile() : openMobile(); }

            function toggleDesktop(){
                const collapsed = document.body.classList.toggle('sidebar-collapsed');
                toggleBtn?.setAttribute('aria-expanded', String(!collapsed ? 'true' : 'false'));
            }

            toggleBtn?.addEventListener('click', () => {
                isMobile() ? toggleMobile() : toggleDesktop();
            });

            backdrop?.addEventListener('click', closeMobile);
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeMobile(); });

            // Reconcile classes on resize
            let wasMobile = isMobile();
            window.addEventListener('resize', () => {
                const nowMobile = isMobile();
                if (nowMobile !== wasMobile){
                    // Clean up state crossing breakpoints
                    document.body.classList.remove('sidebar-collapsed');
                    closeMobile();
                    wasMobile = nowMobile;
                }
            });
        })();
    </script>
@endpush
