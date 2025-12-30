{{-- resources/views/user/reservations/show.blade.php --}}
@extends('layouts.frontend')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Detail Reservasi #{{ $reservation->id }}</h2>
            <a href="{{ route('user.reservation.my') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
        
        <div class="row">
            {{-- LEFT COLUMN --}}
            <div class="col-lg-8">
                {{-- STATUS CARD --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <small class="text-muted d-block">Status Reservasi</small>
                                <span class="badge bg-{{ $reservation->status == 'approved' ? 'success' : ($reservation->status == 'pending' ? 'warning' : 'danger') }} fs-6 py-2 px-3">
                                    {{ strtoupper($reservation->status) }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Status Pembayaran</small>
                                <span class="badge bg-{{ $reservation->payment_status == 'verified' ? 'success' : ($reservation->payment_status == 'paid' ? 'info' : 'warning') }} fs-6 py-2 px-3">
                                    {{ strtoupper($reservation->payment_status) }}
                                </span>
                                @if($reservation->payment_method)
                                    <small class="text-muted">({{ ucfirst($reservation->payment_method) }})</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- PAKET INFO --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-box me-2"></i>Detail Paket</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <small class="text-muted d-block">Nama Paket</small>
                                <strong>{{ $reservation->packages->nama ?? '-' }}</strong>
                            </div>
                            <div class="col-md-4 mb-3">
                                <small class="text-muted d-block">Jenis Layanan</small>
                                <strong>{{ ucfirst($reservation->service_type) }}</strong>
                            </div>
                            <div class="col-md-4 mb-3">
                                <small class="text-muted d-block">Tanggal Reservasi</small>
                                <strong>{{ $reservation->created_at->format('d F Y H:i') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- TANGGAL & JUMLAH --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Tanggal Pelaksanaan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <small class="text-muted d-block">Check-in</small>
                                    <h4 class="fw-bold my-2">{{ $reservation->checkin_date->format('d') }}</h4>
                                    <h6 class="mb-1">{{ $reservation->checkin_date->format('F Y') }}</h6>
                                    <small class="text-muted">{{ $reservation->checkin_date->format('l') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <small class="text-muted d-block">Check-out</small>
                                    <h4 class="fw-bold my-2">{{ $reservation->checkout_date->format('d') }}</h4>
                                    <h6 class="mb-1">{{ $reservation->checkout_date->format('F Y') }}</h6>
                                    <small class="text-muted">{{ $reservation->checkout_date->format('l') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                            <small class="text-muted">Jumlah Peserta:</small>
                            <h5 class="fw-bold d-inline ms-2">{{ $reservation->jumlah_orang }} orang</h5>
                        </div>
                    </div>
                </div>
                
                {{-- PAYMENT INFO --}}
                @if($reservation->payments->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Informasi Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Kode Transaksi</th>
                                        <th>Metode</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservation->payments as $payment)
                                    <tr>
                                        <td><code>{{ $payment->transaction_code }}</code></td>
                                        <td>{{ ucfirst($payment->method) }}</td>
                                        <td>IDR {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                // Warna badge yang konsisten
                                                $badgeColor = 'warning'; // default
                                                if ($payment->status == 'verified') $badgeColor = 'success';
                                                elseif ($payment->status == 'paid') $badgeColor = 'info';
                                                elseif ($payment->status == 'failed') $badgeColor = 'danger';
                                                elseif ($payment->status == 'expired') $badgeColor = 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $badgeColor }}">
                                                {{ strtoupper($payment->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @php
                            // Logika tombol upload
                            $latestPayment = $reservation->payments->first();
                            $showUploadButton = $reservation->payment_status == 'pending' && 
                                               in_array($reservation->payment_method, ['transfer', 'bank', 'qris']) && 
                                               $reservation->payments->count() > 0 &&
                                               in_array($latestPayment->status, ['pending', 'expired']);
                        @endphp
                        
                        @if($showUploadButton)
                        <div class="mt-3 text-center">
                            <a href="{{ route('user.payment.upload', $latestPayment->id) }}" 
                               class="btn btn-warning">
                                <i class="fas fa-upload me-2"></i> Upload Bukti Pembayaran
                            </a>
                            <p class="text-muted mt-2 mb-0">
                                <small><i class="fas fa-info-circle me-1"></i>Upload bukti transfer untuk mempercepat proses verifikasi</small>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                {{-- NOTES --}}
                @if($reservation->notes)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Catatan</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $reservation->notes }}</p>
                    </div>
                </div>
                @endif
                
            </div>
            
            {{-- RIGHT COLUMN --}}
            <div class="col-lg-4">
                {{-- TOTAL AMOUNT --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center">
                        <small class="text-muted d-block">Total Pembayaran</small>
                        <h2 class="fw-bold text-primary my-3">IDR {{ number_format($reservation->total_amount, 0, ',', '.') }}</h2>
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted d-block">Harga per Paket</small>
                                <strong>IDR {{ number_format($reservation->packages->price ?? 0, 0, ',', '.') }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Jumlah Orang</small>
                                <strong>{{ $reservation->jumlah_orang }} orang</strong>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- PERSONAL INFO --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Diri</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Nama Lengkap:</strong><br>{{ $reservation->nama_lengkap }}</p>
                        <p class="mb-2"><strong>NIK:</strong><br>{{ $reservation->nik }}</p>
                        <p class="mb-0"><strong>No. Telepon:</strong><br>{{ $reservation->no_telepon }}</p>
                    </div>
                </div>
                
                {{-- CONTACT INFO --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Butuh Bantuan?</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><i class="fas fa-phone-alt me-2 text-primary"></i>+62 812 3456 7890</p>
                        <p class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i>cs@gumalandscape.com</p>
                        <p class="mb-0"><i class="fas fa-clock me-2 text-primary"></i>Senin - Minggu, 08:00 - 21:00 WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection