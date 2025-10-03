@extends('userLayouts.app')

@section('content')
    <div class="container py-4">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <h5 class="fw-semibold mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-receipt"></i> Payment History
            </h5>

            {{-- Optional lightweight filters (no white backgrounds) --}}
{{--            <form method="GET" class="d-flex gap-2">--}}
{{--                <select name="status" class="form-select bg-transparent text-white border-light" style="max-width:180px">--}}
{{--                    <option value="">All Status</option>--}}
{{--                    <option value="success" {{ request('status')==='success'?'selected':'' }}>Success</option>--}}
{{--                    <option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option>--}}
{{--                    <option value="failed"  {{ request('status')==='failed' ?'selected':'' }}>Failed</option>--}}
{{--                </select>--}}
{{--                <button class="btn btn-ghost btn-pill" type="submit"><i class="bi bi-funnel me-1"></i> Filter</button>--}}
{{--            </form>--}}
        </div>

        {{-- Empty state --}}
        @if($payments->isEmpty())
            <div class="glass-card p-4 text-center text-white-50">
                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                No payments found.
            </div>
        @endif

        {{-- Mobile cards --}}
        <div class="d-md-none">
            @foreach($payments as $p)
                @php
                    $isSuccess = ($p->status ?? '') === 'success';
                    $isPending = ($p->status ?? '') === 'pending';
                    $badge = $isSuccess ? 'bg-success' : ($isPending ? 'bg-warning text-dark' : 'bg-danger');
                @endphp
                <div class="glass-card p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div class="fw-semibold">৳{{ number_format($p->amount ?? 0) }}</div>
                        <span class="badge {{ $badge }}">{{ ucfirst($p->status ?? 'unknown') }}</span>
                    </div>
                    <div class="small text-white-50">
                        <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($p->created_at)->format('M d, Y h:i A') }}
                        @if(!empty($p->method)) · <i class="bi bi-wallet2 me-1"></i>{{ strtoupper($p->method) }} @endif
                        @if(!empty($p->transaction_id)) · <i class="bi bi-hash me-1"></i>{{ $p->transaction_id }} @endif
                        @if(!empty($p->match_name)) <div class="mt-1"><i class="bi bi-controller me-1"></i>{{ $p->match_name }}</div> @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Desktop table --}}
        <div class="card glass-card border-0 shadow-sm d-none d-md-block">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th style="width:160px">Date</th>
                            <th>Match</th>
                            <th class="text-end" style="width:130px">Amount</th>
                            <th style="width:120px">Method</th>
                            <th style="width:140px">Txn ID</th>
                            <th class="text-center" style="width:120px">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $p)
                            @php
                                $isSuccess = ($p->status ?? '') === 'success';
                                $isPending = ($p->status ?? '') === 'pending';
                                $badge = $isSuccess ? 'bg-success' : ($isPending ? 'bg-warning text-dark' : 'bg-danger');
                            @endphp
                            <tr>
                                <td class="small text-white-50">
                                    {{ \Carbon\Carbon::parse($p->created_at)->format('M d, Y h:i A') }}
                                </td>
                                <td class="fw-semibold">
                                    {{ $p->match_name ?? '—' }}
                                </td>
                                <td class="text-end">৳{{ number_format($p->amount ?? 0) }}</td>
                                <td>{{ strtoupper($p->method ?? '—') }}</td>
                                <td class="small text-white-50">{{ $p->transaction_id ?? '—' }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $badge }}">{{ ucfirst($p->status ?? 'unknown') }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination slot (optional) --}}
                @if(method_exists($payments, 'links'))
                    <div class="p-3">
                        {{ $payments->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
