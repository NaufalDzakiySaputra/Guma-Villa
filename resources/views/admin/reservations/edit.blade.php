<!-- resources/views/admin/reservations/edit.blade.php -->
@extends('admin.layouts.admin')

@section('page-title', 'Edit Reservasi #' . $reservation->id)
@section('page-subtitle', 'Perbarui status reservasi')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-soft-primary">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Edit Reservasi
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Informasi Reservasi -->
                    <div class="mb-3">
                        <h6 class="text-accent">Informasi Reservasi</h6>
                        <div class="border rounded p-3 bg-light">
                            <p class="mb-1"><strong>ID:</strong> #{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</p>
                            <p class="mb-1"><strong>Customer:</strong> {{ $reservation->user->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Layanan:</strong> 
                                @switch($reservation->service_type)
                                    @case('villa') Villa @break
                                    @case('wisata') Paket Wisata @break
                                    @case('nikah') Wedding @break
                                    @case('mice') MICE @break
                                @endswitch
                            </p>
                            <p class="mb-0"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Status Reservasi -->
                    <div class="mb-3">
                        <label class="form-label">Status Reservasi <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ old('status', $reservation->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $reservation->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $reservation->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Pembayaran -->
                    <div class="mb-3">
                        <label class="form-label">Status Pembayaran <span class="text-danger">*</span></label>
                        <select name="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                            <option value="unpaid" {{ old('payment_status', $reservation->payment_status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ old('payment_status', $reservation->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="verified" {{ old('payment_status', $reservation->payment_status) == 'verified' ? 'selected' : '' }}>Verified</option>
                        </select>
                        @error('payment_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Catatan Admin -->
                    <div class="mb-4">
                        <label class="form-label">Catatan Admin</label>
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                  rows="4" placeholder="Tambah catatan untuk reservasi ini...">{{ old('notes', $reservation->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <div>
                            <button type="button" class="btn btn-outline-danger me-2" 
                                    onclick="if(confirm('Hapus reservasi ini?')) document.getElementById('deleteForm').submit();">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Delete Form (hidden) -->
                <form id="deleteForm" action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Status Guide</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span class="badge bg-warning me-2">Pending</span>
                    <small class="text-muted">Menunggu konfirmasi admin</small>
                </div>
                <div class="mb-3">
                    <span class="badge bg-success me-2">Approved</span>
                    <small class="text-muted">Reservasi disetujui</small>
                </div>
                <div class="mb-3">
                    <span class="badge bg-danger me-2">Rejected</span>
                    <small class="text-muted">Reservasi ditolak</small>
                </div>
                <hr>
                <div class="mb-3">
                    <span class="badge bg-secondary me-2">Unpaid</span>
                    <small class="text-muted">Belum bayar</small>
                </div>
                <div class="mb-3">
                    <span class="badge bg-success me-2">Paid</span>
                    <small class="text-muted">Sudah bayar</small>
                </div>
                <div class="mb-0">
                    <span class="badge bg-info me-2">Verified</span>
                    <small class="text-muted">Pembayaran terverifikasi</small>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-sm btn-success" 
                            onclick="document.querySelector('select[name=\"status\"]').value='approved'; document.querySelector('select[name=\"payment_status\"]').value='paid';">
                        <i class="fas fa-check me-1"></i> Setujui & Tandai Paid
                    </button>
                    <button type="button" class="btn btn-sm btn-warning" 
                            onclick="document.querySelector('select[name=\"status\"]').value='pending';">
                        <i class="fas fa-clock me-1"></i> Set ke Pending
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" 
                            onclick="if(confirm('Tolak reservasi ini?')) { document.querySelector('select[name=\"status\"]').value='rejected'; }">
                        <i class="fas fa-times me-1"></i> Tolak Reservasi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-save draft atau validasi
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const originalData = {
            status: form.querySelector('[name="status"]').value,
            payment_status: form.querySelector('[name="payment_status"]').value,
            notes: form.querySelector('[name="notes"]').value
        };
        
        // Warning jika akan keluar halaman dengan perubahan yang belum disimpan
        window.addEventListener('beforeunload', function(e) {
            const currentData = {
                status: form.querySelector('[name="status"]').value,
                payment_status: form.querySelector('[name="payment_status"]').value,
                notes: form.querySelector('[name="notes"]').value
            };
            
            if (JSON.stringify(originalData) !== JSON.stringify(currentData)) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    });
</script>
@endpush