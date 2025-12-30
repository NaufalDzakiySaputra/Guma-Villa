@extends('layouts.admin')

@section('page-title', 'Edit Menu: ' . $menu->name)
@section('page-actions')
    <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if($menu->image_path)
        <div class="text-center mb-4">
            <p class="text-muted small mb-2">Gambar saat ini:</p>
            <img src="{{ asset($menu->image_path) }}" 
                 alt="{{ $menu->name }}" 
                 class="img-fluid rounded" 
                 style="max-height: 150px;">
            <p class="text-muted small mt-2">{{ basename($menu->image_path) }}</p>
        </div>
        @endif
        
        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label">Nama Menu *</label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $menu->name) }}"
                               required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="3">{{ old('description', $menu->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Harga (Rp) *</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       name="price" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price', $menu->price) }}"
                                       min="0" 
                                       required>
                            </div>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Diskon (%)</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" 
                                       name="discount" 
                                       class="form-control @error('discount') is-invalid @enderror" 
                                       value="{{ old('discount', $menu->discount) }}"
                                       min="0"
                                       max="100">
                            </div>
                            @error('discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
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
                            <h6 class="card-title small"><i class="fas fa-info-circle me-1"></i> Info Menu</h6>
                            <ul class="small text-muted mb-0">
                                <li>ID: {{ $menu->id }}</li>
                                <li>Dibuat: {{ $menu->created_at->format('d/m/Y') }}</li>
                                <li>Diupdate: {{ $menu->updated_at->format('d/m/Y') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Menu
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