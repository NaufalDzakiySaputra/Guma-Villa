@extends('layouts.admin')

@section('page-title', 'Edit Berita/Event')
@section('page-subtitle', 'Perbarui informasi event atau promo')

@section('page-actions')
    <a href="{{ route('news.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2"></i>Edit: {{ $news->title }}
            </h5>
            <div class="d-flex gap-2">
                <a href="{{ route('news.create') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus me-1"></i>Tambah Baru
                </a>
                <form id="delete-news-{{ $news->id }}" 
                      action="{{ route('news.destroy', $news->id) }}" 
                      method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" 
                            class="btn btn-sm btn-danger"
                            onclick="confirmDelete(event, 'delete-news-{{ $news->id }}')">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Gambar Saat Ini -->
        @if($news->image_path)
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2">
                <div class="card bg-soft-primary border-0">
                    <div class="card-body">
                        <h6 class="card-title text-accent mb-3">
                            <i class="fas fa-image me-2"></i>Gambar Saat Ini
                        </h6>
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $news->image_path) }}" 
                                 alt="{{ $news->title }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 250px; max-width: 100%;">
                            <p class="text-muted small mt-2 mb-0">
                                {{ basename($news->image_path) }}
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

        <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Input hidden untuk hapus gambar -->
            <input type="hidden" id="remove_image" name="remove_image" value="0">
            
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-lg-8">
                    <div class="mb-4">
                        <label for="title" class="form-label">Judul Event/Promo <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $news->title) }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="6" 
                                  required>{{ old('description', $news->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="event_date" class="form-label">Tanggal Event <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control @error('event_date') is-invalid @enderror" 
                               id="event_date" 
                               name="event_date" 
                               value="{{ old('event_date', $news->event_date->format('Y-m-d')) }}" 
                               required>
                        @error('event_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Info Event Saat Ini -->
                    <div class="card bg-soft-info border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-info-circle me-2"></i>Informasi Saat Ini
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Tanggal Event</label>
                                        <div class="fw-bold text-accent">
                                            {{ $news->event_date->format('d/m/Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $news->event_date->translatedFormat('l') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Status</label>
                                        <div>
                                            @php
                                                $daysDiff = now()->diffInDays($news->event_date, false);
                                                if ($daysDiff < 0) {
                                                    $statusClass = 'danger';
                                                    $statusText = 'Event Selesai';
                                                } elseif ($daysDiff == 0) {
                                                    $statusClass = 'success';
                                                    $statusText = 'Hari Ini';
                                                } elseif ($daysDiff <= 7) {
                                                    $statusClass = 'warning';
                                                    $statusText = 'Minggu Ini';
                                                } else {
                                                    $statusClass = 'info';
                                                    $statusText = 'Akan Datang';
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }} me-2">
                                                {{ $statusText }}
                                            </span>
                                            <span class="text-{{ $statusClass }} small">
                                                {{ abs($daysDiff) }} hari {{ $daysDiff > 0 ? 'lagi' : 'yang lalu' }}
                                            </span>
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
                                <i class="fas fa-upload me-2"></i>{{ $news->image_path ? 'Ganti Gambar' : 'Upload Gambar' }}
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
                    
                    <!-- Preview Perubahan -->
                    <div class="card bg-soft-info border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-calendar-check me-2"></i>Preview Perubahan
                            </h6>
                            <div class="small">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tanggal Baru:</span>
                                    <span id="newDateDisplay" class="fw-bold">-</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Status Baru:</span>
                                    <span id="newStatusDisplay" class="fw-bold">-</span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Perubahan:</span>
                                    <span id="dateChangeDisplay" class="fw-bold">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info News -->
                    <div class="card bg-soft-primary border-0">
                        <div class="card-body">
                            <h6 class="card-title text-accent mb-3">
                                <i class="fas fa-info-circle me-2"></i>Info Berita
                            </h6>
                            <div class="small text-muted">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>ID Berita:</span>
                                    <span class="fw-bold">{{ $news->id }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Dibuat:</span>
                                    <span>{{ $news->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Diupdate:</span>
                                    <span>{{ $news->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                                @if($news->user_id)
                                <div class="d-flex justify-content-between">
                                    <span>User ID:</span>
                                    <span>{{ $news->user_id }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('news.index') }}" class="btn btn-secondary">
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
    // Format tanggal
    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }
    
    // Hitung status event
    function calculateStatus(eventDate) {
        const today = new Date();
        const event = new Date(eventDate);
        const timeDiff = event.getTime() - today.getTime();
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
        
        if (daysDiff < 0) {
            return { text: 'Event Selesai', class: 'danger', days: Math.abs(daysDiff) };
        } else if (daysDiff === 0) {
            return { text: 'Hari Ini', class: 'success', days: 0 };
        } else if (daysDiff <= 7) {
            return { text: 'Minggu Ini', class: 'warning', days: daysDiff };
        } else {
            return { text: 'Akan Datang', class: 'info', days: daysDiff };
        }
    }
    
    // Update preview perubahan
    function updateChangePreview() {
        const oldDate = new Date('{{ $news->event_date->format("Y-m-d") }}');
        const newDateStr = document.getElementById('event_date').value;
        
        if (!newDateStr) return;
        
        const newDate = new Date(newDateStr);
        
        // Format tanggal baru
        document.getElementById('newDateDisplay').textContent = 
            newDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        
        // Status baru
        const newStatus = calculateStatus(newDateStr);
        const statusDisplay = document.getElementById('newStatusDisplay');
        statusDisplay.textContent = newStatus.text;
        statusDisplay.className = `fw-bold text-${newStatus.class}`;
        
        // Perubahan tanggal
        const dayDiff = Math.ceil((newDate - oldDate) / (1000 * 3600 * 24));
        const dateChangeDisplay = document.getElementById('dateChangeDisplay');
        
        if (dayDiff > 0) {
            dateChangeDisplay.textContent = `+${dayDiff} hari`;
            dateChangeDisplay.className = 'fw-bold text-danger';
        } else if (dayDiff < 0) {
            dateChangeDisplay.textContent = `${dayDiff} hari`;
            dateChangeDisplay.className = 'fw-bold text-success';
        } else {
            dateChangeDisplay.textContent = 'Tidak berubah';
            dateChangeDisplay.className = 'fw-bold';
        }
    }
    
    // Event listener untuk tanggal
    document.getElementById('event_date').addEventListener('change', updateChangePreview);
    
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
    
    // Inisialisasi saat page load
    document.addEventListener('DOMContentLoaded', function() {
        updateChangePreview();
    });
</script>
@endpush
@endsection