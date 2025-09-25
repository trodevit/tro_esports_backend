@extends('layouts.app')

@section('page_title','Registered Players')

@section('content')
    <div class="card border-0 shadow-sm rounded-4">
        {{-- Header --}}
        <div class="p-3 p-md-4 bg-body-tertiary border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 fw-semibold">Registered Players</h4>
                <span class="badge bg-primary-subtle text-primary">
                {{ is_countable($register) ? count($register) : 0 }}
            </span>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-light rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body p-3 p-md-4">
            @forelse($register as $registerd)
                @php
                    // Partners (array | json | csv -> array)
                    $partners = $registerd->partners_name ?? [];
                    if (is_string($partners)) {
                        $decoded = json_decode($partners, true);
                        $partners = json_last_error() === JSON_ERROR_NONE ? $decoded : explode(',', $partners);
                    }
                    $partners = is_array($partners) ? array_filter($partners) : [];
                    $partnersText = $partners ? implode(', ', $partners) : '—';

                    // Currency format
                    $amount = is_numeric($registerd->amount ?? null) ? number_format((float)$registerd->amount) : ($registerd->amount ?? '—');

                    // Avatar initials from game_username or name
                    $baseName = trim(($registerd->game_username ?? '') ?: ($registerd->name ?? ''));
                    $initials = collect(explode(' ', $baseName))
                        ->filter()->map(fn($p) => mb_strtoupper(mb_substr($p,0,1)))->take(2)->implode('');

                    // Optional match meta if exists on item (won't break if missing)
                    $matchId   = $registerd->match_id ?? null;
                    $matchName = $registerd->match_name ?? null;
                @endphp

                <div class="card border-0 rounded-4 mb-3 reg-card">
                    <div class="card-body p-3 p-md-4">
                        <div class="row g-4 align-items-start">
                            {{-- Left: summary --}}
                            <div class="col-12 col-lg-8">
                                <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-soft">
                                            <span>{{ $initials ?: 'U' }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold lh-sm">{{ $registerd->game_username ?? '—' }}</div>
                                            <div class="small text-muted">{{ $registerd->name ?? '—' }}</div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        @if($registerd->match_type)
                                            <span class="chip chip-success"><i class="bi bi-controller me-1"></i>{{ $registerd->match_type }}</span>
                                        @endif
                                        @if($matchId)
                                            <span class="chip chip-primary">Match ID: #{{ $matchId }}</span>
                                        @endif
                                        @if($matchName)
                                            <span class="chip chip-info">Match: {{ $matchName }}</span>
                                        @endif
                                    </div>
                                </div>

                                <ul class="list-group list-group-flush nice-list">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="muted-label"><i class="bi bi-person-fill me-2"></i>Main Player</span>
                                        <span class="fw-semibold">{{ $registerd->game_username ?? '—' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="muted-label"><i class="bi bi-people-fill me-2"></i>Partner Players</span>
                                        <span class="text-truncate text-end" style="max-width: 60%;">{{ $partnersText }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="muted-label"><i class="bi bi-cash-coin me-2"></i>Total Pay</span>
                                        <span class="fw-semibold">৳{{ $amount }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="muted-label"><i class="bi bi-telephone-fill me-2"></i>Payment Number</span>
                                        <div class="d-flex align-items-center gap-2">
                                            <span>{{ $registerd->payment_number ?? '—' }}</span>
                                            @if(!empty($registerd->payment_number))
                                                <button class="btn btn-xs btn-outline-secondary copy-btn"
                                                        type="button"
                                                        data-copy="{{ $registerd->payment_number }}"
                                                        title="Copy payment number">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="muted-label"><i class="bi bi-phone-fill me-2"></i>User Number</span>
                                        <div class="d-flex align-items-center gap-2">
                                            <span>{{ $registerd->phone ?? '—' }}</span>
                                            @if(!empty($registerd->phone))
                                                <a class="btn btn-xs btn-outline-secondary" href="tel:{{ $registerd->phone }}" title="Call">
                                                    <i class="bi bi-telephone-outbound"></i>
                                                </a>
                                                <a class="btn btn-xs btn-outline-success" target="_blank"
                                                   href="https://wa.me/{{ preg_replace('/\D/','',$registerd->phone) }}"
                                                   title="WhatsApp">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>
                                            @endif
                                            @if(!empty($registerd->game_username))
                                                <button class="btn btn-xs btn-outline-secondary copy-btn"
                                                        type="button"
                                                        data-copy="{{ $registerd->game_username }}"
                                                        title="Copy username">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            {{-- Right: quick update --}}
                            <div class="col-12 col-lg-4">
                                <div class="p-3 bg-body-tertiary rounded-3 border">
                                    <h6 class="fw-semibold mb-3">Quick Update</h6>

                                    {{-- Balance Form --}}
                                    <form action="#" method="POST" class="row g-3 mb-3">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-12">
                                            <label for="balance-{{ $registerd->id }}" class="form-label small text-muted">Add Money</label>
                                            <input type="number" class="form-control" id="balance-{{ $registerd->id }}" name="balance" placeholder="Amount">
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

                                    {{-- Position Form --}}
                                    <form action="#" method="POST" class="row g-3">
                                        @csrf
                                        @method('PUT')
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

                                    <div class="small text-muted mt-2">Each form works separately, you can wire different actions if needed.</div>
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
        .reg-card{ box-shadow: 0 6px 18px rgba(0,0,0,.04); transition: transform .15s ease, box-shadow .15s ease; }
        .reg-card:hover{ transform: translateY(-1px); box-shadow: 0 10px 24px rgba(0,0,0,.06); }

        .avatar-soft{
            width: 44px; height: 44px; border-radius: 50%;
            display: grid; place-items: center;
            background: rgba(99,102,241,.10);
            color: #5850ec; font-weight: 700;
            letter-spacing: .5px;
        }

        .chip{
            display: inline-flex; align-items: center; gap: .25rem;
            padding: .25rem .6rem; border-radius: 999px; font-size: .75rem; font-weight: 600;
            border: 1px solid transparent;
        }
        .chip-primary{ background: rgba(13,110,253,.08); color:#0d6efd; border-color: rgba(13,110,253,.2); }
        .chip-success{ background: rgba(25,135,84,.08); color:#198754; border-color: rgba(25,135,84,.2); }
        .chip-info{ background: rgba(13,202,240,.10); color:#087990; border-color: rgba(13,202,240,.25); }

        .nice-list .list-group-item{ padding:.8rem 0; }
        .muted-label{ color:#6c757d; }

        /* xs-sized buttons */
        .btn-xs{
            --bs-btn-padding-y: .15rem;
            --bs-btn-padding-x: .45rem;
            --bs-btn-font-size: .75rem;
            --bs-btn-border-radius: 999px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function(){
            // Copy buttons for phone/payment/username
            const toast = (btn, ok=true) => {
                const icon = ok ? 'bi-clipboard-check' : 'bi-clipboard-x';
                const prev = btn.innerHTML;
                btn.innerHTML = `<i class="bi ${icon}"></i>`;
                setTimeout(()=> btn.innerHTML = prev, 1200);
            };

            document.addEventListener('click', async (e)=>{
                const btn = e.target.closest('.copy-btn');
                if(!btn) return;
                const text = btn.getAttribute('data-copy') || '';
                try{
                    await navigator.clipboard.writeText(text);
                    toast(btn, true);
                }catch(_){
                    // Fallback
                    const ta = document.createElement('textarea');
                    ta.value = text;
                    document.body.appendChild(ta); ta.select(); document.execCommand('copy'); ta.remove();
                    toast(btn, true);
                }
            });
        })();
    </script>
@endpush
