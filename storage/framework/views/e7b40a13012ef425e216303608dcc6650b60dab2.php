

<?php $__env->startSection('page-title', 'Kelola Berita & Event'); ?>
<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Berita
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <?php if($news->isEmpty()): ?>
        <div class="card-body text-center py-5">
            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
            <h5 class="text-muted mb-3">Belum ada berita/event</h5>
            <a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Berita Pertama
            </a>
        </div>
    <?php else: ?>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">Gambar</th>
                            <th>Judul & Deskripsi</th>
                            <th>Tanggal Event</th>
                            <th>Status</th>
                            <th width="100" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($item->image_path): ?>
                                    <img src="<?php echo e(asset('storage/' . $item->image_path)); ?>" 
                                         alt="<?php echo e($item->title); ?>" 
                                         class="rounded" 
                                         width="50" height="50"
                                         style="object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-newspaper text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold"><?php echo e($item->title); ?></div>
                                <?php if($item->description): ?>
                                    <small class="text-muted d-block mt-1">
                                        <?php echo e(Str::limit(strip_tags($item->description), 60)); ?>

                                    </small>
                                <?php endif; ?>
                                <small class="text-muted">
                                    <i class="far fa-calendar me-1"></i>
                                    <?php echo e($item->created_at->format('d/m/Y')); ?>

                                </small>
                            </td>
                            <td>
                                <div class="fw-bold">
                                    <?php echo e($item->event_date->format('d/m/Y')); ?>

                                </div>
                                <small class="text-muted d-block">
                                    <?php echo e($item->event_date->translatedFormat('l')); ?>

                                </small>
                            </td>
                            <td>
                                <?php
                                    $today = \Carbon\Carbon::today();
                                    $eventDate = $item->event_date->startOfDay();
                                    
                                    if ($eventDate->isSameDay($today)) {
                                        $statusClass = 'success';
                                        $statusText = 'Hari Ini';
                                    } elseif ($eventDate->isFuture()) {
                                        $daysDiff = $today->diffInDays($eventDate);
                                        
                                        if ($daysDiff == 1) {
                                            $statusClass = 'primary';
                                            $statusText = 'Besok';
                                        } elseif ($daysDiff <= 7) {
                                            $statusClass = 'warning';
                                            $statusText = $daysDiff . ' hari lagi';
                                        } else {
                                            $statusClass = 'info';
                                            $statusText = 'Akan Datang';
                                        }
                                    } else {
                                        $statusClass = 'danger';
                                        $statusText = 'Selesai';
                                    }
                                ?>
                                <span class="badge bg-<?php echo e($statusClass); ?>">
                                    <?php echo e($statusText); ?>

                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="<?php echo e(route('admin.news.edit', $item->id)); ?>" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.news.destroy', $item->id)); ?>" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus berita ini?')">
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
            Total: <?php echo e($news->count()); ?> berita
            <?php
                $upcomingCount = $news->filter(function($item) {
                    return $item->event_date->isFuture();
                })->count();
            ?>
            <?php if($upcomingCount > 0): ?>
                • <?php echo e($upcomingCount); ?> event mendatang
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\guma\Guma-Villa\resources\views/admin/news/index.blade.php ENDPATH**/ ?>