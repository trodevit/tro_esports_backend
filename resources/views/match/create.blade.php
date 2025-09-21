@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Create Match</h4>
                <a href="{{ route('matches.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('matches.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Match Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Match Name</label>
                            <input type="text" name="match_name" class="form-control" placeholder="Enter match name" required>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="" disabled selected>Select Category</option>
                                <option value="BR Match">BR Match</option>
                                <option value="Class Squad">Class Squad</option>
                            </select>
                        </div>

                        <!-- Entry Fee -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Entry Fee</label>
                            <input type="number" name="entry_fee" class="form-control" placeholder="Enter entry fee" required>
                        </div>

                        <!-- Player Limit -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Player Limit</label>
                            <input type="number" name="player_limit" class="form-control" placeholder="Enter player limit" required>
                        </div>

                        <!-- Match Start Date -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Match Start Date</label>
                            <input type="date" name="match_date" class="form-control" required>
                        </div>

                        <!-- Match Start Time -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Match Start Time</label>
                            <input type="time" name="match_time" class="form-control" required>
                        </div>

                        <!-- Match Instruction -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Match Instruction</label>
                            <textarea name="instructions" class="form-control html-editor" rows="4" placeholder="Write match instructions..."></textarea>
                        </div>

                        <!-- Grand Prize -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Grand Prize</label>
                            <input type="number" name="grand_prize" class="form-control" placeholder="Enter grand prize" required>
                        </div>

                        <!-- Per Kill Price -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Per Kill Price</label>
                            <input type="number" name="per_kill_price" class="form-control" placeholder="Enter per kill price" required>
                        </div>

                        <!-- Match Type -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Match Type</label>
                            <select name="match_type" class="form-select" required>
                                <option value="" disabled selected>Select Match Type</option>
                                <option value="Solo">Solo</option>
                                <option value="Duo">Duo</option>
                                <option value="4v4 Team">4v4 Team</option>
                                <option value="1v3">1v3</option>
                                <option value="2v3">2v3</option>
                                <option value="1v2">1v2</option>
                            </select>
                        </div>

                        <!-- Map Type -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Map Type</label>
                            <input type="text" name="map_type" class="form-control" placeholder="Enter map type" required>
                        </div>

                        <!-- Version -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Version</label>
                            <select name="version" class="form-select" required>
                                <option value="" disabled selected>Select Version</option>
                                <option value="Mobile">Mobile</option>
                                <option value="PC Player">PC Player</option>
                            </select>
                        </div>

                        <!-- Room Details -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Room Details</label>
                            <textarea name="room_details" class="form-control" rows="3" placeholder="Enter room details"></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Create Match</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- If using a WYSIWYG editor like Summernote or TinyMCE -->
    @push('scripts')
        <script>
            // Example for Summernote Editor
            $('.html-editor').summernote({
                height: 200
            });
        </script>
    @endpush
@endsection

