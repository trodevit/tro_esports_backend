{{-- resources/views/payments/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <style>
        /* --- Quick pretties (scoped) --- */
        .page-hero {
            background: linear-gradient(135deg, #f1f5ff 0%, #eefcf5 100%);
            border: 1px solid #e9eef5;
            border-radius: 1rem;
        }
        .table thead th.sticky { position: sticky; top: 0; z-index: 5; background: #fff; border-top: 0; }
        .table-hover tbody tr:hover { background-color: #f8fbff !important; }
        .chip { display: inline-block; padding: .25rem .5rem; border-radius: 999px; font-size: .75rem; background: #eef5ff; border: 1px solid #e0e9ff; margin: 0 .25rem .25rem 0; }
        .muted { color: #6c757d; }
        .truncate { max-width: 220px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; vertical-align: bottom; }
        .copy-btn { border: 1px dashed #d0d7e1; background: #fff; font-size: .7rem; padding: .1rem .35rem; line-height: 1; }
        .card-rounded { border-radius: 1rem; }

        /* Refund modal tweaks */
        .refund-modal .modal-content { border-radius: 1rem; overflow: hidden; }
        .refund-modal .modal-header { background: linear-gradient(135deg,#f7fbff,#f8fffb); border-bottom: 1px solid #e9eef5; }
        .refund-modal .summary-list dt { color:#6c757d; font-weight:600; }
        .refund-modal .summary-list dd { margin-bottom:.5rem; }
        .refund-modal .badge-method { background:#eaf3ff; color:#0b5ed7; border:1px solid #d9e8ff; }
        .refund-modal .captured-box { background:#f8fafc; border:1px solid #eef2f7; border-radius:.75rem; padding:.75rem 1rem; }
        .refund-modal .form-label { font-weight:600; }
        @media (max-width: 575.98px){
            .refund-modal .modal-dialog { margin: .75rem; }
        }
    </style>

    <div class="container py-4">
        {{-- Header --}}
        <div class="page-hero p-4 mb-4 d-flex align-items-center justify-content-between">
            <div>
                <h1 class="h3 mb-1">Payments</h1>
                <div class="muted">A tidy list of all recent payments with status & details.</div>
            </div>
            <div>
                <a href="{{ request()->url() }}" class="btn btn-sm btn-outline-primary">Refresh</a>
            </div>
        </div>

        {{-- Flash --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>There were validation errors.</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Quick stats (current page only; optional) --}}
        @php
            $pageTotal = $payments->sum('amount');
            $pageCompleted = $payments->filter(fn($p)=> in_array(strtolower((string)$p->status), ['paid','success','completed']))->count();
            $pagePending = $payments->filter(fn($p)=> in_array(strtolower((string)$p->status), ['pending','processing']))->count();
        @endphp
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-4">
                <div class="card card-rounded h-100">
                    <div class="card-body">
                        <div class="muted">Page Total Amount</div>
                        <div class="h4 m-0">{{ number_format((float)$pageTotal, 2) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card card-rounded h-100">
                    <div class="card-body">
                        <div class="muted">Completed</div>
                        <div class="h4 m-0">{{ $pageCompleted }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card card-rounded h-100">
                    <div class="card-body">
                        <div class="muted">Pending</div>
                        <div class="h4 m-0">{{ $pagePending }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="card card-rounded">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th class="sticky">#</th>
                            <th class="sticky">User</th>
                            <th class="sticky">Game Username</th>
                            <th class="sticky">Payment Number</th>
                            <th class="sticky">Method</th>
                            <th class="sticky">Email</th>
                            <th class="sticky">Amount</th>
                            <th class="sticky">Status</th>
                            {{-- NEW --}}
                            <th class="sticky">Refunded Amount</th>
                            <th class="sticky">Refund Reason</th>
                            <th class="sticky">Transaction</th>
                            <th class="sticky">Date & Time</th>
                            <th class="sticky">Match</th>
                            <th class="sticky">Order</th>
                            <th class="sticky">Partners</th>
                            <th class="sticky">Created</th>
                            <th class="sticky">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($payments as $index => $p)
                            @php
                                $status = strtolower((string)$p->status);
                                $badge = match ($status) {
                                    'paid','success','completed' => 'text-bg-success',
                                    'pending','processing'       => 'text-bg-warning',
                                    'failed','cancelled'         => 'text-bg-danger',
                                    default                      => 'text-bg-secondary',
                                };
                                $partners   = is_array($p->partners_name) ? array_filter($p->partners_name) : [];
                                $refundable = $p->transaction_id && in_array($status, ['paid','success','completed']);
                                $refundedAmount = (float)($p->refund_amount ?? 0);
                                $refundReason   = $p->refund_reason ?? $p->refunded_reason ?? null; // support either field name
                            @endphp
                            <tr>
                                <td class="text-muted">{{ $payments->firstItem() + $index }}</td>
                                <td><span class="fw-semibold">{{ $p->user_id }}</span></td>
                                <td><span class="truncate" title="{{ $p->game_username }}">{{ $p->game_username }}</span></td>
                                <td><span class="truncate" title="{{ $p->payment_number }}">{{ $p->payment_number }}</span></td>
                                <td><span class="badge text-bg-info">{{ strtoupper($p->method) }}</span></td>
                                <td><span class="truncate" title="{{ $p->email }}">{{ $p->email }}</span></td>
                                <td class="fw-semibold">{{ number_format((float)$p->amount, 2) }}</td>
                                <td><span class="badge {{ $badge }}">{{ strtoupper($p->status) }}</span></td>

                                {{-- NEW: Refunded Amount --}}
                                <td class="{{ $refundedAmount > 0 ? 'text-success fw-semibold' : 'muted' }}">
                                    {{ $refundedAmount > 0 ? number_format($refundedAmount, 2) : '—' }}
                                </td>

                                {{-- NEW: Refund Reason --}}
                                <td>
                                    @if($refundReason)
                                        <span class="truncate" title="{{ $refundReason }}">{{ $refundReason }}</span>
                                    @else
                                        <span class="muted">—</span>
                                    @endif
                                </td>

                                {{-- Transaction with copy --}}
                                <td>
                                    @if($p->transaction_id)
                                        <span class="truncate" title="{{ $p->transaction_id }}">{{ $p->transaction_id }}</span>
                                        <button type="button" class="btn btn-sm copy-btn ms-2"
                                                data-copy="{{ $p->transaction_id }}">copy</button>
                                    @else
                                        <span class="muted">—</span>
                                    @endif
                                </td>

                                <td>
                                    <div>{{ $p->date }} <span class="muted">{{ $p->time }}</span></div>
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $p->match_name }}</div>
                                    @if($p->match_id)
                                        <small class="muted">ID: {{ $p->match_id }}</small>
                                    @endif
                                </td>

                                {{-- Order with copy --}}
                                <td>
                                    @if($p->orderId)
                                        <span class="truncate" title="{{ $p->orderId }}">{{ $p->orderId }}</span>
                                        <button type="button" class="btn btn-sm copy-btn ms-2"
                                                data-copy="{{ $p->orderId }}">copy</button>
                                    @else
                                        <span class="muted">—</span>
                                    @endif
                                </td>

                                <td style="max-width:240px;">
                                    @if(count($partners))
                                        @foreach($partners as $partner)
                                            <span class="chip" title="{{ $partner }}">{{ $partner }}</span>
                                        @endforeach
                                    @else
                                        <span class="muted">—</span>
                                    @endif
                                </td>

                                <td class="muted">{{ optional($p->created_at)->format('Y-m-d H:i') }}</td>

                                {{-- Actions --}}
                                <td>
                                    @if($refundable)
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger refund-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#refundModal"
                                            data-payment-id="{{ $p->id }}"
                                            data-transaction-id="{{ $p->transaction_id }}"
                                            data-method="{{ strtoupper($p->method) }}"
                                            data-amount="{{ number_format((float)$p->amount, 2) }}"
                                            data-amount-raw="{{ (float)$p->amount }}"
                                            data-refunded-raw="{{ (float)($p->refund_amount ?? 0) }}"
                                            data-match="{{ $p->match_name }}"
                                        >
                                            Refund
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-outline-secondary" disabled>Refund</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                {{-- colspan updated: 17 columns --}}
                                <td colspan="17" class="text-center py-5">
                                    <div class="fs-5">No payments found</div>
                                    <div class="muted">Try refreshing the page.</div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($payments->hasPages())
                <div class="card-footer bg-white">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Refund Modal --}}
    <div class="modal fade refund-modal" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form method="POST" action="{{ route('uddoktapay.refund') }}" class="modal-content needs-validation" novalidate>
                @csrf

                {{-- Hidden inputs --}}
                <input type="hidden" name="payment_id" id="refundPaymentId">
                <input type="hidden" name="transaction_id" id="refundTransactionId">
                <input type="hidden" name="method" id="refundMethodInput">
                {{-- If you also want a separate key --}}
                <input type="hidden" name="payment_method" id="refundPaymentMethod">
                <input type="hidden" name="match_name" id="refundMatchInput">

                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-0" id="refundModalLabel">Issue Refund</h5>
                        <small class="text-muted d-block">Review the details, then confirm the refund amount.</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3 align-items-stretch">
                        <div class="col-12 col-md-6">
                            <div class="captured-box h-100">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="text-muted">Transaction</div>
                                        <div class="fw-semibold" id="refundTx">—</div>
                                    </div>
                                    <span class="badge badge-method" id="refundMethod">—</span>
                                </div>
                                <hr class="my-3">
                                <div class="summary-list">
                                    <dl class="row mb-0">
                                        <dt class="col-6">Captured Amount</dt>
                                        <dd class="col-6" id="refundAmountCaptured">—</dd>

                                        <dt class="col-6">Match</dt>
                                        <dd class="col-6" id="refundMatch">—</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="refundAmountInput" class="form-label">Refund amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="amount"
                                        id="refundAmountInput"
                                        step="0.01"
                                        min="0.01"
                                        required
                                        placeholder="0.00"
                                    >
                                    <div class="invalid-feedback">Enter a valid amount (min 0.01, not exceeding the max refundable).</div>
                                </div>
                                <div class="mt-1 muted">
                                    Max refundable: <strong><span id="refundAmountMax">0.00</span></strong>
                                </div>
                            </div>

                            <div class="mb-0">
                                <label for="refundReason" class="form-label">Reason</label>
                                <textarea
                                    class="form-control"
                                    name="reason"
                                    id="refundReason"
                                    rows="4"
                                    placeholder="Reason for refund…"
                                    required minlength="5" maxlength="500"
                                ></textarea>
                                <div class="form-text">Be specific. This will be stored with the refund.</div>
                                <div class="invalid-feedback">Please provide a reason (5–500 characters).</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <div class="text-muted small">
                        Refunds may take a moment to process. Don’t close the window until you see a confirmation.
                    </div>
                    <div>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" id="refundSubmitBtn">
                            <span class="submit-text">Submit Refund</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- copy + refund handlers --}}
    <script>
        document.addEventListener('click', function(e) {
            // Copy buttons
            if (e.target && e.target.matches('.copy-btn')) {
                const val = e.target.getAttribute('data-copy') || '';
                if (!val) return;
                navigator.clipboard.writeText(val).then(function () {
                    const old = e.target.textContent;
                    e.target.textContent = 'copied';
                    setTimeout(()=>{ e.target.textContent = old; }, 800);
                });
                return;
            }

            const btn = e.target.closest('.refund-btn');
            if (!btn) return;

            // Numbers (raw) for computing max refundable
            const amountRaw   = parseFloat(btn.dataset.amountRaw || '0');
            const refundedRaw = parseFloat(btn.dataset.refundedRaw || '0');
            const maxRefund   = Math.max(0, amountRaw - refundedRaw);

            // Fill visible summary
            document.getElementById('refundTx').textContent        = btn.dataset.transactionId || '—';
            document.getElementById('refundMethod').textContent    = btn.dataset.method || '—';
            document.getElementById('refundAmountCaptured').textContent = btn.dataset.amount || '—';
            document.getElementById('refundMatch').textContent     = btn.dataset.match || '—';

            // Fill hidden inputs
            document.getElementById('refundPaymentId').value       = btn.dataset.paymentId || '';
            document.getElementById('refundTransactionId').value   = btn.dataset.transactionId || '';
            document.getElementById('refundMethodInput').value     = btn.dataset.method || '';
            document.getElementById('refundPaymentMethod').value   = btn.dataset.method || '';
            document.getElementById('refundMatchInput').value      = btn.dataset.match || '';

            // Editable amount
            const amountInput = document.getElementById('refundAmountInput');
            const maxSpan     = document.getElementById('refundAmountMax');

            if (maxSpan)   maxSpan.textContent = maxRefund.toFixed(2);
            if (amountInput) {
                amountInput.max   = maxRefund.toFixed(2);
                amountInput.min   = '0.01';
                amountInput.value = maxRefund.toFixed(2); // default to full remaining; user can lower it

                amountInput.addEventListener('input', function() {
                    let v = parseFloat(this.value || '0');
                    if (isNaN(v)) return;
                    if (v > maxRefund) this.value = maxRefund.toFixed(2);
                    if (v < 0.01 && this.value !== '') this.value = '0.01';
                }, { once: true });
            }

            // Clear previous reason
            const reason = document.getElementById('refundReason');
            if (reason) reason.value = '';
        });

        // Basic Bootstrap validation + submit UX
        (function () {
            const form = document.querySelector('#refundModal form');
            const submitBtn = document.getElementById('refundSubmitBtn');
            if (!form || !submitBtn) return;

            form.addEventListener('submit', function (e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                } else {
                    submitBtn.disabled = true;
                    submitBtn.querySelector('.submit-text').classList.add('d-none');
                    submitBtn.querySelector('.spinner-border').classList.remove('d-none');
                }
                form.classList.add('was-validated');
            });

            // Reset state when modal hides
            const modalEl = document.getElementById('refundModal');
            modalEl.addEventListener('hidden.bs.modal', function () {
                form.classList.remove('was-validated');
                submitBtn.disabled = false;
                submitBtn.querySelector('.spinner-border').classList.add('d-none');
                submitBtn.querySelector('.submit-text').classList.remove('d-none');
            });

            // Focus amount field when shown
            modalEl.addEventListener('shown.bs.modal', function(){
                document.getElementById('refundAmountInput')?.focus();
            });
        })();
    </script>
@endsection
