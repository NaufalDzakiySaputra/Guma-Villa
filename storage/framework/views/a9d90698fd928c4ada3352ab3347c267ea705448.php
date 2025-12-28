

<?php $__env->startSection('page-title', 'Kelola Menu Cafe'); ?>
<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('menus.create')); ?>" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Menu
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <?php if($menus->isEmpty()): ?>
        <div class="card-body text-center py-5">
            <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
            <h5 class="text-muted mb-3">Belum ada menu</h5>
            <a href="<?php echo e(route('menus.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Menu Pertama
            </a>
        </div>
    <?php else: ?>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">Gambar</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th width="100" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($menu->image_path): ?>
                                    <img src="<?php echo e(asset($menu->image_path)); ?>" 
                                         alt="<?php echo e($menu->name); ?>" 
                                         class="rounded" 
                                         width="50" height="50"
                                         style="object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-utensils text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold"><?php echo e($menu->name); ?></div>
                                <?php if($menu->description): ?>
                                    <small class="text-muted d-block mt-1">
                                        <?php echo e(Str::limit($menu->description, 60)); ?>

                                    </small>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold">
                                Rp <?php echo e(number_format($menu->price, 0, ',', '.')); ?>

                            </td>
                            <td>
                                <?php if($menu->discount > 0): ?>
                                    <span class="badge bg-danger">
                                        -<?php echo e($menu->discount); ?>%
                                    </span>
                                    <div class="text-success small mt-1">
                                        Rp <?php echo e(number_format($menu->harga_diskon, 0, ',', '.')); ?>

                                    </div>
                                <?php else: ?>
                                    <span class="badge bg-secondary">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="<?php echo e(route('menus.edit', $menu->id)); ?>" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('menus.destroy', $menu->id)); ?>" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus menu ini?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
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
        </div>
        
        <div class="card-footer text-muted small">
            Total: <?php echo e($menus->count()); ?> menu
            <?php if($menus->where('discount', '>', 0)->count() > 0): ?>
                • <?php echo e($menus->where('discount', '>', 0)->count()); ?> menu diskon
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\guma\Guma-Villa\resources\views/admin/menus/index.blade.php ENDPATH**/ ?>