@extends('userLayouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-6">
                <div class="glass-card p-4">

                    <div class="mb-3">
                        <h5 class="fw-semibold d-flex align-items-center gap-2 mb-0">
                            <i class="bi bi-unlock"></i> Set New Password
                        </h5>
                        <div class="text-white-50 small">Phone verified: set your new password below.</div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('password.forget') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="phone" value="{{ $phone }}">

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control bg-transparent text-white border-light" value="{{ $phone }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-lock"></i>
                            </span>
                                <input type="password"
                                       name="password"
                                       class="form-control bg-transparent text-white border-light border-start-0"
                                       placeholder="Min 6 characters"
                                       minlength="6"
                                       required>
                                <div class="invalid-feedback">Password must be at least 8 characters.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirm New Password</label>
                            <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control bg-transparent text-white border-light border-start-0"
                                       placeholder="Re-type new password"
                                       minlength="6"
                                       required>
                                <div class="invalid-feedback">Please confirm your new password.</div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-accent btn-pill" type="submit">
                                <i class="bi bi-check2-circle me-2"></i> Reset Password
                            </button>
                        </div>
                    </form>

{{--                    <div class="mt-3 text-center">--}}
{{--                        <a href="{{ route('password.phone.form') }}" class="small text-white-50 text-decoration-none">--}}
{{--                            <i class="bi bi-arrow-left me-1"></i> Back--}}
{{--                        </a>--}}
{{--                    </div>--}}

                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const forms = document.querySelectorAll('.needs-validation');
            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endsection
