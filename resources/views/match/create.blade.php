@extends('layouts.app')

@section('page_title','Create Match')

@section('content')
    <div class="container my-4">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Header -->
            <div class="card-header p-3 p-md-4 border-0 bg-gradient-primary text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-white text-primary fw-semibold rounded-pill px-3 py-2">New</span>
                        <h4 class="mb-0 fw-semibold">Create Match</h4>
                    </div>
                    <a href="{{ route('matches.index') }}" class="btn btn-light btn-sm rounded-pill px-3">
                        ← Back to Matches
                    </a>
                </div>
                <div class="mt-3">
                    <div class="small opacity-75">Fill out the details below. Your progress updates as you complete required fields.</div>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar progress-bar-striped" id="formProgress" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <div class="card-body p-3 p-md-4">
                <div class="row g-4">
                    <!-- Left: Form -->
                    <div class="col-12 col-lg-8">
                        <form action="{{ route('matches.store') }}" method="POST" id="createMatchForm" novalidate>
                            @csrf

                            <!-- Section: Basic Info -->
                            <div class="section mb-4">
                                <div class="section-title">
                                    <span class="badge rounded-pill bg-soft-primary text-primary me-2">1</span>
                                    Basic Info
                                </div>
                                <div class="row g-3">
                                    <!-- Match Name -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="match_name" id="match_name" class="form-control" placeholder="Match name" required>
                                            <label for="match_name">Match Name *</label>
                                            <div class="form-text">Use a short, unique title (e.g., “BR Night Cup #12”).</div>
                                            <div class="invalid-feedback">Please enter a match name.</div>
                                        </div>
                                    </div>

                                    <!-- Category -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select name="category" id="category" class="form-select" required>
                                                <option value="" disabled selected>Select Category</option>
                                                <option value="br_match">BR Match</option>
                                                <option value="br_servival">BR Servival</option>
                                                <option value="clash_squad">Clash Squad</option>
                                                <option value="csv2">CSV2</option>
                                                <option value="lone_wolf">Lone Wolf</option>
                                                <option value="free_match">Free Match</option>
                                            </select>
                                            <label for="category">Category *</label>
                                            <div class="invalid-feedback">Please select a category.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Schedule & Capacity -->
                            <div class="section mb-4">
                                <div class="section-title">
                                    <span class="badge rounded-pill bg-soft-primary text-primary me-2">2</span>
                                    Schedule & Capacity
                                </div>
                                <div class="row g-3">
                                    <!-- Match Date -->
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="date" name="match_date" id="match_date" class="form-control" required>
                                            <label for="match_date">Match Start Date *</label>
                                            <div class="invalid-feedback">Pick a start date.</div>
                                        </div>
                                    </div>
                                    <!-- Match Time -->
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="time" name="match_time" id="match_time" class="form-control" required>
                                            <label for="match_time">Match Start Time *</label>
                                            <div class="invalid-feedback">Pick a start time.</div>
                                        </div>
                                    </div>
                                    <!-- Player Limit -->
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="number" name="player_limit" id="player_limit" class="form-control" placeholder="e.g. 100" min="1" required>
                                            <label for="player_limit">Player Limit *</label>
                                            <div class="invalid-feedback">Enter a valid player limit.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Prizing & Fees -->
                            <div class="section mb-4">
                                <div class="section-title">
                                    <span class="badge rounded-pill bg-soft-primary text-primary me-2">3</span>
                                    Prizing & Fees
                                </div>
                                <div class="row g-3">
                                    <!-- Entry Fee -->
                                    <div class="col-md-4">
                                        <div class="form-floating input-group">
                                            <span class="input-group-text">৳</span>
                                            <input type="number" name="entry_fee" id="entry_fee" class="form-control" placeholder="0" min="0" required>
                                            <label for="entry_fee">Entry Fee *</label>
                                            <div class="invalid-feedback">Enter the entry fee (can be 0).</div>
                                        </div>
                                        <div class="form-text ms-1">Set to 0 for free entry.</div>
                                    </div>
                                    <!-- Grand Prize -->
                                    <div class="col-md-4">
                                        <div class="form-floating input-group">
                                            <span class="input-group-text">৳</span>
                                            <input type="number" name="grand_prize" id="grand_prize" class="form-control" placeholder="0" min="0" required>
                                            <label for="grand_prize">Grand Prize *</label>
                                            <div class="invalid-feedback">Enter the grand prize amount.</div>
                                        </div>
                                    </div>
                                    <!-- Per Kill Price -->
                                    <div class="col-md-4">
                                        <div class="form-floating input-group">
                                            <span class="input-group-text">৳</span>
                                            <input type="number" name="per_kill_price" id="per_kill_price" class="form-control" placeholder="0" min="0" required>
                                            <label for="per_kill_price">Per Kill Price *</label>
                                            <div class="invalid-feedback">Enter the per-kill reward.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Game Settings -->
                            <div class="section mb-4">
                                <div class="section-title">
                                    <span class="badge rounded-pill bg-soft-primary text-primary me-2">4</span>
                                    Game Settings
                                </div>
                                <div class="row g-3">
                                    <!-- Match Type -->
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select name="match_type" id="match_type" class="form-select" required>
                                                <option value="" disabled selected>Select Match Type</option>
                                                <option value="Solo">Solo</option>
                                                <option value="Duo">Duo</option>
                                                <option value="4v4">4v4 Team</option>
                                            </select>
                                            <label for="match_type">Match Type *</label>
                                            <div class="invalid-feedback">Select a match type.</div>
                                        </div>
                                    </div>
                                    <!-- Map Type -->
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" name="map_type" id="map_type" class="form-control" placeholder="e.g. Erangel" required>
                                            <label for="map_type">Map Type *</label>
                                            <div class="invalid-feedback">Enter a map type.</div>
                                        </div>
                                    </div>
                                    <!-- Version -->
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select name="version" id="version" class="form-select" required>
                                                <option value="" disabled selected>Select Version</option>
                                                <option value="Mobile">Mobile</option>
                                                <option value="PC Player">PC Player</option>
                                            </select>
                                            <label for="version">Version *</label>
                                            <div class="invalid-feedback">Select a version.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Text Areas -->
                            <div class="section mb-4">
                                <div class="section-title">
                                    <span class="badge rounded-pill bg-soft-primary text-primary me-2">5</span>
                                    Instructions & Room
                                </div>
                                <div class="row g-3">
                                    <!-- Match Instruction -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Match Instruction</label>
                                        <textarea name="instructions" id="instructions" class="form-control html-editor" rows="5" placeholder="Write match instructions..."></textarea>
                                        <div class="form-text">Formatting supported. Keep it concise and clear.</div>
                                    </div>

                                    <!-- Room Details -->
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea name="room_details" id="room_details" class="form-control" style="height: 120px" placeholder="Room ID, password, timing notes"></textarea>
                                            <label for="room_details">Room Details</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end">
                                <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">Reset</button>
                                <button type="submit" class="btn btn-primary rounded-pill px-4">Create Match</button>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Live Preview -->
                    <div class="col-12 col-lg-4">
                        <div class="sticky-lg-top" style="top: 1rem;">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h6 class="fw-semibold mb-3">Live Preview</h6>
                                        <span class="badge bg-soft-primary text-primary" id="previewCategory">Category</span>
                                    </div>

                                    <h5 class="mb-1" id="previewTitle">Match Name</h5>
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
                                Tip: Hover labels to see hints. Fields marked * are required.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /card -->
    </div> <!-- /container -->
@endsection

@push('styles')
    <style>
        .bg-gradient-primary{
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 50%, #8b5cf6 100%);
        }
        .bg-soft-primary { background: rgba(99,102,241,.08); }
        .bg-soft-success { background: rgba(16,185,129,.08); }
        .bg-soft-info { background: rgba(59,130,246,.08); }
        .text-success-700 { color: #047857; }
        .text-info-700 { color: #1d4ed8; }

        .section-title{
            font-weight: 700;
            margin-bottom: .75rem;
            display: flex; align-items: center; font-size: .95rem; letter-spacing:.2px;
        }
        .form-floating>.form-control:focus, .form-floating>.form-select:focus{
            box-shadow: 0 0 0 .2rem rgba(99,102,241,.15);
            border-color: #6366f1;
        }
        .input-group .form-floating > label { left: 2.75rem; } /* keep label clear of prefix */
        .input-group-text{ border-top-right-radius:0; border-bottom-right-radius:0; }
    </style>
@endpush

@push('scripts')
    <script>
        // Bootstrap validation
        (function () {
            const form = document.getElementById('createMatchForm');
            form.addEventListener('submit', function (e) {
                if (!form.checkValidity()) {
                    e.preventDefault(); e.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })();

        // Summernote (or keep your preferred editor)
        if (window.$ && $('.html-editor').summernote) {
            $('.html-editor').summernote({ height: 200 });
        }

        // Live preview + progress
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
            room:    document.getElementById('previewRoom'),
            progress:document.getElementById('formProgress')
        };

        const requiredKeys = [
            'match_name','category','match_date','match_time','player_limit',
            'entry_fee','grand_prize','per_kill_price','match_type','map_type','version'
        ];

        function money(v){
            const n = Number(v||0);
            return '৳' + (isFinite(n) ? n.toLocaleString() : '0');
        }

        function updatePreview(){
            preview.title.textContent = fields.match_name.value || 'Match Name';
            preview.category.textContent = fields.category.value || 'Category';

            const date = fields.match_date.value;
            const time = fields.match_time.value;
            preview.meta.textContent = (date || time)
                ? `${date || '—'} at ${time || '—'}`
                : '—';

            preview.type.textContent = fields.match_type.value || 'Type';
            preview.version.textContent = fields.version.value || 'Version';
            preview.map.textContent = fields.map_type.value || 'Map';
            preview.players.textContent = (fields.player_limit.value ? fields.player_limit.value : '0') + ' players';

            preview.prize.textContent = money(fields.grand_prize.value);
            preview.perKill.textContent = money(fields.per_kill_price.value);
            preview.room.textContent = fields.room_details.value || 'Room details will appear here.';

            // Progress
            let done = 0;
            requiredKeys.forEach(k=>{
                const el = fields[k];
                if (!el) return;
                if (el.type === 'select-one') {
                    if (el.value && el.value !== '') done++;
                } else {
                    if (el.value && el.value.trim() !== '') done++;
                }
            });
            const pct = Math.round((done / requiredKeys.length) * 100);
            preview.progress.style.width = pct + '%';
            preview.progress.setAttribute('aria-valuenow', pct);
        }
        Object.values(fields).forEach(el=>{
            if(!el) return;
            el.addEventListener('input', updatePreview);
            el.addEventListener('change', updatePreview);
        });
        updatePreview();
    </script>
@endpush
