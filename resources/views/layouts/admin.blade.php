<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Guma Landscape</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Admin CSS -->
    <link href="{{ asset('css/admin-colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-style.css') }}" rel="stylesheet">
    
    <style>
        /* Additional inline styles for safety */
        .navbar-custom {
            background-color: #F3EBDD !important;
            border-bottom: 1px solid rgba(139, 125, 107, 0.2);
        }
        
        .navbar-custom .navbar-brand {
            color: #A0522D !important;
            font-weight: 700;
        }
        
        .text-accent {
            color: #A0522D !important;
        }
        
        .bg-soft-primary {
            background-color: rgba(243, 235, 221, 0.3) !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-leaf me-2"></i>
                Guma Landscape
                <small class="ms-2 text-muted d-none d-md-inline">Admin Panel</small>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}" target="_blank">
                            <i class="fas fa-external-link-alt me-1"></i>Lihat Website
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 mb-4">
                <!-- Menu Card -->
                <div class="card sidebar-card">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="fas fa-bars me-2"></i>Menu Admin
                        </h6>
                        <div class="list-group list-group-flush">
                            <!-- Paket Wisata -->
                            <a href="{{ route('packages.index') }}" 
                               class="list-group-item list-group-item-action {{ request()->routeIs('packages.*') ? 'active' : '' }}">
                                <i class="fas fa-box me-2"></i>Paket Wisata
                            </a>
                            
                            <!-- Menu Cafe -->
                            <a href="{{ route('menus.index') }}" 
                               class="list-group-item list-group-item-action {{ request()->routeIs('menus.*') ? 'active' : '' }}">
                                <i class="fas fa-utensils me-2"></i>Menu Cafe
                            </a>
                            
                            <!-- Berita & Event -->
                            <a href="{{ route('news.index') }}" 
                               class="list-group-item list-group-item-action {{ request()->routeIs('news.*') ? 'active' : '' }}">
                                <i class="fas fa-newspaper me-2"></i>Berita & Event
                            </a>
                            
                            <!-- Galeri -->
                            <a href="{{ route('gallery.index') }}" 
                               class="list-group-item list-group-item-action {{ request()->routeIs('gallery.*') ? 'active' : '' }}">
                                <i class="fas fa-images me-2"></i>Galeri
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Stats Card -->
                <div class="card sidebar-card mt-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="fas fa-chart-bar me-2"></i>Statistik
                        </h6>
                        <div class="small">
                            <!-- Packages Count -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Paket Wisata:</span>
                                <span class="fw-bold text-accent">
                                    @php
                                        $packagesCount = 0;
                                        if (class_exists('App\Models\Packages')) {
                                            try {
                                                $packagesCount = App\Models\Packages::count();
                                            } catch (Exception $e) {
                                                $packagesCount = 0;
                                            }
                                        }
                                    @endphp
                                    {{ $packagesCount }}
                                </span>
                            </div>
                            
                            <!-- Menus Count -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Menu Cafe:</span>
                                <span class="fw-bold text-success">
                                    @php
                                        $menusCount = 0;
                                        if (class_exists('App\Models\Menus')) {
                                            try {
                                                $menusCount = App\Models\Menus::count();
                                            } catch (Exception $e) {
                                                $menusCount = 0;
                                            }
                                        }
                                    @endphp
                                    {{ $menusCount }}
                                </span>
                            </div>
                            
                            <!-- News Count -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Berita & Event:</span>
                                <span class="fw-bold text-info">
                                    @php
                                        $newsCount = 0;
                                        if (class_exists('App\Models\News')) {
                                            try {
                                                $newsCount = App\Models\News::count();
                                            } catch (Exception $e) {
                                                $newsCount = 0;
                                            }
                                        }
                                    @endphp
                                    {{ $newsCount }}
                                </span>
                            </div>
                            
                            <!-- Gallery Count -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Galeri Foto:</span>
                                <span class="fw-bold text-warning">
                                    @php
                                        $galleryCount = 0;
                                        if (class_exists('App\Models\Gallery')) {
                                            try {
                                                $galleryCount = App\Models\Gallery::count();
                                            } catch (Exception $e) {
                                                $galleryCount = 0;
                                            }
                                        }
                                    @endphp
                                    {{ $galleryCount }}
                                </span>
                            </div>
                            
                            <!-- Status -->
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Status:</span>
                                <span class="badge bg-success">
                                    <i class="fas fa-circle me-1" style="font-size: 8px;"></i>Online
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="card sidebar-card mt-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="fas fa-bolt me-2"></i>Quick Actions
                        </h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('packages.create') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus-circle me-1"></i>Tambah Paket
                            </a>
                            <a href="{{ route('menus.create') }}" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-plus-circle me-1"></i>Tambah Menu
                            </a>
                            <a href="{{ route('news.create') }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-plus-circle me-1"></i>Tambah Berita
                            </a>
                            <a href="{{ route('gallery.create') }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-plus-circle me-1"></i>Tambah Foto
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-md-9 col-lg-10">
                <!-- Page Title Area -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-1 fw-bold text-accent">
                            @yield('page-title', 'Dashboard Admin')
                        </h4>
                        <p class="text-muted mb-0 small">
                            @yield('page-subtitle', 'Kelola konten website Guma Landscape')
                        </p>
                    </div>
                    <div>
                        @yield('page-actions')
                    </div>
                </div>
                
                <!-- Main Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-custom mt-5">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">
                        <i class="fas fa-leaf me-2 text-accent"></i>
                        <span class="text-muted">
                            &copy; {{ date('Y') }} Guma Landscape Cafe & Resort
                        </span>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted small">
                        Admin Panel v1.0 • 
                        <span class="text-accent">Laravel {{ app()->version() }}</span>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // SweetAlert untuk konfirmasi delete
        function confirmDelete(event, formId) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#A0522D',
                cancelButtonColor: '#8B7D6B',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
        
        // Notifikasi dari session
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                background: '#F3EBDD',
                color: '#333'
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#A0522D'
            });
        @endif
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Image preview function
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="text-center">
                            <img src="${e.target.result}" class="img-thumbnail mb-2" style="max-height: 200px; max-width: 100%;">
                            <p class="small text-success mb-0">
                                <i class="fas fa-check-circle me-1"></i>
                                ${file.name} (${(file.size / 1024).toFixed(1)} KB)
                            </p>
                        </div>
                    `;
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '<p class="text-muted small">Preview gambar akan muncul di sini</p>';
            }
        }
        
        // Highlight active menu
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.list-group-item');
            
            menuItems.forEach(function(item) {
                const href = item.getAttribute('href');
                if (href && href !== '#') {
                    // Remove base URL for comparison
                    const cleanHref = href.replace('{{ url('') }}', '');
                    if (currentPath.includes(cleanHref) || currentPath === cleanHref) {
                        item.classList.add('active');
                    }
                }
            });
            
            // Set current page title if not set
            const pageTitle = document.querySelector('h4.fw-bold.text-accent');
            if (pageTitle && pageTitle.textContent === 'Dashboard Admin') {
                // Auto detect page title from menu
                const activeMenu = document.querySelector('.list-group-item.active');
                if (activeMenu) {
                    const menuText = activeMenu.textContent.trim();
                    pageTitle.textContent = 'Kelola ' + menuText;
                }
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>