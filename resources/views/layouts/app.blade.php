<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rice Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background-color: #2c3e50;
        }
        .navbar-brand {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }
        .nav-link {
            color: #ffffff !important;
            font-weight: 500;
        }
        .nav-link.active,
        .nav-link:hover {
            color: #d1e7ff !important;
        }
        .main-content {
            padding: 30px;
        }
        .card-header {
            background-color: #2c3e50;
            color: white;
        }
        .btn-custom {
            background-color: #3498db;
            border-color: #3498db;
        }
        .btn-custom:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
    </style>
</head>
<body>
    @auth
    <nav class="navbar navbar-custom py-3">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="{{ route('dashboard') }}">Rice Management</a>
            <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
                <li class="nav-item me-3">
                    <a class="nav-link @if(request()->routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link @if(request()->routeIs('rices.*')) active @endif" href="{{ route('rices.index') }}">Rice Menu</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link @if(request()->routeIs('orders.*')) active @endif" href="{{ route('orders.index') }}">Orders</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link @if(request()->routeIs('payments.*')) active @endif" href="{{ route('payments.index') }}">Payments</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-flex">
                        @csrf
                        <button type="submit" class="btn btn-light text-dark">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="main-content">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Errors:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
    @else
        @yield('content')
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
