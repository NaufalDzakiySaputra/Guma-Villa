<!-- resources/views/admin/reservations/index.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="fas fa-calendar-check me-2"></i>Kelola Reservasi
    </h1>
    <button class="btn btn-outline-secondary" id="toggleFilter">
        <i class="fas fa-filter me-1"></i>Filter
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filter Section -->
<div class="card mb-4 d-none" id="filterSection">
    <div class="card-body">
        <h6 class="card-title mb-3"><i class="fas fa-filter me-2"></i>Filter Reservasi</h6>
        <form method="GET" action="{{ route('reservations.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Jenis Layanan</label>
                <select name="service_type" class="form-select">
                    <option value="">Semua Layanan</option>
                    <option value="villa" {{ request('service_type') == 'villa' ? 'selected' : '' }}>Villa</option>
                    <option value="wisata" {{ request('service_type') == 'wisata' ? 'selected' : '' }}>Wisata</option>
                    <option value="nikah" {{ request('service_type') == 'nikah' ? 'selected' : '' }}>Wedding</option>
                    <option value="mice" {{ request('service_type') == 'mice' ? 'selected' : '' }}>MICE</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Reservasi</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status Pembayaran</label>
                <select name="payment_status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="verified" {{ request('payment_status') == 'verified' ? 'selected' : '' }}>Verified</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>Terapkan Filter
                </button>
                <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Reservasi</h6>
                        <h3 class="mb-0">{{ $totalCount ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Pending</h6>
                        <h3 class="mb-0">{{ $pendingCount ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Approved</h6>
                        <h3 class="mb-0">{{ $approvedCount ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Paid</h6>
                        <h3 class="mb-0">{{ $paidCount ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-credit-card fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

@if($reservations->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada reservasi</h5>
            <p class="text-muted">Belum ada customer yang melakukan reservasi</p>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>ID Reservasi</th>
                            <th>Customer</th>
                            <th>Layanan</th>
                            <th>Tanggal Reservasi</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong class="text-primary">
                                    #{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}
                                </strong>
                            </td>
                            <td>
                                <strong>{{ $reservation->user->name ?? 'Guest' }}</strong>
                                <p class="text-muted mb-0 small">
                                    {{ $reservation->user->email ?? 'N/A' }}
                                </p>
                                @if($reservation->user->phone ?? false)
                                <p class="text-muted mb-0 small">
                                    <i class="fas fa-phone me-1"></i>{{ $reservation->user->phone }}
                                </p>
                                @endif
                            </td>
                            <td>
                                @php
                                    $serviceTypes = [
                                        'villa' => ['label' => 'Villa', 'color' => 'primary'],
                                        'wisata' => ['label' => 'Wisata', 'color' => 'success'],
                                        'nikah' => ['label' => 'Wedding', 'color' => 'danger'],
                                        'mice' => ['label' => 'MICE', 'color' => 'info']
                                    ];
                                    $type = $serviceTypes[$reservation->service_type] ?? ['label' => $reservation->service_type, 'color' => 'secondary'];
                                @endphp
                                <span class="badge bg-{{ $type['color'] }}">
                                    {{ $type['label'] }}
                                </span>
                                @if($reservation->package)
                                    <p class="text-muted mb-0 small mt-1">
                                        {{ $reservation->package->nama }}
                                    </p>
                                @endif
                            </td>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</strong>
                                <p class="text-muted mb-0 small">
                                    dibuat: {{ \Carbon\Carbon::parse($reservation->created_at)->format('H:i') }}
                                </p>
                            </td>
                            <td>
                                @if($reservation->status == 'pending')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Pending
                                    </span>
                                @elseif($reservation->status == 'approved')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Approved
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Rejected
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($reservation->payment_status == 'unpaid')
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-money-bill-wave me-1"></i>Unpaid
                                    </span>
                                @elseif($reservation->payment_status == 'paid')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Paid
                                    </span>
                                @else
                                    <span class="badge bg-info">
                                        <i class="fas fa-shield-alt me-1"></i>Verified
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('reservations.show', $reservation->id) }}" 
                                       class="btn btn-outline-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('reservations.edit', $reservation->id) }}" 
                                       class="btn btn-outline-warning" title="Edit Status">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-form-{{ $reservation->id }}" 
                                          action="{{ route('reservations.destroy', $reservation->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                title="Hapus Reservasi"
                                                onclick="confirmDelete(event, 'delete-form-{{ $reservation->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Menampilkan {{ $reservations->firstItem() ?? 0 }} - {{ $reservations->lastItem() ?? 0 }} dari {{ $reservations->total() }} reservasi
                </div>
                <!-- Pagination -->
                @if($reservations->hasPages())
                <div>
                    {{ $reservations->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    // Toggle filter section
    document.getElementById('toggleFilter').addEventListener('click', function() {
        const filterSection = document.getElementById('filterSection');
        filterSection.classList.toggle('d-none');
    });
    
    // Show filter if there are active filters
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        let hasFilters = false;
        
        ['status', 'service_type', 'date', 'payment_status'].forEach(param => {
            if (urlParams.get(param)) hasFilters = true;
        });
        
        if (hasFilters) {
            document.getElementById('filterSection').classList.remove('d-none');
        }
    });
</script>
@endpush