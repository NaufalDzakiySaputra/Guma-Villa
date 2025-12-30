@extends('layouts.frontend')

@section('content')
<section class="py-5 bg-package-section">
    <div class="container">

        {{-- HEADER --}}
        <div class="mb-4">
            <h2 class="fw-bold">{{ $package->nama }}</h2>
            <p class="text-muted mb-0">
                {{ ucfirst($package->service_type) }}
            </p>
        </div>

        <div class="row g-4">
            
            {{-- LEFT : GALLERY + DETAIL --}}
            <div class="col-lg-8">

                {{-- GALLERY --}}
                <div class="row g-2 mb-4">
                    <div class="col-12">
                        <img src="{{ asset('storage/' . $package->image_path) }}"
                             class="img-fluid rounded shadow-sm w-100"
                             style="height:360px; object-fit:cover;"
                             onerror="this.src='{{ asset('images/default-package.jpg') }}'">
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Detail Paket</h5>
                        <p class="text-muted mb-0">
                            {{ $package->description }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- RIGHT : PRICE BOX --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top:100px;">
                    <div class="card-body">

                        <p class="text-muted mb-1">Harga</p>
                        <h3 class="fw-bold text-accent mb-4">
                            IDR {{ number_format($package->price, 0, ',', '.') }}
                        </h3>

                        <a href="#" class="btn btn-guma w-100 py-2 text-white fw-bold">
                            Pesan Sekarang
                        </a>

                        <p class="text-center small text-muted mt-3 mb-0">
                            *Harga dapat berubah sewaktu-waktu
                        </p>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
