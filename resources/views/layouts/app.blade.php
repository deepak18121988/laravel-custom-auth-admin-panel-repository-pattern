<!DOCTYPE html>
<html>
<head>
    <title>Auth Demo</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</head>
<body>

<!-- 🔝 TOP NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <a class="navbar-brand" href="/">MyApp</a>

        <div class="collapse navbar-collapse">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>

                @auth
                    @if(auth()->user()->role->name == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/dashboard">Admin Panel</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/user/dashboard">User Panel</a>
                        </li>
                    @endif
                @endauth

            </ul>

            <ul class="navbar-nav">

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
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
                        <form method="POST" action="/logout">
                            @csrf
                            <button class="btn btn-sm btn-danger">Logout</button>
                        </form>
                    </li>
                @endauth

            </ul>

        </div>
    </div>
</nav>

<!-- 🔽 MAIN CONTENT -->
<div class="container mt-4">
    @yield('content')
</div>


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>