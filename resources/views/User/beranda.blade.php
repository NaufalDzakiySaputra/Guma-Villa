@extends('layouts.frontend')

@section('content')
<section class="hero-wrapper" style="background-image: url('{{ asset('images/hero/gum.jpg') }}');">
    <div class="hero-overlay"></div>
    <div class="container hero-content text-center text-md-start">
        <h1 class="display-3 fw-bold">Jelajahi Pesona <br> <span class="text-accent">Guma Landscape</span></h1>
        <p class="fs-5 mb-4">Villa eksklusif, Restoran mewah, dan Paket Wisata alam terbaik.</p>
        <a href="#paket" class="btn btn-guma btn-lg fw-bold">Lihat Paket</a>
    </div>
</section>

<section id="paket" class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Paket <span class="text-accent">Favorit</span></h2>
            <p class="text-muted">Pilih paket terbaik untuk momen spesial Anda.</p>
        </div>
        <div class="row g-4">
            @foreach($packages as $p)
            <div class="col-md-3">
                <div class="guma-card shadow-sm">
                    <img src="{{ asset('storage/' . $p->image_path) }}" alt="{{ $p->nama }}">
                    <div class="card-body">
                        <span class="badge bg-light text-success mb-2 text-uppercase">{{ $p->service_type }}</span>
                        <h5 class="fw-bold mb-1">{{ $p->nama }}</h5>
                        <p class="text-accent fw-bold mb-3">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                        <a href="#" class="btn btn-detail-guma w-100">Detail Paket</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding" style="background-color: var(--primary-color);">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">Kabar <span class="text-accent">Terbaru</span></h2>
        <div class="row g-4">
            @foreach($news as $n)
            <div class="col-md-4">
                <div class="guma-card border-0">
                    <img src="{{ asset('storage/' . $n->image_path) }}" alt="{{ $n->title }}">
                    <div class="card-body">
                        <small class="text-muted">{{ $n->formatted_event_date }}</small>
                        <h5 class="fw-bold mt-2">{{ $n->title }}</h5>
                        <p class="small text-muted">{{ Str::limit(strip_tags($n->description), 80) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection