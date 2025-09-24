@extends('layouts.app')

@section('content')

    @foreach($register as $registerd)
        Main Player: {{$registerd->game_username}}
        Partner Players: {{$registerd->partners_name}}
    @endforeach

@endsection
