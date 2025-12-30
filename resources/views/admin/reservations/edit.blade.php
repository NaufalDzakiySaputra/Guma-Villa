@extends('layouts.admin')

@section('title', 'Edit Reservasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-edit me-2"></i>Edit Reservasi #{{ $reservation->id }}
        </h4>
        <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
                @csrf @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Status Reservasi</label>
                    <select name="status" class="form-select" required>
                        <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $reservation->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $reservation->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="payment_status" class="form-select" required>
                        <option value="unpaid" {{ $reservation->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="paid" {{ $reservation->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="verified" {{ $reservation->payment_status == 'verified' ? 'selected' : '' }}>Verified</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Catatan (Opsional)</label>
                    <textarea name="notes" class="form-control" rows="3">{{ $reservation->notes }}</textarea>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection