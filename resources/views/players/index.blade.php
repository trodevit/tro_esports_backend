@extends('layouts.app')

@section('page_title','Players')

@section('content')
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-3 p-md-4">

            {{-- Header / actions --}}
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-0 fw-semibold">Players</h4>
                    <span class="badge bg-primary-subtle text-primary">
                    {{ isset($users) ? ($users instanceof \Illuminate\Pagination\AbstractPaginator ? $users->total() : $users->count()) : 0 }}
                </span>
                </div>
                <form method="GET" action="{{ route('players.index') }}" class="d-flex flex-wrap align-items-center gap-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control border-start-0" name="q" value="{{ request('q') }}"
                               placeholder="Search name, email or phone…">
                    </div>
                    <select name="permission" class="form-select form-select-sm">
                        <option value="">All</option>
                        <option value="granted" {{ request('permission')==='granted' ? 'selected' : '' }}>Granted</option>
                        <option value="denied"  {{ request('permission')==='denied'  ? 'selected' : '' }}>Denied</option>
                    </select>
                    <button class="btn btn-sm btn-outline-secondary">Filter</button>
                    @if(request()->hasAny(['q','permission']))
                        <a href="{{ route('players.index') }}" class="btn btn-sm btn-outline-light text-body-secondary">Reset</a>
                    @endif
                </form>
            </div>

            {{-- Table --}}
            <div class="table-responsive rounded-3 border" style="max-height: 68vh;">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light position-sticky top-0" style="z-index:1;">
                    <tr class="text-nowrap">
                        <th style="width:56px;">#</th>
                        <th style="min-width:220px;">Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>UID</th>
                        <th>Permission</th>
                        <th class="text-end" style="width:170px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $player)
                        <tr id="player-row-{{ $player->id }}">
                            <td class="text-muted">{{ $loop->iteration }}</td>

                            <td class="fw-medium">{{ $player->name }}</td>

                            <td class="text-nowrap">
                                <a class="text-decoration-none" href="mailto:{{ $player->email }}">{{ $player->email }}</a>
                            </td>

                            <td class="text-nowrap">
                                <a class="text-decoration-none" href="tel:{{ $player->phone }}">{{ $player->phone ?: '—' }}</a>
                            </td>

                            <td class="text-nowrap">{{ $player->uid ?: '—' }}</td>

                            <td>
                                @if($player->blocked)
                                    <span class="badge bg-danger-subtle text-danger">Denied</span>
                                @else
                                    <span class="badge bg-success-subtle text-success">Granted</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <form action="{{ route('players.update', $player->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="btn btn-sm {{ $player->blocked ? 'btn-success' : 'btn-warning' }} rounded-pill">
                                        {{ $player->blocked ? 'Unblock' : 'Block' }}
                                    </button>
                                </form>

                                {{-- Solid delete button (no dropdown) --}}
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger rounded-pill ms-1"
                                        data-delete
                                        data-player-id="{{ $player->id }}"
                                        data-player-name="{{ $player->name }}">
                                    <i class="bi bi-trash3 me-1"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="text-center py-5">
                                    <div class="mb-2"><i class="bi bi-people fs-3 text-muted"></i></div>
                                    <p class="text-muted mb-0">No players found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($users instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }}
                    </small>
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Reusable Delete Modal --}}
    <div class="modal fade" id="deletePlayerModal" tabindex="-1" aria-labelledby="deletePlayerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePlayerLabel">Delete Player</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deletePlayerForm" method="POST" action="#">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Are you sure you want to delete <strong id="deletePlayerName">this player</strong>?
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
        .table thead th{ font-weight:600; letter-spacing:.2px; }
        .table tbody tr:hover td{ background: var(--bs-table-hover-bg); }
        .badge{ font-weight:600; }
    </style>
@endpush

@push('scripts')
    <script>
        (function(){
        // Make sure Bootstrap JS is loaded from your layout:
        // <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    // Wire every [data-delete] button to open the modal and set the form action
    const modalEl = document.getElementById('deletePlayerModal');
    const nameEl  = document.getElementById('deletePlayerName');
    const formEl  = document.getElementById('deletePlayerForm');
    const bsModal = modalEl ? new bootstrap.Modal(modalEl) : null;

    document.addEventListener('click', function(e){
    const btn = e.target.closest('[data-delete]');
    if(!btn || !bsModal) return;

    const id   = btn.getAttribute('data-player-id');
    const name = btn.getAttribute('data-player-name') || 'this player';

    nameEl.textContent = name;
    formEl.setAttribute('action', `{{ url('/players') }}/${id}`);

    bsModal.show();
    }, true); // use capture to avoid dropdown/parent interference (robust)
    })();
    </script>
@endpush
