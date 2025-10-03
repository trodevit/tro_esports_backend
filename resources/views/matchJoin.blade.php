@extends('userLayouts.app')

@section('content')
    <div class="container py-4">
        <div class="row g-4">
            <!-- Match Details -->
            <div class="col-lg-6">
                <div class="glass-card p-4">
                    <h4 class="fw-bold mb-3">
                        <i class="bi bi-controller me-2"></i> Match Details
                    </h4>
                    <ul class="list-unstyled mb-3">
                        <li><strong>ID:</strong> {{ $match->id }}</li>
                        <li><strong>Name:</strong> {{ $match->match_name }}</li>
                        <li><strong>Type:</strong> {{ $match->match_type }}</li>
                        <li><strong>Category:</strong> {{ $match->category }}</li>
                        <li><strong>Date:</strong> {{ $match->match_date }}</li>
                        <li><strong>Time:</strong> {{ $match->match_time }}</li>
                        <li><strong>Entry Fee:</strong> ৳{{ number_format($match->entry_fee) }}</li>
                        <li><strong>Grand Prize:</strong> ৳{{ number_format($match->grand_prize) }}</li>
                        <li><strong>Per Kill Price:</strong> ৳{{ number_format($match->per_kill_price) }}</li>
                        <li><strong>Map:</strong> {{ $match->map_type }}</li>
                        <li><strong>Version:</strong> {{ $match->version }}</li>
                    </ul>
                    <div class="alert alert-info small">
                        {!! nl2br(e($match->instructions)) !!}
                    </div>
                </div>
            </div>

            <!-- Join Form -->
            <div class="col-lg-6">
                <div class="glass-card p-4">
                    <h4 class="fw-bold mb-3">
                        <i class="bi bi-person-plus me-2"></i> Join Match
                    </h4>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{route('webMatch.checkout')}}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="match_id" value="{{ $match->id }}">
                        <div class="mb-3">
                            <label class="form-label">Game Username</label>
                            <input type="text" name="username" value="{{Auth::user()->game_username}}" class="form-control bg-transparent text-white border-light" placeholder="Enter your game username" readonly>
                            <div class="invalid-feedback">Please enter your game username.</div>
                        </div>

                        @if($match->match_type === 'Duo' || $match->match_type === '4v4')
                            <div class="mb-3">
                                <label class="form-label">Partner(s) Name</label>
{{--                                <input type="text" name="partners[]" class="form-control bg-transparent text-white border-light mb-2" placeholder="Enter partner name">--}}
                                <input type="text" name="partners_name[]" class="form-control bg-transparent text-white border-light mb-2" placeholder="Enter partner name">
                                @if($match->match_type === '4v4')
                                    <input type="text" name="partners_name[]" class="form-control bg-transparent text-white border-light mb-2" placeholder="Enter partner name">
                                @endif
                            </div>
                        @endif

                        <div class="d-grid">
                            @php
                                $fee = $match->entry_fee;
                                if ($match->match_type === 'Duo') {
                                    $fee *= 2;
                                } elseif ($match->match_type === '4v4') {
                                    $fee *= 4;
                                }
                            @endphp

                            <button type="submit" class="btn btn-accent btn-pill">
                                <i class="bi bi-rocket-takeoff me-2"></i> Confirm Join (৳{{ number_format($fee) }})
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
