@extends('layouts.frontend')

@section('content')
<section class="py-5 bg-package-section">
    <div class="container">
        <div class="mb-4">
            <h2 class="fw-bold">{{ $package->nama }}</h2>
            <p class="text-muted mb-0">{{ ucfirst($package->service_type) }}</p>
        </div>

        <div class="row g-4 align-items-start">
            <div class="col-lg-8">
                <div class="mb-4">
                    <img
                        src="{{ asset('storage/' . $package->image_path) }}"
                        class="img-fluid rounded shadow-sm w-100"
                        style="height:360px; object-fit:cover;"
                        onerror="this.src='{{ asset('images/default-package.jpg') }}'"
                        alt="{{ $package->nama }}">
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Detail Paket</h5>
                        <p class="text-muted mb-0">{{ $package->description }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="price-sticky">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <p class="text-muted mb-1">Harga</p>
                            <h3 class="fw-bold text-accent mb-4">
                                IDR {{ number_format($package->price, 0, ',', '.') }}
                            </h3>
                            @auth
                                {{-- USER SUDAH LOGIN: Langsung ke form reservasi --}}
                                <form action="{{ route('user.reservation.create') }}" method="GET">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">
                                            <i class="fas fa-calendar-alt me-1"></i> Tanggal Keberangkatan *
                                        </label>
                                        <input type="date" 
                                               name="date" 
                                               class="form-control form-control-sm"
                                               min="{{ date('Y-m-d') }}"
                                               value="{{ date('Y-m-d') }}"
                                               required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label small fw-bold">
                                            <i class="fas fa-users me-1"></i> Jumlah Orang *
                                        </label>
                                        <input type="number" 
                                               name="jumlah_orang" 
                                               class="form-control form-control-sm"
                                               min="1" 
                                               value="1"
                                               required>
                                    </div>
                                    
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    
                                    <button type="submit" class="btn btn-guma w-100 py-3 fw-bold">
                                        <i class="fas fa-shopping-cart me-2"></i> Pesan Sekarang
                                    </button>
                                    <p class="text-center small text-success mt-2 mb-0">
                                        <i class="fas fa-user-check me-1"></i>
                                        Anda sudah login, langsung lanjutkan reservasi
                                    </p>
                                </form>
                            @else
                                {{-- USER BELUM LOGIN: Simpan dulu, lalu ke login --}}
                                <form action="{{ route('user.pesan.sekarang') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">
                                            <i class="fas fa-calendar-alt me-1"></i> Tanggal Keberangkatan *
                                        </label>
                                        <input type="date" 
                                               name="date" 
                                               class="form-control form-control-sm"
                                               min="{{ date('Y-m-d') }}"
                                               value="{{ date('Y-m-d') }}"
                                               required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label small fw-bold">
                                            <i class="fas fa-users me-1"></i> Jumlah Orang *
                                        </label>
                                        <input type="number" 
                                               name="jumlah_orang" 
                                               class="form-control form-control-sm"
                                               min="1" 
                                               value="1"
                                               required>
                                    </div>
                                    
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    <input type="hidden" name="service_type" value="{{ $package->service_type }}">
                                    
                                    <button type="submit" class="btn btn-guma w-100 py-3 fw-bold">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login untuk Pesan
                                    </button>
                                    <p class="text-center small text-muted mt-2 mb-0">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Anda akan diarahkan ke halaman login untuk melanjutkan
                                    </p>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection