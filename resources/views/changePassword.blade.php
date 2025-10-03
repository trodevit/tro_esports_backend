@extends('userLayouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="glass-card p-4">

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-semibold mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-key"></i> Change Password
                        </h5>
                    </div>

                    {{-- Success --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Errors (including current password incorrect) --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.change') }}" class="needs-validation" novalidate>
                        @csrf

                        {{-- Current password --}}
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-lock"></i>
                            </span>
                                <input type="password"
                                       name="current_password"
                                       class="form-control bg-transparent text-white border-light border-start-0"
                                       id="currentPassword"
                                       placeholder="Enter current password"
                                       required>
                                <button type="button" class="btn btn-outline-light" tabindex="-1" id="toggleCurrent">
                                    <i class="bi bi-eye" id="eyeCurrentOpen"></i>
                                    <i class="bi bi-eye-slash d-none" id="eyeCurrentOff"></i>
                                </button>
                                <div class="invalid-feedback">Please enter your current password.</div>
                            </div>
                            @error('current_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        {{-- New password --}}
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-shield-lock"></i>
                            </span>
                                <input type="password"
                                       name="new_password"
                                       class="form-control bg-transparent text-white border-light border-start-0"
                                       id="newPassword"
                                       placeholder="Enter new password (min 8 chars)"
                                       minlength="6"
                                       required>
                                <button type="button" class="btn btn-outline-light" tabindex="-1" id="toggleNew">
                                    <i class="bi bi-eye" id="eyeNewOpen"></i>
                                    <i class="bi bi-eye-slash d-none" id="eyeNewOff"></i>
                                </button>
                                <div class="invalid-feedback">New password must be at least 8 characters.</div>
                            </div>
                            @error('new_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        {{-- Confirm new password --}}
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-shield-check"></i>
                            </span>
                                <input type="password"
                                       name="new_password_confirmation"
                                       class="form-control bg-transparent text-white border-light border-start-0"
                                       id="confirmPassword"
                                       placeholder="Re-type new password"
                                       minlength="6"
                                       required>
                                <button type="button" class="btn btn-outline-light" tabindex="-1" id="toggleConfirm">
                                    <i class="bi bi-eye" id="eyeConfirmOpen"></i>
                                    <i class="bi bi-eye-slash d-none" id="eyeConfirmOff"></i>
                                </button>
                                <div class="invalid-feedback">Please confirm your new password.</div>
                            </div>
                        </div>

                        <div class="small text-white-50 mb-3">
                            Tip: Use at least 8 characters with a mix of letters, numbers and symbols.
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-accent btn-pill" type="submit">
                                <i class="bi bi-check2-circle me-2"></i> Update Password
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Client-side helpers (Bootstrap validation + show/hide) --}}
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

            const toggleVisibility = (inputId, btnId, eyeOpenId, eyeOffId) => {
                const input = document.getElementById(inputId);
                const btn = document.getElementById(btnId);
                const eyeOpen = document.getElementById(eyeOpenId);
                const eyeOff = document.getElementById(eyeOffId);
                btn?.addEventListener('click', () => {
                    const isText = input.type === 'text';
                    input.type = isText ? 'password' : 'text';
                    eyeOpen.classList.toggle('d-none', !isText);
                    eyeOff.classList.toggle('d-none', isText);
                });
            };

            toggleVisibility('currentPassword', 'toggleCurrent', 'eyeCurrentOpen', 'eyeCurrentOff');
            toggleVisibility('newPassword', 'toggleNew', 'eyeNewOpen', 'eyeNewOff');
            toggleVisibility('confirmPassword', 'toggleConfirm', 'eyeConfirmOpen', 'eyeConfirmOff');
        })();
    </script>
@endsection

