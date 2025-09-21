@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
            <h4 class="mb-0">Prize Tools</h4>
            <a href="{{ route('prizes.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Create New</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>MVP</th>
                    <th>2nd</th>
                    <th>3rd</th>
                    <th>4th</th>
                    <th>5th</th>
                    <th>Total Prize</th>
                    <th>Actions</th>
                    <th>Details</th>
                </tr>
                </thead>
                <tbody>
                @forelse($prizes as $prize)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $prize->mvp }}</td>
                        <td>{{ $prize->second_winner }}</td>
                        <td>{{ $prize->third_winner }}</td>
                        <td>{{ $prize->fourth_winner }}</td>
                        <td>{{ $prize->fifth_winner }}</td>
                        <td>{{ $prize->total_grand_prize }}</td>
                        <td>
                            <a href="{{ route('prizes.edit', $prize->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('prizes.destroy', $prize->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this prize?')">Delete</button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('prizes.show',$prize->id) }}" class="btn btn-sm btn-info">Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No prize tools found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
