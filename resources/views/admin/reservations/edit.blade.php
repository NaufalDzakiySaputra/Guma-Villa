@extends('layouts.admin')

@section('title', 'Edit Reservasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Reservasi #{{ $reservation->id }}</h4>
        <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
                @csrf @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status Reservasi</label>
                        <select name="status" class="form-select" required>
                            @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ $reservation->status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="payment_status" class="form-select" required>
                            @foreach($paymentStatuses as $status)
                            <option value="{{ $status }}" {{ $reservation->payment_status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select">
                            <option value="">Pilih Metode</option>
                            @foreach($paymentMethods as $method)
                            @if(!is_null($method))
                            <option value="{{ $method }}" {{ $reservation->payment_method == $method ? 'selected' : '' }}>
                                {{ ucfirst($method) }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
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