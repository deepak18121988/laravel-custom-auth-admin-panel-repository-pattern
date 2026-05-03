@extends('layouts.app')

@section('content')

<div class="row">

    <!-- Sidebar -->
    <div class="col-md-3">
        <div class="list-group">

            <a href="/user/dashboard" class="list-group-item list-group-item-action">
                Dashboard
            </a>

            <a href="#" class="list-group-item list-group-item-action">
                My Profile
            </a>

            <a href="#" class="list-group-item list-group-item-action">
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