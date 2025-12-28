@extends('layouts.admin')

@section('page-title', 'Detail Reservasi #' . $reservation->id)
@section('page-actions')
    <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="mb-3">Informasi Customer</h6>
                <p><strong>Nama:</strong> {{ $reservation->user->name ?? 'Guest' }}</p>
                <p><strong>Email:</strong> {{ $reservation->user->email ?? '-' }}</p>
                <p><strong>Telepon:</strong> {{ $reservation->user->phone ?? '-' }}</p>
            </div>
            
            <div class="col-md-6">
                <h6 class="mb-3">Informasi Reservasi</h6>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</p>
                <p><strong>Layanan:</strong> {{ ucfirst($reservation->service_type) }}</p>
                <p><strong>Status:</strong>
                    @if($reservation->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($reservation->status == 'approved')
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </p>
            </div>
        </div>
        
        @if($reservation->notes)
        <hr>
        <h6 class="mb-2">Catatan</h6>
        <div class="border rounded p-3">
            {{ $reservation->notes }}
        </div>
        @endif
    </div>
</div>
@endsection