@extends('layouts.user')

@section('user-content')

<h2>User Dashboard</h2>

<div class="card">
    <div class="card-body">
        Welcome, {{ auth()->user()->name }}
    </div>
</div>

@endsection