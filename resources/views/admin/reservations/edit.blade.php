@extends('layouts.admin')

@section('page-title', 'Edit Reservasi #' . $reservation->id)
@section('page-actions')
    <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <h6 class="mb-3">Informasi Reservasi</h6>
                        <div class="border rounded p-3">
                            <p class="mb-1"><strong>ID:</strong> #{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</p>
                            <p class="mb-1"><strong>Customer:</strong> {{ $reservation->user->name ?? 'Guest' }}</p>
                            <p class="mb-0"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $reservation->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $reservation->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" class="form-control" rows="3">{{ $reservation->notes }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Quick Actions</h6>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-sm btn-success" 
                            onclick="document.querySelector('select[name=\"status\"]').value='approved';">
                        Setujui
                    </button>
                    <button type="button" class="btn btn-sm btn-warning" 
                            onclick="document.querySelector('select[name=\"status\"]').value='pending';">
                        Set Pending
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" 
                            onclick="if(confirm('Tolak reservasi?')) document.querySelector('select[name=\"status\"]').value='rejected';">
                        Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection