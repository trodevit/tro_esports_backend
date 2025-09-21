@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Prize Tool Details</h4>
            <a href="{{ route('prizes.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>MVP</th>
                    <td>{{ $prize->mvp }}</td>
                </tr>
                <tr>
                    <th>2nd Winner</th>
                    <td>{{ $prize->second_winner }}</td>
                </tr>
                <tr>
                    <th>3rd Winner</th>
                    <td>{{ $prize->third_winner }}</td>
                </tr>
                <tr>
                    <th>4th Winner</th>
                    <td>{{ $prize->fourth_winner }}</td>
                </tr>
                <tr>
                    <th>5th Winner</th>
                    <td>{{ $prize->fifth_winner }}</td>
                </tr>
                <tr>
                    <th>Total Grand Prize</th>
                    <td>{{ $prize->total_grand_prize }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $prize->created_at->format('d M Y H:i A') }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $prize->updated_at->format('d M Y H:i A') }}</td>
                </tr>
            </table>
            <div class="mt-3">
                <a href="{{ route('prizes.edit', $prize->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('prizes.destroy', $prize->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this prize tool?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
