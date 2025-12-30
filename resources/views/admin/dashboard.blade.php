@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview sistem')

@section('content')
<!-- Simple Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-primary mb-2">
                    <i class="fas fa-box fa-2x"></i>
                </div>
                <h5 class="fw-bold">{{ \App\Models\Packages::count() }}</h5>
                <p class="text-muted mb-1">Paket</p>
                <a href="{{ route('admin.packages.index') }}" class="small">Lihat</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-success mb-2">
                    <i class="fas fa-utensils fa-2x"></i>
                </div>
                <h5 class="fw-bold">{{ \App\Models\Menus::count() }}</h5>
                <p class="text-muted mb-1">Menu</p>
                <a href="{{ route('admin.menus.index') }}" class="small">Lihat</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-info mb-2">
                    <i class="fas fa-newspaper fa-2x"></i>
                </div>
                <h5 class="fw-bold">{{ \App\Models\News::count() }}</h5>
                <p class="text-muted mb-1">Berita/Event</p>
                <a href="{{ route('admin.news.index') }}" class="small">Lihat</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-warning mb-2">
                    <i class="fas fa-images fa-2x"></i>
                </div>
                <h5 class="fw-bold">{{ \App\Models\Gallery::count() }}</h5>
                <p class="text-muted mb-1">Foto</p>
                <a href="{{ route('admin.gallery.index') }}" class="small">Lihat</a>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Message -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                <i class="fas fa-user-circle fa-2x text-primary"></i>
            </div>
            <div>
                <h5 class="mb-1">Selamat datang, {{ Auth::user()->name }}!</h5>
                <p class="text-muted mb-0">
                    Anda login sebagai <strong>{{ Auth::user()->role }}</strong>.
                    @if(Auth::user()->role === 'admin')
                    Anda memiliki akses penuh ke semua fitur.
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="d-grid">
            <a href="{{ route('admin.packages.create') }}" class="btn btn-outline-primary">
                <i class="fas fa-plus me-1"></i>Tambah Paket
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="d-grid">
            <a href="{{ route('admin.menus.create') }}" class="btn btn-outline-success">
                <i class="fas fa-plus me-1"></i>Tambah Menu
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="d-grid">
            <a href="{{ route('admin.news.create') }}" class="btn btn-outline-info">
                <i class="fas fa-plus me-1"></i>Tambah Berita
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="d-grid">
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-outline-warning">
                <i class="fas fa-plus me-1"></i>Tambah Foto
            </a>
        </div>
    </div>
</div>

<!-- Admin Only -->
@if(Auth::check() && Auth::user()->role === 'admin')
<div class="row g-3">
    <div class="col-md-4">
        <div class="d-grid">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-users me-1"></i>Kelola User
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-grid">
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-dark">
                <i class="fas fa-calendar-check me-1"></i>Reservasi
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-grid">
            <a href="{{ route('admin.users.create') }}" class="btn btn-outline-secondary">
                <i class="fas fa-user-plus me-1"></i>Tambah User
            </a>
        </div>
    </div>
</div>
@endif
@endsection