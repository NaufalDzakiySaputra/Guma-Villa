@extends('layouts.admin')

@section('page-title', 'Edit Menu')
@section('page-subtitle', 'Perbarui informasi menu')

@section('page-actions')
    <a href="{{ route('menus.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2"></i>Edit Menu: {{ $menu->name }}
            </h5>
            <div class="d-flex gap-2">
                <a href="{{ route('menus.create') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus me-1"></i>Tambah Baru
                </a>
                <form id="delete-menu-{{ $menu->id }}" 
                      action="{{ route('menus.destroy', $menu->id) }}" 
                      method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" 
                            class="btn btn-sm btn-danger"
                            onclick="confirmDelete(event, 'delete-menu-{{ $menu->id }}')">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Gambar Saat Ini -->
        @if($menu->image_path)
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2">
                <div class="card bg-soft-primary border-0">
                    <div class="card-body">
                        <h6 class="card-title text-accent mb-3">
                            <i class="fas fa-image me-2"></i>Gambar Saat Ini
                        </h6>
                        <div class="text-center">
                            <img src="{{ asset($menu->image_path) }}" 
                                 alt="{{ $menu->name }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 250px; max-width: 100%;">
                            <p class="text-muted small mt-2 mb-0">
                                {{ basename($menu->image_path) }}
                            </p>
                            <div class="mt-3">
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="removeImage()">
                                    <i class="fas fa-trash me-1"></i>Hapus Gambar Ini
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Input hidden untuk hapus gambar -->
            <input type="hidden" id="remove_image" name="remove_image" value="0">
            
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-lg-8">
                    <div class="mb-4">
                        <label for="name" class="form-label">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $menu->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="form-label">Deskripsi Menu</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4">{{ old('description', $menu->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="price" class="form-label">Harga Normal (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-soft-primary border-end-0">
                                    <i class="fas fa-tag text-accent"></i>
                                </span>
                                <input type="number" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price', $menu->price) }}" 
                                       min="0"
                                       step="500"
                                       required>
                                <span class="input-group-text bg-soft-primary">,00</span>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label for="discount" class="form-label">Diskon (%)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-soft-primary border-end-0">
                                    <i class="fas fa-percentage text-accent"></i>
                                </span>
                                <input type="number" 
                                       class="form-control @error('discount') is-invalid @enderror" 
                                       id="discount" 
                                       name="discount" 
                                       value="{{ old('discount', $menu->discount) }}" 
                                       min="0"
                                       max="100"
                                       step="1">
                                <span class="input-group-text bg-soft-primary">%</span>
                            </div>
                            @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Kosongkan atau isi 0 untuk menghapus diskon.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info Harga Saat Ini -->
                    <div class="card bg-soft-info border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-info-circle me-2"></i>Informasi Harga Saat Ini
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Harga Normal</label>
                                        <div class="fw-bold text-accent">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Diskon</label>
                                        <div>
                                            @if($menu->discount > 0)
                                                <span class="badge bg-danger me-2">
                                                    -{{ number_format($menu->discount, 0) }}%
                                                </span>
                                                <span class="text-success fw-bold">
                                                    Rp {{ number_format($menu->harga_diskon, 0, ',', '.') }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Tidak ada diskon</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="col-lg-4">
                    <!-- Upload Gambar Baru -->
                    <div class="card bg-soft-primary border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-upload me-2"></i>{{ $menu->image_path ? 'Ganti Gambar' : 'Upload Gambar' }}
                            </h6>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">File Gambar Baru</label>
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
                                    Kosongkan jika tidak ingin mengubah gambar.
                                </div>
                            </div>
                            
                            <!-- Preview Gambar Baru -->
                            <div class="mt-3">
                                <div id="newImagePreview">
                                    <div class="border rounded p-3 text-center bg-white">
                                        <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                        <p class="text-muted small mb-0">Preview gambar baru</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kalkulator Harga -->
                    <div class="card bg-soft-info border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-calculator me-2"></i>Preview Perubahan
                            </h6>
                            <div class="small">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Harga Baru:</span>
                                    <span id="newPriceDisplay" class="fw-bold">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Diskon Baru:</span>
                                    <span id="newDiscountDisplay" class="fw-bold text-danger">0%</span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Harga Akhir:</span>
                                    <span id="finalPriceDisplay" class="fw-bold text-accent">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Perubahan:</span>
                                    <span id="priceChangeDisplay" class="fw-bold">± Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info Menu -->
                    <div class="card bg-soft-primary border-0">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-info-circle me-2"></i>Info Menu
                            </h6>
                            <div class="small text-muted">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>ID Menu:</span>
                                    <span class="fw-bold">{{ $menu->id }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Dibuat:</span>
                                    <span>{{ $menu->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Diupdate:</span>
                                    <span>{{ $menu->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                                @if($menu->user_id)
                                <div class="d-flex justify-content-between">
                                    <span>User ID:</span>
                                    <span>{{ $menu->user_id }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('menus.index') }}" class="btn btn-secondary">
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
    // Kalkulator harga
    function updatePriceCalculator() {
        const currentPrice = parseFloat({{ $menu->price }}) || 0;
        const currentDiscount = parseFloat({{ $menu->discount }}) || 0;
        const newPrice = parseFloat(document.getElementById('price').value) || currentPrice;
        const newDiscount = parseFloat(document.getElementById('discount').value) || 0;
        
        // Hitung harga lama
        const oldDiscountedPrice = currentPrice - (currentPrice * (currentDiscount / 100));
        
        // Hitung harga baru
        const newDiscountedPrice = newPrice - (newPrice * (newDiscount / 100));
        
        // Perubahan harga
        const priceChange = newDiscountedPrice - oldDiscountedPrice;
        
        // Update display
        document.getElementById('newPriceDisplay').textContent = 
            'Rp ' + newPrice.toLocaleString('id-ID');
        document.getElementById('newDiscountDisplay').textContent = 
            newDiscount + '%';
        document.getElementById('finalPriceDisplay').textContent = 
            'Rp ' + newDiscountedPrice.toLocaleString('id-ID');
        
        // Tampilkan perubahan harga
        const priceChangeElem = document.getElementById('priceChangeDisplay');
        if (priceChange > 0) {
            priceChangeElem.textContent = '+ Rp ' + Math.abs(priceChange).toLocaleString('id-ID');
            priceChangeElem.className = 'fw-bold text-danger';
        } else if (priceChange < 0) {
            priceChangeElem.textContent = '- Rp ' + Math.abs(priceChange).toLocaleString('id-ID');
            priceChangeElem.className = 'fw-bold text-success';
        } else {
            priceChangeElem.textContent = '± Rp 0';
            priceChangeElem.className = 'fw-bold';
        }
    }
    
    // Event listeners untuk kalkulator
    document.getElementById('price').addEventListener('input', updatePriceCalculator);
    document.getElementById('discount').addEventListener('input', updatePriceCalculator);
    
    // Hapus gambar
    function removeImage() {
        if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
            document.getElementById('remove_image').value = '1';
            
            // Sembunyikan gambar saat ini
            const currentImageCard = document.querySelector('.card .text-center');
            if (currentImageCard) {
                currentImageCard.innerHTML = `
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Gambar akan dihapus saat perubahan disimpan
                    </div>
                `;
            }
        }
    }
    
    // Preview gambar baru
    function previewNewImage(input, previewId) {
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
                <div class="border rounded p-3 text-center bg-white">
                    <i class="fas fa-image fa-2x text-muted mb-2"></i>
                    <p class="text-muted small mb-0">Preview gambar baru</p>
                </div>
            `;
        }
    }
    
    // Inisialisasi kalkulator saat page load
    document.addEventListener('DOMContentLoaded', function() {
        updatePriceCalculator();
    });
</script>
@endpush
@endsection