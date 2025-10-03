@extends('userLayouts.app') {{-- change to your actual layout filename that contains the big HTML + @yield('content') --}}

{{--@section('page_title', 'My Profile')--}}

@section('content')

    <style>
        .form-select.bg-transparent {
            background-color: #12182a !important; /* dark background for the select box */
            color: #ffffff !important;            /* white text */
        }

    </style>
    <section class="py-5">
        <div class="container">
            <div class="row g-4">

                {{-- Left: Profile + Balance --}}
                <div class="col-12 col-lg-4">
                    <div class="glass-card p-4 h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-light text-dark d-inline-flex align-items-center justify-content-center" style="width:64px;height:64px;">
                                <i class="bi bi-person-fill fs-3"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                <div class="small text-white-50">{{ Auth::user()->email ?? '—' }}</div>
                                <div class="small text-white-50">{{ Auth::user()->phone ?? '—' }}</div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-white-50">Current Balance</div>
                            <div class="fs-3 fw-semibold">৳{{ number_format(Auth::user()->balance ?? 0) }}</div>
                        </div>
                        @if(Auth::user()->balance >= 50)
                            <div class="mt-3 d-grid">
                                <button class="btn btn-accent btn-pill" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                    <i class="bi bi-cash-coin me-2"></i>Withdraw Money
                                </button>
                            </div>
                        @else
                            <div class="mt-3 text-warning small">
                                ⚠️ You can withdraw money once your balance reaches ৳50 or more.
                            </div>
                        @endif
                        <div class="mt-3 d-grid">
                            <a href="{{ route('edit.profile') }}" class="btn btn-ghost btn-pill">
                                <i class="bi bi-pencil-square me-2"></i>Edit Profile
                            </a>
                        </div>

                        {{-- Optional: profile quick stats --}}
                    </div>
                </div>

                {{-- Right: Recent Withdrawals --}}
                <div class="col-12 col-lg-8">
                    <div class="glass-card p-0 h-100">
                        <div class="p-3 p-md-4 border-bottom border-secondary-subtle d-flex align-items-center justify-content-between">
                            <h5 class="mb-0"><i class="bi bi-wallet2 me-2"></i>Recent Withdrawals</h5>
                        </div>

                        <div class="p-3 p-md-4">
                            <div class="table-responsive">
                                <table class="table table-dark table-striped align-middle mb-0">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Account</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Transaction Id</th>
                                        <th class="text-end">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse(($money ?? []) as $w)
                                        @php
                                            $status = ucfirst(strtolower($w->payment_status));
                                            $badge = [
                                                'Pending'  => 'warning',
                                                'Approved' => 'success',
                                                'Rejected' => 'danger',
                                            ][$status] ?? 'secondary';
                                        @endphp
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($w->created_at)->format('M d, Y h:i A') }}</td>
                                            <td>{{$w->payment_number}}</td>
                                            <td>৳{{ number_format($w->amount) }}</td>
                                            <td>{{ strtoupper($w->payment_method) }}</td>
                                            <td class="text-truncate" style="max-width:220px">{{ $w->transaction_id }}</td>
                                            <td class="text-end">
                                                <span class="badge text-bg-{{ $badge }}">{{ ucfirst($w->payment_status) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-white-50 py-4">No withdrawals yet.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if(isset($withdrawals) && method_exists($withdrawals, 'links'))
                                <div class="pt-3">
                                    {{ $withdrawals->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Withdraw Modal (matches your theme) --}}
    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content bg-dark text-light needs-validation" novalidate
                  action="{{ route('withdraw.money')}}"
                  method="POST">
                @csrf
{{--                @method('PUT')--}}

                <div class="modal-header border-secondary">
                    <h5 class="modal-title">Withdraw Money</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-info small">
                        Available balance: <strong>৳{{ number_format(Auth::user()->balance ?? 0) }}</strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount (৳)</label>
                        <input type="number" min="1" step="1" class="form-control bg-transparent text-white border-light" name="amount" required placeholder="e.g. 500">
                        <div class="invalid-feedback">Please enter a valid amount.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Method</label>
                        <select class="form-select bg-transparent text-white border-light" name="payment_method" required>
                            <option value="" disabled selected>Select</option>
                            <option value="bkash">bKash</option>
                            <option value="nagad">Nagad</option>
                            <option value="rocket">Rocket</option>
                            <option value="bank">Bank</option>
                        </select>
                        <div class="invalid-feedback">Please choose a method.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account / Number</label>
                        <input type="text" class="form-control bg-transparent text-white border-light" name="payment_number" required placeholder="Account number or details">
                        <div class="invalid-feedback">Please enter account/number.</div>
                    </div>

                    <div class="small text-white-50">
                        By submitting, you agree to our withdrawal rules and processing times.
                    </div>
                </div>

                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-ghost btn-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-accent btn-pill" id="withdrawSubmit">
                        <i class="bi bi-send me-2"></i>Request Withdraw
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            // modal form validation + double-submit guard
            const form = document.querySelector('#withdrawModal form.needs-validation');
            const btn  = document.getElementById('withdrawSubmit');
            form?.addEventListener('submit', (e) => {
                if (!form.checkValidity()) {
                    e.preventDefault(); e.stopPropagation();
                } else {
                    btn?.setAttribute('disabled','disabled');
                    btn?.classList.add('disabled');
                }
                form.classList.add('was-validated');
            }, false);
        })();
    </script>
@endpush
