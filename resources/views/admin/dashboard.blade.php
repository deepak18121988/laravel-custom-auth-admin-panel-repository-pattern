@extends('layouts.admin')

@section('admin-content')

<h3 class="mb-3">Admin Dashboard</h3>

<div class="alert alert-info">
    Welcome, {{ auth()->user()->name }}
</div>
@endsection