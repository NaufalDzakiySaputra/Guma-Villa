@extends('layouts.admin')

@section('page-title', 'Edit Foto')
@section('page-actions')
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="text-center mb-4">
            <p class="text-muted small mb-2">Foto saat ini:</p>
            <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                 alt="{{ $gallery->title ?? 'Foto' }}"
                 class="img-fluid rounded" 
                 style="max-height: 200px;">
        </div>
        
        <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label">Judul (Opsional)</label>
                        <input type="text" 
                               name="title" 
                               class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title', $gallery->title) }}">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Ganti Foto</label>
                        <input type="file" 
                               name="image" 
                               class="form-control @error('image') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewImage(this, 'imagePreview')">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text small">Kosongkan jika tidak ingin mengubah</div>
                        
                        <div class="mt-3 border rounded p-3" id="imagePreview">
                            <p class="text-muted small mb-0">Preview foto baru</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Foto
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="text-center">
                    <img src="${e.target.result}" class="img-fluid rounded mb-2" style="max-height: 150px;">
                    <p class="small text-warning mb-0">
                        <i class="fas fa-exclamation-triangle me-1"></i> Foto baru
                    </p>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '<p class="text-muted small mb-0">Preview foto baru</p>';
    }
}
</script>
@endsection