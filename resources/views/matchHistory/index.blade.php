{{-- resources/views/matchHistory/index.blade.php --}}
@extends('layouts.app')

@section('page_title', 'Match History')

@section('content')
    <style>
        /* ---- Scoped styles for this page only ---- */
        .page-hero {
            background: linear-gradient(135deg, #f8fbff 0%, #f3f7ff 100%);
            border: 1px solid #e9eef5;
            border-radius: 1rem;
        }

        .table thead th.sticky {
            position: sticky;
            top: 0;
            z-index: 5;
            background: #fff;
            border-top: 0;
        }

        .table-hover tbody tr:hover {
            background-color: #f9fbff !important;
        }

        .chip {
            display: inline-block;
            padding: .25rem .5rem;
            border-radius: 999px;
            font-size: .75rem;
            background: #eef5ff;
            border: 1px solid #e0e9ff;
            margin: 0 .25rem .25rem 0;
            white-space: nowrap;
        }

        .text-truncate-1 {
            max-width: 220px;
            display: inline-block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            vertical-align: bottom;
        }

        /* Card list (mobile) tweaks */
        .mh-card {
            border: 1px solid #eef1f6;
            border-radius: .75rem;
        }
        .mh-card .mh-label {
            font-size: .75rem;
            color: #6b7280;
        }
        .mh-card .mh-value {
            font-weight: 600;
        }

        /* Make numeric columns narrower on wide screens */
        @media (min-width: 992px) {
            .col-narrow { width: 90px; }
            .col-wider { width: 140px; }
        }
    </style>

    @php $total = $histories->count(); @endphp

    <div class="container py-4">
        <div class="page-hero p-3 p-md-4 mb-3 d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">
            <div>
                <h3 class="mb-1">Match History</h3>
                <div class="text-muted">You have <span class="fw-semibold">{{ $total }}</span> record{{ $total === 1 ? '' : 's' }}.</div>
            </div>
            <div class="d-flex align-items-center gap-2 w-100 w-md-auto">
                <input id="mhSearch" type="search" class="form-control"
                       placeholder="Search by Match ID, Name, Email, Username…"
                       aria-label="Search match history">
                <button type="button" class="btn btn-outline-secondary d-none d-md-inline-flex" id="mhClearBtn">Clear</button>
            </div>
        </div>

        {{-- Desktop / Tablet Table --}}
        <div class="card border-0 shadow-sm d-none d-md-block">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th class="sticky">#</th>
                        <th class="sticky">Match ID</th>
                        <th class="sticky d-none d-lg-table-cell">User ID</th>
                        <th class="sticky">Name</th>
                        <th class="sticky d-none d-lg-table-cell">Email</th>
                        <th class="sticky d-none d-xl-table-cell">Mobile</th>
                        <th class="sticky">Username</th>
                        <th class="sticky text-end col-narrow">Total Kill</th>
                        <th class="sticky text-end col-narrow">Per Kill</th>
                        <th class="sticky text-end col-narrow">Position</th>
                        <th class="sticky text-end col-wider">Prize Money</th>
                        <th class="sticky d-none d-lg-table-cell">Created At</th>
                    </tr>
                    </thead>
                    <tbody id="mhTableBody">
                    @forelse($histories as $history)
                        <tr class="mh-row">
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="chip">#{{ $history->match_id }}</span></td>
                            <td class="d-none d-lg-table-cell">{{ $history->id }}</td>
                            <td>
                                <span class="text-truncate-1" title="{{ $history->name }}">{{ $history->name }}</span>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <span class="text-truncate-1" title="{{ $history->email }}">{{ $history->email }}</span>
                            </td>
                            <td class="d-none d-xl-table-cell">
                                <span class="text-truncate-1" title="{{ $history->mobile }}">{{ $history->mobile }}</span>
                            </td>
                            <td>
                                <span class="text-truncate-1" title="{{ $history->username }}">{{ $history->username }}</span>
                            </td>
                            <td class="text-end">{{ $history->match_kill }}</td>
                            <td class="text-end">{{ $history->per_kill ?? $history->total_kill_money }}</td>
                            <td class="text-end">{{ $history->position }}</td>
                            <td class="text-end">৳{{ number_format($history->prize_money, 0) }}</td>
                            <td class="d-none d-lg-table-cell">{{ $history->created_at?->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted py-4">
                                No match history found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Cards --}}
        <div class="d-md-none">
            @forelse($histories as $history)
                <div class="mh-card p-3 shadow-sm mb-2 mh-row">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="mh-label">Match</div>
                            <div class="mh-value"><span class="chip">#{{ $history->match_id }}</span></div>
                        </div>
                        <div class="text-end">
                            <div class="mh-label">Created</div>
                            <div class="small text-muted">{{ $history->created_at?->format('Y-m-d H:i') }}</div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <div class="mh-label">Name</div>
                            <div class="mh-value text-truncate" title="{{ $history->name }}">{{ $history->name }}</div>
                        </div>
                        <div class="col-6">
                            <div class="mh-label">Username</div>
                            <div class="mh-value text-truncate" title="{{ $history->username }}">{{ $history->username }}</div>
                        </div>

                        <div class="col-12">
                            <div class="mh-label">Email</div>
                            <div class="text-truncate" title="{{ $history->email }}">{{ $history->email }}</div>
                        </div>

                        @if(!empty($history->mobile))
                            <div class="col-12">
                                <div class="mh-label">Mobile</div>
                                <div class="text-truncate" title="{{ $history->mobile }}">{{ $history->mobile }}</div>
                            </div>
                        @endif

                        <div class="col-4">
                            <div class="mh-label">Kills</div>
                            <div class="mh-value">{{ $history->match_kill }}</div>
                        </div>
                        <div class="col-4">
                            <div class="mh-label">Per Kill</div>
                            <div class="mh-value">{{ $history->total_kill_money }}</div>
                        </div>
                        <div class="col-4">
                            <div class="mh-label">Position</div>
                            <div class="mh-value">{{ $history->position }}</div>
                        </div>

                        <div class="col-12">
                            <div class="mh-label">Prize Money</div>
                            <div class="fs-5 fw-bold">৳{{ number_format($history->prize_money, 0) }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-4">
                    No match history found.
                </div>
            @endforelse
        </div>
    </div>

    <script>
        (function () {
            const q = document.getElementById('mhSearch');
            const clearBtn = document.getElementById('mhClearBtn');
            const rows = Array.from(document.querySelectorAll('.mh-row'));

            function normalize(s) {
                return (s || '').toString().toLowerCase();
            }

            function rowText(el) {
                // combine all text within a row/card for searching
                return normalize(el.textContent);
            }

            function applyFilter() {
                const term = normalize(q.value);
                rows.forEach(el => {
                    const match = rowText(el).includes(term);
                    el.style.display = match ? '' : 'none';
                });
            }

            if (q) {
                q.addEventListener('input', applyFilter);
            }
            if (clearBtn) {
                clearBtn.addEventListener('click', function () {
                    q.value = '';
                    applyFilter();
                    q.focus();
                });
            }
        })();
    </script>
@endsection
