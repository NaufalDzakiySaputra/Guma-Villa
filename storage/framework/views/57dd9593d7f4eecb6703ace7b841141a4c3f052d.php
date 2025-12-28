

<?php $__env->startSection('page-title', 'Tambah User Baru'); ?>
<?php $__env->startSection('page-subtitle', 'Buat akun user atau admin baru'); ?>
<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
        <form action="<?php echo e(route('admin.users.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="row g-3">
                <!-- Kolom Kiri -->
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" 
                               name="name" 
                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('name')); ?>"
                               required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" 
                               name="email" 
                               class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('email')); ?>"
                               required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Password *</label>
                            <div class="position-relative">
                                <input type="password" 
                                       name="password" 
                                       id="password"
                                       class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> pe-5" 
                                       required>
                                <!-- UBAH BUTTON: tambah data-toggle-password -->
                                <button type="button" 
                                        class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted"
                                        data-toggle-password="password"
                                        style="padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-text small">Minimal 8 karakter</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password *</label>
                            <div class="position-relative">
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation"
                                       class="form-control pe-5" 
                                       required>
                                <!-- UBAH BUTTON: tambah data-toggle-password -->
                                <button type="button" 
                                        class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted"
                                        data-toggle-password="password_confirmation"
                                        style="padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="col-lg-4">
                    <div class="mb-4">
                        <label class="form-label">Role *</label>
                        <select name="role" 
                                class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                required>
                            <option value="">Pilih Role</option>
                            <option value="user" <?php echo e(old('role') == 'user' ? 'selected' : ''); ?>>User Biasa</option>
                            <option value="admin" <?php echo e(old('role') == 'admin' ? 'selected' : ''); ?>>Administrator</option>
                        </select>
                        <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="card-title small"><i class="fas fa-info-circle me-1"></i> Informasi Role</h6>
                            <ul class="small text-muted mb-0">
                                <li><strong>User Biasa:</strong> Hanya bisa melihat frontend</li>
                                <li><strong>Administrator:</strong> Akses penuh ke admin panel</li>
                                <li>Role bisa diubah kapan saja</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="d-flex justify-content-end gap-2">
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan User
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<!-- HAPUS SECTION SCRIPTS - SUDAH ADA DI LAYOUT -->
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\guma\Guma-Villa\resources\views/admin/users/create.blade.php ENDPATH**/ ?>