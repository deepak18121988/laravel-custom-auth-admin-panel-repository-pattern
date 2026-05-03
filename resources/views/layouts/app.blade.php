<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name', 'ClientPanel') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <!-- 🔹 Branding -->
        <a class="navbar-brand" href="/">
            {{ config('app.name', 'ClientPanel') }}
        </a>

        <div class="collapse navbar-collapse">

            <!-- Left Menu -->
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>

                @auth
                    @if(auth()->user()->role->name == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                Admin Panel
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/user/dashboard">
                                User Panel
                            </a>
                        </li>
                    @endif
                @endauth

            </ul>

            <!-- Right Menu -->
            <ul class="navbar-nav">

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <span class="nav-link text-white">
                            {{ auth()->user()->name }}
                        </span>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-sm btn-danger">Logout</button>
                        </form>
                    </li>
                @endauth

            </ul>

        </div>
    </div>
</nav>

<!-- ================= CONTENT ================= -->
<div class="container mt-4 flex-grow-1">
    @yield('content')
</div>

<!-- ================= GLOBAL LOADER ================= -->
<div id="globalLoader" style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.3);
    z-index:9999;
    justify-content:center;
    align-items:center;
">
    <div class="spinner-border text-light"></div>
</div>

<!-- ================= FOOTER ================= -->
@include('partials.footer')

<!-- ================= SCRIPTS ================= -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Common JS -->
<script src="{{ asset('js/common.js') }}"></script>

@stack('scripts')

</body>
</html>