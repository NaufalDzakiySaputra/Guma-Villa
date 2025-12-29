

<?php $__env->startSection('page-title', 'Kelola User'); ?>
<?php $__env->startSection('page-subtitle', 'Manajemen user dan akses admin'); ?>
<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah User
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60">ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Daftar</th>
                        <th width="150" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-muted">#<?php echo e($user->id); ?></td>
                        <td>
                            <div class="fw-bold"><?php echo e($user->name); ?></div>
                            <?php if($user->id === auth()->id()): ?>
                                <small class="text-primary">
                                    <i class="fas fa-user-circle me-1"></i> Anda
                                </small>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($user->email); ?></td>
                        <td>
                            <?php
                                $badgeColors = [
                                    'admin' => 'badge-success',
                                    'user' => 'badge-info'
                                ];
                            ?>
                            <span class="badge <?php echo e($badgeColors[$user->role] ?? 'badge-secondary'); ?>">
                                <?php echo e(ucfirst($user->role)); ?>

                            </span>
                        </td>
                        <td class="text-muted">
                            <?php echo e($user->created_at->format('d/m/Y')); ?>

                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" 
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" 
                                      method="POST" 
                                      id="delete-form-<?php echo e($user->id); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete(event, 'delete-form-<?php echo e($user->id); ?>')"
                                            <?php echo e($user->id === auth()->id() ? 'disabled' : ''); ?>>
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
        Total: <?php echo e($users->count()); ?> user
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function confirmDelete(event, formId) {
        event.preventDefault();
        const form = document.getElementById(formId);
        const userName = form.closest('tr').querySelector('.fw-bold').textContent;
        
        Swal.fire({
            title: 'Hapus User?',
            html: `<p>User <strong>"${userName}"</strong> akan dihapus permanen!</p>
                   <p class="text-danger small">Tindakan ini tidak dapat dibatalkan.</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#A0522D',
            cancelButtonColor: '#8B7D6B',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\Guma-Villa\resources\views/admin/users/index.blade.php ENDPATH**/ ?>