@extends('layouts.admin')

@section('page-title', 'Tambah Menu Baru')
@section('page-actions')
    <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-3">
                <!-- Kolom Kiri -->
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label">Nama Menu *</label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}"
                               required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="3">{{ old('description') }}</textarea>
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
                                       value="{{ old('price') }}"
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
                                       value="{{ old('discount', 0) }}"
                                       min="0"
                                       max="100">
                            </div>
                            @error('discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Gambar Menu</label>
                        <input type="file" 
                               name="image" 
                               class="form-control @error('image') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewImage(this, 'imagePreview')">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text small">Format: JPG, PNG. Maks. 2MB</div>
                        
                        <div class="mt-3 border rounded p-3" id="imagePreview">
                            <p class="text-muted small mb-0">Preview gambar</p>
                        </div>
                    </div>
                    
                    <!-- Info Harga -->
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="card-title small"><i class="fas fa-info-circle me-1"></i> Info Harga</h6>
                            <div class="small text-muted mb-2">Diskon: <span id="diskonDisplay">0</span>%</div>
                            <div class="small text-muted">Harga Akhir: Rp <span id="hargaAkhirDisplay">0</span></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Menu
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
                    <p class="small text-success mb-0">
                        <i class="fas fa-check-circle me-1"></i> ${file.name}
                    </p>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '<p class="text-muted small mb-0">Preview gambar</p>';
    }
}

// Kalkulator sederhana
document.querySelector('input[name="price"]').addEventListener('input', updateHarga);
document.querySelector('input[name="discount"]').addEventListener('input', updateHarga);

function updateHarga() {
    const price = parseFloat(document.querySelector('input[name="price"]').value) || 0;
    const discount = parseFloat(document.querySelector('input[name="discount"]').value) || 0;
    const finalPrice = price - (price * discount / 100);
    
    document.getElementById('diskonDisplay').textContent = discount;
    document.getElementById('hargaAkhirDisplay').textContent = finalPrice.toLocaleString('id-ID');
}
</script>
@endsection