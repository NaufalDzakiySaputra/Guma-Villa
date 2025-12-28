

<?php $__env->startSection('page-title', 'Kelola Paket'); ?>
<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('packages.create')); ?>" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Paket
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
    <?php if($packages->isEmpty()): ?>
        <div class="card-body text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted mb-3">Belum ada paket</h5>
            <a href="<?php echo e(route('packages.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Paket Pertama
            </a>
        </div>
    <?php else: ?>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">Gambar</th>
                            <th>Nama Paket</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th width="100" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($package->image_path): ?>
                                    <img src="<?php echo e(asset('storage/' . $package->image_path)); ?>" 
                                         alt="<?php echo e($package->nama); ?>" 
                                         class="rounded" 
                                         width="50" height="50"
                                         style="object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold"><?php echo e($package->nama); ?></div>
                                <?php if($package->description): ?>
                                    <small class="text-muted d-block mt-1">
                                        <?php echo e(Str::limit($package->description, 60)); ?>

                                    </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                    $badgeColors = [
                                        'villa' => 'badge-villa',
                                        'wisata' => 'badge-wisata',
                                        'nikah' => 'badge-nikah',
                                        'mice' => 'badge-mice'
                                    ];
                                ?>
                                <span class="badge <?php echo e($badgeColors[$package->service_type] ?? 'badge-villa'); ?>">
                                    <?php echo e(ucfirst($package->service_type)); ?>

                                </span>
                            </td>
                            <td class="fw-bold text-success">
                                Rp <?php echo e(number_format($package->price, 0, ',', '.')); ?>

                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="<?php echo e(route('packages.edit', $package->id)); ?>" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('packages.destroy', $package->id)); ?>" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus paket ini?')">
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
            Total: <?php echo e($packages->count()); ?> paket
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\guma\Guma-Villa\resources\views/admin/packages/index.blade.php ENDPATH**/ ?>