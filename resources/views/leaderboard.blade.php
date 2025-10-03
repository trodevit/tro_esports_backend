@extends('userLayouts.app')

@section('content')
    <div class="container py-4">
        <div class="card glass-card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3 fw-semibold">Matches</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-striped align-middle mb-0">
                        <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Match Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($matches as $match)
                            <tr>
                                <td>{{ $match->id }}</td>
                                <td>{{ $match->match_name }}</td>
                                <td>{{ $match->match_type }}</td>
                                <td>
                                    <a href="{{route('leaderboard.history',$match->id)}}"
                                       class="btn btn-sm btn-accent btn-pill">
                                        <i class="bi bi-trophy me-2"></i> Leaderboard
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
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
