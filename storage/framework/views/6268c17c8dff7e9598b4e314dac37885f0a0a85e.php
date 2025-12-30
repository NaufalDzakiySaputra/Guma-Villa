

<?php $__env->startSection('title', 'Kelola Reservasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">
                <i class="fas fa-calendar-check me-2"></i>Reservasi
            </h4>
            <p class="text-muted mb-0">Total: <?php echo e($reservations->total()); ?> reservasi</p>
        </div>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- Simple Stats -->
    <div class="row mb-4">
        <div class="col-3">
            <div class="card text-center py-2">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total</h6>
                    <h4><?php echo e($totalCount ?? 0); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center py-2">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Pending</h6>
                    <h4 class="text-warning"><?php echo e($pendingCount ?? 0); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center py-2">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Approved</h6>
                    <h4 class="text-success"><?php echo e($approvedCount ?? 0); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center py-2">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Paid</h6>
                    <h4 class="text-info"><?php echo e($paidCount ?? 0); ?></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Reservasi -->
    <div class="card">
        <div class="card-body">
            <?php if($reservations->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e($reservation->id); ?></td>
                            <td><?php echo e($reservation->user->name ?? 'N/A'); ?></td>
                            <td>
                                <?php
                                    $jenis = [
                                        'villa' => 'Villa',
                                        'wisata' => 'Wisata', 
                                        'nikah' => 'Nikah',
                                        'mice' => 'MICE'
                                    ];
                                ?>
                                <?php echo e($jenis[$reservation->service_type] ?? $reservation->service_type); ?>

                            </td>
                            <td><?php echo e($reservation->date->format('d/m/Y')); ?></td>
                            <td>
                                <?php if($reservation->status == 'pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif($reservation->status == 'approved'): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($reservation->payment_status == 'unpaid'): ?>
                                    <span class="badge bg-danger">Unpaid</span>
                                <?php elseif($reservation->payment_status == 'paid'): ?>
                                    <span class="badge bg-warning">Paid</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Verified</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo e(route('admin.reservations.show', $reservation->id)); ?>" 
                                       class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.reservations.edit', $reservation->id)); ?>" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3">
                <?php echo e($reservations->links()); ?>

            </div>
            
            <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada reservasi</h5>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\guma\Guma-Villa\resources\views/admin/reservations/index.blade.php ENDPATH**/ ?>