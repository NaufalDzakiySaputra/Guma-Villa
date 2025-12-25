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
    <link href="<?php echo e(asset('css/admin-colors.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/admin-style.css')); ?>" rel="stylesheet">
    
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
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
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
                        <a class="nav-link" href="<?php echo e(url('/')); ?>" target="_blank">
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
                            <!-- Menu Dashboard -->
                            <a href="<?php echo e(route('admin.dashboard')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                            
                            <!-- Kelola Reservasi -->
                            <a href="<?php echo e(route('reservations.index')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('reservations.*') ? 'active' : ''); ?>">
                                <i class="fas fa-calendar-check me-2"></i>Kelola Reservasi
                            </a>
                            
                            <!-- Paket Wisata -->
                            <a href="<?php echo e(route('packages.index')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('packages.*') ? 'active' : ''); ?>">
                                <i class="fas fa-box me-2"></i>Paket Guma
                            </a>
                            
                            <!-- Menu Cafe -->
                            <a href="<?php echo e(route('menus.index')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('menus.*') ? 'active' : ''); ?>">
                                <i class="fas fa-utensils me-2"></i>Menu Cafe
                            </a>
                            
                            <!-- Berita & Event -->
                            <a href="<?php echo e(route('news.index')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('news.*') ? 'active' : ''); ?>">
                                <i class="fas fa-newspaper me-2"></i>Berita & Event
                            </a>
                            
                            <!-- Galeri -->
                            <a href="<?php echo e(route('gallery.index')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('gallery.*') ? 'active' : ''); ?>">
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
                            <!-- Reservasi Count -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Reservasi:</span>
                                <span class="fw-bold text-primary">
                                    <?php
                                        $reservationsCount = 0;
                                        if (class_exists('App\Models\Reservation')) {
                                            try {
                                                $reservationsCount = App\Models\Reservation::count();
                                            } catch (Exception $e) {
                                                $reservationsCount = 0;
                                            }
                                        }
                                    ?>
                                    <?php echo e($reservationsCount); ?>

                                </span>
                            </div>
                            
                            <!-- Reservasi Pending Count -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Reservasi Pending:</span>
                                <span class="fw-bold text-warning">
                                    <?php
                                        $pendingCount = 0;
                                        if (class_exists('App\Models\Reservation')) {
                                            try {
                                                $pendingCount = App\Models\Reservation::where('status', 'pending')->count();
                                            } catch (Exception $e) {
                                                $pendingCount = 0;
                                            }
                                        }
                                    ?>
                                    <?php echo e($pendingCount); ?>

                                </span>
                            </div>
                            
                            <!-- Packages Count -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Paket Guma:</span>
                                <span class="fw-bold text-accent">
                                    <?php
                                        $packagesCount = 0;
                                        if (class_exists('App\Models\Packages')) {
                                            try {
                                                $packagesCount = App\Models\Packages::count();
                                            } catch (Exception $e) {
                                                $packagesCount = 0;
                                            }
                                        }
                                    ?>
                                    <?php echo e($packagesCount); ?>

                                </span>
                            </div>
                            
                            <!-- Menus Count -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Menu Cafe:</span>
                                <span class="fw-bold text-success">
                                    <?php
                                        $menusCount = 0;
                                        if (class_exists('App\Models\Menus')) {
                                            try {
                                                $menusCount = App\Models\Menus::count();
                                            } catch (Exception $e) {
                                                $menusCount = 0;
                                            }
                                        }
                                    ?>
                                    <?php echo e($menusCount); ?>

                                </span>
                            </div>
                            
                            <!-- News Count -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Berita & Event:</span>
                                <span class="fw-bold text-info">
                                    <?php
                                        $newsCount = 0;
                                        if (class_exists('App\Models\News')) {
                                            try {
                                                $newsCount = App\Models\News::count();
                                            } catch (Exception $e) {
                                                $newsCount = 0;
                                            }
                                        }
                                    ?>
                                    <?php echo e($newsCount); ?>

                                </span>
                            </div>
                            
                            <!-- Gallery Count -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Galeri Foto:</span>
                                <span class="fw-bold text-warning">
                                    <?php
                                        $galleryCount = 0;
                                        if (class_exists('App\Models\Gallery')) {
                                            try {
                                                $galleryCount = App\Models\Gallery::count();
                                            } catch (Exception $e) {
                                                $galleryCount = 0;
                                            }
                                        }
                                    ?>
                                    <?php echo e($galleryCount); ?>

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
                            <!-- Lihat Reservasi Pending -->
                            <?php if($pendingCount > 0): ?>
                            <a href="<?php echo e(route('reservations.index')); ?>?status=pending" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-clock me-1"></i>Lihat <?php echo e($pendingCount); ?> Pending
                            </a>
                            <?php endif; ?>
                            
                            <a href="<?php echo e(route('packages.create')); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus-circle me-1"></i>Tambah Paket
                            </a>
                            <a href="<?php echo e(route('menus.create')); ?>" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-plus-circle me-1"></i>Tambah Menu
                            </a>
                            <a href="<?php echo e(route('news.create')); ?>" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-plus-circle me-1"></i>Tambah Berita
                            </a>
                            <a href="<?php echo e(route('gallery.create')); ?>" class="btn btn-sm btn-outline-warning">
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
                            <?php echo $__env->yieldContent('page-title', 'Dashboard Admin'); ?>
                        </h4>
                        <p class="text-muted mb-0 small">
                            <?php echo $__env->yieldContent('page-subtitle', 'Kelola konten website Guma Landscape'); ?>
                        </p>
                    </div>
                    <div>
                        <?php echo $__env->yieldContent('page-actions'); ?>
                    </div>
                </div>
                
                <!-- Main Content -->
                <?php echo $__env->yieldContent('content'); ?>
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
                            &copy; <?php echo e(date('Y')); ?> Guma Landscape Cafe & Resort
                        </span>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted small">
                        Admin Panel v1.0 • 
                        <span class="text-accent">Laravel <?php echo e(app()->version()); ?></span>
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
        <?php if(session('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?php echo e(session('success')); ?>',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                background: '#F3EBDD',
                color: '#333'
            });
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: '<?php echo e(session('error')); ?>',
                confirmButtonColor: '#A0522D'
            });
        <?php endif; ?>
        
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
                    const cleanHref = href.replace('<?php echo e(url('')); ?>', '');
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
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\Guma_Villa\guma-landscape\resources\views/layouts/admin.blade.php ENDPATH**/ ?>