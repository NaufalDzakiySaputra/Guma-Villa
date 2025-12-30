@extends('layouts.frontend')

@section('title', 'Tentang Kami')

@section('content')
<!-- Hero Section -->
<section class="text-center py-5 bg-light border-bottom">
    <div class="container">
        <img src="{{ asset('images/logo/logo.png') }}" 
             alt="Guma Landscape Café" 
             class="img-fluid rounded shadow mb-4" 
             style="max-height: 400px; object-fit: cover;">
        <h1 class="fw-bold text-accent">Tentang Kami</h1>
        <p class="lead text-muted mt-3">
            Nikmati pengalaman kuliner & staycation terbaik di Puncak Purbalingga dengan konsep syariah & fasilitas lengkap
        </p>
    </div>
</section>

<!-- Deskripsi -->
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold text-accent mb-4">Guma Landscape</h2>
        <p class="text-secondary">
            Guma Landscape adalah sebuah destinasi kuliner dan wisata yang menghadirkan pengalaman lengkap dalam satu tempat. 
            Tidak hanya menyediakan hidangan lezat dengan suasana restoran yang nyaman dan estetik, Guma Landscape juga menawarkan 
            berbagai paket wisata serta layanan penyewaan villa bagi para pengunjung yang ingin menikmati waktu santai dengan nuansa alam.
        </p>
        <p class="text-secondary">
            Sebagai tempat yang dirancang untuk memberikan kenyamanan dan keindahan, Guma Landscape memadukan konsep kuliner, rekreasi, 
            dan akomodasi dalam satu kawasan. Pengunjung dapat menikmati hidangan khas sambil bersantai di area outdoor yang asri, 
            mengikuti aktivitas wisata yang tersedia, atau menginap di villa dengan fasilitas lengkap untuk liburan keluarga, gathering, 
            maupun acara spesial lainnya.
        </p>
        <p class="text-secondary">
            Dengan pelayanan ramah, lingkungan yang terawat, serta beragam pilihan paket menarik, Guma Landscape menjadi pilihan ideal 
            bagi siapa saja yang ingin merasakan pengalaman makan, berlibur, dan beristirahat dalam suasana yang tenang dan menyegarkan.
        </p>
    </div>
</section>

<!-- Tim Kami -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-accent text-center mb-5">Tim Kami</h2>
        <div class="row justify-content-center">
            <!-- Card 1 -->
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 text-center">
                    <img src="{{ asset('images/gm.png') }}" 
                         class="card-img-top rounded-circle mx-auto mt-4" 
                         style="width: 120px; height: 120px; object-fit: cover;" 
                         alt="Miftahurrozi">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-accent">Miftahurrozi</h5>
                        <p class="text-muted">General Manager</p>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 text-center">
                    <img src="{{ asset('images/wahyu.jpg') }}" 
                         class="card-img-top rounded-circle mx-auto mt-4" 
                         style="width: 120px; height: 120px; object-fit: cover;" 
                         alt="Wahyu Syafeudin">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-accent">Wahyu Syafeudin</h5>
                        <p class="text-muted">Operational Leader</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
