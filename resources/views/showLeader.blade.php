@extends('userLayouts.app')

@section('content')

    <style>
        /* Leaderboard row/card highlights (dark-friendly, subtle) */
        .hl-1 { background: rgba(255,215,0,.08) !important; border-left: 3px solid #FFD700; }   /* Gold */
        .hl-2 { background: rgba(192,192,192,.08) !important; border-left: 3px solid #C0C0C0; } /* Silver */
        .hl-3 { background: rgba(205,127,50,.10) !important; border-left: 3px solid #CD7F32; }  /* Bronze */
        .hl-4 { background: rgba(168,85,247,.10) !important; border-left: 3px solid #A855F7; }  /* Purple */
        .hl-5 { background: rgba(34,211,238,.10) !important; border-left: 3px solid #22D3EE; }  /* Cyan */

        /* Optional: make highlight pop a bit on hover (desktop) */
        .table tbody tr.hl-1:hover,
        .table tbody tr.hl-2:hover,
        .table tbody tr.hl-3:hover,
        .table tbody tr.hl-4:hover,
        .table tbody tr.hl-5:hover {
            filter: brightness(1.05);
        }

    </style>

    <div class="container py-4">

        {{-- Match Header --}}
        <div class="glass-card p-3 p-md-4 mb-4">
            <h4 class="mb-1">{{ $match['match_name'] }}</h4>
            <div class="text-white-50 small mb-2">
                <i class="bi bi-controller me-1"></i>{{ $match['match_type'] }} ·
                <i class="bi bi-map me-1"></i>{{ $match['map_type'] }} ·
                <i class="bi bi-people me-1"></i>{{ $match['player_limit'] }} Players
            </div>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-danger"><i class="bi bi-trophy me-1"></i>৳{{ number_format($match['grand_prize'],0) }}</span>
                <span class="badge bg-success"><i class="bi bi-bullseye me-1"></i>৳{{ number_format($match['per_kill_price'],0) }} / Kill</span>
                <span class="badge bg-info"><i class="bi bi-ticket-detailed me-1"></i>৳{{ number_format($match['entry_fee'],0) }} Entry</span>
            </div>
            <div class="text-white-50 small mt-2">
                <i class="bi bi-calendar2-week me-1"></i>
                {{ \Carbon\Carbon::parse($match['match_date'].' '.$match['match_time'])->format('M d, Y h:i A') }}
            </div>
            @if(!empty($match['instructions']))
                <div class="divider"></div>
                <div class="small text-white-50">
                    <i class="bi bi-info-circle me-1"></i>{!! nl2br(e($match['instructions'])) !!}
                </div>
            @endif
        </div>

        {{-- Desktop table --}}
        <div class="card glass-card border-0 shadow-sm d-none d-md-block">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th style="width:80px">Pos</th>
                            <th>Player</th>
                            <th class="text-center">Kills</th>
                            <th class="text-end">Kill Money</th>
                            <th class="text-end">Prize</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Recorded</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($histories as $row)
                            @php
                                $h = $row['history'];
                                $u = $row['userLayouts'];
                                $total = ($h['prize_money'] ?? 0) + ($h['total_kill_money'] ?? 0);

                                // Row highlight class for positions 1–5
                                $pos = (int) $h['position'];
                                $rowHl = $pos === 1 ? 'hl-1'
                                      : ($pos === 2 ? 'hl-2'
                                      : ($pos === 3 ? 'hl-3'
                                      : ($pos === 4 ? 'hl-4'
                                      : ($pos === 5 ? 'hl-5' : ''))));

                                // Badge color stays readable on dark
                                $badgeClass = $pos === 1 ? 'bg-warning text-dark'
                                            : ($pos === 2 ? 'bg-secondary'
                                            : ($pos === 3 ? 'bg-danger'
                                            : ($pos === 4 ? 'bg-purple'  // if you don't have bg-purple, keep bg-secondary
                                            : ($pos === 5 ? 'bg-info' : 'bg-secondary'))));
                            @endphp
                            <tr class="{{ $rowHl }}">
                                <td>
                                    <span class="badge {{ $badgeClass }}">#{{ $h['position'] }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $h['username'] }}</div>
                                    <div class="small text-white-50">
                                        {{ $u['name'] ?? '' }} @if(!empty($u['phone'])) · {{ $u['phone'] }} @endif
                                    </div>
                                </td>
                                <td class="text-center">{{ $h['match_kill'] }}</td>
                                <td class="text-end">৳{{ number_format($h['total_kill_money'],0) }}</td>
                                <td class="text-end">৳{{ number_format($h['prize_money'],0) }}</td>
                                <td class="text-end fw-semibold">৳{{ number_format($total,0) }}</td>
                                <td class="text-end small text-white-50">
                                    {{ \Carbon\Carbon::parse($h['created_at'])->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        {{-- Mobile cards --}}
        <div class="d-md-none">
            @foreach($histories as $row)
                @php
                    $h = $row['history'];
                    $u = $row['userLayouts'];
                    $total = ($h['prize_money'] ?? 0) + ($h['total_kill_money'] ?? 0);
                    $pos = (int) $h['position'];
                    $cardHl = $pos === 1 ? 'hl-1'
                           : ($pos === 2 ? 'hl-2'
                           : ($pos === 3 ? 'hl-3'
                           : ($pos === 4 ? 'hl-4'
                           : ($pos === 5 ? 'hl-5' : ''))));

                    $badgeClass = $pos === 1 ? 'bg-warning text-dark'
                                : ($pos === 2 ? 'bg-secondary'
                                : ($pos === 3 ? 'bg-danger'
                                : ($pos === 4 ? 'bg-purple'
                                : ($pos === 5 ? 'bg-info' : 'bg-secondary'))));
                @endphp

                <div class="glass-card p-3 mb-3 {{ $cardHl }}">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="badge {{ $badgeClass }}">#{{ $h['position'] }}</span>
                        <span class="small text-white-50">
                {{ \Carbon\Carbon::parse($h['created_at'])->format('M d, Y h:i A') }}
            </span>
                    </div>

                    <div class="fw-semibold">{{ $h['username'] }}</div>
                    <div class="small text-white-50 mb-2">
                        {{ $u['name'] ?? '' }} @if(!empty($u['phone'])) · {{ $u['phone'] }} @endif
                    </div>

                    <div class="row g-2 text-center">
                        <div class="col-4">
                            <div class="card-dark rounded-3 p-2">
                                <div class="small text-white-50">Kills</div>
                                <div class="fw-semibold">{{ $h['match_kill'] }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card-dark rounded-3 p-2">
                                <div class="small text-white-50">Prize</div>
                                <div class="fw-semibold">৳{{ number_format($h['prize_money'],0) }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card-dark rounded-3 p-2">
                                <div class="small text-white-50">Total</div>
                                <div class="fw-semibold">৳{{ number_format($total,0) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- Back / CTA --}}
        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('home') }}#matches" class="btn btn-ghost btn-pill">
                <i class="bi bi-arrow-left-short me-1"></i> Back to Matches
            </a>
            <a href="{{ route('download-apk') }}" class="btn btn-accent btn-pill">
                <i class="bi bi-android2 me-1"></i> Get the App
            </a>
        </div>
    </div>
@endsection
