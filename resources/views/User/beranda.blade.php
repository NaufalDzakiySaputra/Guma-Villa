@extends('layouts.frontend')

@section('content')
<section 
    class="hero-wrapper"
    style="
        background-image: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)), url('{{ asset('images/hero/gum.jpg') }}') !important;
        background-size: cover !important;
        background-position: center center !important;
        background-repeat: no-repeat !important;
        min-height: 85vh;
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
    "
>
    <!-- ========== WIDGET CUACA DI POJOK KANAN ATAS ========== -->
    <div class="weather-float">
        <div class="weather-float-card">
            <div class="weather-float-icon">
                <img id="weather-float-icon" src="" alt="cuaca" width="40">
            </div>
            <div class="weather-float-info">
                <div class="weather-float-location" id="weather-float-location">📍 Purwokerto</div>
                <div class="weather-float-temp" id="weather-float-temp">--°C</div>
                <div class="weather-float-condition" id="weather-float-condition">--</div>
            </div>
        </div>
    </div>
    <!-- ========== END WIDGET CUACA ========== -->
    
    <div class="container hero-content text-center text-md-start" style="position: relative; z-index: 2; color: #ffffff;">
        <h1 class="display-3 fw-bold">
            Jelajahi Pesona <br>
            <span class="text-accent">Guma Landscape</span>
        </h1>

        <p class="fs-5 mb-4">
            Villa eksklusif, Restoran mewah, dan Paket Wisata alam terbaik.
        </p>

        <a href="#paket" class="btn btn-guma btn-lg fw-bold">
            Lihat Paket
        </a>
    </div>
</section>

<style>
/* ========== HERO FIX ========== */
.hero-wrapper {
    width: 100%;
}

.hero-content h1,
.hero-content p {
    text-shadow: 0 3px 12px rgba(0, 0, 0, 0.45);
}

/* ========== WEATHER FLOAT ========== */
.weather-float {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 10;
}

.weather-float-card {
    background: rgba(0, 0, 0, 0.65);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 10px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    border: 1px solid rgba(255,255,255,0.2);
    transition: transform 0.2s ease;
    min-width: 160px;
}

.weather-float-card:hover {
    transform: scale(1.02);
    background: rgba(0, 0, 0, 0.8);
}

.weather-float-icon img {
    width: 45px;
    height: 45px;
    filter: drop-shadow(1px 1px 2px rgba(0,0,0,0.3));
}

.weather-float-info {
    display: flex;
    flex-direction: column;
    line-height: 1.3;
}

.weather-float-location {
    font-size: 11px;
    opacity: 0.8;
    margin-bottom: 2px;
}

.weather-float-temp {
    font-size: 20px;
    font-weight: bold;
}

.weather-float-condition {
    font-size: 11px;
    opacity: 0.85;
    text-transform: capitalize;
}

/* ========== EMPTY STATE ========== */
.empty-section-box {
    background: #ffffff;
    border: 1px dashed #d6d6d6;
    border-radius: 14px;
    padding: 40px 20px;
    text-align: center;
    color: #6c757d;
}

/* ========== RESPONSIVE ========== */
@media (max-width: 768px) {
    .hero-wrapper {
        min-height: 75vh !important;
        padding-top: 80px;
        padding-bottom: 60px;
    }

    .hero-content h1 {
        font-size: 2.5rem;
    }

    .weather-float {
        top: 10px;
        right: 10px;
    }

    .weather-float-card {
        padding: 6px 12px;
        gap: 8px;
        min-width: 130px;
    }

    .weather-float-icon img {
        width: 32px;
        height: 32px;
    }

    .weather-float-location {
        font-size: 9px;
    }

    .weather-float-temp {
        font-size: 16px;
    }

    .weather-float-condition {
        font-size: 9px;
    }
}
</style>

<script>
async function loadWeatherFloat() {
    try {
        const response = await fetch('/weather/cek?city=Purwokerto');
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('weather-float-icon').src = data.icon;
            document.getElementById('weather-float-location').innerHTML = '📍 ' + data.kota;
            document.getElementById('weather-float-temp').innerHTML = data.suhu + '°C';
            document.getElementById('weather-float-condition').innerHTML = data.kondisi;
        } else {
            document.getElementById('weather-float-location').innerHTML = '📍 Purwokerto';
            document.getElementById('weather-float-temp').innerHTML = '--°C';
            document.getElementById('weather-float-condition').innerHTML = 'tidak tersedia';
        }
    } catch (error) {
        console.log('Gagal load cuaca:', error);
        document.getElementById('weather-float-location').innerHTML = '📍 Purwokerto';
        document.getElementById('weather-float-temp').innerHTML = '--°C';
        document.getElementById('weather-float-condition').innerHTML = 'error';
    }
}

document.addEventListener('DOMContentLoaded', loadWeatherFloat);
</script>

<section id="paket" class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">
                Paket <span class="text-accent">Favorit</span>
            </h2>
            <p class="text-muted">
                Pilih paket terbaik untuk momen spesial Anda.
            </p>
        </div>

        <div class="row g-4">
            @forelse($packages as $p)
                <div class="col-md-3">
                    <div class="guma-card shadow-sm">
                        @if($p->image_path)
                            <img src="{{ asset('storage/' . $p->image_path) }}" alt="{{ $p->nama }}">
                        @else
                            <img src="{{ asset('images/hero/gum.jpg') }}" alt="{{ $p->nama }}">
                        @endif

                        <div class="card-body">
                            <span class="badge bg-light text-success mb-2 text-uppercase">
                                {{ $p->service_type }}
                            </span>

                            <h5 class="fw-bold mb-1">
                                {{ $p->nama }}
                            </h5>

                            <p class="text-accent fw-bold mb-1">
                                Rp {{ number_format($p->price, 0, ',', '.') }}
                            </p>

                            @if(isset($p->max_people))
                                <p class="small text-muted mb-3">
                                    Maks. {{ $p->max_people }} orang
                                </p>
                            @endif

                            <a href="{{ route('user.paket.detail', $p->id) }}" class="btn btn-detail-guma w-100">
                                Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-section-box">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <h5 class="fw-bold">Belum ada paket tersedia</h5>
                        <p class="mb-0">
                            Data paket kosong setelah reset database. Silakan tambahkan paket dari halaman admin.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="section-padding" style="background-color: var(--primary-color);">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">
            Kabar <span class="text-accent">Terbaru</span>
        </h2>

        <div class="row g-4">
            @forelse($news as $n)
                <div class="col-md-4">
                    <div class="guma-card border-0">
                        @if($n->image_path)
                            <img src="{{ asset('storage/' . $n->image_path) }}" alt="{{ $n->title }}">
                        @else
                            <img src="{{ asset('images/hero/menu-hero.jpeg') }}" alt="{{ $n->title }}">
                        @endif

                        <div class="card-body">
                            <small class="text-muted">
                                {{ $n->formatted_event_date ?? '-' }}
                            </small>

                            <h5 class="fw-bold mt-2">
                                {{ $n->title }}
                            </h5>

                            <p class="small text-muted">
                                {{ Str::limit(strip_tags($n->description), 80) }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-section-box">
                        <i class="fas fa-newspaper fa-3x mb-3"></i>
                        <h5 class="fw-bold">Belum ada kabar terbaru</h5>
                        <p class="mb-0">
                            Data berita kosong setelah reset database. Silakan tambahkan berita dari halaman admin.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection