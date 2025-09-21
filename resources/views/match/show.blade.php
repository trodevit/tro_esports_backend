@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Match Details</h4>
                <div>
                    <a href="{{ route('matches.index') }}" class="btn btn-secondary btn-sm">Back</a>
                    <a href="{{ route('matches.edit', $match->id) }}" class="btn btn-warning btn-sm ms-2">
                        Edit
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>Match Name</th>
                        <td>{{ $match->match_name }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $match->category }}</td>
                    </tr>
                    <tr>
                        <th>Entry Fee</th>
                        <td>{{ $match->entry_fee }}</td>
                    </tr>
                    <tr>
                        <th>Player Limit</th>
                        <td>{{ $match->player_limit }}</td>
                    </tr>
                    <tr>
                        <th>Match Date</th>
                        <td>{{ \Carbon\Carbon::parse($match->match_date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Match Time</th>
                        <td>{{ \Carbon\Carbon::parse($match->match_time)->format('h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Match Instructions</th>
                        <td>{!! $match->instructions !!}</td>
                    </tr>
                    <tr>
                        <th>Grand Prize</th>
                        <td>{{ $match->grand_prize }}</td>
                    </tr>
                    <tr>
                        <th>Per Kill Price</th>
                        <td>{{ $match->per_kill_price }}</td>
                    </tr>
                    <tr>
                        <th>Match Type</th>
                        <td>{{ $match->match_type }}</td>
                    </tr>
                    <tr>
                        <th>Map Type</th>
                        <td>{{ $match->map_type }}</td>
                    </tr>
                    <tr>
                        <th>Version</th>
                        <td>{{ $match->version }}</td>
                    </tr>
                    <tr>
                        <th>Room Details</th>
                        <td>{{ $match->room_details }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $match->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $match->updated_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
