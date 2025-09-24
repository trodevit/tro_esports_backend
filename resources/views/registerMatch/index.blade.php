@extends('layouts.app')

@section('page_title','Registered Players')

@section('content')
    <div class="card border-0 shadow-sm rounded-4">
        {{-- Header --}}
        <div class="p-3 p-md-4 bg-body-tertiary border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 fw-semibold">Registered Players</h4>
                <span class="badge bg-primary-subtle text-primary">{{ is_countable($register) ? count($register) : 0 }}</span>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-light rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        {{-- Body --}}
        <div class="card-body p-3 p-md-4">
            @forelse($register as $registerd)
                @php
                    // Safe partners_name handling (array or json or csv)
                    $partners = $registerd->partners_name ?? [];
                    if (is_string($partners)) {
                        $decoded = json_decode($partners, true);
                        $partners = json_last_error() === JSON_ERROR_NONE ? $decoded : explode(',', $partners);
                    }
                    $partners = is_array($partners) ? array_filter($partners) : [];
                    $partnersText = $partners ? implode(', ', $partners) : '—';

                    $amount = is_numeric($registerd->amount ?? null) ? number_format((float)$registerd->amount) : ($registerd->amount ?? '—');
                @endphp

                <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden">
                    <div class="card-body">
                        <div class="row g-4 align-items-start">
                            {{-- Left: summary --}}
                            <div class="col-12 col-lg-8">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-success-subtle text-success">Match Type: {{ $registerd->match_type ?? '—' }}</span>
                                    <span class="badge bg-info-subtle text-info">User: {{ $registerd->game_username ?? '—' }}</span>
                                </div>

                                <ul class="list-group list-group-flush nice-list">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="text-muted"><i class="bi bi-person-fill me-2"></i>Main Player</span>
                                        <span class="fw-semibold">{{ $registerd->game_username ?? '—' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="text-muted"><i class="bi bi-people-fill me-2"></i>Partner Players</span>
                                        <span class="text-truncate text-end" style="max-width: 60%;">
                                        {{ $partnersText }}
                                    </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="text-muted"><i class="bi bi-cash-coin me-2"></i>Total Pay</span>
                                        <span class="fw-semibold">৳{{ $amount }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="text-muted"><i class="bi bi-telephone-fill me-2"></i>Payment Number</span>
                                        <span>{{ $registerd->payment_number ?? '—' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="text-muted"><i class="bi bi-phone-fill me-2"></i>User Number</span>
                                        <span>{{ $registerd->phone ?? '—' }}</span>
                                    </li>
                                </ul>
                            </div>

                            {{-- Right: small update form --}}
                            <div class="col-12 col-lg-4">
                                <div class="p-3 bg-body-tertiary rounded-3 border">
                                    <h6 class="fw-semibold mb-3">Quick Update</h6>
                                    <form action="{{ route('register.update', $registerd->id ?? 0) }}" method="POST" class="row g-3">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-12">
                                            <label for="balance-{{ $registerd->id }}" class="form-label small text-muted">Add Money</label>
                                            <input type="number" class="form-control" id="balance-{{ $registerd->id }}" name="balance" placeholder="Amount">
                                        </div>
                                        <div class="col-12">
                                            <label for="position-{{ $registerd->id }}" class="form-label small text-muted">Add Position</label>
                                            <input type="text" class="form-control" id="position-{{ $registerd->id }}" name="position" placeholder="e.g., #1, #2">
                                        </div>
                                        <div class="col-12 d-flex gap-2">
                                            <button type="submit" class="btn btn-success rounded-pill px-3">
                                                <i class="bi bi-check2 me-1"></i> Save
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary rounded-pill px-3"
                                                    onclick="this.closest('form').reset()">
                                                Reset
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> {{-- row --}}
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="mb-2"><i class="bi bi-people fs-3 text-muted"></i></div>
                    <p class="text-muted mb-3">No registrations found.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .nice-list .list-group-item{ padding:.75rem 0; }
        .nice-list .list-group-item span:first-child{ color:#6c757d; }
    </style>
@endpush
