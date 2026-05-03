@extends('layouts.app')

@section('content')

<div class="row">

    <!-- Sidebar -->
    <div class="col-md-3">
        <div class="list-group">

            <a href="/user/dashboard"
               class="list-group-item {{ request()->is('user/dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="/user/profile"
               class="list-group-item {{ request()->is('user/profile') ? 'active' : '' }}">
                My Profile
            </a>

            <a href="#"
               class="list-group-item">
                Orders
            </a>

        </div>
    </div>

    <!-- Content -->
    <div class="col-md-9">
        @yield('user-content')
    </div>

</div>

@endsection