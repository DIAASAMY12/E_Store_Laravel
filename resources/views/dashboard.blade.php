
@extends('layouts.app')

@section('content')
    <h1>Welcome to the Dashboard</h1>
    <p>Hello, {{ auth()->user()->username }}!</p>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error')}}
        </div>
    @endif

@endsection
