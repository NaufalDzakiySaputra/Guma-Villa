@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-plus-circle me-2"></i>Tambah Paket Wisata Baru
        </h5>
        <a href="{{ route('packages.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Paket <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" 
                               name="nama" 
                               value="{{ old('nama') }}" 
                               placeholder="Contoh: Paket Villa Premium 2 Hari 1 Malam"
                               required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Paket</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Deskripsikan fasilitas, keunggulan, dan informasi penting lainnya">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Deskripsi akan ditampilkan di halaman detail paket.
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price') }}" 
                                       min="0" 
                                       step="1000"
                                       placeholder="2500000"
                                       required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Harga dalam Rupiah.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="service_type" class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                            <select class="form-select @error('service_type') is-invalid @enderror" 
                                    id="service_type" 
                                    name="service_type" 
                                    required>
                                <option value="" disabled selected>Pilih Jenis Layanan</option>
                                <option value="villa" {{ old('service_type') == 'villa' ? 'selected' : '' }}>Villa</option>
                                <option value="wisata" {{ old('service_type') == 'wisata' ? 'selected' : '' }}>Paket Wisata</option>
                                <option value="nikah" {{ old('service_type') == 'nikah' ? 'selected' : '' }}>Perkawinan</option>
                                <option value="mice" {{ old('service_type') == 'mice' ? 'selected' : '' }}>MICE (Meeting)</option>
                            </select>
                            @error('service_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Paket</label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image"
                               accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Format: JPG, JPEG, PNG. Maksimal 2MB.
                        </div>
                        
                        <!-- Preview Image -->
                        <div class="mt-3" id="imagePreview">
                            <p class="text-muted small">Preview gambar akan muncul di sini</p>
                        </div>
                    </div>
                    
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-info-circle me-1"></i>Informasi
                            </h6>
                            <ul class="small text-muted mb-0">
                                <li>Pastikan data diisi dengan benar</li>
                                <li>Gambar akan ditampilkan di halaman paket</li>
                                <li>Harga bisa diupdate kapan saja</li>
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
                    <i class="fas fa-save me-1"></i>Simpan Paket
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Image Preview
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail', 'w-100');
                img.style.maxHeight = '200px';
                img.style.objectFit = 'cover';
                preview.innerHTML = '';
                preview.appendChild(img);
                
                // Tambahkan info file
                const info = document.createElement('div');
                info.classList.add('mt-2', 'small');
                info.innerHTML = `<i class="fas fa-check text-success me-1"></i> Gambar siap diupload`;
                preview.appendChild(info);
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Format price input
    document.getElementById('price').addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        this.value = value;
    });
</script>
@endpush
@endsection