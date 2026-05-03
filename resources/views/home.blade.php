@extends('layouts.app')

@section('content')

<div class="text-center">
    <h1>Welcome to Auth Demo</h1>

    @guest
        <a href="/login" class="btn btn-primary">Login</a>
        <a href="/register" class="btn btn-success">Register</a>
    @endguest

    @auth
        @if(auth()->user()->role->name == 'admin')
            <a href="/admin/dashboard" class="btn btn-dark">Go to Admin Dashboard</a>
        @else
            <a href="/user/dashboard" class="btn btn-info">Go to User Dashboard</a>
        @endif
    @endauth
</div>

@endsection