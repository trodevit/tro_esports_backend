@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h4 class="mb-4">New Pending Withdraw Requests</h4>

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
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex gap-2 flex-wrap">
                                    <span class="badge text-bg-secondary">ID: {{ $withdraw->user_id }}</span>
                                    <span class="badge text-bg-{{ $methodColor }}">{{ strtoupper($withdraw->payment_method) }}</span>
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
                        <div class="card-footer bg-body-tertiary border-0 small text-muted">
                            Requested on {{ $withdraw->created_at->format('d M Y, h:i A') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info border-0 rounded-3">
                        🎉 No new pending requests!
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Redirect button --}}
        <div class="mt-4 text-center">
            <a href="{{ route('withdraw.money') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-arrow-right-circle me-1"></i> View All Withdraw Requests
            </a>
        </div>
    </div>
@endsection
