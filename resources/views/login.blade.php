<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <title>Login | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" />

    <style>
        :root{
            --card-radius: 1rem;
        }
        body{
            min-height: 100vh;
            background:
                radial-gradient(1200px 600px at 10% -10%, rgba(99,102,241,.12), transparent 40%),
                radial-gradient(800px 500px at 100% 0%, rgba(16,185,129,.10), transparent 40%),
                linear-gradient(180deg, var(--bs-body-bg), var(--bs-body-bg));
        }
        .auth-wrap{
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 1.5rem;
        }
        .auth-card{
            width: min(100%, 460px);
            border: 0;
            border-radius: var(--card-radius);
            box-shadow: 0 10px 30px rgba(0,0,0,.06);
            overflow: hidden;
        }
        .auth-header{
            background: linear-gradient(135deg, #111827, #0b1220);
            color: #fff;
        }
        .auth-header .logo img{ filter: drop-shadow(0 2px 6px rgba(0,0,0,.35)); }
        .auth-body{ padding: 1.25rem; }
        @media (min-width: 768px){
            .auth-body{ padding: 1.75rem; }
        }
        .form-floating>.form-control:focus{
            box-shadow: 0 0 0 .2rem rgba(99,102,241,.15);
            border-color: #6366f1;
        }
        .input-group .form-floating>label{ left: 2.75rem; } /* aligns label when using input-group */
        .input-group-text{ border-top-right-radius: 0; border-bottom-right-radius: 0; }
        .btn-primary{
            border-radius: 999px;
            padding: .7rem 1rem;
        }
        .divider{
            display: flex; align-items: center; gap: .5rem; color: var(--bs-secondary-color); font-size: .9rem;
        }
        .divider::before,.divider::after{ content:""; height:1px; background: var(--bs-border-color); flex: 1; }
    </style>
</head>

<body>
<div class="auth-wrap">
    <div class="card auth-card">
        {{-- Header --}}
        <div class="auth-header text-center p-3">
            <a href="{{ route('home') }}" class="logo d-inline-flex align-items-center justify-content-center">
                <img src="{{ asset('assets/images/logo-sm.png') }}" height="56" alt="logo" class="auth-logo">
            </a>
            <h4 class="mt-3 mb-1 fw-semibold">Welcome to {{ config('app.name') }}</h4>
            <p class="text-white-50 mb-0">Sign in to continue</p>
        </div>

        {{-- Body --}}
        <div class="auth-body">
            <form class="needs-validation" action="{{ route('loggedIn') }}" method="post" novalidate>
                @csrf

                {{-- Flash / Errors --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
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

                {{-- Email --}}
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="iconoir-mail"></i>
                        </span>
                        <div class="form-floating flex-grow-1">
                            <input type="email" class="form-control border-start-0" id="email" name="email"
                                   value="{{ old('email') }}" placeholder="name@example.com" required>
                            <label for="email">Email</label>
                            <div class="invalid-feedback">Please enter a valid email.</div>
                        </div>
                    </div>
                </div>

                {{-- Password with toggle --}}
                <div class="mb-2">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="iconoir-lock"></i>
                        </span>
                        <div class="form-floating flex-grow-1">
                            <input type="password" class="form-control border-start-0" name="password" id="password"
                                   placeholder="Your password" required>
                            <label for="password">Password</label>
                            <div class="invalid-feedback">Password is required.</div>
                        </div>
                        <button class="btn btn-outline-secondary" type="button" id="togglePw" tabindex="-1" aria-label="Show password">
                            <i class="iconoir-eye-empty" id="eyeOpen"></i>
                            <i class="iconoir-eye-off d-none" id="eyeOff"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember + (optional) forgot --}}
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    {{-- <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot password?</a> --}}
                </div>

                {{-- Submit --}}
                <div class="d-grid mt-3">
                    <button class="btn btn-primary" type="submit" id="loginBtn">
                        Log In
                    </button>
                </div>

                {{-- Optional divider / SSO slot (add later if needed) --}}
                {{-- <div class="my-3 divider"><span>or</span></div> --}}
                {{-- <div class="d-grid gap-2">
                    <a href="#" class="btn btn-outline-secondary">Continue with Google</a>
                </div> --}}
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    (function(){
        // Client-side validation (Bootstrap)
        const form = document.querySelector('.needs-validation');
        form?.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            } else {
                // prevent double submit
                const btn = document.getElementById('loginBtn');
                btn?.setAttribute('disabled','disabled');
                btn?.classList.add('disabled');
            }
            form.classList.add('was-validated');
        }, false);

        // Password visibility toggle
        const pw = document.getElementById('password');
        const btn = document.getElementById('togglePw');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeOff  = document.getElementById('eyeOff');
        btn?.addEventListener('click', ()=>{
            const isText = pw.type === 'text';
            pw.type = isText ? 'password' : 'text';
            eyeOpen.classList.toggle('d-none', !isText);
            eyeOff.classList.toggle('d-none', isText);
            btn.setAttribute('aria-label', pw.type === 'text' ? 'Hide password' : 'Show password');
        });
    })();
</script>
</body>
</html>
