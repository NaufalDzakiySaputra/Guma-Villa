<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guma Landscape</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/admin-colors.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend-style.css') }}">
</head>
<body style="background-color: var(--bg-body);">

    <nav class="navbar navbar-expand-lg sticky-top bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-accent" href="/">GUMA LANDSCAPE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto text-uppercase small fw-bold">
                    <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.paket') }}">Paket</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.menu') }}">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.galeri') }}">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.about') }}">Tentang Kami</a></li>
                </ul>

                <div class="d-flex gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-dark px-4 rounded-pill">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-guma px-4 rounded-pill text-white">Daftar</a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle px-4 rounded-pill shadow-sm" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate slideIn">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-id-card me-2"></i>Profil</a></li>
                                
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item text-primary fw-bold" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-user-shield me-2"></i>Panel Admin
                                    </a></li>
                                @endif

                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer style="background-color: var(--bg-footer);" class="py-5 mt-5 border-top">
        <div class="container text-center">
            <h5 class="fw-bold text-accent">Guma Landscape</h5>
            <p class="text-muted">Nikmati keindahan alam bersama kami.</p>
            <p class="small mb-0 text-secondary">&copy; 2025 Guma Landscape. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>