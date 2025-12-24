@extends('layouts.admin')

@section('page-title', 'Kelola Berita & Event')
@section('page-subtitle', 'Daftar event dan promo Guma Landscape')

@section('page-actions')
    <a href="{{ route('news.create') }}" class="btn btn-success">
        <i class="fas fa-plus-circle me-2"></i>Tambah Berita Baru
    </a>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-newspaper me-2"></i>Daftar Berita & Event
            </h5>
            <div class="d-flex gap-2">
                <span class="badge bg-soft-primary text-accent">
                    {{ $news->count() }} Berita
                </span>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                            type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Semua</a></li>
                        <li><a class="dropdown-item" href="#">Event Mendatang</a></li>
                        <li><a class="dropdown-item" href="#">Event Selesai</a></li>
                        <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    @if($news->isEmpty())
    <div class="card-body text-center py-5">
        <div class="mb-4">
            <i class="fas fa-newspaper fa-4x text-muted opacity-25"></i>
        </div>
        <h5 class="text-muted mb-3">Belum ada berita atau event</h5>
        <p class="text-muted mb-4">Mulai dengan menambahkan event pertama</p>
        <a href="{{ route('news.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle me-2"></i>Tambah Event Pertama
        </a>
    </div>
    @else
    <div class="card-body">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-soft-primary border-0">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total</h6>
                                <h4 class="mb-0 fw-bold text-accent">{{ $news->count() }}</h4>
                            </div>
                            <div>
                                <i class="fas fa-newspaper fa-2x text-accent opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-soft-success border-0">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Mendatang</h6>
                                <h4 class="mb-0 fw-bold text-success">
                                    {{ $news->where('event_date', '>=', now())->count() }}
                                </h4>
                            </div>
                            <div>
                                <i class="fas fa-calendar-alt fa-2x text-success opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-soft-warning border-0">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Minggu Ini</h6>
                                <h4 class="mb-0 fw-bold text-warning">
                                    {{ $news->whereBetween('event_date', [now(), now()->addDays(7)])->count() }}
                                </h4>
                            </div>
                            <div>
                                <i class="fas fa-bell fa-2x text-warning opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-soft-info border-0">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Dengan Gambar</h6>
                                <h4 class="mb-0 fw-bold text-info">
                                    {{ $news->whereNotNull('image_path')->count() }}
                                </h4>
                            </div>
                            <div>
                                <i class="fas fa-image fa-2x text-info opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th width="100">Gambar</th>
                        <th>Judul & Deskripsi</th>
                        <th width="150">Tanggal Event</th>
                        <th width="120">Status</th>
                        <th width="120" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $item)
                    @php
                        $isPast = $item->event_date->isPast();
                        $isUpcoming = $item->event_date->isFuture();
                        $daysDiff = now()->diffInDays($item->event_date, false);
                        
                        // Determine status
                        if ($daysDiff < 0) {
                            $statusClass = 'danger';
                            $statusText = 'Selesai';
                        } elseif ($daysDiff == 0) {
                            $statusClass = 'success';
                            $statusText = 'Hari Ini';
                        } elseif ($daysDiff <= 7) {
                            $statusClass = 'warning';
                            $statusText = 'Minggu Ini';
                        } else {
                            $statusClass = 'info';
                            $statusText = 'Akan Datang';
                        }
                    @endphp
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td>
                            @if($item->image_path)
                                <img src="{{ asset('storage/' . $item->image_path) }}" 
                                     alt="{{ $item->title }}" 
                                     class="img-thumbnail"
                                     style="width: 80px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 60px;">
                                    <i class="fas fa-newspaper text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <h6 class="mb-1" style="color: var(--accent-color);">{{ $item->title }}</h6>
                            <p class="text-muted mb-0 small">
                                {{ Str::limit(strip_tags($item->description), 80) }}
                            </p>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="far fa-calendar me-1"></i>
                                    Dibuat: {{ $item->created_at->format('d/m/Y') }}
                                </small>
                                @if($item->user_id)
                                    <small class="text-muted ms-3">
                                        <i class="fas fa-user me-1"></i>
                                        User ID: {{ $item->user_id }}
                                    </small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold">
                                {{ $item->event_date->format('d/m/Y') }}
                            </div>
                            <small class="text-muted d-block">
                                {{ $item->event_date->translatedFormat('l') }}
                            </small>
                            @if(!$isPast)
                                <small class="text-{{ $statusClass }}">
                                    <i class="far fa-clock me-1"></i>
                                    {{ abs($daysDiff) }} hari {{ $daysDiff > 0 ? 'lagi' : 'yang lalu' }}
                                </small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('news.edit', $item->id) }}" 
                                   class="btn btn-outline-secondary btn-sm" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form id="delete-news-{{ $item->id }}" 
                                      action="{{ route('news.destroy', $item->id) }}" 
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-sm" 
                                            title="Hapus"
                                            onclick="confirmDelete(event, 'delete-news-{{ $item->id }}')">
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
        
        <!-- Summary -->
        <div class="text-center mt-4">
            <p class="text-muted mb-0">
                <i class="fas fa-info-circle me-1"></i>
                Total {{ $news->count() }} berita • 
                {{ $news->where('event_date', '>=', now())->count() }} event mendatang
            </p>
        </div>
    </div>
    @endif
</div>

<!-- Calendar Preview -->
<div class="card mt-4">
    <div class="card-header">
        <h6 class="mb-0">
            <i class="fas fa-calendar-alt me-2"></i>Kalender Event Bulan Ini
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            @php
                $currentMonth = now()->format('F Y');
                $monthEvents = $news->filter(function($item) {
                    return $item->event_date->format('m Y') == now()->format('m Y');
                });
            @endphp
            <div class="col-md-8">
                <h6 class="text-accent mb-3">{{ $currentMonth }}</h6>
                @if($monthEvents->isEmpty())
                    <p class="text-muted">Tidak ada event di bulan ini</p>
                @else
                    <div class="list-group">
                        @foreach($monthEvents as $event)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $event->title }}</strong>
                                    <div class="small text-muted">
                                        {{ $event->event_date->format('d F Y') }}
                                    </div>
                                </div>
                                <span class="badge bg-{{ $event->event_date->isPast() ? 'secondary' : 'primary' }}">
                                    {{ $event->event_date->isPast() ? 'Selesai' : 'Akan Datang' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="bg-soft-primary rounded p-3 text-center">
                    <h6 class="text-accent mb-2">Event Terdekat</h6>
                    @php
                        $nearestEvent = $news->where('event_date', '>=', now())->sortBy('event_date')->first();
                    @endphp
                    @if($nearestEvent)
                        <div class="mb-3">
                            <i class="fas fa-calendar-star fa-3x text-accent mb-3"></i>
                            <h5 class="mb-1">{{ $nearestEvent->title }}</h5>
                            <div class="text-success fw-bold">
                                {{ $nearestEvent->event_date->format('d F Y') }}
                            </div>
                            <small class="text-muted">
                                {{ now()->diffInDays($nearestEvent->event_date) }} hari lagi
                            </small>
                        </div>
                    @else
                        <p class="text-muted">Tidak ada event mendatang</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection