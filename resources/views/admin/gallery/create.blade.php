@extends('layouts.admin')

@section('page-title', 'Tambah Foto ke Galeri')
@section('page-subtitle', 'Upload foto baru ke galeri')

@section('page-actions')
    <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-plus-circle me-2"></i>Form Upload Foto
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-lg-8">
                    <div class="mb-4">
                        <label for="title" class="form-label">Judul Foto (Opsional)</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               placeholder="Contoh: Acara Wedding Customer">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Beri judul yang mendeskripsikan foto.
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="col-lg-4">
                    <div class="card bg-soft-primary border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-image me-2"></i>File Foto
                            </h6>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Pilih Foto <span class="text-danger">*</span></label>
                                <input type="file" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       id="image" 
                                       name="image"
                                       accept="image/*"
                                       onchange="previewImage(this, 'imagePreview')"
                                       required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text small">
                                    Format: JPG, JPEG, PNG. Maksimal 2MB.
                                </div>
                            </div>
                            
                            <!-- Preview Image -->
                            <div class="mt-3">
                                <div id="imagePreview">
                                    <div class="border rounded p-4 text-center bg-white">
                                        <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-3"></i>
                                        <p class="text-muted small mb-0">Preview foto akan muncul di sini</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-soft-primary border-0">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-info-circle me-2"></i>Informasi
                            </h6>
                            <ul class="small text-muted mb-0">
                                <li class="mb-2">Gunakan foto berkualitas tinggi</li>
                                <li class="mb-2">Foto akan ditampilkan di halaman galeri</li>
                                <li>Ukuran optimal: 1200 x 800 pixel</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-redo me-1"></i>Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload me-1"></i>Upload Foto
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Image preview function
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <div class="text-center">
                        <img src="${e.target.result}" class="img-fluid rounded mb-2" style="max-height: 300px;">
                        <p class="small text-success mb-0">
                            <i class="fas fa-check-circle me-1"></i>
                            ${file.name} (${(file.size / 1024).toFixed(1)} KB)
                        </p>
                        <p class="small text-muted mb-0 mt-1">
                            ${file.type} • ${input.files[0].width} x ${input.files[0].height} px
                        </p>
                    </div>
                `;
            }
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = `
                <div class="border rounded p-4 text-center bg-white">
                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-3"></i>
                    <p class="text-muted small mb-0">Preview foto akan muncul di sini</p>
                </div>
            `;
        }
    }
</script>
@endpush
@endsection