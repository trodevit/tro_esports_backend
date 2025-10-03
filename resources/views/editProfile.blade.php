@extends('userLayouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="glass-card p-4">

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-semibold mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-pencil-square"></i> Edit Profile
                        </h5>
                    </div>

                    {{-- Success --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{route('profile.edit')}}" class="needs-validation" novalidate>
                        @csrf
                        @method('POST')

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name"
                                   value="{{ old('name', Auth::user()->name) }}"
                                   class="form-control bg-transparent text-white border-light"
                                   placeholder="Enter your full name"
                                   >
                            <div class="invalid-feedback">Please enter your name.</div>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email', Auth::user()->email) }}"
                                   class="form-control bg-transparent text-white border-light"
                                   placeholder="you@example.com"
                                   >
                            <div class="invalid-feedback">Please enter a valid email.</div>
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone"
                                   value="{{ old('phone', Auth::user()->phone) }}"
                                   class="form-control bg-transparent text-white border-light"
                                   placeholder="e.g. 017XXXXXXXX"
                                   >
                            <div class="invalid-feedback">Please enter a phone number.</div>
                        </div>

                        {{-- Game Username --}}
                        <div class="mb-3">
                            <label class="form-label">Game Username</label>
                            <input type="text" name="game_username"
                                   value="{{ old('game_username', Auth::user()->game_username) }}"
                                   class="form-control bg-transparent text-white border-light"
                                   placeholder="Your in-game name"
                                   readonly>
                            <div class="invalid-feedback">Please enter your game username.</div>
                        </div>

                        <div class="d-grid mt-4">
                            <button class="btn btn-accent btn-pill" type="submit">
                                <i class="bi bi-save2 me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Client-side Bootstrap validation --}}
    <script>
        (function () {
            const form = document.querySelector('.needs-validation');
            form?.addEventListener('submit', function (e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })();
    </script>
@endsection

