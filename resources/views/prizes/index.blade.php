@extends('layouts.app')

@section('page_title','Prize Tools')

@section('content')
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-3 p-md-4">

            {{-- Header / actions --}}
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-0 fw-semibold">Prize Tools</h4>
                    <span class="badge bg-primary-subtle text-primary">
                    {{ isset($prizes) ? ($prizes instanceof \Illuminate\Pagination\AbstractPaginator ? $prizes->total() : $prizes->count()) : 0 }}
                </span>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form method="GET" action="{{ route('prizes.index') }}" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                            <input type="search" class="form-control border-start-0" name="q" value="{{ request('q') }}"
                                   placeholder="Search MVP or amounts…">
                        </div>
                        <button class="btn btn-sm btn-outline-secondary">Filter</button>
                        @if(request()->has('q'))
                            <a href="{{ route('prizes.index') }}" class="btn btn-sm btn-outline-light text-body-secondary">Reset</a>
                        @endif>
                    </form>

                    <a href="{{ route('prizes.create') }}" class="btn btn-primary btn-sm rounded-pill">
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
                        <th>Match ID</th>
                        <th>Match Name</th>
                        <th>MVP</th>
                        <th>2nd</th>
                        <th>3rd</th>
                        <th>4th</th>
                        <th>5th</th>
                        <th class="text-end">Total Prize</th>
                        <th class="text-end" style="width:72px;">Actions</th>
                        <th class="text-center" style="width:92px;">Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($prizes as $prize)
                        @php
                            $fmt = fn($v) => '৳'.number_format((float)($v ?? 0));
                        @endphp
                        <tr id="prize-row-{{ $prize->id }}">
                            <td class="text-muted">{{ $loop->iteration }}</td>

                            <td class="text-muted">#{{ $prize->match_id }}</td>
                            <td class="text-nowrap">{{ $prize->match_name ?? '—' }}</td>

                            <td class="text-nowrap"><span class="badge bg-success-subtle text-success">{{ $prize->mvp }}</span></td>
                            <td class="text-nowrap">{{ $prize->second_winner }}</td>
                            <td class="text-nowrap">{{ $prize->third_winner }}</td>
                            <td class="text-nowrap">{{ $prize->fourth_winner }}</td>
                            <td class="text-nowrap">{{ $prize->fifth_winner }}</td>

                            <td class="text-end fw-semibold">{{ $fmt($prize->total_grand_prize) }}</td>

                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('prizes.edit', $prize->id) }}">
                                                <i class="bi bi-pencil-square me-2"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button
                                                class="dropdown-item text-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deletePrizeModal"
                                                data-id="{{ $prize->id }}"
                                                data-name="Prize #{{ $prize->id }}"
                                            >
                                                <i class="bi bi-trash3 me-2"></i>Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('prizes.show',$prize->id) }}" class="btn btn-sm btn-outline-info rounded-pill">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">
                                <div class="text-center py-5">
                                    <div class="mb-2"><i class="bi bi-gift fs-3 text-muted"></i></div>
                                    <p class="text-muted mb-3">No prize tools found.</p>
                                    <a href="{{ route('prizes.create') }}" class="btn btn-primary btn-sm">Create your first prize</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>


                    {{--                    @if(!empty($prizes) && count($prizes))--}}
{{--                        --}}{{-- Optional footer summary (client-side) --}}
{{--                        <tfoot class="table-secondary position-sticky bottom-0">--}}
{{--                        <tr>--}}
{{--                            <th colspan="6" class="text-end">Total (this page)</th>--}}
{{--                            <th class="text-end" id="pageTotalCell">—</th>--}}
{{--                            <th colspan="2"></th>--}}
{{--                        </tr>--}}
{{--                        </tfoot>--}}
{{--                    @endif--}}
                </table>
            </div>

            {{-- Pagination --}}
            @if($prizes instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Showing {{ $prizes->firstItem() }}–{{ $prizes->lastItem() }} of {{ $prizes->total() }}
                    </small>
                    {{ $prizes->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Reusable Delete Modal --}}
    <div class="modal fade" id="deletePrizeModal" tabindex="-1" aria-labelledby="deletePrizeLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePrizeLabel">Delete Prize</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deletePrizeForm" method="POST" action="#">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Are you sure you want to delete <strong id="deletePrizeName">this prize</strong>?
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
        // Reusable delete modal wiring
        (function(){
            const modal = document.getElementById('deletePrizeModal');
            const nameEl = document.getElementById('deletePrizeName');
            const form   = document.getElementById('deletePrizeForm');
            modal?.addEventListener('show.bs.modal', function (event) {
                const btn  = event.relatedTarget;
                const id   = btn?.getAttribute('data-id');
                const name = btn?.getAttribute('data-name') || 'this prize';
                if(!id) return;
                nameEl.textContent = name;
                form.setAttribute('action', `{{ url('/prizes') }}/${id}`);
            });
        })();

        // Page total (this page only)
        (function(){
            const cell = document.getElementById('pageTotalCell');
            if(!cell) return;
            const rows = document.querySelectorAll('tbody tr');
            let sum = 0;
            rows.forEach(r=>{
                const td = r.querySelector('td:nth-last-child(4)'); // the Total Prize cell (text-end)
                if(!td) return;
                const num = (td.textContent || '').replace(/[^\d.]/g,'');
                sum += Number(num||0);
            });
            cell.textContent = '৳' + sum.toLocaleString();
        })();
    </script>
@endpush
