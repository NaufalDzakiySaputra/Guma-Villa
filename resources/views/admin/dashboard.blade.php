@extends('layouts.admin')

@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Overview Guma Landscape')

@section('content')
<div class="row">
    <!-- Stat Cards -->
    <div class="col-md-3 mb-4">
        <div class="card bg-soft-primary border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Paket</h6>
                        <h2 class="fw-bold text-accent mb-0">
                            {{ App\Models\Packages::count() ?? 0 }}
                        </h2>
                        <div class="small text-muted mt-2">
                            @php
                                $villaCount = App\Models\Packages::where('service_type', 'villa')->count();
                                $wisataCount = App\Models\Packages::where('service_type', 'wisata')->count();
                            @endphp
                            Villa: {{ $villaCount }} • Wisata: {{ $wisataCount }}
                        </div>
                    </div>
                    <div class="bg-accent rounded-circle p-3">
                        <i class="fas fa-box fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-soft-success border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Menu</h6>
                        <h2 class="fw-bold text-success mb-0">
                            {{ App\Models\Menus::count() ?? 0 }}
                        </h2>
                        <div class="small text-muted mt-2">
                            @php
                                $diskonCount = App\Models\Menus::where('discount', '>', 0)->count();
                                $avgPrice = App\Models\Menus::avg('price') ?? 0;
                            @endphp
                            Diskon: {{ $diskonCount }} • Avg: Rp {{ number_format($avgPrice, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="bg-success rounded-circle p-3">
                        <i class="fas fa-utensils fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-soft-info border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Event Aktif</h6>
                        <h2 class="fw-bold text-info mb-0">
                            @php
                                $eventCount = App\Models\News::where('event_date', '>=', now())->count();
                            @endphp
                            {{ $eventCount }}
                        </h2>
                        <div class="small text-muted mt-2">
                            @php
                                $thisWeek = App\Models\News::whereBetween('event_date', [now(), now()->addDays(7)])->count();
                                $thisMonth = App\Models\News::whereMonth('event_date', now()->month)->count();
                            @endphp
                            Minggu Ini: {{ $thisWeek }} • Bulan Ini: {{ $thisMonth }}
                        </div>
                    </div>
                    <div class="bg-info rounded-circle p-3">
                        <i class="fas fa-calendar-alt fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-soft-warning border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Foto Galeri</h6>
                        <h2 class="fw-bold text-warning mb-0">
                            {{ App\Models\Gallery::count() ?? 0 }}
                        </h2>
                        <div class="small text-muted mt-2">
                            @php
                                $recentGallery = App\Models\Gallery::where('created_at', '>=', now()->subDays(7))->count();
                            @endphp
                            Terbaru: {{ $recentGallery }} • Total: {{ App\Models\Gallery::count() }}
                        </div>
                    </div>
                    <div class="bg-warning rounded-circle p-3">
                        <i class="fas fa-images fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Kalender Event -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Kalender Event {{ now()->translatedFormat('F Y') }}
                </h6>
            </div>
            <div class="card-body">
                @php
                    $eventsThisMonth = App\Models\News::whereMonth('event_date', now()->month)
                        ->whereYear('event_date', now()->year)
                        ->get();
                @endphp
                
                <!-- Simple Calendar -->
                <div class="text-center mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h5 class="mb-0">{{ now()->translatedFormat('F Y') }}</h5>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    
                    <!-- Day Headers -->
                    <div class="row mb-2">
                        @foreach(['M', 'S', 'S', 'R', 'K', 'J', 'S'] as $day)
                        <div class="col p-2 text-center">
                            <small class="text-muted">{{ $day }}</small>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Calendar Days -->
                    <div class="row">
                        @php
                            $firstDay = now()->startOfMonth()->dayOfWeek;
                            $daysInMonth = now()->daysInMonth;
                        @endphp
                        
                        <!-- Empty days before first day -->
                        @for($i = 0; $i < $firstDay; $i++)
                        <div class="col p-2"></div>
                        @endfor
                        
                        <!-- Days of month -->
                        @for($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $hasEvent = $eventsThisMonth->contains(function($event) use ($day) {
                                return $event->event_date->day == $day;
                            });
                            $isToday = $day == now()->day;
                        @endphp
                        <div class="col p-2 text-center">
                            <div class="calendar-day {{ $isToday ? 'bg-accent text-white rounded-circle' : '' }} 
                                          {{ $hasEvent ? 'border border-success' : '' }}"
                                 style="width: 30px; height: 30px; line-height: 30px; margin: 0 auto;">
                                {{ $day }}
                                @if($hasEvent)
                                <div class="position-absolute" style="bottom: 2px; right: 2px;">
                                    <i class="fas fa-circle text-success" style="font-size: 6px;"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        @if(($day + $firstDay) % 7 == 0)
                        </div><div class="row">
                        @endif
                        @endfor
                    </div>
                </div>
                
                <!-- Event List -->
                <h6 class="mt-4 mb-3">Event Bulan Ini:</h6>
                @if($eventsThisMonth->isEmpty())
                <p class="text-muted">Tidak ada event di bulan ini</p>
                @else
                <div class="list-group">
                    @foreach($eventsThisMonth->take(3) as $event)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $event->title }}</strong>
                                <div class="small text-muted">
                                    {{ $event->event_date->translatedFormat('l, d F Y') }}
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
        </div>
    </div>

    <!-- Event Mendatang & Quick Stats -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-bullhorn me-2"></i>
                    Event Mendatang & Aktivitas
                </h6>
            </div>
            <div class="card-body">
                <!-- Upcoming Events -->
                <h6 class="mb-3">Event Mendatang (7 hari):</h6>
                @php
                    $upcomingEvents = App\Models\News::where('event_date', '>=', now())
                        ->where('event_date', '<=', now()->addDays(7))
                        ->orderBy('event_date')
                        ->get();
                @endphp
                
                @if($upcomingEvents->isEmpty())
                <p class="text-muted">Tidak ada event dalam 7 hari ke depan</p>
                @else
                <div class="list-group mb-4">
                    @foreach($upcomingEvents as $event)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $event->title }}</strong>
                                <div class="small">
                                    {{ $event->event_date->translatedFormat('d F') }}
                                    <span class="text-success ms-2">
                                        ({{ now()->diffInDays($event->event_date) }} hari lagi)
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('news.edit', $event->id) }}" 
                               class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                
                <!-- Quick Stats -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">Paket Terbaru</h6>
                                @php
                                    $latestPackage = App\Models\Packages::latest()->first();
                                @endphp
                                @if($latestPackage)
                                <div class="d-flex align-items-center">
                                    @if($latestPackage->image_path)
                                    <img src="{{ asset('storage/' . $latestPackage->image_path) }}" 
                                         alt="{{ $latestPackage->nama }}"
                                         class="rounded me-2"
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                    @endif
                                    <div>
                                        <strong class="d-block">{{ Str::limit($latestPackage->nama, 20) }}</strong>
                                        <small class="text-muted">
                                            Rp {{ number_format($latestPackage->price, 0, ',', '.') }}
                                        </small>
                                    </div>
                                </div>
                                @else
                                <p class="text-muted small">Belum ada paket</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">Menu Diskon</h6>
                                @php
                                    $discountMenu = App\Models\Menus::where('discount', '>', 0)->latest()->first();
                                @endphp
                                @if($discountMenu)
                                <div>
                                    <strong class="d-block">{{ $discountMenu->name }}</strong>
                                    <div>
                                        <span class="text-decoration-line-through text-muted small">
                                            Rp {{ number_format($discountMenu->price, 0, ',', '.') }}
                                        </span>
                                        <span class="text-success fw-bold ms-2">
                                            -{{ $discountMenu->discount }}%
                                        </span>
                                    </div>
                                </div>
                                @else
                                <p class="text-muted small">Tidak ada menu diskon</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Galeri Terbaru -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="fas fa-images me-2"></i>
                    Galeri Terbaru
                </h6>
                <a href="{{ route('gallery.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
                @php
                    $recentGalleries = App\Models\Gallery::latest()->take(6)->get();
                @endphp
                
                @if($recentGalleries->isEmpty())
                <p class="text-muted">Belum ada foto di galeri</p>
                @else
                <div class="row">
                    @foreach($recentGalleries as $gallery)
                    <div class="col-md-2 col-sm-4 col-6 mb-3">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                                 alt="{{ $gallery->title ?? 'Gallery Image' }}"
                                 class="img-fluid rounded"
                                 style="height: 120px; width: 100%; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 w-100 p-2" 
                                 style="background: rgba(0,0,0,0.5);">
                                <p class="text-white mb-0 small">
                                    {{ $gallery->title ? Str::limit($gallery->title, 15) : 'Foto' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-soft-primary border-0">
            <div class="card-body">
                <h6 class="text-accent mb-3">
                    <i class="fas fa-bolt me-2"></i>Quick Links
                </h6>
                <div class="row">
                    <div class="col-md-3 col-6 mb-2">
                        <a href="{{ route('packages.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus-circle me-1"></i>Tambah Paket
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-2">
                        <a href="{{ route('menus.create') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-plus-circle me-1"></i>Tambah Menu
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-2">
                        <a href="{{ route('news.create') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-plus-circle me-1"></i>Tambah Event
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-2">
                        <a href="{{ route('gallery.create') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-plus-circle me-1"></i>Tambah Foto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection