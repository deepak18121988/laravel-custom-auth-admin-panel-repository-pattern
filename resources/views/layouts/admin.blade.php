@extends('layouts.app')

@section('content')

<div class="row">

    <!-- 🔹 Sidebar -->
    <div class="col-md-3">

        <button class="btn btn-dark mb-2" onclick="toggleSidebar()">☰</button>

        <div id="sidebar" class="list-group">

            <a href="/admin/dashboard"
               class="list-group-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="/admin/users"
               class="list-group-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                Manage Users
            </a>

            <a href="/admin/roles"
               class="list-group-item {{ request()->is('admin/roles*') ? 'active' : '' }}">
                Roles
            </a>

        </div>
    </div>

    <!-- 🔹 Content -->
    <div class="col-md-9">
        @yield('admin-content')
    </div>

</div>
<script>
function toggleSidebar() {
    let sidebar = document.getElementById('sidebar');
    sidebar.style.display = (sidebar.style.display === 'none') ? 'block' : 'none';
}
</script>

@endsection