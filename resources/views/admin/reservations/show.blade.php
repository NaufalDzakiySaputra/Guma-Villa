@extends('layouts.admin')

@section('title', 'Detail Reservasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-eye me-2"></i>Detail Reservasi #{{ $reservation->id }}
        </h4>
        <div>
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Informasi Customer</h6>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $reservation->user->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $reservation->user->email ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Detail Reservasi</h6>
                </div>
                <div class="card-body">
                    <p><strong>Jenis:</strong> {{ $reservation->service_type }}</p>
                    <p><strong>Paket:</strong> {{ $reservation->package->name ?? '-' }}</p>
                    <p><strong>Tanggal:</strong> {{ $reservation->date->format('d F Y') }}</p>
                    <p><strong>Status:</strong> 
                        @if($reservation->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($reservation->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </p>
                    <p><strong>Pembayaran:</strong> 
                        @if($reservation->payment_status == 'unpaid')
                            <span class="badge bg-danger">Unpaid</span>
                        @elseif($reservation->payment_status == 'paid')
                            <span class="badge bg-warning">Paid</span>
                        @else
                            <span class="badge bg-success">Verified</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if($reservation->notes)
    <div class="card mb-3">
        <div class="card-header">
            <h6 class="mb-0">Catatan</h6>
        </div>
        <div class="card-body">
            <p>{{ $reservation->notes }}</p>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between">
        <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" 
                    onclick="return confirm('Hapus reservasi ini?')">
                <i class="fas fa-trash me-1"></i>Hapus
            </button>
        </form>
    </div>
</div>
@endsection