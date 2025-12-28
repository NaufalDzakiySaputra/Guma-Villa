

<?php $__env->startSection('page-title', 'Kelola Galeri'); ?>
<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('gallery.create')); ?>" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Foto
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
    <?php if($galleries->isEmpty()): ?>
        <div class="card-body text-center py-5">
            <i class="fas fa-images fa-3x text-muted mb-3"></i>
            <h5 class="text-muted mb-3">Belum ada foto</h5>
            <a href="<?php echo e(route('gallery.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Foto Pertama
            </a>
        </div>
    <?php else: ?>
        <div class="card-body">
            <div class="row">
                <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3 col-6 mb-4">
                    <div class="card border-0">
                        <div class="position-relative">
                            <img src="<?php echo e(asset('storage/' . $gallery->image_path)); ?>" 
                                 alt="<?php echo e($gallery->title ?? 'Foto'); ?>"
                                 class="img-fluid rounded"
                                 style="height: 150px; width: 100%; object-fit: cover;">
                            <?php if($gallery->title): ?>
                                <div class="position-absolute bottom-0 start-0 w-100 p-2" 
                                     style="background: rgba(0,0,0,0.5);">
                                    <p class="text-white mb-0 small"><?php echo e($gallery->title); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between gap-1">
                                <a href="<?php echo e(route('gallery.edit', $gallery->id)); ?>" 
                                   class="btn btn-sm btn-outline-warning flex-fill">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('gallery.destroy', $gallery->id)); ?>" 
                                      method="POST" 
                                      onsubmit="return confirm('Hapus foto ini?')"
                                      class="flex-fill">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        
        <div class="card-footer text-muted small">
            Total: <?php echo e($galleries->count()); ?> foto
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\guma\Guma-Villa\resources\views/admin/gallery/index.blade.php ENDPATH**/ ?>