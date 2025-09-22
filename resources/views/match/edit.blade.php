@extends('layouts.app')

@section('page_title','Edit Match')

@section('content')
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        {{-- Header --}}
        <div class="p-3 p-md-4 bg-body-tertiary border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 fw-semibold">Edit Match</h4>
                <span class="badge bg-primary-subtle text-primary">#{{ $match->id }}</span>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('matches.index') }}" class="btn btn-light rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
                <a href="{{ route('matches.show',$match->id) }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="bi bi-eye me-1"></i> View
                </a>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="row g-4">
                {{-- Left: form --}}
                <div class="col-12 col-lg-8">
                    <form id="editMatchForm" action="{{ route('matches.update', $match->id) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- Section: Basic Info --}}
                        <div class="mb-4">
                            <div class="section-title">
                                <span class="badge rounded-pill bg-soft-primary text-primary me-2">1</span> Basic Info
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="match_name" id="match_name" class="form-control"
                                               value="{{ old('match_name', $match->match_name) }}" placeholder="Match name" required>
                                        <label for="match_name">Match Name *</label>
                                        <div class="invalid-feedback">Please enter a match name.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="category" id="category" class="form-select" required>
                                            <option value="BR Match" {{ old('category', $match->category) == 'BR Match' ? 'selected' : '' }}>BR Match</option>
                                            <option value="Class Squad" {{ old('category', $match->category) == 'Class Squad' ? 'selected' : '' }}>Class Squad</option>
                                        </select>
                                        <label for="category">Category *</label>
                                        <div class="invalid-feedback">Please choose a category.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Schedule & Capacity --}}
                        <div class="mb-4">
                            <div class="section-title">
                                <span class="badge rounded-pill bg-soft-primary text-primary me-2">2</span> Schedule & Capacity
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="date" name="match_date" id="match_date" class="form-control"
                                               value="{{ old('match_date', $match->match_date) }}" required>
                                        <label for="match_date">Match Date *</label>
                                        <div class="invalid-feedback">Pick a date.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="time" name="match_time" id="match_time" class="form-control"
                                               value="{{ old('match_time', $match->match_time) }}" required>
                                        <label for="match_time">Match Time *</label>
                                        <div class="invalid-feedback">Pick a time.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" name="player_limit" id="player_limit" class="form-control"
                                               value="{{ old('player_limit', $match->player_limit) }}" min="1" placeholder="100" required>
                                        <label for="player_limit">Player Limit *</label>
                                        <div class="invalid-feedback">Enter a valid player limit.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Prizes & Fees --}}
                        <div class="mb-4">
                            <div class="section-title">
                                <span class="badge rounded-pill bg-soft-primary text-primary me-2">3</span> Prizes & Fees
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="input-group form-floating">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" name="entry_fee" id="entry_fee" class="form-control"
                                               value="{{ old('entry_fee', $match->entry_fee) }}" min="0" placeholder="0" required>
                                        <label for="entry_fee">Entry Fee *</label>
                                        <div class="invalid-feedback">Enter entry fee (can be 0).</div>
                                    </div>
                                    <div class="form-text ms-1">Set 0 for free entry.</div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group form-floating">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" name="grand_prize" id="grand_prize" class="form-control"
                                               value="{{ old('grand_prize', $match->grand_prize) }}" min="0" placeholder="0" required>
                                        <label for="grand_prize">Grand Prize *</label>
                                        <div class="invalid-feedback">Enter the prize.</div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group form-floating">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" name="per_kill_price" id="per_kill_price" class="form-control"
                                               value="{{ old('per_kill_price', $match->per_kill_price) }}" min="0" placeholder="0" required>
                                        <label for="per_kill_price">Per Kill *</label>
                                        <div class="invalid-feedback">Enter per-kill reward.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Game Settings --}}
                        <div class="mb-4">
                            <div class="section-title">
                                <span class="badge rounded-pill bg-soft-primary text-primary me-2">4</span> Game Settings
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select name="match_type" id="match_type" class="form-select" required>
                                            @foreach(['Solo','Duo','4v4 Team','1v3','2v3','1v2'] as $type)
                                                <option value="{{ $type }}" {{ old('match_type', $match->match_type) == $type ? 'selected' : '' }}>
                                                    {{ $type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="match_type">Match Type *</label>
                                        <div class="invalid-feedback">Choose a match type.</div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" name="map_type" id="map_type" class="form-control"
                                               value="{{ old('map_type', $match->map_type) }}" placeholder="Erangel" required>
                                        <label for="map_type">Map Type *</label>
                                        <div class="invalid-feedback">Enter a map type.</div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select name="version" id="version" class="form-select" required>
                                            @foreach(['Mobile','PC Player'] as $version)
                                                <option value="{{ $version }}" {{ old('version', $match->version) == $version ? 'selected' : '' }}>
                                                    {{ $version }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="version">Version *</label>
                                        <div class="invalid-feedback">Select a version.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Text areas --}}
                        <div class="mb-4">
                            <div class="section-title">
                                <span class="badge rounded-pill bg-soft-primary text-primary me-2">5</span> Instructions & Room
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Match Instructions</label>
                                    <textarea name="instructions" id="instructions" class="form-control html-editor" rows="6"
                                              placeholder="Write match instructions…">{{ old('instructions', $match->instructions) }}</textarea>
                                    <div class="form-text">Formatting supported.</div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                    <textarea name="room_details" id="room_details" class="form-control" style="height: 120px"
                                              placeholder="Room ID, password, timing notes">{{ old('room_details', $match->room_details) }}</textarea>
                                        <label for="room_details">Room Details</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end">
                            <a href="{{ route('matches.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Update Match</button>
                        </div>
                    </form>
                </div>

                {{-- Right: Live preview --}}
                <div class="col-12 col-lg-4">
                    <div class="sticky-lg-top" style="top: 1rem;">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <h6 class="fw-semibold mb-3">Live Preview</h6>
                                    <span class="badge bg-soft-primary text-primary" id="previewCategory">Category</span>
                                </div>

                                <h5 class="mb-1" id="previewTitle">{{ $match->match_name }}</h5>
                                <div class="text-muted small mb-3" id="previewMeta">—</div>

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge bg-light text-dark border" id="previewType">Type</span>
                                    <span class="badge bg-light text-dark border" id="previewVersion">Version</span>
                                    <span class="badge bg-light text-dark border" id="previewMap">Map</span>
                                    <span class="badge bg-light text-dark border" id="previewPlayers">Players</span>
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="card bg-soft-success border-0">
                                            <div class="card-body py-2">
                                                <div class="small text-success-700">Grand Prize</div>
                                                <div class="fw-bold" id="previewPrize">৳0</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card bg-soft-info border-0">
                                            <div class="card-body py-2">
                                                <div class="small text-info-700">Per Kill</div>
                                                <div class="fw-bold" id="previewPerKill">৳0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="small text-muted" id="previewRoom">Room details will appear here.</div>
                            </div>
                        </div>

                        <div class="alert alert-light border mt-3 mb-0 small">
                            Tip: Fields marked * are required. Preview updates as you type.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-soft-primary{ background: rgba(99,102,241,.08); }
        .bg-soft-success{ background: rgba(16,185,129,.08); }
        .bg-soft-info{ background: rgba(59,130,246,.08); }
        .text-success-700{ color:#047857; }
        .text-info-700{ color:#1d4ed8; }
        .section-title{ font-weight:700; margin-bottom:.75rem; display:flex; align-items:center; font-size:.95rem; }
        .form-floating>.form-control:focus, .form-floating>.form-select:focus{
            box-shadow: 0 0 0 .2rem rgba(99,102,241,.15);
            border-color: #6366f1;
        }
        .input-group .form-floating>label{ left:2.75rem; }
        .input-group-text{ border-top-right-radius:0; border-bottom-right-radius:0; }
    </style>
@endpush

@push('scripts')
    <script>
        // Bootstrap validation
        (function () {
            const form = document.getElementById('editMatchForm');
            form?.addEventListener('submit', function (e) {
                if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
                form.classList.add('was-validated');
            }, false);
        })();

        // Summernote/TinyMCE hook if present
        if (window.$ && $('.html-editor').summernote) {
            $('.html-editor').summernote({ height: 200 });
        }

        // Live preview
        (function(){
            const fields = {
                match_name:  document.getElementById('match_name'),
                category:    document.getElementById('category'),
                match_date:  document.getElementById('match_date'),
                match_time:  document.getElementById('match_time'),
                player_limit:document.getElementById('player_limit'),
                entry_fee:   document.getElementById('entry_fee'),
                grand_prize: document.getElementById('grand_prize'),
                per_kill_price: document.getElementById('per_kill_price'),
                match_type:  document.getElementById('match_type'),
                map_type:    document.getElementById('map_type'),
                version:     document.getElementById('version'),
                room_details:document.getElementById('room_details')
            };

            const preview = {
                title:   document.getElementById('previewTitle'),
                meta:    document.getElementById('previewMeta'),
                category:document.getElementById('previewCategory'),
                type:    document.getElementById('previewType'),
                version: document.getElementById('previewVersion'),
                map:     document.getElementById('previewMap'),
                players: document.getElementById('previewPlayers'),
                prize:   document.getElementById('previewPrize'),
                perKill: document.getElementById('previewPerKill'),
                room:    document.getElementById('previewRoom')
            };

            function money(v){
                const n = Number(v||0);
                return '৳' + (isFinite(n) ? n.toLocaleString() : '0');
            }
            function update(){
                preview.title.textContent = fields.match_name?.value || '{{ $match->match_name }}';
                preview.category.textContent = fields.category?.value || '{{ $match->category }}';
                const d = fields.match_date?.value || '{{ $match->match_date }}';
                const t = fields.match_time?.value || '{{ $match->match_time }}';
                preview.meta.textContent = (d||t) ? `${d||'—'} at ${t||'—'}` : '—';
                preview.type.textContent = fields.match_type?.value || '{{ $match->match_type }}';
                preview.version.textContent = fields.version?.value || '{{ $match->version }}';
                preview.map.textContent = fields.map_type?.value || '{{ $match->map_type }}';
                preview.players.textContent = (fields.player_limit?.value || '{{ $match->player_limit }}') + ' players';
                preview.prize.textContent = money(fields.grand_prize?.value || '{{ (float)$match->grand_prize }}');
                preview.perKill.textContent = money(fields.per_kill_price?.value || '{{ (float)$match->per_kill_price }}');
                preview.room.textContent = fields.room_details?.value || `{{ $match->room_details ? e($match->room_details) : 'Room details will appear here.' }}`;
            }
            Object.values(fields).forEach(el=>{
                el?.addEventListener('input', update);
                el?.addEventListener('change', update);
            });
            update();
        })();
    </script>
@endpush
