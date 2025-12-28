

<?php $__env->startSection('page-title', 'Dashboard Admin'); ?>
<?php $__env->startSection('page-subtitle', 'Overview Guma Landscape'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Grid -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card bg-light border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div style="background-color: #A0522D; border-radius: 50%; padding: 12px; margin-right: 15px;">
                        <i class="fas fa-box fa-lg text-white"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Paket</h6>
                        <h4 class="fw-bold" style="color: #A0522D;">
                            <?php echo e(App\Models\Packages::count() ?? 0); ?>

                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card bg-light border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div style="background-color: #28a745; border-radius: 50%; padding: 12px; margin-right: 15px;">
                        <i class="fas fa-utensils fa-lg text-white"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Menu</h6>
                        <h4 class="fw-bold text-success">
                            <?php echo e(App\Models\Menus::count() ?? 0); ?>

                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card bg-light border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div style="background-color: #17a2b8; border-radius: 50%; padding: 12px; margin-right: 15px;">
                        <i class="fas fa-calendar-alt fa-lg text-white"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Event</h6>
                        <h4 class="fw-bold text-info">
                            <?php echo e(App\Models\News::where('event_date', '>=', now()->startOfDay())->count()); ?>

                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card bg-light border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div style="background-color: #ffc107; border-radius: 50%; padding: 12px; margin-right: 15px;">
                        <i class="fas fa-images fa-lg text-white"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Galeri</h6>
                        <h4 class="fw-bold text-warning">
                            <?php echo e(App\Models\Gallery::count() ?? 0); ?>

                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Event Mendatang -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-calendar me-2"></i>
                    Event Mendatang
                </h6>
            </div>
            <div class="card-body">
                <?php
                    $today = \Carbon\Carbon::today()->startOfDay();
                    $upcomingEvents = App\Models\News::where('event_date', '>=', $today)
                        ->orderBy('event_date')
                        ->take(5)
                        ->get();
                ?>
                
                <?php if($upcomingEvents->isEmpty()): ?>
                    <p class="text-muted">Tidak ada event mendatang</p>
                <?php else: ?>
                    <div class="list-group">
                        <?php $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?php echo e($event->title); ?></strong>
                                        <div class="small text-muted">
                                            <?php echo e($event->event_date->format('d M Y')); ?>

                                        </div>
                                    </div>
                                    <div>
                                        <?php
                                            // PERBAIKAN: Gunakan startOfDay() dan parameter FALSE
                                            $eventDate = $event->event_date->startOfDay();
                                            $daysDiff = $today->diffInDays($eventDate, false); // FALSE = bisa negatif
                                            
                                            if ($daysDiff == 0) {
                                                $badgeClass = 'success';
                                                $badgeText = 'Hari Ini';
                                            } elseif ($daysDiff == 1) {
                                                $badgeClass = 'primary';
                                                $badgeText = 'Besok';
                                            } elseif ($daysDiff > 1 && $daysDiff <= 7) {
                                                $badgeClass = 'warning';
                                                $badgeText = $daysDiff . ' hari lagi';
                                            } else {
                                                $badgeClass = 'info';
                                                $badgeText = 'Akan Datang';
                                            }
                                        ?>
                                        <span class="badge bg-<?php echo e($badgeClass); ?>">
                                            <?php echo e($badgeText); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="mt-3 text-end">
                        <a href="<?php echo e(route('news.index')); ?>" class="btn btn-sm btn-outline-primary">
                            Lihat Semua Event
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Galeri Terbaru -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-images me-2"></i>
                    Galeri Terbaru
                </h6>
            </div>
            <div class="card-body">
                <?php
                    $recentGalleries = App\Models\Gallery::latest()->take(4)->get();
                ?>
                
                <?php if($recentGalleries->isEmpty()): ?>
                    <p class="text-muted">Belum ada foto di galeri</p>
                <?php else: ?>
                    <div class="row g-2">
                        <?php $__currentLoopData = $recentGalleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6">
                                <img src="<?php echo e(asset('storage/' . $gallery->image_path)); ?>" 
                                     alt="<?php echo e($gallery->title ?? 'Foto'); ?>"
                                     class="img-fluid rounded"
                                     style="height: 120px; width: 100%; object-fit: cover;">
                                <?php if($gallery->title): ?>
                                    <p class="small text-muted mb-0 mt-1 text-truncate">
                                        <?php echo e($gallery->title); ?>

                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="mt-3 text-end">
                        <a href="<?php echo e(route('gallery.index')); ?>" class="btn btn-sm btn-outline-primary">
                            Lihat Semua Foto
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 bg-light">
            <div class="card-body">
                <h6 class="mb-3">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h6>
                <div class="row g-2">
                    <div class="col-md-3 col-6">
                        <a href="<?php echo e(route('packages.create')); ?>" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus me-1"></i>Paket
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="<?php echo e(route('menus.create')); ?>" class="btn btn-outline-success w-100">
                            <i class="fas fa-plus me-1"></i>Menu
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="<?php echo e(route('news.create')); ?>" class="btn btn-outline-info w-100">
                            <i class="fas fa-plus me-1"></i>Event
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="<?php echo e(route('gallery.create')); ?>" class="btn btn-outline-warning w-100">
                            <i class="fas fa-plus me-1"></i>Foto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\guma\Guma-Villa\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>