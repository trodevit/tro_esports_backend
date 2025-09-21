@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Edit Match</h4>
                <a href="{{ route('matches.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('matches.update', $match->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Match Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Match Name</label>
                            <input type="text" name="match_name" class="form-control" value="{{ old('match_name', $match->match_name) }}" required>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="BR Match" {{ old('category', $match->category) == 'BR Match' ? 'selected' : '' }}>BR Match</option>
                                <option value="Class Squad" {{ old('category', $match->category) == 'Class Squad' ? 'selected' : '' }}>Class Squad</option>
                            </select>
                        </div>

                        <!-- Entry Fee -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Entry Fee</label>
                            <input type="number" name="entry_fee" class="form-control" value="{{ old('entry_fee', $match->entry_fee) }}" required>
                        </div>

                        <!-- Player Limit -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Player Limit</label>
                            <input type="number" name="player_limit" class="form-control" value="{{ old('player_limit', $match->player_limit) }}" required>
                        </div>

                        <!-- Match Date -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Match Date</label>
                            <input type="date" name="match_date" class="form-control" value="{{ old('match_date', $match->match_date) }}" required>
                        </div>

                        <!-- Match Time -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Match Time</label>
                            <input type="time" name="match_time" class="form-control" value="{{ old('match_time', $match->match_time) }}" required>
                        </div>

                        <!-- Match Instructions -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Match Instructions</label>
                            <textarea name="instructions" class="form-control" rows="4">{{ old('instructions', $match->instructions) }}</textarea>
                        </div>

                        <!-- Grand Prize -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Grand Prize</label>
                            <input type="number" name="grand_prize" class="form-control" value="{{ old('grand_prize', $match->grand_prize) }}" required>
                        </div>

                        <!-- Per Kill Price -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Per Kill Price</label>
                            <input type="number" name="per_kill_price" class="form-control" value="{{ old('per_kill_price', $match->per_kill_price) }}" required>
                        </div>

                        <!-- Match Type -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Match Type</label>
                            <select name="match_type" class="form-select" required>
                                @foreach(['Solo','Duo','4v4 Team','1v3','2v3','1v2'] as $type)
                                    <option value="{{ $type }}" {{ old('match_type', $match->match_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Map Type -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Map Type</label>
                            <input type="text" name="map_type" class="form-control" value="{{ old('map_type', $match->map_type) }}" required>
                        </div>

                        <!-- Version -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Version</label>
                            <select name="version" class="form-select" required>
                                @foreach(['Mobile','PC Player'] as $version)
                                    <option value="{{ $version }}" {{ old('version', $match->version) == $version ? 'selected' : '' }}>{{ $version }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Room Details -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Room Details</label>
                            <textarea name="room_details" class="form-control" rows="3">{{ old('room_details', $match->room_details) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update Match</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
