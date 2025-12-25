

<?php $__env->startSection('page-title', 'Kelola Menu Cafe'); ?>
<?php $__env->startSection('page-subtitle', 'Daftar menu makanan & minuman'); ?>

<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('menus.create')); ?>" class="btn btn-success">
        <i class="fas fa-utensils me-2"></i>Tambah Menu Baru
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-utensils me-2"></i>Daftar Menu Cafe
            </h5>
            <span class="badge bg-soft-primary text-accent">
                <?php echo e($menus->count()); ?> Menu
            </span>
        </div>
    </div>
    
    <?php if($menus->isEmpty()): ?>
    <div class="card-body text-center py-5">
        <div class="mb-4">
            <i class="fas fa-utensils fa-4x text-muted opacity-25"></i>
        </div>
        <h5 class="text-muted mb-3">Belum ada menu</h5>
        <p class="text-muted mb-4">Mulai dengan menambahkan menu pertama</p>
        <a href="<?php echo e(route('menus.create')); ?>" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle me-2"></i>Tambah Menu Pertama
        </a>
    </div>
    <?php else: ?>
    <div class="card-body">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-soft-primary border-0">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Menu</h6>
                                <h4 class="mb-0 fw-bold text-accent"><?php echo e($menus->count()); ?></h4>
                            </div>
                            <div>
                                <i class="fas fa-list fa-2x text-accent opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-soft-success border-0">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Menu Diskon</h6>
                                <h4 class="mb-0 fw-bold text-success">
                                    <?php echo e($menus->where('discount', '>', 0)->count()); ?>

                                </h4>
                            </div>
                            <div>
                                <i class="fas fa-percentage fa-2x text-success opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-soft-info border-0">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Rata-rata Diskon</h6>
                                <h4 class="mb-0 fw-bold text-info">
                                    <?php
                                        $diskonMenus = $menus->where('discount', '>', 0);
                                        $avgDiskon = $diskonMenus->count() > 0 
                                            ? $diskonMenus->avg('discount') 
                                            : 0;
                                    ?>
                                    <?php echo e(number_format($avgDiskon, 1)); ?>%
                                </h4>
                            </div>
                            <div>
                                <i class="fas fa-chart-line fa-2x text-info opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-soft-warning border-0">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Gambar</h6>
                                <h4 class="mb-0 fw-bold text-warning">
                                    <?php echo e($menus->whereNotNull('image_path')->count()); ?>

                                </h4>
                            </div>
                            <div>
                                <i class="fas fa-image fa-2x text-warning opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th width="100">Gambar</th>
                        <th>Nama Menu</th>
                        <th width="180">Harga</th>
                        <th width="120">Diskon</th>
                        <th width="120" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $hasDiscount = $menu->discount > 0;
                        $discountBadge = $hasDiscount ? '-' . number_format($menu->discount, 0) . '%' : null;
                    ?>
                    <tr>
                        <td class="text-muted"><?php echo e($loop->iteration); ?></td>
                        <td>
                            <?php if($menu->image_path): ?>
                                <img src="<?php echo e(asset($menu->image_path)); ?>" 
                                     alt="<?php echo e($menu->name); ?>" 
                                     class="img-thumbnail"
                                     style="width: 80px; height: 60px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 60px;">
                                    <i class="fas fa-utensils text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <h6 class="mb-1" style="color: var(--accent-color);"><?php echo e($menu->name); ?></h6>
                            <?php if($menu->description): ?>
                                <p class="text-muted mb-0 small">
                                    <?php echo e(Str::limit($menu->description, 60)); ?>

                                </p>
                            <?php else: ?>
                                <p class="text-muted mb-0 small"><em>Tidak ada deskripsi</em></p>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($hasDiscount): ?>
                                <div class="mb-1">
                                    <span class="text-decoration-line-through text-muted small">
                                        Rp <?php echo e(number_format($menu->price, 0, ',', '.')); ?>

                                    </span>
                                </div>
                                <div class="fw-bold text-success">
                                    Rp <?php echo e(number_format($menu->harga_diskon, 0, ',', '.')); ?>

                                </div>
                            <?php else: ?>
                                <div class="fw-bold">
                                    Rp <?php echo e(number_format($menu->price, 0, ',', '.')); ?>

                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($hasDiscount): ?>
                                <span class="badge bg-danger">
                                    <i class="fas fa-tag me-1"></i><?php echo e($discountBadge); ?>

                                </span>
                                <small class="d-block text-muted mt-1">
                                    Hemat: Rp <?php echo e(number_format($menu->price - $menu->harga_diskon, 0, ',', '.')); ?>

                                </small>
                            <?php else: ?>
                                <span class="badge bg-secondary">Tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?php echo e(route('menus.edit', $menu->id)); ?>" 
                                   class="btn btn-outline-secondary btn-sm" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form id="delete-menu-<?php echo e($menu->id); ?>" 
                                      action="<?php echo e(route('menus.destroy', $menu->id)); ?>" 
                                      method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-sm" 
                                            title="Hapus"
                                            onclick="confirmDelete(event, 'delete-menu-<?php echo e($menu->id); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <!-- Summary -->
        <div class="text-center mt-4">
            <p class="text-muted mb-0">
                <i class="fas fa-info-circle me-1"></i>
                Total <?php echo e($menus->count()); ?> menu • 
                <?php echo e($menus->where('discount', '>', 0)->count()); ?> menu diskon
            </p>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Guma_Villa\guma-landscape\resources\views/admin/menus/index.blade.php ENDPATH**/ ?>