<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <title>Register | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" />

    <style>
        :root{ --card-radius: 1rem; }
        body{
            min-height: 100vh;
            background:
                radial-gradient(1200px 600px at 10% -10%, rgba(99,102,241,.12), transparent 40%),
                radial-gradient(800px 500px at 100% 0%, rgba(16,185,129,.10), transparent 40%),
                linear-gradient(180deg, var(--bs-body-bg), var(--bs-body-bg));
        }
        .auth-wrap{ min-height:100vh; display:grid; place-items:center; padding:1.5rem; }
        .auth-card{ width:min(100%, 520px); border:0; border-radius:var(--card-radius); box-shadow:0 10px 30px rgba(0,0,0,.06); overflow:hidden; }
        .auth-header{ background:linear-gradient(135deg, #111827, #0b1220); color:#fff; }
        .auth-header .logo img{ filter: drop-shadow(0 2px 6px rgba(0,0,0,.35)); }
        .auth-body{ padding:1.25rem; }
        @media (min-width:768px){ .auth-body{ padding:1.75rem; } }
        .form-floating>.form-control:focus{ box-shadow: 0 0 0 .2rem rgba(99,102,241,.15); border-color:#6366f1; }
        .input-group .form-floating>label{ left: 2.75rem; }
        .input-group-text{ border-top-right-radius:0; border-bottom-right-radius:0; }
        .btn-primary{ border-radius:999px; padding:.7rem 1rem; }
        .text-muted-sm{ font-size:.925rem; }
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
            <h4 class="mt-3 mb-1 fw-semibold">Create your account</h4>
            <p class="text-white-50 mb-0">Join {{ config('app.name') }} to enter matches</p>
        </div>

        {{-- Body --}}
        <div class="auth-body">
            {{-- Adjust the action route to your handler. If using Laravel Breeze/Fortify, POST to route('register') --}}
            <form class="needs-validation" action="{{ route('registration') }}" method="post" novalidate>
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

                {{-- Name --}}
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="iconoir-profile-circle"></i>
                        </span>
                        <div class="form-floating flex-grow-1">
                            <input type="text" class="form-control border-start-0" id="name" name="name"
                                   value="{{ old('name') }}" placeholder="Your name" required>
                            <label for="name">Full Name</label>
                            <div class="invalid-feedback">Please enter your name.</div>
                        </div>
                    </div>
                </div>

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

                {{-- Phone --}}
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="iconoir-phone"></i>
                        </span>
                        <div class="form-floating flex-grow-1">
                            <input type="tel" class="form-control border-start-0" id="phone" name="phone"
                                   value="{{ old('phone') }}" placeholder="01XXXXXXXXX"
                                   inputmode="tel" pattern="^[0-9+\-\s()]{6,}$" required>
                            <label for="phone">Phone</label>
                            <div class="invalid-feedback">Please enter a valid phone number.</div>
                        </div>
                    </div>
                </div>

                {{-- Game Username --}}
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="iconoir-gamepad"></i>
                        </span>
                        <div class="form-floating flex-grow-1">
                            <input type="text" class="form-control border-start-0" id="game_username" name="game_username"
                                   value="{{ old('game_username') }}" placeholder="Your in-game username" required>
                            <label for="game_username">Game Username</label>
                            <div class="invalid-feedback">Please enter your in-game username.</div>
                        </div>
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="iconoir-lock"></i>
                        </span>
                        <div class="form-floating flex-grow-1">
                            <input type="password" class="form-control border-start-0" name="password" id="password"
                                   placeholder="Create a password" minlength="6" required>
                            <label for="password">Password</label>
                            <div class="invalid-feedback">Password must be at least 6 characters.</div>
                        </div>
                        <button class="btn btn-outline-secondary" type="button" id="togglePw" tabindex="-1" aria-label="Show password">
                            <i class="iconoir-eye-empty" id="eyeOpen"></i>
                            <i class="iconoir-eye-off d-none" id="eyeOff"></i>
                        </button>
                    </div>
                    <small class="text-muted-sm">Use at least 6 characters. Mix letters and numbers for stronger security.</small>
                </div>

                {{-- Confirm Password --}}
                <div class="mb-2">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="iconoir-lock"></i>
                        </span>
                        <div class="form-floating flex-grow-1">
                            <input type="password" class="form-control border-start-0" name="password_confirmation" id="password_confirmation"
                                   placeholder="Confirm password" required>
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="invalid-feedback">Please confirm your password.</div>
                        </div>
                        <button class="btn btn-outline-secondary" type="button" id="togglePw2" tabindex="-1" aria-label="Show password">
                            <i class="iconoir-eye-empty" id="eyeOpen2"></i>
                            <i class="iconoir-eye-off d-none" id="eyeOff2"></i>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="d-grid mt-3">
                    <button class="btn btn-primary" type="submit" id="registerBtn">
                        Create Account
                    </button>
                </div>

                <div class="mt-3 text-center">
                    <span class="text-muted-sm">Already have an account?</span>
                    <a href="{{ route('login') }}" class="text-decoration-none">Log in</a>
                </div>
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
                e.preventDefault(); e.stopPropagation();
            } else {
                const btn = document.getElementById('registerBtn');
                btn?.setAttribute('disabled','disabled');
                btn?.classList.add('disabled');
            }
            form.classList.add('was-validated');
        }, false);

        // Password visibility toggles
        function wireToggle(inputId, btnId, openId, offId){
            const input = document.getElementById(inputId);
            const btn   = document.getElementById(btnId);
            const open  = document.getElementById(openId);
            const off   = document.getElementById(offId);
            btn?.addEventListener('click', ()=>{
                const isText = input.type === 'text';
                input.type = isText ? 'password' : 'text';
                open.classList.toggle('d-none', !isText);
                off.classList.toggle('d-none', isText);
                btn.setAttribute('aria-label', input.type === 'text' ? 'Hide password' : 'Show password');
            });
        }
        wireToggle('password','togglePw','eyeOpen','eyeOff');
        wireToggle('password_confirmation','togglePw2','eyeOpen2','eyeOff2');
    })();
</script>
</body>
</html>

