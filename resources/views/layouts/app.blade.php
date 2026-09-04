<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kembang Tahu Pak Ujang')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #4A8A34;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-store me-2"></i>Kembang Tahu Pak Ujang
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pelanggan.shop') }}">Toko</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pelanggan.cart') }}">Keranjang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pelanggan.history') }}">Riwayat</a>
                </li>
                
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link text-white">Logout</button>
                        </form>
                    </li>
                @else
                    <!-- ✅ UBAH DARI "Login" MENJADI "Admin" -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.login') }}">Admin</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

    <!-- Content -->
    <main class="py-4 pb-5 mb-5">
        @yield('content')
    </main>

    <!-- Footer (Hide on mobile since bottom nav takes over) -->
    <footer class="text-white text-center py-3 mt-auto d-none d-md-block" style="background-color: #4A8A34;">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Kembang Tahu Pak Ujang</p>
        </div>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <nav class="navbar fixed-bottom bg-white border-top shadow-lg d-md-none pb-2 pt-2 px-3">
        <div class="container-fluid d-flex justify-content-between">
            <a href="{{ route('pelanggan.shop') }}" class="text-decoration-none text-center flex-fill {{ request()->routeIs('pelanggan.shop') ? 'text-success' : 'text-secondary' }}" style="{{ request()->routeIs('pelanggan.shop') ? 'color: #4A8A34 !important;' : '' }}">
                <i class="fas fa-store d-block mb-1 fs-5"></i>
                <small style="font-size: 0.75rem; font-weight: 600;">Toko</small>
            </a>
            <a href="{{ route('pelanggan.cart') }}" class="text-decoration-none text-center flex-fill {{ request()->routeIs('pelanggan.cart') ? 'text-success' : 'text-secondary' }}" style="{{ request()->routeIs('pelanggan.cart') ? 'color: #4A8A34 !important;' : '' }}">
                <i class="fas fa-shopping-cart d-block mb-1 fs-5"></i>
                <small style="font-size: 0.75rem; font-weight: 600;">Keranjang</small>
            </a>
            <a href="{{ route('pelanggan.history') }}" class="text-decoration-none text-center flex-fill {{ request()->routeIs('pelanggan.history') ? 'text-success' : 'text-secondary' }}" style="{{ request()->routeIs('pelanggan.history') ? 'color: #4A8A34 !important;' : '' }}">
                <i class="fas fa-history d-block mb-1 fs-5"></i>
                <small style="font-size: 0.75rem; font-weight: 600;">Riwayat</small>
            </a>
            <a href="{{ auth()->check() && auth()->user()->role == 'admin' ? route('admin.dashboard') : route('admin.login') }}" class="text-decoration-none text-center flex-fill {{ request()->routeIs('admin.*') ? 'text-success' : 'text-secondary' }}" style="{{ request()->routeIs('admin.*') ? 'color: #4A8A34 !important;' : '' }}">
                <i class="fas fa-user-shield d-block mb-1 fs-5"></i>
                <small style="font-size: 0.75rem; font-weight: 600;">Admin</small>
            </a>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Add smooth transition and nice styling for mobile nav */
        .fixed-bottom a { transition: all 0.3s ease; }
        .fixed-bottom a:active { transform: scale(0.9); }
    </style>
</body>
</html>