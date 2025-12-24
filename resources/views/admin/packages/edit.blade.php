@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-edit me-2"></i>Edit Paket: {{ $package->nama }}
        </h5>
        <a href="{{ route('packages.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Tampilkan gambar saat ini -->
            @if($package->image_path)
            <div class="row mb-4">
                <div class="col-md-8 offset-md-2">
                    <div class="text-center">
                        <p class="text-muted mb-2">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $package->image_path) }}" 
                             alt="{{ $package->nama }}" 
                             class="img-fluid rounded" 
                             style="max-height: 200px;">
                        <p class="text-muted small mt-2">
                            {{ basename($package->image_path) }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Paket <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" 
                               name="nama" 
                               value="{{ old('nama', $package->nama) }}" 
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
                                  rows="4">{{ old('description', $package->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                                       value="{{ old('price', $package->price) }}" 
                                       min="0" 
                                       step="1000"
                                       required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="service_type" class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                            <select class="form-select @error('service_type') is-invalid @enderror" 
                                    id="service_type" 
                                    name="service_type" 
                                    required>
                                <option value="villa" {{ old('service_type', $package->service_type) == 'villa' ? 'selected' : '' }}>Villa</option>
                                <option value="wisata" {{ old('service_type', $package->service_type) == 'wisata' ? 'selected' : '' }}>Paket Wisata</option>
                                <option value="nikah" {{ old('service_type', $package->service_type) == 'nikah' ? 'selected' : '' }}>Perkawinan</option>
                                <option value="mice" {{ old('service_type', $package->service_type) == 'mice' ? 'selected' : '' }}>MICE (Meeting)</option>
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
                        <label for="image" class="form-label">Ubah Gambar</label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image"
                               accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Kosongkan jika tidak ingin mengubah gambar.
                        </div>
                        
                        <!-- Preview Image Baru -->
                        <div class="mt-3" id="imagePreview">
                            <p class="text-muted small">Preview gambar baru</p>
                        </div>
                    </div>
                    
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-info-circle me-1"></i>Info Paket
                            </h6>
                            <ul class="small text-muted mb-0">
                                <li>ID: {{ $package->id }}</li>
                                <li>Dibuat: {{ $package->created_at->format('d/m/Y') }}</li>
                                <li>Diupdate: {{ $package->updated_at->format('d/m/Y') }}</li>
                                @if($package->user_id)
                                    <li>User ID: {{ $package->user_id }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('packages.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Update Paket
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Image Preview untuk gambar baru
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
                
                const info = document.createElement('div');
                info.classList.add('mt-2', 'small', 'text-success');
                info.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i> Gambar lama akan diganti`;
                preview.appendChild(info);
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endpush
@endsection