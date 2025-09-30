<footer\1 class=\"site-footer\">
<div class="container-fluid">
    <div class="footer-card card mb-0">
        <div class="card-body py-2 py-sm-3">
            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
                <p class="mb-0 text-muted small">
                    © <span id="year">{{ date('Y') }}</span> {{ config('app.name') }}
                    <span class="d-none d-sm-inline-block ms-2">
                            • Built with
                            <i class="iconoir-heart-solid text-danger align-middle"></i>
                            by <a class="link-muted" href="https://trodev.com" target="_blank" rel="noopener">Trodev IT</a>
                        </span>
                </p>

                <ul class="nav small gap-2">
                    <li class="nav-item"><a class="nav-link px-2 link-muted" href="#">Help</a></li>
                    <li class="nav-item"><a class="nav-link px-2 link-muted" href="#">Settings</a></li>
                    <li class="nav-item"><a class="nav-link px-2 link-muted" href="#">Privacy</a></li>
                    <li class="nav-item"><a class="nav-link px-2 link-muted" href="#">Terms</a></li>
                </ul>
            </div>

            {{-- Optional: socials (show on md+) --}}
            <div class="d-none d-md-flex align-items-center justify-content-end mt-2 gap-2">
                <a class="btn btn-light-subtle btn-sm rounded-circle footer-icon" aria-label="Twitter" href="#" target="_blank" rel="noopener">
                    <i class="iconoir-twitter"></i>
                </a>
                <a class="btn btn-light-subtle btn-sm rounded-circle footer-icon" aria-label="Facebook" href="#" target="_blank" rel="noopener">
                    <i class="iconoir-facebook"></i>
                </a>
                <a class="btn btn-light-subtle btn-sm rounded-circle footer-icon" aria-label="GitHub" href="#" target="_blank" rel="noopener">
                    <i class="iconoir-github"></i>
                </a>
            </div>
        </div>
    </div>
</div>
</footer>

@push('styles')
    <style>
        .app-footer{
            /* Remove if you do NOT want it sticky */
            position: sticky; bottom: 0; z-index: 101;
            backdrop-filter: saturate(120%) blur(2px);
        }
        .footer-card{
            border: 0;
            border-top: 1px solid var(--bs-border-color);
            border-radius: .75rem .75rem 0 0; /* rounded top */
            background: color-mix(in srgb, var(--bs-body-bg) 92%, transparent);
            box-shadow: 0 -6px 18px rgba(0,0,0,.04);
        }
        [data-bs-theme="dark"] .footer-card{
            background: color-mix(in srgb, var(--bs-body-bg) 96%, transparent);
        }
        .link-muted{
            color: var(--bs-secondary-color);
            text-decoration: none;
        }
        .link-muted:hover{
            color: var(--bs-body-color);
            text-decoration: underline;
        }
        .footer-icon{
            width: 32px; height: 32px;
            display: inline-flex; align-items: center; justify-content: center;
            border: 1px solid var(--bs-border-color);
            transition: transform .12s ease, background-color .12s ease;
        }
        .footer-icon:hover{ transform: translateY(-1px); }
        .btn-light-subtle{
            background: var(--bs-tertiary-bg);
            color: var(--bs-body-color);
        }
    </style>
@endpush
