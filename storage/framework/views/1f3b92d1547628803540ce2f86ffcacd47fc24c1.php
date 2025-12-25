

<?php $__env->startSection('page-title', 'Kelola Galeri'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola foto-foto Guma Landscape'); ?>

<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('gallery.create')); ?>" class="btn btn-success">
        <i class="fas fa-plus-circle me-2"></i>Tambah Foto
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
                <i class="fas fa-images me-2"></i>Daftar Galeri Foto
            </h5>
            <span class="badge bg-soft-primary text-accent">
                <?php echo e($galleries->count()); ?> Foto
            </span>
        </div>
    </div>
    
    <?php if($galleries->isEmpty()): ?>
    <div class="card-body text-center py-5">
        <div class="mb-4">
            <i class="fas fa-images fa-4x text-muted opacity-25"></i>
        </div>
        <h5 class="text-muted mb-3">Belum ada foto di galeri</h5>
        <p class="text-muted mb-4">Mulai dengan menambahkan foto pertama</p>
        <a href="<?php echo e(route('gallery.create')); ?>" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle me-2"></i>Tambah Foto Pertama
        </a>
    </div>
    <?php else: ?>
    <div class="card-body">
        <!-- Grid View untuk Foto -->
        <div class="row">
            <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <!-- Image -->
                    <div class="position-relative" style="height: 200px; overflow: hidden;">
                        <img src="<?php echo e(asset('storage/' . $gallery->image_path)); ?>" 
                             alt="<?php echo e($gallery->title ?? 'Gallery Image'); ?>"
                             class="img-fluid w-100 h-100"
                             style="object-fit: cover;">
                        <div class="position-absolute top-0 end-0 p-2">
                            <span class="badge bg-dark bg-opacity-75">
                                <?php echo e($loop->iteration); ?>

                            </span>
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="card-body">
                        <h6 class="card-title mb-2">
                            <?php echo e($gallery->title ?? 'Tanpa Judul'); ?>

                        </h6>
                        <div class="small text-muted mb-3">
                            <div>
                                <i class="far fa-calendar me-1"></i>
                                <?php echo e($gallery->created_at->format('d/m/Y')); ?>

                            </div>
                            <?php if($gallery->uploaded_by): ?>
                            <div>
                                <i class="fas fa-user me-1"></i>
                                User ID: <?php echo e($gallery->uploaded_by); ?>

                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('gallery.edit', $gallery->id)); ?>" 
                               class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="delete-gallery-<?php echo e($gallery->id); ?>" 
                                  action="<?php echo e(route('gallery.destroy', $gallery->id)); ?>" 
                                  method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete(event, 'delete-gallery-<?php echo e($gallery->id); ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <!-- Summary -->
        <div class="text-center mt-4">
            <p class="text-muted mb-0">
                <i class="fas fa-info-circle me-1"></i>
                Total <?php echo e($galleries->count()); ?> foto di galeri
            </p>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Guma_Villa\guma-landscape\resources\views/admin/gallery/index.blade.php ENDPATH**/ ?>