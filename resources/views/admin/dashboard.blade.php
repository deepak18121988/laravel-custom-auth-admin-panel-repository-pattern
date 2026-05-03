@extends('layouts.admin')

@section('admin-content')

<h2>Admin Dashboard</h2>

<div class="card">
    <div class="card-body">
        Welcome, {{ auth()->user()->name }}
    </div>
</div>
@endsection