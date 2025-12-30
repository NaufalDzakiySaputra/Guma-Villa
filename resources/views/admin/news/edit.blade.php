@extends('layouts.admin')

@section('page-title', 'Edit Berita: ' . $news->title)
@section('page-actions')
    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if($news->image_path)
        <div class="text-center mb-4">
            <p class="text-muted small mb-2">Gambar saat ini:</p>
            <img src="{{ asset('storage/' . $news->image_path) }}" 
                 alt="{{ $news->title }}" 
                 class="img-fluid rounded" 
                 style="max-height: 150px;">
            <p class="text-muted small mt-2">{{ basename($news->image_path) }}</p>
        </div>
        @endif
        
        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label">Judul *</label>
                        <input type="text" 
                               name="title" 
                               class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title', $news->title) }}"
                               required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi *</label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="5" 
                                  required>{{ old('description', $news->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Event *</label>
                        <input type="date" 
                               name="event_date" 
                               class="form-control @error('event_date') is-invalid @enderror" 
                               value="{{ old('event_date', $news->event_date->format('Y-m-d')) }}"
                               required>
                        @error('event_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Ubah Gambar</label>
                        <input type="file" 
                               name="image" 
                               class="form-control @error('image') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewImage(this, 'imagePreview')">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text small">Kosongkan jika tidak ingin mengubah</div>
                        
                        <div class="mt-3 border rounded p-3" id="imagePreview">
                            <p class="text-muted small mb-0">Preview gambar baru</p>
                        </div>
                    </div>
                    
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="card-title small"><i class="fas fa-info-circle me-1"></i> Info Berita</h6>
                            <ul class="small text-muted mb-0">
                                <li>ID: {{ $news->id }}</li>
                                <li>Dibuat: {{ $news->created_at->format('d/m/Y') }}</li>
                                <li>Diupdate: {{ $news->updated_at->format('d/m/Y') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Berita
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
                        <i class="fas fa-exclamation-triangle me-1"></i> Gambar baru
                    </p>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '<p class="text-muted small mb-0">Preview gambar baru</p>';
    }
}
</script>
@endsection