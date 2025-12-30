@extends('layouts.admin')

@section('page-title', 'Kelola Berita & Event')
@section('page-actions')
    <a href="{{ route('admin.news.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Berita
    </a>
@endsection

@section('content')
<div class="card">
    @if($news->isEmpty())
        <div class="card-body text-center py-5">
            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
            <h5 class="text-muted mb-3">Belum ada berita/event</h5>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Berita Pertama
            </a>
        </div>
    @else
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">Gambar</th>
                            <th>Judul & Deskripsi</th>
                            <th>Tanggal Event</th>
                            <th>Status</th>
                            <th width="100" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $item)
                        <tr>
                            <td>
                                @if($item->image_path)
                                    <img src="{{ asset('storage/' . $item->image_path) }}" 
                                         alt="{{ $item->title }}" 
                                         class="rounded" 
                                         width="50" height="50"
                                         style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-newspaper text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $item->title }}</div>
                                @if($item->description)
                                    <small class="text-muted d-block mt-1">
                                        {{ Str::limit(strip_tags($item->description), 60) }}
                                    </small>
                                @endif
                                <small class="text-muted">
                                    <i class="far fa-calendar me-1"></i>
                                    {{ $item->created_at->format('d/m/Y') }}
                                </small>
                            </td>
                            <td>
                                <div class="fw-bold">
                                    {{ $item->event_date->format('d/m/Y') }}
                                </div>
                                <small class="text-muted d-block">
                                    {{ $item->event_date->translatedFormat('l') }}
                                </small>
                            </td>
                            <td>
                                @php
                                    $today = \Carbon\Carbon::today();
                                    $eventDate = $item->event_date->startOfDay();
                                    
                                    if ($eventDate->isSameDay($today)) {
                                        $statusClass = 'success';
                                        $statusText = 'Hari Ini';
                                    } elseif ($eventDate->isFuture()) {
                                        $daysDiff = $today->diffInDays($eventDate);
                                        
                                        if ($daysDiff == 1) {
                                            $statusClass = 'primary';
                                            $statusText = 'Besok';
                                        } elseif ($daysDiff <= 7) {
                                            $statusClass = 'warning';
                                            $statusText = $daysDiff . ' hari lagi';
                                        } else {
                                            $statusClass = 'info';
                                            $statusText = 'Akan Datang';
                                        }
                                    } else {
                                        $statusClass = 'danger';
                                        $statusText = 'Selesai';
                                    }
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('admin.news.edit', $item->id) }}" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $item->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus berita ini?')">
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
            Total: {{ $news->count() }} berita
            @php
                $upcomingCount = $news->filter(function($item) {
                    return $item->event_date->isFuture();
                })->count();
            @endphp
            @if($upcomingCount > 0)
                • {{ $upcomingCount }} event mendatang
            @endif
        </div>
    @endif
</div>
@endsection