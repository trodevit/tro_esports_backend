@extends('layouts.app')

@section('content')

    @foreach($register as $registerd)
        Main Player: {{$registerd->game_username}}
        Partner Players: {{ implode(', ', array_filter($registerd->partners_name ?? [])) }}
    @endforeach

@endsection
