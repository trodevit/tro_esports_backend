@extends('layouts.app')

@section('page_title', 'Matches')

@section('content')
    @php
        $highlightId = session('updated_id') ?? request('updated');
    @endphp

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-3 p-md-4">

            {{-- Header / actions --}}
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-0 fw-semibold">Matches</h4>
                    <span class="badge bg-primary-subtle text-primary">{{ isset($matches) ? ($matches instanceof \Illuminate\Pagination\AbstractPaginator ? $matches->total() : $matches->count()) : 0 }}</span>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form id="matchFilters" method="GET" action="{{ route('matches.index') }}" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                            <input type="search" class="form-control border-start-0" name="q" value="{{ request('q') }}"
                                   placeholder="Search by name or category…">
                        </div>
                        <select name="category" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            <option value="BR Match" {{ request('category')==='BR Match' ? 'selected' : '' }}>BR Match</option>
                            <option value="Class Squad" {{ request('category')==='Class Squad' ? 'selected' : '' }}>Class Squad</option>
                        </select>
                        <button class="btn btn-sm btn-outline-secondary">Filter</button>
                        @if(request()->hasAny(['q','category']))
                            <a href="{{ route('matches.index') }}" class="btn btn-sm btn-outline-light text-body-secondary">Reset</a>
                        @endif
                    </form>

                    <a href="{{ route('matches.create') }}" class="btn btn-primary btn-sm rounded-pill">
                        <i class="bi bi-plus-lg me-1"></i> Create New
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive rounded-3 border" style="max-height: 68vh;">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light position-sticky top-0" style="z-index:1;">
                    <tr class="text-nowrap">
                        <th style="width:56px;">#</th>
                        <th>Match</th>
                        <th>Category</th>
                        <th>Date & Time</th>
                        <th class="text-end">Grand Prize</th>
                        <th class="text-center">Details</th>
                        <th class="text-end" style="width:72px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($matches as $match)
                        <tr id="match-row-{{ $match->id }}" @class(['flash-target' => (string)$highlightId === (string)$match->id])>
                        <td class="text-muted">{{ $loop->iteration }}</td>

                            <td class="fw-medium">
                                <a href="{{ route('matches.show',$match->id) }}" class="link-underline link-underline-opacity-0">
                                    {{ $match->match_name }}
                                </a>
                                <div class="small text-muted">
                                    Map: {{ $match->map_type ?? '—' }} • Type: {{ $match->match_type ?? '—' }}
                                </div>
                            </td>

                            <td>
                                @php
                                    $cat = $match->category;
                                    $badgeClass = match($cat) {
                                        'BR Match' => 'bg-info-subtle text-info',
                                        'Class Squad' => 'bg-success-subtle text-success',
                                        default => 'bg-secondary-subtle text-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $cat }}</span>
                            </td>

                            <td class="text-nowrap">
                                @php
                                    $d = \Carbon\Carbon::parse($match->match_date ?? $match->match_time);
                                    $t = \Carbon\Carbon::parse($match->match_time);
                                @endphp
                                <div>{{ $d ? $d->format('d M Y') : '—' }}</div>
                                <small class="text-muted">{{ $t ? $t->format('h:i A') : '' }}</small>
                            </td>

                            <td class="text-end">
                                <span class="fw-semibold">৳{{ number_format((float)($match->grand_prize ?? 0)) }}</span>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('matches.show',$match->id) }}" class="btn btn-sm btn-outline-info rounded-pill">
                                    Details
                                </a>
                            </td>

                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('matches.edit', $match->id) }}">
                                                <i class="bi bi-pencil-square me-2"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button
                                                class="dropdown-item text-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteMatchModal"
                                                data-id="{{ $match->id }}"
                                                data-name="{{ $match->match_name }}"
                                            >
                                                <i class="bi bi-trash3 me-2"></i>Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="text-center py-5">
                                    <div class="mb-2"><i class="bi bi-collection fs-3 text-muted"></i></div>
                                    <p class="text-muted mb-3">No matches found.</p>
                                    <a href="{{ route('matches.create') }}" class="btn btn-primary btn-sm">Create your first match</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination (if using LengthAwarePaginator) --}}
            @if($matches instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Showing {{ $matches->firstItem() }}–{{ $matches->lastItem() }} of {{ $matches->total() }}
                    </small>
                    {{ $matches->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Reusable Delete Modal --}}
    <div class="modal fade" id="deleteMatchModal" tabindex="-1" aria-labelledby="deleteMatchLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMatchLabel">Delete Match</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteMatchForm" method="POST" action="#">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Are you sure you want to delete "<strong id="deleteMatchName">this match</strong>"?
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
        .table thead th {
            font-weight: 600;
            letter-spacing: .2px;
        }
        .table tbody tr:hover td { background: var(--bs-table-hover-bg); }
        .badge { font-weight: 600; }

        @keyframes rowFlash {
            0%   { background-color: rgba(34,197,94,.18); }   /* green-ish */
            50%  { background-color: rgba(34,197,94,.08); }
            100% { background-color: transparent; }
        }
        tr.row-flash > * {  /* apply to cells */
            animation: rowFlash 1600ms ease-out 1;
            transition: background-color .3s ease;
        }

        /* Optional pill to show "Updated" for a moment */
        .just-updated-badge{
            display:inline-block; margin-left:.25rem;
            font-size:.75rem; padding:.15rem .4rem;
            border-radius:999px;
            background: var(--bs-success-bg-subtle);
            color: var(--bs-success-text);
            border: 1px solid var(--bs-success-border-subtle, rgba(16,185,129,.25));
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function(){
            const highlightId = @json($highlightId);
            if(!highlightId) return;

            // Find the row and flash it
            const row = document.getElementById(`match-row-${highlightId}`);
            if(!row) return; // might be on a different page of pagination

            // Smooth scroll it into view
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Add a temporary class to animate background
            row.classList.add('row-flash');

            // Optional: add "Updated" badge next to the match name for a moment
            const nameCell = row.querySelector('td:nth-child(2)'); // your "Match" column
            if(nameCell){
                const badge = document.createElement('span');
                badge.className = 'just-updated-badge';
                badge.textContent = 'Updated';
                // append after the title link
                const titleLink = nameCell.querySelector('a, strong') || nameCell.firstChild;
                (titleLink?.parentNode || nameCell).insertBefore(badge, titleLink?.nextSibling || null);

                setTimeout(()=> badge.remove(), 2200);
            }

            // Clean up the row flash after the animation
            setTimeout(()=> row.classList.remove('row-flash'), 1800);
        })();
    </script>
@endpush

