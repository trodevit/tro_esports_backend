@extends('userLayouts.app')

@section('content')
    <div class="container py-4">

        <h5 class="fw-semibold mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-collection-play"></i> My Matches
        </h5>

        {{-- Empty state --}}
        @if($matches->isEmpty())
            <div class="glass-card p-4 text-center text-white-50">
                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                You haven’t joined any matches yet.
            </div>
        @endif

        {{-- Mobile cards --}}
        <div class="d-md-none">
            @foreach($matches as $match)
                @php
                    $room = trim((string)($match->room_details ?? ''));
                    $hasRoom = $room !== '';
                @endphp
                <div class="glass-card p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="small text-white-50">#{{ $match->match_id }}</div>
                            <h6 class="mb-1">{{ $match->match_name }}</h6>
                            <div class="small text-white-50">
                                <i class="bi bi-controller me-1"></i>{{ $match->match_type }}
                                · <i class="bi bi-map me-1"></i>{{ $match->map_type }}
                                · <i class="bi bi-clock me-1"></i>{{ $match->match_date }} {{ $match->match_time }}
                            </div>
                        </div>
                        <span class="badge {{ $hasRoom ? 'bg-success' : 'bg-secondary' }}">
                        {{ $hasRoom ? 'Ready' : 'Pending' }}
                    </span>
                    </div>

                    <div class="divider"></div>

                    @if($hasRoom)
                        <div class="small mb-2 text-white-50">Room Details</div>
                        <div class="card-dark p-2 rounded-3 d-flex justify-content-between align-items-center">
                            <code class="text-break">{{ $room }}</code>
                            <button class="btn btn-sm btn-outline-light ms-2"
                                    onclick="navigator.clipboard.writeText(`{{ str_replace('`','\`',$room) }}`)">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    @else
                        <div class="alert alert-warning py-2 px-3 small mb-0">
                            <i class="bi bi-hourglass-split me-1"></i>
                            Before 5–10 minutes of game start, room details will be shared.
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Desktop table --}}
        <div class="card glass-card border-0 shadow-sm d-none d-md-block">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th style="width:95px">Match ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Map</th>
                            <th>Date & Time</th>
                            <th style="width:40%">Room Details</th>
                            <th class="text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($matches as $match)
                            @php
                                $room = trim((string)($match->room_details ?? ''));
                                $hasRoom = $room !== '';
                            @endphp
                            <tr>
                                <td>#{{ $match->match_id }}</td>
                                <td class="fw-semibold">{{ $match->match_name }}</td>
                                <td><span class="badge bg-primary">{{ $match->match_type }}</span></td>
                                <td>{{ $match->map_type }}</td>
                                <td class="small text-white-50">{{ $match->match_date }} {{ $match->match_time }}</td>
                                <td>
                                    @if($hasRoom)
                                        <div class="card-dark p-2 rounded-3 d-flex justify-content-between align-items-center">
                                            <code class="text-break">{{ $room }}</code>
                                            <button class="btn btn-sm btn-outline-light ms-2"
                                                    onclick="navigator.clipboard.writeText(`{{ str_replace('`','\`',$room) }}`)">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-white-50 small">
                                            Before 5–10 minutes of game start, room details will be shared.
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $hasRoom ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $hasRoom ? 'Ready' : 'Pending' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-white-50 py-4">
                                    No matches found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
