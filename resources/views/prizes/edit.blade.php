@extends('layouts.app')

@section('page_title','Create Prize Tool')

@section('content')
    <div class="card border-0 shadow-sm rounded-4">
        {{-- Header --}}
        <div class="p-3 p-md-4 bg-body-tertiary border-bottom d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 fw-semibold">Edit Prize Tool</h4>
                <span class="badge bg-primary-subtle text-primary">#{{ $prize->id }}</span>
                <span class="badge bg-info-subtle text-info">Match #{{ $prize->match_id }}</span>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('prizes.show',$prize->id) }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="bi bi-eye me-1"></i> View
                </a>
                <a href="{{ route('prizes.index') }}" class="btn btn-light rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <form action="{{ route('prizes.update', $prize->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                {{-- Match pick (dropdown lives in the form) --}}
                <div class="mb-4">
                    <div class="section-title mb-2">
                        <span class="badge rounded-pill bg-soft-primary text-primary me-2">0</span> Match
                    </div>

                    {{-- Hidden field to submit match_id --}}
                    <input type="hidden" name="match_id" id="match_id" value="{{ old('match_id', $prize->match_id) }}">

                    <div class="dropdown">
                        @php
                            // Prefer old() after validation errors; otherwise use the prize's current match_id
                            $selectedId = old('match_id', $prize->match_id);
                            $selectedMatch = collect($match ?? [])->firstWhere('id', (int)$selectedId);
                            $buttonLabel = $selectedMatch
                                ? ('Match #'.$selectedMatch->id.' - '.($selectedMatch->match_name ?? 'Unnamed'))
                                : ('Match #'.$selectedId);
                        @endphp

                        <button class="btn btn-outline-primary rounded-pill dropdown-toggle"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                id="matchDropdownBtn">
                            {{ $buttonLabel }}
                        </button>

                        <ul class="dropdown-menu shadow" style="max-height: 320px; overflow:auto;">
                            @forelse($match as $m)
                                <li>
                                    <a class="dropdown-item js-match" href="#"
                                       data-id="{{ $m->id }}"
                                       data-label="Match #{{ $m->id }} - {{ $m->match_name ?? 'Unnamed' }}">
                                        <div class="d-flex flex-column">
                                            <strong>Match #{{ $m->id }}</strong>
                                            <small class="text-muted">{{ $m->match_name ?? 'Unnamed' }}</small>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item-text text-muted">No matches available</span></li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="form-text mt-1">Pick the match this prize belongs to.</div>
                </div>

                <div class="row g-4">
                    {{-- Left column --}}
                    <div class="col-12 col-lg-7">
                        <div class="section-title mb-2">
                            <span class="badge rounded-pill bg-soft-primary text-primary me-2">1</span> Winners
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input type="text" name="mvp" id="mvp" class="form-control"
                                           value="{{ old('mvp', $prize->mvp ?? '') }}" placeholder="MVP">
                                    <label for="mvp">MVP</label>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input type="text" name="second_winner" id="second_winner" class="form-control"
                                           value="{{ old('second_winner', $prize->second_winner ?? '') }}" placeholder="2nd Winner">
                                    <label for="second_winner">2nd Winner</label>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input type="text" name="third_winner" id="third_winner" class="form-control"
                                           value="{{ old('third_winner', $prize->third_winner ?? '') }}" placeholder="3rd Winner">
                                    <label for="third_winner">3rd Winner</label>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input type="text" name="fourth_winner" id="fourth_winner" class="form-control"
                                           value="{{ old('fourth_winner', $prize->fourth_winner ?? '') }}" placeholder="4th Winner">
                                    <label for="fourth_winner">4th Winner</label>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input type="text" name="fifth_winner" id="fifth_winner" class="form-control"
                                           value="{{ old('fifth_winner', $prize->fifth_winner ?? '') }}" placeholder="5th Winner">
                                    <label for="fifth_winner">5th Winner</label>
                                </div>
                            </div>
                        </div>

                        {{-- (Optional) quick-fill templates inside the form --}}
                        <div class="mt-3">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Apply Winner Template
                                </button>
                                <ul class="dropdown-menu shadow">
                                    <li class="dropdown-header small text-muted">Prize templates</li>
                                    <li><a class="dropdown-item js-template" href="#" data-template="top5">Top 5 (MVP→5th)</a></li>
                                    <li><a class="dropdown-item js-template" href="#" data-template="top3">Top 3 (MVP→3rd)</a></li>
                                    <li><a class="dropdown-item js-template" href="#" data-template="mvpOnly">MVP Only</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item js-clear" href="#">Clear all fields</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="section-title mt-4 mb-2">
                            <span class="badge rounded-pill bg-soft-primary text-primary me-2">2</span> Total
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input type="number" step="0.01" name="total_grand_prize" id="total_grand_prize" class="form-control"
                                           value="{{ old('total_grand_prize', $prize->total_grand_prize ?? '') }}" placeholder="Total Grand Prize">
                                    <label for="total_grand_prize">Total Grand Prize</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right column (preview) --}}
                    <div class="col-12 col-lg-5">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3">Preview</h6>
                                <ul class="list-group list-group-flush small">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>MVP</span><span id="p_mvp">{{ old('mvp', $prize->mvp ?? '—') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>2nd</span><span id="p_2nd">{{ old('second_winner', $prize->second_winner ?? '—') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>3rd</span><span id="p_3rd">{{ old('third_winner', $prize->third_winner ?? '—') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>4th</span><span id="p_4th">{{ old('fourth_winner', $prize->fourth_winner ?? '—') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>5th</span><span id="p_5th">{{ old('fifth_winner', $prize->fifth_winner ?? '—') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between fw-semibold">
                                        <span>Total Grand Prize</span><span id="p_total">{{ old('total_grand_prize', $prize->total_grand_prize ?? '—') }}</span>
                                    </li>
                                </ul>
                                <div class="form-text mt-2">This is a visual preview only.</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end mt-4">
                    <a href="{{ route('prizes.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-soft-primary{ background: rgba(99,102,241,.08); }
        .section-title{ font-weight:700; display:flex; align-items:center; font-size:.95rem; }
        .form-floating>.form-control:focus{
            box-shadow: 0 0 0 .2rem rgba(99,102,241,.12);
            border-color:#6366f1;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Live preview (mirrors text)
        (function(){
            const map = [
                ['#mvp', '#p_mvp'],
                ['#second_winner', '#p_2nd'],
                ['#third_winner', '#p_3rd'],
                ['#fourth_winner', '#p_4th'],
                ['#fifth_winner', '#p_5th'],
                ['#total_grand_prize', '#p_total'],
            ];
            map.forEach(([src, dst])=>{
                const s = document.querySelector(src);
                const d = document.querySelector(dst);
                if(!s || !d) return;
                const update = () => d.textContent = s.value || '—';
                s.addEventListener('input', update);
                s.addEventListener('change', update);
            });
        })();

        // Match dropdown: save to hidden input + update button label
        (function(){
            const matchBtn = document.getElementById('matchDropdownBtn');
            const hidden = document.getElementById('match_id');
            document.querySelectorAll('.js-match').forEach(item=>{
                item.addEventListener('click', (e)=>{
                    e.preventDefault();
                    const id = item.dataset.id;
                    const label = item.dataset.label || ('Match #'+id);
                    hidden.value = id;
                    if (matchBtn) matchBtn.textContent = label;
                });
            });
        })();

        // Winner templates & clear
        (function(){
            const $ = (sel)=>document.querySelector(sel);
            const setValues = (vals) => {
                Object.entries(vals).forEach(([id, val])=>{
                    const el = $('#'+id);
                    if (el) { el.value = val; el.dispatchEvent(new Event('input')); }
                });
            };

            document.querySelectorAll('.js-template').forEach(a=>{
                a.addEventListener('click', (e)=>{
                    e.preventDefault();
                    const t = a.dataset.template;
                    if (t === 'top5') {
                        setValues({
                            mvp: 'Player A',
                            second_winner: 'Player B',
                            third_winner: 'Player C',
                            fourth_winner: 'Player D',
                            fifth_winner: 'Player E',
                            total_grand_prize: '5000'
                        });
                    } else if (t === 'top3') {
                        setValues({
                            mvp: 'Player A',
                            second_winner: 'Player B',
                            third_winner: 'Player C',
                            fourth_winner: '',
                            fifth_winner: '',
                            total_grand_prize: '3000'
                        });
                    } else if (t === 'mvpOnly') {
                        setValues({
                            mvp: 'Player A',
                            second_winner: '',
                            third_winner: '',
                            fourth_winner: '',
                            fifth_winner: '',
                            total_grand_prize: '1000'
                        });
                    }
                });
            });

            const clearItem = document.querySelector('.js-clear');
            if (clearItem) {
                clearItem.addEventListener('click', (e)=>{
                    e.preventDefault();
                    ['mvp','second_winner','third_winner','fourth_winner','fifth_winner','total_grand_prize']
                        .forEach(id=>{
                            const el = document.getElementById(id);
                            if (el) { el.value = ''; el.dispatchEvent(new Event('input')); }
                        });
                });
            }
        })();
    </script>
@endpush
