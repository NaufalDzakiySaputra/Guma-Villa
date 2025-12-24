@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="fas fa-box-open me-2"></i>Kelola Paket
    </h1>
    <a href="{{ route('packages.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-1"></i>Tambah Paket Baru
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($packages->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada paket </h5>
            <p class="text-muted">Mulai dengan menambahkan paket pertama Anda</p>
            <a href="{{ route('packages.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Tambah Paket Pertama
            </a>
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
                            <th>Gambar</th>
                            <th>Nama Paket</th>
                            <th>Jenis Layanan</th>
                            <th>Harga</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($package->image_path)
                                    <img src="{{ asset('storage/' . $package->image_path) }}" 
                                         alt="{{ $package->nama }}" 
                                         class="img-thumbnail" 
                                         width="80" height="60"
                                         style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 80px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $package->nama }}</strong>
                                @if($package->description)
                                    <p class="text-muted mb-0 small">
                                        {{ Str::limit($package->description, 50) }}
                                    </p>
                                @endif
                            </td>
                            <td>
                                @php
                                    $serviceTypes = [
                                        'villa' => ['label' => 'Villa', 'color' => 'primary'],
                                        'wisata' => ['label' => 'Wisata', 'color' => 'success'],
                                        'nikah' => ['label' => 'Perkawinan', 'color' => 'danger'],
                                        'mice' => ['label' => 'MICE', 'color' => 'info']
                                    ];
                                    $type = $serviceTypes[$package->service_type] ?? ['label' => $package->service_type, 'color' => 'secondary'];
                                @endphp
                                <span class="badge bg-{{ $type['color'] }}">
                                    {{ $type['label'] }}
                                </span>
                            </td>
                            <td>
                                <strong class="text-success">
                                    Rp {{ number_format($package->price, 0, ',', '.') }}
                                </strong>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('packages.edit', $package->id) }}" 
                                       class="btn btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-form-{{ $package->id }}" 
                                          action="{{ route('packages.destroy', $package->id) }}" 
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                title="Hapus"
                                                onclick="confirmDelete(event, 'delete-form-{{ $package->id }}')">
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
                    Total: {{ $packages->count() }} paket
                </div>
                <!-- Jika ada pagination -->
                <!-- {{-- $packages->links() --}} -->
            </div>
        </div>
    </div>
@endif
@endsection