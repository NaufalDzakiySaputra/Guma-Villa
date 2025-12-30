{{-- resources/views/user/reservations/index.blade.php --}}
@extends('layouts.frontend')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Reservasi Saya</h2>
            <a href="{{ route('user.paket') }}" class="btn btn-outline-primary">
                <i class="fas fa-plus me-1"></i> Pesan Baru
            </a>
        </div>
        
        @if($reservations->count() > 0)
        <div class="row">
            @foreach($reservations as $reservation)
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-{{ $reservation->status == 'approved' ? 'success' : ($reservation->status == 'pending' ? 'warning' : 'danger') }} mb-2">
                                    {{ strtoupper($reservation->status) }}
                                </span>
                                <h5 class="fw-bold mb-1">{{ $reservation->packages->nama ?? 'Paket' }}</h5>
                                <small class="text-muted">#{{ $reservation->id }} • {{ $reservation->created_at->format('d M Y') }}</small>
                            </div>
                            <span class="badge bg-info">{{ ucfirst($reservation->service_type) }}</span>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Check-in</small>
                                <strong>{{ $reservation->checkin_date->format('d/m/Y') }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Check-out</small>
                                <strong>{{ $reservation->checkout_date->format('d/m/Y') }}</strong>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <small class="text-muted d-block">Jumlah Orang</small>
                                <strong>{{ $reservation->jumlah_orang }} orang</strong>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">Total</small>
                                <strong class="text-primary">IDR {{ number_format($reservation->total_amount, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted d-block">Status Pembayaran</small>
                            <span class="badge bg-{{ $reservation->payment_status == 'verified' ? 'success' : ($reservation->payment_status == 'paid' ? 'info' : 'warning') }}">
                                {{ strtoupper($reservation->payment_status) }}
                            </span>
                            @if($reservation->payment_method)
                                <small class="text-muted ms-2">({{ ucfirst($reservation->payment_method) }})</small>
                            @endif
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('user.reservation.show', $reservation->id) }}" 
                               class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i> Detail
                            </a>
                            
                            @if($reservation->payment_status == 'pending' && in_array($reservation->payment_method, ['transfer', 'bank', 'qris']) && $reservation->payments->count() > 0)
                            <a href="{{ route('user.payment.upload', $reservation->payments->first()->id) }}" 
                               class="btn btn-warning btn-sm flex-fill">
                                <i class="fas fa-upload me-1"></i> Upload Bukti
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $reservations->links() }}
        </div>
        
        @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-calendar-times fa-4x text-muted"></i>
            </div>
            <h4 class="text-muted mb-3">Belum Ada Reservasi</h4>
            <p class="text-muted mb-4">Yuk, pesan paket liburan menarik untuk pengalaman tak terlupakan!</p>
            <a href="{{ route('user.paket') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-search me-2"></i> Lihat Paket Tersedia
            </a>
        </div>
        @endif
    </div>
</section>
@endsection