@extends('layouts.app')

@section('page_title','Match Details')

@section('content')
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        {{-- Header --}}
        <div class="p-3 p-md-4 bg-body-tertiary border-bottom">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <h4 class="mb-1 fw-semibold">{{ $match->match_name }}</h4>
                    <div class="d-flex flex-wrap align-items-center gap-2 small text-muted">
                    <span>
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ \Carbon\Carbon::parse($match->match_date)->format('d M Y') }}
                        at {{ \Carbon\Carbon::parse($match->match_time)->format('h:i A') }}
                    </span>
                        <span class="vr"></span>
                        <span><i class="bi bi-people me-1"></i> {{ $match->player_limit }} players</span>
                        <span class="vr"></span>
                        <span><i class="bi bi-map me-1"></i> {{ $match->map_type }}</span>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('matches.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                    <a href="{{ route('matches.edit', $match->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>
                    <button class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="bi bi-printer me-1"></i> Print
                    </button>
                </div>
            </div>

            {{-- Quick stats --}}
            @php
                $catClass = match($match->category){
                    'BR Match' => 'bg-info-subtle text-info',
                    'Class Squad' => 'bg-success-subtle text-success',
                    default => 'bg-secondary-subtle text-secondary'
                };
                $typeClass = 'bg-primary-subtle text-primary';
                $verClass  = 'bg-dark-subtle text-dark';
            @endphp
            <div class="d-flex flex-wrap gap-2 mt-3">
            <span class="badge {{ $catClass }} px-3 py-2 fw-semibold">
                <i class="bi bi-grid-3x3-gap-fill me-1"></i>{{ $match->category }}
            </span>
                <span class="badge {{ $typeClass }} px-3 py-2 fw-semibold">
                <i class="bi bi-controller me-1"></i>{{ $match->match_type }}
            </span>
                <span class="badge {{ $verClass }} px-3 py-2 fw-semibold">
                <i class="bi bi-phone me-1"></i>{{ $match->version }}
            </span>
                <span class="badge bg-warning-subtle text-warning px-3 py-2 fw-semibold">
                <i class="bi bi-cash-coin me-1"></i> Entry Fee: ৳{{ number_format((float) $match->entry_fee) }}
            </span>
                <span class="badge bg-success-subtle text-success px-3 py-2 fw-semibold">
                <i class="bi bi-trophy me-1"></i> Grand Prize: ৳{{ number_format((float) $match->grand_prize) }}
            </span>
                <span class="badge bg-primary-subtle text-primary px-3 py-2 fw-semibold">
                <i class="bi bi-bullseye me-1"></i> Per Kill: ৳{{ number_format((float) $match->per_kill_price) }}
            </span>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body p-3 p-md-4">
            <div class="row g-4">
                {{-- Left column --}}
                <div class="col-12 col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Overview</h6>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="small text-muted">Category</div>
                                    <div class="fw-medium">{{ $match->category }}</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="small text-muted">Match Type</div>
                                    <div class="fw-medium">{{ $match->match_type }}</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="small text-muted">Map Type</div>
                                    <div class="fw-medium">{{ $match->map_type }}</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="small text-muted">Version</div>
                                    <div class="fw-medium">{{ $match->version }}</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="small text-muted">Player Limit</div>
                                    <div class="fw-medium">{{ $match->player_limit }}</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="small text-muted">Entry Fee</div>
                                    <div class="fw-medium">৳{{ number_format((float) $match->entry_fee) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Instructions</h6>
                            <div class="prose small">
                                {{-- safe HTML from WYSIWYG --}}
                                {!! $match->instructions ?: '<span class="text-muted">No instructions provided.</span>' !!}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right column --}}
                <div class="col-12 col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Schedule</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-light text-body border"><i class="bi bi-calendar-date"></i></span>
                                    <span>{{ \Carbon\Carbon::parse($match->match_date)->isoFormat('dddd, D MMMM Y') }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-2">
                                    <span class="badge bg-light text-body border"><i class="bi bi-clock"></i></span>
                                    <span>{{ \Carbon\Carbon::parse($match->match_time)->format('h:i A') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Room Details</h6>
                            <div class="d-flex align-items-start justify-content-between gap-2">
                                <pre class="mb-0 small flex-grow-1" id="roomText" style="white-space:pre-wrap">{{ $match->room_details ?: '—' }}</pre>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="copyRoomBtn">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                            <div class="form-text mt-2">Copy and share with participants shortly before start time.</div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Timestamps</h6>
                            <div class="d-flex flex-column gap-1 small">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Created</span>
                                    <span>{{ $match->created_at?->format('d M Y, h:i A') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Last Updated</span>
                                    <span>{{ $match->updated_at?->format('d M Y, h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /col -->
            </div><!-- /row -->
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .prose :is(p,ul,ol){ margin-bottom:.5rem; }
        .prose ul{ padding-left:1.1rem; }
        .prose li{ margin:.25rem 0; }
    </style>
@endpush

@push('scripts')
    <script>
        // Copy Room Details
        (function(){
            const btn = document.getElementById('copyRoomBtn');
            const txt = document.getElementById('roomText');
            btn?.addEventListener('click', async () => {
                try{
                    await navigator.clipboard.writeText(txt?.innerText || '');
                    btn.innerHTML = '<i class="bi bi-clipboard-check"></i>';
                    setTimeout(()=> btn.innerHTML = '<i class="bi bi-clipboard"></i>', 1200);
                }catch(e){
                    // fallback
                    const r = document.createRange(); r.selectNodeContents(txt);
                    const s = window.getSelection(); s.removeAllRanges(); s.addRange(r);
                    document.execCommand('copy'); s.removeAllRanges();
                    btn.innerHTML = '<i class="bi bi-clipboard-check"></i>';
                    setTimeout(()=> btn.innerHTML = '<i class="bi bi-clipboard"></i>', 1200);
                }
            });
        })();
    </script>
@endpush
