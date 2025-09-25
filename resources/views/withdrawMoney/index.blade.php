@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h4 class="mb-4">Withdraw Requests</h4>

        <div class="row g-3">
            @forelse ($money as $withdraw)
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body">
                            <div class="row g-3 align-items-start">
                                {{-- Left: User & Request Details --}}
                                <div class="col-12 col-lg-8">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge text-bg-secondary">ID: {{ $withdraw->user_id }}</span>
                                            <span class="badge text-bg-light text-muted">Method: {{ $withdraw->payment_method }}</span>
                                        </div>
                                        <span class="badge
                                        @class([
                                            'text-bg-warning' => $withdraw->payment_status === 'pending',
                                            'text-bg-success' => $withdraw->payment_status === 'approved',
                                            'text-bg-danger'  => $withdraw->payment_status === 'rejected',
                                            'text-bg-secondary' => !in_array($withdraw->payment_status, ['pending','approved','rejected']),
                                        ])
                                    ">
                                        {{ ucfirst($withdraw->payment_status) }}
                                    </span>
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

                                {{-- Right: Action Form --}}
                                <div class="col-12 col-lg-4">
                                    <form action="{{route('withdraw.money.update',$withdraw->id)}}" method="POST" class="d-grid gap-2">
                                        @csrf
                                        @method('PUT')

                                        {{-- Transaction ID --}}
                                        <label for="txn-{{ $withdraw->id }}" class="form-label small text-muted mb-1">Transaction ID</label>
                                        <input
                                            type="text"
                                            id="txn-{{ $withdraw->id }}"
                                            name="transaction_id"
                                            class="form-control"
                                            placeholder="e.g., TXN12345"
                                        >

                                        {{-- Hidden fields if needed --}}
                                        {{-- <input type="hidden" name="withdraw_id" value="{{ $withdraw->id }}"> --}}

                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                            <button type="submit" class="btn btn-success rounded-pill px-3">
                                                <i class="bi bi-check2 me-1"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary rounded-pill px-3"
                                                    onclick="this.closest('form').reset()">
                                                Reset
                                            </button>
                                        </div>

                                        <div class="small text-muted">
                                            Approving will save the provided Transaction ID.
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Optional subtle footer --}}
                        <div class="card-footer bg-body-tertiary border-0 small text-muted">
                            Requested by {{ $withdraw->name }} · Method: {{ $withdraw->payment_method }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info border-0 rounded-3">
                        No withdraw requests found.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
