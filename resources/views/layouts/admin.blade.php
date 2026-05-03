@extends('layouts.app')

@section('content')

<div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 mb-3">

        <button class="btn btn-dark w-100 mb-2" onclick="toggleSidebar()">☰ Menu</button>

        <div id="sidebar" class="list-group shadow-sm">

            <a href="{{ route('admin.dashboard') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                Manage Users
            </a>

            <a href="{{ route('admin.roles.index') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                Roles
            </a>

        </div>
    </div>

    <!-- Content -->
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-body">
                @yield('admin-content')
            </div>
        </div>
    </div>

</div>

<script>
// Toggle sidebar visibility (mobile friendly)
function toggleSidebar() {
    let sidebar = document.getElementById('sidebar');
    sidebar.style.display = (sidebar.style.display === 'none') ? 'block' : 'block';
}
</script>

@endsection