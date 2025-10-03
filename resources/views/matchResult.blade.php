@extends('userLayouts.app')

@section('content')
    <style>
        /* Top 1–5 subtle highlights (dark-friendly) */
        .hl-1 { background: rgba(255,215,0,.08) !important; border-left: 3px solid #FFD700; }
        .hl-2 { background: rgba(192,192,192,.08) !important; border-left: 3px solid #C0C0C0; }
        .hl-3 { background: rgba(205,127,50,.10) !important; border-left: 3px solid #CD7F32; }
        .hl-4 { background: rgba(168,85,247,.10) !important; border-left: 3px solid #A855F7; }
        .hl-5 { background: rgba(34,211,238,.10) !important; border-left: 3px solid #22D3EE; }

    </style>

    <div class="container py-4">

        <h5 class="fw-semibold mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-trophy"></i> My Match Results
        </h5>

        {{-- Empty state --}}
        @if($matches->isEmpty())
            <div class="glass-card p-4 text-center text-white-50">
                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                No results found yet.
            </div>
        @endif

        {{-- Mobile cards --}}
        <div class="d-md-none">
            @foreach($matches as $m)
                @php
                    $total = (float)($m->total_kill_money ?? 0) + (float)($m->prize_money ?? 0);
                    $pos = (int)($m->position ?? 0);

                    // optional subtle highlight for top 5
                    $hl = $pos===1 ? 'hl-1' : ($pos===2 ? 'hl-2' : ($pos===3 ? 'hl-3' : ($pos===4 ? 'hl-4' : ($pos===5 ? 'hl-5' : ''))));
                @endphp
                <div class="glass-card p-3 mb-3 {{ $hl }}">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div class="small text-white-50">#{{ $m->match_id }}</div>
                        <span class="badge {{ $pos===1?'bg-warning text-dark':($pos<=5?'bg-info':'bg-secondary') }}">Pos {{ $pos }}</span>
                    </div>

                    <h6 class="mb-1">{{ $m->match_name }}</h6>

                    <div class="row g-2 text-center mt-2">
                        <div class="col-4">
                            <div class="card-dark rounded-3 p-2">
                                <div class="small text-white-50">Kills</div>
                                <div class="fw-semibold">{{ (int)$m->match_kill }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card-dark rounded-3 p-2">
                                <div class="small text-white-50">Kill ৳</div>
                                <div class="fw-semibold">৳{{ number_format($m->total_kill_money ?? 0) }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card-dark rounded-3 p-2">
                                <div class="small text-white-50">Prize ৳</div>
                                <div class="fw-semibold">৳{{ number_format($m->prize_money ?? 0) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-dark rounded-3 p-2 mt-2 text-center">
                        <div class="small text-white-50">Total ৳</div>
                        <div class="fw-semibold">৳{{ number_format($total) }}</div>
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
                            <th style="width:110px">Match ID</th>
                            <th>Match Name</th>
                            <th class="text-center" style="width:110px">Position</th>
                            <th class="text-center" style="width:90px">Kills</th>
                            <th class="text-end" style="width:140px">Kill Money</th>
                            <th class="text-end" style="width:140px">Prize Money</th>
                            <th class="text-end" style="width:140px">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($matches as $m)
                            @php
                                $total = (float)($m->total_kill_money ?? 0) + (float)($m->prize_money ?? 0);
                                $pos = (int)($m->position ?? 0);
                                $rowHl = $pos===1 ? 'hl-1' : ($pos===2 ? 'hl-2' : ($pos===3 ? 'hl-3' : ($pos===4 ? 'hl-4' : ($pos===5 ? 'hl-5' : ''))));
                            @endphp
                            <tr class="{{ $rowHl }}">
                                <td>#{{ $m->match_id }}</td>
                                <td class="fw-semibold">{{ $m->match_name }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $pos===1?'bg-warning text-dark':($pos<=5?'bg-info':'bg-secondary') }}">
                                        {{ $pos }}
                                    </span>
                                </td>
                                <td class="text-center">{{ (int)$m->match_kill }}</td>
                                <td class="text-end">৳{{ number_format($m->total_kill_money ?? 0) }}</td>
                                <td class="text-end">৳{{ number_format($m->prize_money ?? 0) }}</td>
                                <td class="text-end fw-semibold">৳{{ number_format($total) }}</td>
                            </tr>
                        @endforeach

                        @if($matches->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center text-white-50 py-4">No results found.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
