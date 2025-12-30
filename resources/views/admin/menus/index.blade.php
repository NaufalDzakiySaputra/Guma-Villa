@extends('layouts.admin')

@section('page-title', 'Kelola Menu Cafe')
@section('page-actions')
    <a href="{{ route('admin.menus.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Menu
    </a>
@endsection

@section('content')
<div class="card">
    @if($menus->isEmpty())
        <div class="card-body text-center py-5">
            <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
            <h5 class="text-muted mb-3">Belum ada menu</h5>
            <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Menu Pertama
            </a>
        </div>
    @else
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">Gambar</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th width="100" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $menu)
                        <tr>
                            <td>
                                @if($menu->image_path)
                                    <img src="{{ asset($menu->image_path) }}" 
                                         alt="{{ $menu->name }}" 
                                         class="rounded" 
                                         width="50" height="50"
                                         style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-utensils text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $menu->name }}</div>
                                @if($menu->description)
                                    <small class="text-muted d-block mt-1">
                                        {{ Str::limit($menu->description, 60) }}
                                    </small>
                                @endif
                            </td>
                            <td class="fw-bold">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($menu->discount > 0)
                                    <span class="badge bg-danger">
                                        -{{ $menu->discount }}%
                                    </span>
                                    <div class="text-success small mt-1">
                                        Rp {{ number_format($menu->harga_diskon, 0, ',', '.') }}
                                    </div>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('admin.menus.edit', $menu->id) }}" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.menus.destroy', $menu->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus menu ini?')">
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
            Total: {{ $menus->count() }} menu
            @if($menus->where('discount', '>', 0)->count() > 0)
                • {{ $menus->where('discount', '>', 0)->count() }} menu diskon
            @endif
        </div>
    @endif
</div>
@endsection