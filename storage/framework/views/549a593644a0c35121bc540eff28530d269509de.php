<!-- resources/views/admin/reservations/index.blade.php -->


<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="fas fa-calendar-check me-2"></i>Kelola Reservasi
    </h1>
    <button class="btn btn-outline-secondary" id="toggleFilter">
        <i class="fas fa-filter me-1"></i>Filter
    </button>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Filter Section -->
<div class="card mb-4 d-none" id="filterSection">
    <div class="card-body">
        <h6 class="card-title mb-3"><i class="fas fa-filter me-2"></i>Filter Reservasi</h6>
        <form method="GET" action="<?php echo e(route('reservations.index')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Approved</option>
                    <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Jenis Layanan</label>
                <select name="service_type" class="form-select">
                    <option value="">Semua Layanan</option>
                    <option value="villa" <?php echo e(request('service_type') == 'villa' ? 'selected' : ''); ?>>Villa</option>
                    <option value="wisata" <?php echo e(request('service_type') == 'wisata' ? 'selected' : ''); ?>>Wisata</option>
                    <option value="nikah" <?php echo e(request('service_type') == 'nikah' ? 'selected' : ''); ?>>Wedding</option>
                    <option value="mice" <?php echo e(request('service_type') == 'mice' ? 'selected' : ''); ?>>MICE</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Reservasi</label>
                <input type="date" name="date" class="form-control" value="<?php echo e(request('date')); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status Pembayaran</label>
                <select name="payment_status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="unpaid" <?php echo e(request('payment_status') == 'unpaid' ? 'selected' : ''); ?>>Unpaid</option>
                    <option value="paid" <?php echo e(request('payment_status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                    <option value="verified" <?php echo e(request('payment_status') == 'verified' ? 'selected' : ''); ?>>Verified</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>Terapkan Filter
                </button>
                <a href="<?php echo e(route('reservations.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-redo me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Reservasi</h6>
                        <h3 class="mb-0"><?php echo e($totalCount ?? 0); ?></h3>
                    </div>
                    <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Pending</h6>
                        <h3 class="mb-0"><?php echo e($pendingCount ?? 0); ?></h3>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Approved</h6>
                        <h3 class="mb-0"><?php echo e($approvedCount ?? 0); ?></h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Paid</h6>
                        <h3 class="mb-0"><?php echo e($paidCount ?? 0); ?></h3>
                    </div>
                    <i class="fas fa-credit-card fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($reservations->isEmpty()): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada reservasi</h5>
            <p class="text-muted">Belum ada customer yang melakukan reservasi</p>
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
                            <th>ID Reservasi</th>
                            <th>Customer</th>
                            <th>Layanan</th>
                            <th>Tanggal Reservasi</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td>
                                <strong class="text-primary">
                                    #<?php echo e(str_pad($reservation->id, 6, '0', STR_PAD_LEFT)); ?>

                                </strong>
                            </td>
                            <td>
                                <strong><?php echo e($reservation->user->name ?? 'Guest'); ?></strong>
                                <p class="text-muted mb-0 small">
                                    <?php echo e($reservation->user->email ?? 'N/A'); ?>

                                </p>
                                <?php if($reservation->user->phone ?? false): ?>
                                <p class="text-muted mb-0 small">
                                    <i class="fas fa-phone me-1"></i><?php echo e($reservation->user->phone); ?>

                                </p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                    $serviceTypes = [
                                        'villa' => ['label' => 'Villa', 'color' => 'primary'],
                                        'wisata' => ['label' => 'Wisata', 'color' => 'success'],
                                        'nikah' => ['label' => 'Wedding', 'color' => 'danger'],
                                        'mice' => ['label' => 'MICE', 'color' => 'info']
                                    ];
                                    $type = $serviceTypes[$reservation->service_type] ?? ['label' => $reservation->service_type, 'color' => 'secondary'];
                                ?>
                                <span class="badge bg-<?php echo e($type['color']); ?>">
                                    <?php echo e($type['label']); ?>

                                </span>
                                <?php if($reservation->package): ?>
                                    <p class="text-muted mb-0 small mt-1">
                                        <?php echo e($reservation->package->nama); ?>

                                    </p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo e(\Carbon\Carbon::parse($reservation->date)->format('d M Y')); ?></strong>
                                <p class="text-muted mb-0 small">
                                    dibuat: <?php echo e(\Carbon\Carbon::parse($reservation->created_at)->format('H:i')); ?>

                                </p>
                            </td>
                            <td>
                                <?php if($reservation->status == 'pending'): ?>
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Pending
                                    </span>
                                <?php elseif($reservation->status == 'approved'): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Approved
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Rejected
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($reservation->payment_status == 'unpaid'): ?>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-money-bill-wave me-1"></i>Unpaid
                                    </span>
                                <?php elseif($reservation->payment_status == 'paid'): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Paid
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-info">
                                        <i class="fas fa-shield-alt me-1"></i>Verified
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?php echo e(route('reservations.show', $reservation->id)); ?>" 
                                       class="btn btn-outline-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('reservations.edit', $reservation->id)); ?>" 
                                       class="btn btn-outline-warning" title="Edit Status">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-form-<?php echo e($reservation->id); ?>" 
                                          action="<?php echo e(route('reservations.destroy', $reservation->id)); ?>" 
                                          method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                title="Hapus Reservasi"
                                                onclick="confirmDelete(event, 'delete-form-<?php echo e($reservation->id); ?>')">
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
                    Menampilkan <?php echo e($reservations->firstItem() ?? 0); ?> - <?php echo e($reservations->lastItem() ?? 0); ?> dari <?php echo e($reservations->total()); ?> reservasi
                </div>
                <!-- Pagination -->
                <?php if($reservations->hasPages()): ?>
                <div>
                    <?php echo e($reservations->links()); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Toggle filter section
    document.getElementById('toggleFilter').addEventListener('click', function() {
        const filterSection = document.getElementById('filterSection');
        filterSection.classList.toggle('d-none');
    });
    
    // Show filter if there are active filters
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        let hasFilters = false;
        
        ['status', 'service_type', 'date', 'payment_status'].forEach(param => {
            if (urlParams.get(param)) hasFilters = true;
        });
        
        if (hasFilters) {
            document.getElementById('filterSection').classList.remove('d-none');
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Guma_Villa\guma-landscape\resources\views/admin/reservations/index.blade.php ENDPATH**/ ?>