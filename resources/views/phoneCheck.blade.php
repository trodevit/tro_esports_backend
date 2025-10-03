@extends('userLayouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-6">
                <div class="glass-card p-4">

                    <div class="mb-3">
                        <h5 class="fw-semibold d-flex align-items-center gap-2 mb-0">
                            <i class="bi bi-shield-lock"></i> Forgot Password
                        </h5>
                        <div class="text-white-50 small">Verify your phone number to continue.</div>
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

                    <form action="{{ route('check.phone') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-telephone"></i>
                            </span>
                                <input type="text"
                                       name="phone"
                                       class="form-control bg-transparent text-white border-light border-start-0"
                                       placeholder="e.g. 017XXXXXXXX"
                                       value="{{ old('phone') }}"
                                       required>
                                <div class="invalid-feedback">Please enter your phone number.</div>
                            </div>
                            <div class="form-text text-white-50">We’ll verify if this phone is registered.</div>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-accent btn-pill" type="submit">
                                <i class="bi bi-search me-2"></i> Verify Phone
                            </button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}" class="small text-white-50 text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i> Back to Login
                        </a>
                    </div>

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
