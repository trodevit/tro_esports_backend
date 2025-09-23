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
        .table thead th.sticky {
            position: sticky; top: 0; z-index: 5;
            background: #fff; /* for backdrop */
            border-top: 0;
        }
        .table-hover tbody tr:hover {
            background-color: #f8fbff !important;
        }
        .chip {
            display: inline-block; padding: .25rem .5rem; border-radius: 999px;
            font-size: .75rem; background: #eef5ff; border: 1px solid #e0e9ff;
            margin: 0 .25rem .25rem 0;
        }
        .muted {
            color: #6c757d;
        }
        .truncate {
            max-width: 220px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            vertical-align: bottom;
        }
        .copy-btn {
            border: 1px dashed #d0d7e1; background: #fff; font-size: .7rem; padding: .1rem .35rem; line-height: 1;
        }
        .card-rounded { border-radius: 1rem; }
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
                            <th class="sticky">Transaction</th>
                            <th class="sticky">Date & Time</th>
                            <th class="sticky">Match</th>
                            <th class="sticky">Order</th>
                            <th class="sticky">Partners</th>
                            <th class="sticky">Created</th>
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
                                $partners = is_array($p->partners_name) ? array_filter($p->partners_name) : [];
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center py-5">
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

    {{-- tiny copy-to-clipboard helper --}}
    <script>
        document.addEventListener('click', function(e) {
            if (e.target && e.target.matches('.copy-btn')) {
                const val = e.target.getAttribute('data-copy') || '';
                if (!val) return;
                navigator.clipboard.writeText(val).then(function () {
                    const old = e.target.textContent;
                    e.target.textContent = 'copied';
                    setTimeout(()=>{ e.target.textContent = old; }, 800);
                });
            }
        });
    </script>
@endsection
