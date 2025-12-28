

<?php $__env->startSection('page-title', 'Kelola Reservasi'); ?>
<?php $__env->startSection('page-actions'); ?>
    <button class="btn btn-outline-secondary" id="toggleFilter">
        <i class="fas fa-filter"></i> Filter
    </button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Filter Section -->
<div class="card mb-4 d-none" id="filterSection">
    <div class="card-body">
        <h6 class="card-title mb-3">Filter Reservasi</h6>
        <form method="GET" action="<?php echo e(route('reservations.index')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Approved</option>
                    <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Jenis Layanan</label>
                <select name="service_type" class="form-select">
                    <option value="">Semua</option>
                    <option value="villa" <?php echo e(request('service_type') == 'villa' ? 'selected' : ''); ?>>Villa</option>
                    <option value="wisata" <?php echo e(request('service_type') == 'wisata' ? 'selected' : ''); ?>>Wisata</option>
                    <option value="nikah" <?php echo e(request('service_type') == 'nikah' ? 'selected' : ''); ?>>Wedding</option>
                    <option value="mice" <?php echo e(request('service_type') == 'mice' ? 'selected' : ''); ?>>MICE</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="date" class="form-control" value="<?php echo e(request('date')); ?>">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Terapkan
                </button>
                <a href="<?php echo e(route('reservations.index')); ?>" class="btn btn-outline-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<?php if($reservations->isEmpty()): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada reservasi</h5>
        </div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Layanan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th width="100" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <strong class="text-primary">
                                    #<?php echo e(str_pad($reservation->id, 6, '0', STR_PAD_LEFT)); ?>

                                </strong>
                            </td>
                            <td>
                                <div class="fw-bold"><?php echo e($reservation->user->name ?? 'Guest'); ?></div>
                                <small class="text-muted d-block">
                                    <?php echo e($reservation->user->email ?? ''); ?>

                                </small>
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
                                <span class="badge <?php echo e($badgeColors[$reservation->service_type] ?? 'badge-villa'); ?>">
                                    <?php echo e(ucfirst($reservation->service_type)); ?>

                                </span>
                            </td>
                            <td>
                                <?php echo e(\Carbon\Carbon::parse($reservation->date)->format('d/m/Y')); ?>

                            </td>
                            <td>
                                <?php if($reservation->status == 'pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif($reservation->status == 'approved'): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="<?php echo e(route('reservations.edit', $reservation->id)); ?>" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('reservations.destroy', $reservation->id)); ?>" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus reservasi ini?')">
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
        
        <?php if($reservations->hasPages()): ?>
        <div class="card-footer">
            <?php echo e($reservations->links()); ?>

        </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<script>
document.getElementById('toggleFilter').addEventListener('click', function() {
    document.getElementById('filterSection').classList.toggle('d-none');
});

// Show filter if active
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    if (params.toString()) {
        document.getElementById('filterSection').classList.remove('d-none');
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\guma\Guma-Villa\resources\views/admin/reservations/index.blade.php ENDPATH**/ ?>