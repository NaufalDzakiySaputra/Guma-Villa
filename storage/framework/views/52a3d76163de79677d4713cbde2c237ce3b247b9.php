<!DOCTYPE html>
<html lang="id" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin - Guma Landscape'); ?></title>
    
    <!-- Bootstrap 5 + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="d-flex flex-column h-100" style="background-color: #f8f9fa;">
    <!-- Simple Navbar -->
    <nav class="navbar navbar-light" style="background-color: #F3EBDD;">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <img src="<?php echo e(asset('images/logo/logo.png')); ?>" alt="Logo" height="40">
                <span class="ms-2 d-none d-md-inline">
                    <strong>Guma Landscape</strong>
                    <small class="text-muted ms-2">Admin</small>
                </span>
            </a>
            
            <?php if(auth()->guard()->check()): ?>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user me-1"></i><?php echo e(Auth::user()->name); ?>

                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                    <li><a class="dropdown-item" href="<?php echo e(url('/')); ?>">Homepage</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Main Content Area (flex-grow-1 untuk mengisi ruang) -->
    <div class="flex-grow-1">
        <div class="container-fluid mt-3">
            <div class="row">
                <!-- Simple Sidebar -->
                <?php if(Auth::check() && Auth::user()->role === 'admin'): ?>
                <div class="col-md-2 d-none d-md-block">
                    <div class="list-group">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-users me-2"></i>Users
                        </a>
                        <a href="<?php echo e(route('admin.reservations.index')); ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-check me-2"></i>Reservasi
                        </a>
                        <a href="<?php echo e(route('admin.packages.index')); ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-box me-2"></i>Paket
                        </a>
                        <a href="<?php echo e(route('admin.menus.index')); ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-utensils me-2"></i>Menu
                        </a>
                        <a href="<?php echo e(route('admin.news.index')); ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-newspaper me-2"></i>Berita
                        </a>
                        <a href="<?php echo e(route('admin.gallery.index')); ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-images me-2"></i>Galeri
                        </a>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-md-10">
                <?php else: ?>
                <!-- Access Denied for non-admin -->
                <div class="col-12">
                    <div class="text-center py-5">
                        <h4 class="text-danger">Akses Ditolak</h4>
                        <p class="text-muted">Hanya admin yang bisa mengakses halaman ini.</p>
                        <a href="<?php echo e(url('/')); ?>" class="btn btn-primary">Kembali ke Home</a>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if(Auth::check() && Auth::user()->role === 'admin'): ?>
                    <!-- Flash Messages -->
                    <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="mb-1"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h4>
                            <p class="text-muted mb-0 small"><?php echo $__env->yieldContent('page-subtitle', ''); ?></p>
                        </div>
                        <div><?php echo $__env->yieldContent('page-actions'); ?></div>
                    </div>
                    
                    <!-- Main Content -->
                    <?php echo $__env->yieldContent('content'); ?>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Footer dengan mt-auto -->
    <footer class="mt-auto py-3 text-center" style="background-color: #F3EBDD;">
        <div class="container">
            <p class="mb-0 text-muted">
                &copy; <?php echo e(date('Y')); ?> Guma Landscape Cafe & Villa Syariah | 
                Admin Panel v1.0
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Simple Delete Confirmation -->
    <script>
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus?');
        }
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.classList.remove('show');
            });
        }, 5000);
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\guma\Guma-Villa\resources\views/layouts/admin.blade.php ENDPATH**/ ?>