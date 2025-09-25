@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h4 class="mb-4">Withdraw Requests</h4>

        {{-- Toggle Buttons --}}
        <ul class="nav nav-pills mb-4" id="withdrawTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="pill" data-bs-target="#pending" type="button" role="tab">
                    Pending <span class="badge bg-warning text-dark">{{ $pending->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="approved-tab" data-bs-toggle="pill" data-bs-target="#approved" type="button" role="tab">
                    Approved <span class="badge bg-success">{{ $approved->count() }}</span>
                </button>
            </li>
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content" id="withdrawTabsContent">
            {{-- Pending Requests --}}
            <div class="tab-pane fade show active" id="pending" role="tabpanel">
                <div class="row g-3">
                    @forelse ($pending as $withdraw)
                        @php
                            $methodColor = match(strtolower($withdraw->payment_method)) {
                                'bkash' => 'danger',  // red
                                'nagad' => 'warning', // orange
                                'rocket' => 'info',   // blue
                                default => 'secondary',
                            };
                        @endphp

                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body">
                                    <div class="row g-3 align-items-start">
                                        <div class="col-12 col-lg-8">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge text-bg-secondary">ID: {{ $withdraw->user_id }}</span>

                                                    {{-- Highlight Payment Method --}}
                                                    <span class="badge text-bg-{{ $methodColor }}">
                                                        {{ strtoupper($withdraw->payment_method) }}
                                                    </span>
                                                </div>
                                                <span class="badge text-bg-warning">Pending</span>
                                            </div>

                                            <div class="row row-cols-1 row-cols-sm-2 g-2">
                                                <div>
                                                    <div class="small text-muted">User Name</div>
                                                    <div class="fw-semibold">{{ $withdraw->name }}</div>
                                                </div>
                                                <div>
                                                    <div class="small text-muted">Email</div>
                                                    <div class="fw-semibold">{{ $withdraw->email }}</div>
                                                </div>
                                                <div>
                                                    <div class="small text-muted">Request Amount</div>
                                                    <div class="fw-semibold">{{ $withdraw->amount }}</div>
                                                </div>
                                                <div>
                                                    <div class="small text-muted">Payment Number</div>
                                                    <div class="fw-semibold">{{ $withdraw->payment_number }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Action Form --}}
                                        <div class="col-12 col-lg-4">
                                            <form action="{{ route('withdraw.money.update', $withdraw->id) }}" method="POST" class="d-grid gap-2">
                                                @csrf
                                                @method('PUT')
                                                <label for="txn-{{ $withdraw->id }}" class="form-label small text-muted mb-1">Transaction ID</label>
                                                <input type="text" id="txn-{{ $withdraw->id }}" name="transaction_id" class="form-control" placeholder="e.g., TXN12345">
                                                <div class="d-flex flex-wrap gap-2 mt-2">
                                                    <button type="submit" class="btn btn-success rounded-pill px-3">
                                                        <i class="bi bi-check2 me-1"></i> Approve
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-body-tertiary border-0 small text-muted">
                                    Requested by {{ $withdraw->name }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info border-0 rounded-3">No pending requests found.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Approved Requests --}}
            <div class="tab-pane fade" id="approved" role="tabpanel">
                <div class="row g-3">
                    @forelse ($approved as $withdraw)
                        @php
                            $methodColor = match(strtolower($withdraw->payment_method)) {
                                'bkash' => 'danger',  // red
                                'nagad' => 'warning', // orange
                                'rocket' => 'info',   // blue
                                default => 'secondary',
                            };
                        @endphp

                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body">
                                    <div class="row g-3 align-items-start">
                                        <div class="col-12 col-lg-8">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge text-bg-secondary">ID: {{ $withdraw->user_id }}</span>

                                                    {{-- Highlight Payment Method --}}
                                                    <span class="badge text-bg-{{ $methodColor }}">
                                                        {{ strtoupper($withdraw->payment_method) }}
                                                    </span>
                                                </div>
                                                <span class="badge text-bg-success">Approved</span>
                                            </div>

                                            <div class="row row-cols-1 row-cols-sm-2 g-2">
                                                <div>
                                                    <div class="small text-muted">User Name</div>
                                                    <div class="fw-semibold">{{ $withdraw->name }}</div>
                                                </div>
                                                <div>
                                                    <div class="small text-muted">Email</div>
                                                    <div class="fw-semibold">{{ $withdraw->email }}</div>
                                                </div>
                                                <div>
                                                    <div class="small text-muted">Approved Amount</div>
                                                    <div class="fw-semibold">{{ $withdraw->amount }}</div>
                                                </div>
                                                <div>
                                                    <div class="small text-muted">Transaction ID</div>
                                                    <div class="fw-semibold">{{ $withdraw->transaction_id }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-body-tertiary border-0 small text-muted">
                                    Approved by Admin
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-success border-0 rounded-3">No approved requests yet.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
