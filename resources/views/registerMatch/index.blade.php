@extends('layouts.app')

@section('content')

    @foreach($register as $registerd)
        Main Player: {{$registerd->game_username}}
        Partner Players: {{ implode(', ', array_filter($registerd->partners_name ?? [])) }}
        Match Type: {{$registerd->match_type}}
        Total Pay: {{$registerd->amount}}
    @endforeach

@endsection
