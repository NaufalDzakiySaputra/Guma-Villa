<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin - Guma Landscape'); ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Admin CSS -->
    <link href="<?php echo e(asset('css/admin-colors.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/admin-style.css')); ?>" rel="stylesheet">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
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
                            <a href="<?php echo e(route('admin.dashboard')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                            
                            <a href="<?php echo e(route('reservations.index')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('reservations.*') ? 'active' : ''); ?>">
                                <i class="fas fa-calendar-check me-2"></i>Reservasi
                            </a>
                            
                            <a href="<?php echo e(route('packages.index')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('packages.*') ? 'active' : ''); ?>">
                                <i class="fas fa-box me-2"></i>Paket
                            </a>
                            
                            <a href="<?php echo e(route('menus.index')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('menus.*') ? 'active' : ''); ?>">
                                <i class="fas fa-utensils me-2"></i>Menu Cafe
                            </a>
                            
                            <a href="<?php echo e(route('news.index')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('news.*') ? 'active' : ''); ?>">
                                <i class="fas fa-newspaper me-2"></i>Berita & Event
                            </a>
                            
                            <a href="<?php echo e(route('gallery.index')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('gallery.*') ? 'active' : ''); ?>">
                                <i class="fas fa-images me-2"></i>Galeri
                            </a>
                            
                            <!-- TAMBAH MENU USER MANAGEMENT -->
                            <a href="<?php echo e(route('admin.users.index')); ?>"
                               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                                <i class="fas fa-users me-2"></i>Kelola User
                            </a>
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
                            <a href="<?php echo e(route('packages.create')); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus me-1"></i>Tambah Paket
                            </a>
                            <a href="<?php echo e(route('menus.create')); ?>" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-plus me-1"></i>Tambah Menu
                            </a>
                            <a href="<?php echo e(route('news.create')); ?>" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-plus me-1"></i>Tambah Berita
                            </a>
                            <a href="<?php echo e(route('gallery.create')); ?>" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-plus me-1"></i>Tambah Foto
                            </a>
                            <!-- TAMBAH QUICK ACTION USER -->
                            <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-user-plus me-1"></i>Tambah User
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
    <footer class="footer-custom mt-5 py-3">
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
                        Admin Panel v1.0
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // ===== GLOBAL FUNCTIONS =====
        
        // 1. Password Toggle Function
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            if (!input) return;
            
            const icon = button.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // 2. Initialize all password toggles
        function initPasswordToggles() {
            document.querySelectorAll('[data-toggle-password]').forEach(button => {
                const inputId = button.getAttribute('data-toggle-password');
                button.addEventListener('click', function() {
                    togglePasswordVisibility(inputId, this);
                });
            });
        }
        
        // 3. Auto-initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initPasswordToggles();
            console.log('Password toggles initialized');
        });
        
        // 4. SweetAlert untuk konfirmasi delete
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
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
        
        // 5. Notifikasi dari session
        <?php if(session('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?php echo e(session('success')); ?>',
                timer: 3000,
                showConfirmButton: false
            });
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: '<?php echo e(session('error')); ?>'
            });
        <?php endif; ?>
        
        // 6. Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // 7. Image preview function
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" class="img-fluid rounded mb-2" style="max-height: 150px;">
                    `;
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '<p class="text-muted small">Preview gambar</p>';
            }
        }
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\laragon\www\Guma-Villa\resources\views/layouts/admin.blade.php ENDPATH**/ ?>