@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Matches List</h4>
                <a href="{{ route('matches.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Create New
                </a>
            </div>

            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>UID</th>
                    <th>Permission</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $match)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $match->name }}</td>
                        <td>{{ $match->email }}</td>
                        <td>{{ $match->phone }}</td>
                        <td>{{ $match->uid }}</td>
                        <td>
                            @if($match->blocked)
                                <span class="badge bg-danger">Denied</span>
                            @else
                                <span class="badge bg-success">Granted</span>
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('players.update', $match->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                @if($match->blocked)
                                    <button type="submit" class="btn btn-sm btn-warning">Unblock</button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-warning">Block</button>
                                @endif
                            </form>

                            <form action="{{ route('players.destroy', $match->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $match->id }}">
                                    Delete
                                </button>
                            </form>
                        </td>
                        <div class="modal fade" id="deleteModal{{ $match->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $match->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $match->id }}">Delete Match</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the match "<strong>{{ $match->match_name }}</strong>"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                        <form action="{{ route('matches.destroy', $match->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No matches found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
