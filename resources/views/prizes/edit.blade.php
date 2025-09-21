@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Edit Prize Tool</h4>
            <a href="{{ route('prizes.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('prizes.update', $prize->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>MVP</label>
                    <input type="text" name="mvp" value="{{ old('mvp', $prize->mvp ?? '') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label>2nd Winner</label>
                    <input type="text" name="second_winner" value="{{ old('second_winner', $prize->second_winner ?? '') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label>3rd Winner</label>
                    <input type="text" name="third_winner" value="{{ old('third_winner', $prize->third_winner ?? '') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label>4th Winner</label>
                    <input type="text" name="fourth_winner" value="{{ old('fourth_winner', $prize->fourth_winner ?? '') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label>5th Winner</label>
                    <input type="text" name="fifth_winner" value="{{ old('fifth_winner', $prize->fifth_winner ?? '') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Total Grand Prize</label>
                    <input type="number" step="0.01" name="total_grand_prize" value="{{ old('total_grand_prize', $prize->total_grand_prize ?? '') }}" class="form-control">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('prizes.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection
