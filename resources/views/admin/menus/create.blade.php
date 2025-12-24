@extends('layouts.admin')

@section('page-title', 'Tambah Menu Baru')
@section('page-subtitle', 'Tambahkan menu makanan atau minuman')

@section('page-actions')
    <a href="{{ route('menus.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-plus-circle me-2"></i>Form Tambah Menu
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-lg-8">
                    <div class="mb-4">
                        <label for="name" class="form-label">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Contoh: Kopi Arabica Special"
                               required
                               autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Beri nama yang menarik untuk menu Anda.
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="form-label">Deskripsi Menu</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Deskripsikan bahan-bahan, rasa, atau informasi tambahan...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Deskripsi akan ditampilkan di halaman menu.
                        </div>
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
                                       value="{{ old('price') }}" 
                                       min="0"
                                       step="500"
                                       placeholder="25000"
                                       required>
                                <span class="input-group-text bg-soft-primary">,00</span>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Harga normal sebelum diskon.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label for="discount" class="form-label">Diskon (%)</label>
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
                                       value="{{ old('discount') }}" 
                                       min="0"
                                       max="100"
                                       step="1"
                                       placeholder="20">
                                <span class="input-group-text bg-soft-primary">%</span>
                            </div>
                            @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Masukkan persentase diskon (0-100%). Kosongkan jika tidak ada diskon.
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="col-lg-4">
                    <div class="card bg-soft-primary border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-image me-2"></i>Gambar Menu
                            </h6>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Gambar</label>
                                <input type="file" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       id="image" 
                                       name="image"
                                       accept="image/*"
                                       onchange="previewImage(this, 'imagePreview')">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text small">
                                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
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
                    
                    <!-- Kalkulator Harga -->
                    <div class="card bg-soft-info border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-calculator me-2"></i>Kalkulator Harga
                            </h6>
                            <div class="small">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Harga Normal:</span>
                                    <span id="hargaNormalDisplay" class="fw-bold">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Diskon:</span>
                                    <span id="diskonDisplay" class="fw-bold text-danger">0%</span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Hemat:</span>
                                    <span id="hematDisplay" class="fw-bold text-success">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Harga Akhir:</span>
                                    <span id="hargaAkhirDisplay" class="fw-bold text-accent">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-soft-primary border-0">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-lightbulb me-2"></i>Tips
                            </h6>
                            <ul class="small text-muted mb-0">
                                <li class="mb-2">Gunakan diskon untuk menu spesial</li>
                                <li class="mb-2">Upload gambar menarik meningkatkan penjualan</li>
                                <li class="mb-2">Deskripsi yang jelas membantu pelanggan</li>
                                <li>Harga dapat diupdate kapan saja</li>
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
                    <i class="fas fa-save me-1"></i>Simpan Menu
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Kalkulator harga real-time
    function updatePriceCalculator() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const discount = parseFloat(document.getElementById('discount').value) || 0;
        
        // Hitung
        const discountAmount = price * (discount / 100);
        const finalPrice = price - discountAmount;
        
        // Update display
        document.getElementById('hargaNormalDisplay').textContent = 
            'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('diskonDisplay').textContent = 
            discount + '%';
        document.getElementById('hematDisplay').textContent = 
            'Rp ' + discountAmount.toLocaleString('id-ID');
        document.getElementById('hargaAkhirDisplay').textContent = 
            'Rp ' + finalPrice.toLocaleString('id-ID');
    }
    
    // Event listeners untuk kalkulator
    document.getElementById('price').addEventListener('input', updatePriceCalculator);
    document.getElementById('discount').addEventListener('input', updatePriceCalculator);
    
    // Jalankan kalkulator saat page load
    document.addEventListener('DOMContentLoaded', updatePriceCalculator);
    
    // Image preview function (sudah ada di layout)
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
@endpush
@endsection