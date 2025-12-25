

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="fas fa-box-open me-2"></i>Kelola Paket
    </h1>
    <a href="<?php echo e(route('packages.create')); ?>" class="btn btn-success">
        <i class="fas fa-plus me-1"></i>Tambah Paket Baru
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if($packages->isEmpty()): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada paket </h5>
            <p class="text-muted">Mulai dengan menambahkan paket pertama Anda</p>
            <a href="<?php echo e(route('packages.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Tambah Paket Pertama
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Gambar</th>
                            <th>Nama Paket</th>
                            <th>Jenis Layanan</th>
                            <th>Harga</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td>
                                <?php if($package->image_path): ?>
                                    <img src="<?php echo e(asset('storage/' . $package->image_path)); ?>" 
                                         alt="<?php echo e($package->nama); ?>" 
                                         class="img-thumbnail" 
                                         width="80" height="60"
                                         style="object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 80px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo e($package->nama); ?></strong>
                                <?php if($package->description): ?>
                                    <p class="text-muted mb-0 small">
                                        <?php echo e(Str::limit($package->description, 50)); ?>

                                    </p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                    $serviceTypes = [
                                        'villa' => ['label' => 'Villa', 'color' => 'primary'],
                                        'wisata' => ['label' => 'Wisata', 'color' => 'success'],
                                        'nikah' => ['label' => 'Perkawinan', 'color' => 'danger'],
                                        'mice' => ['label' => 'MICE', 'color' => 'info']
                                    ];
                                    $type = $serviceTypes[$package->service_type] ?? ['label' => $package->service_type, 'color' => 'secondary'];
                                ?>
                                <span class="badge bg-<?php echo e($type['color']); ?>">
                                    <?php echo e($type['label']); ?>

                                </span>
                            </td>
                            <td>
                                <strong class="text-success">
                                    Rp <?php echo e(number_format($package->price, 0, ',', '.')); ?>

                                </strong>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?php echo e(route('packages.edit', $package->id)); ?>" 
                                       class="btn btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-form-<?php echo e($package->id); ?>" 
                                          action="<?php echo e(route('packages.destroy', $package->id)); ?>" 
                                          method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                title="Hapus"
                                                onclick="confirmDelete(event, 'delete-form-<?php echo e($package->id); ?>')">
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
            
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Total: <?php echo e($packages->count()); ?> paket
                </div>
                <!-- Jika ada pagination -->
                <!--  -->
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Guma_Villa\guma-landscape\resources\views/admin/packages/index.blade.php ENDPATH**/ ?>