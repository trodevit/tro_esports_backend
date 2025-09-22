@extends('layouts.app')

@section('page_title','Edit Prize Tool')

@section('content')
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        {{-- Header --}}
        <div class="p-3 p-md-4 bg-body-tertiary border-bottom d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 fw-semibold">Edit Prize Tool</h4>
                <span class="badge bg-primary-subtle text-primary">#{{ $prize->id }}</span>
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

                <div class="row g-4">
                    {{-- Left column: form --}}
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

                        {{-- Actions --}}
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end mt-4">
                            <a href="{{ route('prizes.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Update</button>
                        </div>
                    </div>

                    {{-- Right column: simple live preview (no calculations) --}}
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
                                <div class="form-text mt-2">Preview mirrors inputs only.</div>
                            </div>
                        </div>

                        <div class="small text-muted mt-2">
                            Tip: Keep labels descriptive (e.g., “MVP” could be player name or notes).
                        </div>
                    </div>
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
        // Simple live preview (no math, just mirrors text)
        (function(){
            const pairs = [
                ['#mvp', '#p_mvp'],
                ['#second_winner', '#p_2nd'],
                ['#third_winner', '#p_3rd'],
                ['#fourth_winner', '#p_4th'],
                ['#fifth_winner',  '#p_5th'],
                ['#total_grand_prize', '#p_total'],
            ];
            for (const [srcSel, dstSel] of pairs) {
                const src = document.querySelector(srcSel);
                const dst = document.querySelector(dstSel);
                if (!src || !dst) continue;
                const update = () => dst.textContent = src.value || '—';
                src.addEventListener('input', update);
                src.addEventListener('change', update);
            }
        })();
    </script>
@endpush
