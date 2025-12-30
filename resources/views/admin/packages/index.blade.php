@extends('layouts.admin')

@section('page-title', 'Kelola Paket')
@section('page-actions')
    <a href="{{ route('admin.packages.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Paket
    </a>
@endsection

@section('content')
<div class="card">
    @if($packages->isEmpty())
        <div class="card-body text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted mb-3">Belum ada paket</h5>
            <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Paket Pertama
            </a>
        </div>
    @else
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">Gambar</th>
                            <th>Nama Paket</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th width="100" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                        <tr>
                            <td>
                                @if($package->image_path)
                                    <img src="{{ asset('storage/' . $package->image_path) }}" 
                                         alt="{{ $package->nama }}" 
                                         class="rounded" 
                                         width="50" height="50"
                                         style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $package->nama }}</div>
                                @if($package->description)
                                    <small class="text-muted d-block mt-1">
                                        {{ Str::limit($package->description, 60) }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeColors = [
                                        'villa' => 'badge-villa',
                                        'wisata' => 'badge-wisata',
                                        'nikah' => 'badge-nikah',
                                        'mice' => 'badge-mice'
                                    ];
                                @endphp
                                <span class="badge {{ $badgeColors[$package->service_type] ?? 'badge-villa' }}">
                                    {{ ucfirst($package->service_type) }}
                                </span>
                            </td>
                            <td class="fw-bold text-success">
                                Rp {{ number_format($package->price, 0, ',', '.') }}
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('admin.packages.edit', $package->id) }}" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.packages.destroy', $package->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus paket ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
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
        </div>
        
        <div class="card-footer text-muted small">
            Total: {{ $packages->count() }} paket
        </div>
    @endif
</div>
@endsection