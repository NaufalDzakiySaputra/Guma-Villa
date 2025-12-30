@extends('layouts.admin')

@section('page-title', 'Kelola Galeri')
@section('page-actions')
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Foto
    </a>
@endsection

@section('content')
<div class="card">
    @if($galleries->isEmpty())
        <div class="card-body text-center py-5">
            <i class="fas fa-images fa-3x text-muted mb-3"></i>
            <h5 class="text-muted mb-3">Belum ada foto</h5>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Foto Pertama
            </a>
        </div>
    @else
        <div class="card-body">
            <div class="row">
                @foreach($galleries as $gallery)
                <div class="col-md-3 col-6 mb-4">
                    <div class="card border-0">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                                 alt="{{ $gallery->title ?? 'Foto' }}"
                                 class="img-fluid rounded"
                                 style="height: 150px; width: 100%; object-fit: cover;">
                            @if($gallery->title)
                                <div class="position-absolute bottom-0 start-0 w-100 p-2" 
                                     style="background: rgba(0,0,0,0.5);">
                                    <p class="text-white mb-0 small">{{ $gallery->title }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between gap-1">
                                <a href="{{ route('admin.gallery.edit', $gallery->id) }}" 
                                   class="btn btn-sm btn-outline-warning flex-fill">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Hapus foto ini?')"
                                      class="flex-fill">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="card-footer text-muted small">
            Total: {{ $galleries->count() }} foto
        </div>
    @endif
</div>
@endsection