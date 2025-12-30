@extends('layouts.frontend') {{-- PERBAIKAN: Harus sesuai nama file frontend.blade.php --}}

@section('content')
<section class="bg-package-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Temukan <span class="text-accent">Pilihan Paketmu</span> di Sini</h2>
        </div>

        <div class="row g-4">
            @forelse($packages as $item)
           <div class="col-lg-3 col-md-6">
                <div class="card guma-card h-100 border-0 shadow-sm position-relative">

                    <div >
                        <img src="{{ asset('storage/' . $item->image_path) }}" 
                             class="card-img-top" 
                             alt="{{ $item->nama }}" 
                             onerror="this.src='{{ asset('images/default-package.jpg') }}'">
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="package-title">{{ $item->nama }}</h5>
                        
                        <p class="package-desc text-muted">
                            {{ Str::limit($item->description, 75) ?? 'Nikmati pengalaman tak terlupakan bersama Guma Landscape.' }}
                        </p>
                        
                        <div class="mt-auto">
                            <p class="package-price">IDR {{ number_format($item->price, 0, ',', '.') }}</p>
                            
                            <a href="{{ route('user.paket.detail', $item->id) }}"
                                 class="btn btn-detail-guma w-100">
                                    Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-info border-0 shadow-sm">
                    <i class="fas fa-info-circle me-2"></i> Saat ini belum ada paket wisata yang tersedia.
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection