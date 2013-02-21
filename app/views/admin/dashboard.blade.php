@extends('admin.layout')

@section('sidebar')

    <p>Willkommen, bitte wählen Sie oben eine Option aus.</p>
@stop

@section('content')
    Administration - Sie sind eingeloggt als: {{ $user->first_name }} {{ $user->last_name }} <a href="{{ URL::to('/') }}">Frontend</a>
@stop