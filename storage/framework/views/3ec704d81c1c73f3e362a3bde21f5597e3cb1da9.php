

<?php $__env->startSection('page-title', 'Tambah Berita/Event Baru'); ?>
<?php $__env->startSection('page-subtitle', 'Tambahkan event atau promo baru'); ?>

<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('news.index')); ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-plus-circle me-2"></i>Form Tambah Berita/Event
        </h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('news.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-lg-8">
                    <div class="mb-4">
                        <label for="title" class="form-label">Judul Event/Promo <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="title" 
                               name="title" 
                               value="<?php echo e(old('title')); ?>" 
                               placeholder="Contoh: Festival Musim Panas 2024"
                               required
                               autofocus>
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-text">
                            Beri judul yang menarik dan jelas.
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="description" 
                                  name="description" 
                                  rows="6" 
                                  placeholder="Deskripsikan event/promo secara detail..."><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-text">
                            Gunakan paragraf yang jelas. Informasikan waktu, lokasi, dan benefit.
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="event_date" class="form-label">Tanggal Event <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control <?php $__errorArgs = ['event_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="event_date" 
                               name="event_date" 
                               value="<?php echo e(old('event_date')); ?>" 
                               required>
                        <?php $__errorArgs = ['event_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-text">
                            Tanggal pelaksanaan event/promo.
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="col-lg-4">
                    <div class="card bg-soft-primary border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-image me-2"></i>Gambar Utama
                            </h6>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Gambar</label>
                                <input type="file" 
                                       class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="image" 
                                       name="image"
                                       accept="image/*"
                                       onchange="previewImage(this, 'imagePreview')">
                                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text small">
                                    Format: JPG, JPEG, PNG. Maksimal 2MB.
                                </div>
                            </div>
                            
                            <!-- Preview Image -->
                            <div class="mt-3">
                                <div id="imagePreview">
                                    <div class="border rounded p-4 text-center bg-white">
                                        <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-3"></i>
                                        <p class="text-muted small mb-0">Preview gambar akan muncul di sini</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info Event -->
                    <div class="card bg-soft-info border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-info-circle me-2"></i>Info Event
                            </h6>
                            <div class="small text-muted">
                                <div id="eventInfo">
                                    <p class="mb-2">Isi form untuk melihat info event</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-soft-primary border-0">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-lightbulb me-2"></i>Tips Event
                            </h6>
                            <ul class="small text-muted mb-0">
                                <li class="mb-2">Gambar menarik meningkatkan minat</li>
                                <li class="mb-2">Jelaskan benefit untuk customer</li>
                                <li class="mb-2">Sertakan kontak untuk informasi</li>
                                <li>Update event yang sudah selesai</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-redo me-1"></i>Reset Form
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Simpan Berita
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Update event info real-time
    function updateEventInfo() {
        const title = document.getElementById('title').value;
        const eventDate = document.getElementById('event_date').value;
        const description = document.getElementById('description').value;
        
        const infoDiv = document.getElementById('eventInfo');
        let html = '';
        
        if (title || eventDate) {
            if (title) {
                html += `<div class="mb-2"><strong>Judul:</strong><br>${title}</div>`;
            }
            
            if (eventDate) {
                const date = new Date(eventDate);
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = date.toLocaleDateString('id-ID', options);
                
                // Hitung hari menuju event
                const today = new Date();
                const timeDiff = date.getTime() - today.getTime();
                const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                
                let status = '';
                let statusClass = '';
                
                if (daysDiff < 0) {
                    status = 'Event telah lewat';
                    statusClass = 'text-danger';
                } else if (daysDiff === 0) {
                    status = 'Event hari ini!';
                    statusClass = 'text-success';
                } else if (daysDiff <= 7) {
                    status = `${daysDiff} hari lagi`;
                    statusClass = 'text-warning';
                } else {
                    status = `${daysDiff} hari lagi`;
                    statusClass = 'text-info';
                }
                
                html += `
                    <div class="mb-2">
                        <strong>Tanggal:</strong><br>
                        ${formattedDate}
                    </div>
                    <div class="${statusClass} fw-bold">
                        <i class="far fa-clock me-1"></i>${status}
                    </div>
                `;
            }
            
            if (description) {
                const wordCount = description.trim().split(/\s+/).length;
                html += `<div class="mt-2"><small>${wordCount} kata dalam deskripsi</small></div>`;
            }
        } else {
            html = '<p class="mb-2">Isi form untuk melihat info event</p>';
        }
        
        infoDiv.innerHTML = html;
    }
    
    // Event listeners
    document.getElementById('title').addEventListener('input', updateEventInfo);
    document.getElementById('event_date').addEventListener('input', updateEventInfo);
    document.getElementById('description').addEventListener('input', updateEventInfo);
    
    // Set minimum date to today
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('event_date').min = today;
        updateEventInfo();
    });
    
    // Image preview function (from layout)
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <div class="text-center">
                        <img src="${e.target.result}" class="img-thumbnail mb-2" style="max-height: 200px; max-width: 100%;">
                        <p class="small text-success mb-0">
                            <i class="fas fa-check-circle me-1"></i>
                            ${file.name} (${(file.size / 1024).toFixed(1)} KB)
                        </p>
                    </div>
                `;
            }
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = `
                <div class="border rounded p-4 text-center bg-white">
                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-3"></i>
                    <p class="text-muted small mb-0">Preview gambar akan muncul di sini</p>
                </div>
            `;
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Guma_Villa\guma-landscape\resources\views/admin/news/create.blade.php ENDPATH**/ ?>