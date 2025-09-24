@extends('layouts.app')

@section('content')

    @foreach($register as $registerd)
        {{$registerd->match_id}}, {{$registerd->match_name}}
    @endforeach

@endsection
