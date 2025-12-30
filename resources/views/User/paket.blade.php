<section class="bg-package-section">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Temukan <span class="text-accent">Pilihan Paketmu</span> di Sini</h2>
        </div>

        <div class="row g-4">
            @foreach($packages as $item)
            <div class="col-lg-4 col-md-6">
                <div class="card guma-card">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->nama }}">
                    
                    <div class="card-body">
                        <h5 class="package-title">{{ $item->nama }}</h5>
                        
                        <p class="package-desc text-muted">
                            {{ Str::limit($item->description, 50) ?? 'Keterangan paket belum tersedia' }}
                        </p>
                        
                        <p class="package-price">IDR {{ number_format($item->price, 0, ',', '.') }}</p>
                        
                        <a href="{{ route('user.paket.detail', $item->id) }}" class="btn btn-detail-guma">
                            Lihat Detail <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>