@extends('layouts.admin')

@section('title', 'Detail Reservasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-eye me-2"></i>Detail Reservasi #{{ $reservation->id }}</h4>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="row">
        <!-- Info Pelanggan -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header"><h6 class="mb-0">Data Pelanggan</h6></div>
                <div class="card-body">
                    <p><strong>Nama Lengkap:</strong> {{ $reservation->nama_lengkap }}</p>
                    <p><strong>NIK:</strong> {{ $reservation->nik }}</p>
                    <p><strong>Telepon:</strong> {{ $reservation->no_telepon }}</p>
                    <p><strong>Email User:</strong> {{ $reservation->user->email ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Info Reservasi -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header"><h6 class="mb-0">Detail Reservasi</h6></div>
                <div class="card-body">
                    <p><strong>Jenis Layanan:</strong> {{ ucfirst($reservation->service_type) }}</p>
                    <p><strong>Paket:</strong> {{ $reservation->packages->nama ?? '-' }}</p>
                    <p><strong>Tanggal Reservasi:</strong> {{ $reservation->date->format('d F Y') }}</p>
                    <p><strong>Check-in:</strong> {{ $reservation->checkin_date->format('d F Y') }}</p>
                    <p><strong>Check-out:</strong> {{ $reservation->checkout_date->format('d F Y') }}</p>
                    <p><strong>Jumlah Orang:</strong> {{ $reservation->jumlah_orang }}</p>
                    <p><strong>Total Amount:</strong> Rp {{ number_format($reservation->total_amount, 0, ',', '.') }}</p>
                    <p><strong>Metode Bayar:</strong> {{ ucfirst($reservation->payment_method ?? '-') }}</p>
                    <p><strong>Status:</strong> 
                        @if($reservation->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($reservation->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </p>
                    <p><strong>Status Pembayaran:</strong> 
                        @if($reservation->payment_status == 'pending')
                            <span class="badge bg-danger">Pending</span>
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

    <!-- Payments History -->
    @if($reservation->payments->count() > 0)
    <div class="card mb-3">
        <div class="card-header"><h6 class="mb-0">Riwayat Pembayaran</h6></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Paid At</th>
                            <th>Verified At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservation->payments as $payment)
                        <tr>
                            <td>{{ $payment->transaction_code }}</td>
                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>{{ $payment->method }}</td>
                            <td>
                                @if($payment->status == 'pending') <span class="badge bg-warning">Pending</span>
                                @elseif($payment->status == 'paid') <span class="badge bg-success">Paid</span>
                                @elseif($payment->status == 'verified') <span class="badge bg-info">Verified</span>
                                @else <span class="badge bg-danger">{{ ucfirst($payment->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ $payment->verified_at ? $payment->verified_at->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Notes -->
    @if($reservation->notes)
    <div class="card mb-3">
        <div class="card-header"><h6 class="mb-0">Catatan</h6></div>
        <div class="card-body">
            <p>{{ $reservation->notes }}</p>
        </div>
    </div>
    @endif

    <!-- Actions -->
    <div class="d-flex justify-content-between">
        <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus reservasi ini?')">
                <i class="fas fa-trash me-1"></i>Hapus
            </button>
        </form>
    </div>
</div>
@endsection