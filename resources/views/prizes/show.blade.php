@extends('layouts.app')

@section('page_title','Prize Tool Details')

@section('content')
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        {{-- Header --}}
        <div class="p-3 p-md-4 bg-body-tertiary border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h4 class="mb-1 fw-semibold">Prize Tool Details</h4>
                <div class="small text-muted d-flex align-items-center gap-2 flex-wrap">
                    <span>Prize ID: #{{ $prize->id }}</span>
                    <span class="badge bg-primary-subtle text-primary">Match ID: #{{ $prize->match_id ?? '—' }}</span>
                    <span class="badge bg-info-subtle text-info">Match Name: {{ $prize->match_name ?? '—' }}</span>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('prizes.index') }}" class="btn btn-light rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
                <a href="{{ route('prizes.edit', $prize->id) }}" class="btn btn-warning rounded-pill">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
                <button class="btn btn-outline-secondary rounded-pill" id="copyAllBtn">
                    <i class="bi bi-clipboard me-1"></i> Copy
                </button>
                <button class="btn btn-outline-secondary rounded-pill" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
                <button class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deletePrizeModal">
                    <i class="bi bi-trash3 me-1"></i> Delete
                </button>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body p-3 p-md-4">
            <div class="row g-4">
                {{-- Left: winners list --}}
                <div class="col-12 col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3 fs-5">Winners</h6> {{-- fs-5 = Bootstrap font-size utility --}}
                            <ul class="list-group list-group-flush" id="detailsList">
                                <li class="list-group-item d-flex justify-content-between align-items-center fs-6">
                                    <span class="text-muted">MVP</span>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill fs-6">{{ $prize->mvp ?: '—' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center fs-6">
                                    <span class="text-muted">2nd Winner</span>
                                    <span>{{ $prize->second_winner ?: '—' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center fs-6">
                                    <span class="text-muted">3rd Winner</span>
                                    <span>{{ $prize->third_winner ?: '—' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center fs-6">
                                    <span class="text-muted">4th Winner</span>
                                    <span>{{ $prize->fourth_winner ?: '—' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center fs-6">
                                    <span class="text-muted">5th Winner</span>
                                    <span>{{ $prize->fifth_winner ?: '—' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3 fs-5">Total</h6>
                            <div class="d-flex align-items-center justify-content-between fs-6">
                                <span class="text-muted">Total Grand Prize</span>
                                <span class="fw-semibold">{{ $prize->total_grand_prize ?: '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Right: match + timestamps --}}
                <div class="col-12 col-lg-5">
                    {{-- Match info --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Match</h6>
                            <div class="d-flex flex-column gap-2 small">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-hash me-1"></i> Match ID</span>
                                    <span>{{ $prize->match_id ?? '—' }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-123 me-1"></i> Match Name</span>
                                    <span>{{ $prize->match_name ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Timestamps --}}
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Timestamps</h6>
                            <div class="d-flex flex-column gap-2 small">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-calendar-plus me-1"></i> Created</span>
                                    <span>{{ optional($prize->created_at)->format('d M Y, h:i A') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-calendar-check me-1"></i> Updated</span>
                                    <span>{{ optional($prize->updated_at)->format('d M Y, h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light border mt-3 mb-0 small">
                        Tip: Use <em>Copy</em> to quickly share details with your team.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal fade" id="deletePrizeModal" tabindex="-1" aria-labelledby="deletePrizeLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePrizeLabel">Delete Prize Tool</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('prizes.destroy', $prize->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Are you sure you want to delete this prize tool?
                        <div class="alert alert-warning d-flex align-items-center gap-2 mt-2 mb-0 py-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div class="small mb-0">This action cannot be undone.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .list-group-item{ padding:.65rem 0; }
    </style>
@endpush

@push('scripts')
    <script>
        // Copy all details as plain text (includes match id & number)
        (function(){
            const btn = document.getElementById('copyAllBtn');
            btn?.addEventListener('click', async () => {
                const lines = [
                    'Prize Tool Details',
                    '-------------------',
                    'Prize ID: {{ $prize->id ?? '' }}',
                    'Match ID: {{ $prize->match_id ?? '' }}',
                    'Match Number: {{ $prize->match_number ?? '' }}',
                    'MVP: {{ $prize->mvp ?? '' }}',
                    '2nd Winner: {{ $prize->second_winner ?? '' }}',
                    '3rd Winner: {{ $prize->third_winner ?? '' }}',
                    '4th Winner: {{ $prize->fourth_winner ?? '' }}',
                    '5th Winner: {{ $prize->fifth_winner ?? '' }}',
                    'Total Grand Prize: {{ $prize->total_grand_prize ?? '' }}',
                    'Created: {{ optional($prize->created_at)->format('d M Y, h:i A') }}',
                    'Updated: {{ optional($prize->updated_at)->format('d M Y, h:i A') }}',
                ].join('\n');
                try{
                    await navigator.clipboard.writeText(lines);
                    btn.innerHTML = '<i class="bi bi-clipboard-check me-1"></i> Copied';
                    setTimeout(()=> btn.innerHTML = '<i class="bi bi-clipboard me-1"></i> Copy', 1400);
                }catch(e){
                    // Fallback
                    const ta = document.createElement('textarea');
                    ta.value = lines;
                    document.body.appendChild(ta);
                    ta.select(); document.execCommand('copy');
                    ta.remove();
                    btn.innerHTML = '<i class="bi bi-clipboard-check me-1"></i> Copied';
                    setTimeout(()=> btn.innerHTML = '<i class="bi bi-clipboard me-1"></i> Copy', 1400);
                }
            });
        })();
    </script>
@endpush
