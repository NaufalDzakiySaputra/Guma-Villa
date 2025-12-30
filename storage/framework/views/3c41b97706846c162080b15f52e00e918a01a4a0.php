<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Guma Landscape Cafe & Resort</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Custom Styles -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background-color: #F3EBDD;
                color: #333;
            }
            .navbar-custom {
                background-color: #A0522D;
                box-shadow: 0 2px 4px rgba(0,0,0,.1);
            }
            .navbar-custom .navbar-brand {
                color: white;
                font-weight: 600;
            }
            .navbar-custom .nav-link {
                color: rgba(255,255,255,.8);
            }
            .navbar-custom .nav-link:hover {
                color: white;
            }
            .welcome-card {
                background: white;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(139, 125, 107, 0.1);
                padding: 2rem;
                margin-top: 2rem;
            }
            .btn-guma {
                background-color: #A0522D;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 8px;
                text-decoration: none;
                display: inline-block;
                transition: background-color 0.3s;
            }
            .btn-guma:hover {
                background-color: #8B4513;
                color: white;
            }
            .user-info-card {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                border-left: 4px solid #A0522D;
            }
            .logout-btn {
                background-color: transparent;
                border: 1px solid #dc3545;
                color: #dc3545;
                padding: 5px 15px;
                border-radius: 5px;
                font-size: 0.9rem;
                transition: all 0.3s;
            }
            .logout-btn:hover {
                background-color: #dc3545;
                color: white;
            }
        </style>
    </head>
    <body>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <i class="fas fa-leaf me-2"></i>
                    Guma Landscape
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <!-- User Info & Logout (Jika login) -->
                        <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>
                                <?php echo e(Auth::user()->name); ?>

                                <span class="badge bg-light text-dark ms-1">
                                    <?php echo e(Auth::user()->role); ?>

                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php if(Auth::user()->role === 'admin'): ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">
                                        <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                                    </a>
                                </li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user me-2"></i>My Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <?php endif; ?>
                        
                        <!-- Auth Links (Jika belum login) -->
                        <?php if(auth()->guard()->guest()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container py-5">
            <!-- Welcome Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold mb-3" style="color: #A0522D;">
                    <i class="fas fa-leaf me-3"></i>Guma Landscape Cafe dan Villa Syariah
                </h1>
                <p class="lead text-muted">
                    Experience nature's beauty with premium hospitality
                </p>
            </div>
            
            <!-- User Info Card (Jika login) -->
            <?php if(auth()->guard()->check()): ?>
            <div class="row justify-content-center mb-5">
                <div class="col-md-8">
                    <div class="card user-info-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">
                                        <i class="fas fa-user-circle me-2 text-accent"></i>
                                        Welcome back, <?php echo e(Auth::user()->name); ?>!
                                    </h5>
                                    <p class="text-muted mb-0">
                                        You are logged in as 
                                        <span class="badge bg-<?php echo e(Auth::user()->role === 'admin' ? 'primary' : 'secondary'); ?>">
                                            <?php echo e(Auth::user()->role); ?>

                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="logout-btn">
                                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="mt-3">
                                <?php if(Auth::user()->role === 'admin'): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-sm btn-primary me-2">
                                    <i class="fas fa-tachometer-alt me-1"></i>Go to Admin Panel
                                </a>
                                <?php endif; ?>
                                <a href="#" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-calendar-check me-1"></i>View Reservations
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-cog me-1"></i>Settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Main Welcome Card -->
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="welcome-card">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="fw-bold mb-3" style="color: #A0522D;">Welcome to Guma Landscape</h2>
                                <p class="lead mb-4">
                                    A beautiful cafe and resort nestled in nature, offering the perfect 
                                    getaway for relaxation and adventure.
                                </p>
                                
                                <!-- Auth Buttons (Jika belum login) -->
                                <?php if(auth()->guard()->guest()): ?>
                                <div class="d-flex gap-3 mb-4">
                                    <a href="<?php echo e(route('login')); ?>" class="btn-guma">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login
                                    </a>
                                    <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-accent" style="border-color: #A0522D; color: #A0522D;">
                                        <i class="fas fa-user-plus me-2"></i>Create Account
                                    </a>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Quick Info -->
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <div class="text-center p-3 bg-light rounded">
                                            <i class="fas fa-utensils fa-2x mb-2" style="color: #A0522D;"></i>
                                            <h5 class="mb-1">Cafe</h5>
                                            <small class="text-muted">Fine Dining</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center p-3 bg-light rounded">
                                            <i class="fas fa-bed fa-2x mb-2" style="color: #A0522D;"></i>
                                            <h5 class="mb-1">Resort</h5>
                                            <small class="text-muted">Luxury Stays</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 text-center">
                                <img src="https://images.unsplash.com/photo-1519046904884-53103b34b206?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                     alt="Guma Landscape" 
                                     class="img-fluid rounded"
                                     style="max-height: 300px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Features Section -->
            <div class="row mt-5">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-mountain fa-3x mb-3" style="color: #A0522D;"></i>
                            <h5>Nature Views</h5>
                            <p class="text-muted">Breathtaking views of mountains and forests</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-utensils fa-3x mb-3" style="color: #A0522D;"></i>
                            <h5>Fine Dining</h5>
                            <p class="text-muted">Local and international cuisine</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-spa fa-3x mb-3" style="color: #A0522D;"></i>
                            <h5>Relaxation</h5>
                            <p class="text-muted">Spa and wellness facilities</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="mt-5 pt-4 border-top text-center">
                <p class="text-muted">
                    <i class="fas fa-leaf me-1" style="color: #A0522D;"></i>
                    &copy; <?php echo e(date('Y')); ?> Guma Landscape Cafe & Resort. All rights reserved.
                </p>
                <div class="small text-muted">
                    <?php if(auth()->guard()->check()): ?>
                    Logged in as: <?php echo e(Auth::user()->name); ?> | 
                    <a href="<?php echo e(route('logout')); ?>" 
                       onclick="event.preventDefault(); document.getElementById('logout-form-bottom').submit();"
                       class="text-decoration-none">
                       <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </a>
                    <form id="logout-form-bottom" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                        <?php echo csrf_field(); ?>
                    </form>
                    <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-decoration-none me-3">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                    <a href="<?php echo e(route('register')); ?>" class="text-decoration-none">
                        <i class="fas fa-user-plus me-1"></i>Register
                    </a>
                    <?php endif; ?>
                </div>
            </footer>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- SweetAlert for Logout Confirmation -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script>
            // Logout confirmation
            document.addEventListener('DOMContentLoaded', function() {
                // All logout forms
                const logoutForms = document.querySelectorAll('form[action*="logout"]');
                
                logoutForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        Swal.fire({
                            title: 'Logout?',
                            text: "Are you sure you want to logout?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#A0522D',
                            cancelButtonColor: '#8B7D6B',
                            confirmButtonText: 'Yes, Logout',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
    </body>
</html><?php /**PATH C:\xampp\htdocs\guma\Guma-Villa\resources\views/welcome.blade.php ENDPATH**/ ?>