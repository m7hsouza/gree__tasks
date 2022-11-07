@extends('layouts.app')

@section('content')
    <task-list @auth user-id={{Auth::check()}} @endauth />
@endsection
