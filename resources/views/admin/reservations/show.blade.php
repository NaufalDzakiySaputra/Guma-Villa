<!-- resources/views/admin/reservations/show.blade.php -->
@extends('admin.layouts.admin')

@section('page-title', 'Detail Reservasi #' . $reservation->id)
@section('page-subtitle', 'Informasi lengkap reservasi')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-soft-primary">
                <h5 class="mb-0">Informasi Reservasi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID Reservasi:</strong> #{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <p><strong>Customer:</strong> {{ $reservation->user->name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $reservation->user->email ?? 'N/A' }}</p>
                        <p><strong>Telepon:</strong> {{ $reservation->user->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tanggal Reservasi:</strong> {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</p>
                        <p><strong>Layanan:</strong> 
                            @switch($reservation->service_type)
                                @case('villa') Villa @break
                                @case('wisata') Paket Wisata @break
                                @case('nikah') Wedding @break
                                @case('mice') MICE @break
                            @endswitch
                        </p>
                        <p><strong>Paket:</strong> {{ $reservation->package->name ?? 'Tidak ada paket' }}</p>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Status Reservasi:</strong>
                            @if($reservation->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($reservation->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status Pembayaran:</strong>
                            @if($reservation->payment_status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif($reservation->payment_status == 'verified')
                                <span class="badge bg-info">Verified</span>
                            @else
                                <span class="badge bg-secondary">Unpaid</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="mt-3">
                    <p><strong>Catatan:</strong></p>
                    <div class="border rounded p-3 bg-light">
                        {{ $reservation->notes ?? 'Tidak ada catatan' }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection