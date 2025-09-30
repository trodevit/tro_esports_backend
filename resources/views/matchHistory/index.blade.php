{{-- resources/views/matchHistory/index.blade.php --}}
@extends('layouts.app')

@section('page_title', 'Match History')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Match History</h3>
{{--            <a href="{{ route('match.history.create') }}" class="btn btn-primary">--}}
{{--                <i class="bi bi-plus-lg me-1"></i> Add New--}}
{{--            </a>--}}
        </div>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Match ID</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Username</th>
                        <th class="text-end">Total Kill</th>
                        <th class="text-end">Per Kill</th>
                        <th class="text-end">Position</th>
                        <th class="text-end">Prize Money</th>
                        <th>Created At</th>
{{--                        <th class="text-end">Actions</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($histories as $history)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $history->match_id }}</td>
                            <td>{{ $history->id }}</td>
                            <td>{{ $history->name }}</td>
                            <td>{{ $history->email }}</td>
                            <td>{{ $history->mobile }}</td>
                            <td>{{ $history->username }}</td>
                            <td class="text-end">{{ $history->match_kill }}</td>
                            <td class="text-end">{{ $history->per_kill ?? $history->total_kill_money }}</td>
                            <td class="text-end">{{ $history->position }}</td>
                            <td class="text-end">৳{{ number_format($history->prize_money,0) }}</td>
                            <td>{{ $history->created_at?->format('Y-m-d H:i') }}</td>
{{--                            <td class="text-end">--}}
{{--                                <a href="{{ route('match.history.show', $history->id) }}" class="btn btn-sm btn-light">--}}
{{--                                    <i class="bi bi-eye"></i>--}}
{{--                                </a>--}}
{{--                                <a href="{{ route('match.history.edit', $history->id) }}" class="btn btn-sm btn-secondary">--}}
{{--                                    <i class="bi bi-pencil"></i>--}}
{{--                                </a>--}}
{{--                                <form action="{{ route('match.history.destroy', $history->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this entry?')">--}}
{{--                                    @csrf--}}
{{--                                    @method('DELETE')--}}
{{--                                    <button class="btn btn-sm btn-danger">--}}
{{--                                        <i class="bi bi-trash"></i>--}}
{{--                                    </button>--}}
{{--                                </form>--}}
{{--                            </td>--}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="text-center text-muted py-4">
                                No match history found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
