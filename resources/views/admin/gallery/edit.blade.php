@extends('layouts.admin')

@section('page-title', 'Edit Foto Galeri')
@section('page-subtitle', 'Perbarui informasi foto')

@section('page-actions')
    <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Galeri
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2"></i>Edit Foto: {{ $gallery->title ?? 'Tanpa Judul' }}
            </h5>
            <form id="delete-gallery-{{ $gallery->id }}" 
                  action="{{ route('gallery.destroy', $gallery->id) }}" 
                  method="POST">
                @csrf
                @method('DELETE')
                <button type="button" 
                        class="btn btn-sm btn-danger"
                        onclick="confirmDelete(event, 'delete-gallery-{{ $gallery->id }}')">
                    <i class="fas fa-trash me-1"></i>Hapus Foto
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <!-- Foto Saat Ini -->
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <div class="card bg-soft-primary border-0">
                    <div class="card-body text-center">
                        <h6 class="card-title text-accent mb-3">
                            <i class="fas fa-image me-2"></i>Foto Saat Ini
                        </h6>
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                             alt="{{ $gallery->title ?? 'Gallery Image' }}"
                             class="img-fluid rounded mb-3"
                             style="max-height: 300px;">
                        <p class="text-muted small mb-0">
                            {{ basename($gallery->image_path) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-lg-8">
                    <div class="mb-4">
                        <label for="title" class="form-label">Judul Foto (Opsional)</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $gallery->title) }}" 
                               placeholder="Contoh: Acara Wedding Customer">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="col-lg-4">
                    <!-- Upload Foto Baru -->
                    <div class="card bg-soft-primary border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-upload me-2"></i>Ganti Foto
                            </h6>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">File Foto Baru</label>
                                <input type="file" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       id="image" 
                                       name="image"
                                       accept="image/*"
                                       onchange="previewNewImage(this, 'newImagePreview')">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text small">
                                    Kosongkan jika tidak ingin mengganti foto.
                                </div>
                            </div>
                            
                            <!-- Preview Foto Baru -->
                            <div class="mt-3">
                                <div id="newImagePreview">
                                    <div class="border rounded p-3 text-center bg-white">
                                        <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                        <p class="text-muted small mb-0">Preview foto baru</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info Foto -->
                    <div class="card bg-soft-primary border-0">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-info-circle me-2"></i>Info Foto
                            </h6>
                            <div class="small text-muted">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>ID Foto:</span>
                                    <span class="fw-bold">{{ $gallery->id }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Diunggah:</span>
                                    <span>{{ $gallery->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Diupdate:</span>
                                    <span>{{ $gallery->updated_at->format('d/m/Y') }}</span>
                                </div>
                                @if($gallery->uploaded_by)
                                <div class="d-flex justify-content-between">
                                    <span>Uploaded By:</span>
                                    <span>{{ $gallery->uploaded_by }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('gallery.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Preview foto baru
    function previewNewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <div class="text-center">
                        <img src="${e.target.result}" class="img-fluid rounded mb-2" style="max-height: 200px;">
                        <p class="small text-success mb-0">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Foto lama akan diganti
                        </p>
                    </div>
                `;
            }
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = `
                <div class="border rounded p-3 text-center bg-white">
                    <i class="fas fa-image fa-2x text-muted mb-2"></i>
                    <p class="text-muted small mb-0">Preview foto baru</p>
                </div>
            `;
        }
    }
</script>
@endpush
@endsection