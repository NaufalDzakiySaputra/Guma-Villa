@extends('layouts.admin')

@section('title', 'Kelola Reservasi')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-calendar-check me-2"></i>Reservasi</h4>
            <p class="text-muted mb-0">Total: {{ $reservations->total() }} reservasi</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-2"><div class="card text-center py-2"><div class="card-body"><h6 class="text-muted mb-1">Total</h6><h4>{{ $totalCount }}</h4></div></div></div>
        <div class="col-2"><div class="card text-center py-2"><div class="card-body"><h6 class="text-muted mb-1">Pending</h6><h4 class="text-warning">{{ $pendingCount }}</h4></div></div></div>
        <div class="col-2"><div class="card text-center py-2"><div class="card-body"><h6 class="text-muted mb-1">Approved</h6><h4 class="text-success">{{ $approvedCount }}</h4></div></div></div>
        <div class="col-2"><div class="card text-center py-2"><div class="card-body"><h6 class="text-muted mb-1">Unpaid</h6><h4 class="text-danger">{{ $unpaidCount }}</h4></div></div></div>
        <div class="col-2"><div class="card text-center py-2"><div class="card-body"><h6 class="text-muted mb-1">Paid</h6><h4 class="text-info">{{ $paidCount }}</h4></div></div></div>
        <div class="col-2"><div class="card text-center py-2"><div class="card-body"><h6 class="text-muted mb-1">Verified</h6><h4 class="text-success">{{ $verifiedCount }}</h4></div></div></div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_status" class="form-select form-select-sm">
                        <option value="">Pembayaran</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="verified" {{ request('payment_status') == 'verified' ? 'selected' : '' }}>Verified</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_method" class="form-select form-select-sm">
                        <option value="">Metode Bayar</option>
                        <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Bank</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="checkin_date" class="form-control form-control-sm" value="{{ request('checkin_date') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary btn-sm w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            @if($reservations->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Paket</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>#{{ $reservation->id }}</td>
                            <td>
                                <strong>{{ $reservation->nama_lengkap }}</strong><br>
                                <small>{{ $reservation->no_telepon }}</small>
                            </td>
                            <td>
                                @if($reservation->packages)
                                    {{ $reservation->packages->nama }}<br>
                                    <small class="text-muted">{{ $reservation->service_type }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $reservation->checkin_date->format('d/m/Y') }}</td>
                            <td>{{ $reservation->checkout_date->format('d/m/Y') }}</td>
                            <td>{{ $reservation->jumlah_orang }} orang</td>
                            <td>Rp {{ number_format($reservation->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @if($reservation->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($reservation->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                @if($reservation->payment_status == 'pending')
                                    <span class="badge bg-danger">Pending</span>
                                @elseif($reservation->payment_status == 'paid')
                                    <span class="badge bg-warning">Paid</span>
                                @else
                                    <span class="badge bg-success">Verified</span>
                                @endif
                                <br>
                                <small>{{ $reservation->payment_method ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.reservations.show', $reservation->id) }}" 
                                       class="btn btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.reservations.edit', $reservation->id) }}" 
                                       class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $reservations->links() }}
            </div>
            
            @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada reservasi</h5>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection