@extends('layouts.app')

@section('content')

    @foreach($register as $registerd)
        {{$registerd->match_id}}
    @endforeach

@endsection
