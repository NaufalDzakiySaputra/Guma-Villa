@extends('layouts.frontend')

@section('content')
{{-- Hero Menu --}}
<section class="guma-menu-hero text-center py-5" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('images/hero/menu-hero.jpg') }}'); background-size: cover; background-position: center; min-height: 300px; display: flex; align-items: center; justify-content: center;">
    <h1 class="text-white fw-bold display-4">MENU KAMI</h1>
</section>

{{-- Judul Section --}}
<div class="py-4 text-center">
    <h2 class="fw-bold" style="color: #333;">Menu Terbaik Kami</h2>
    <div style="width: 60px; height: 4px; background: #84752b; margin: 10px auto;"></div>
</div>

<section class="guma-menu-container">
    <div class="container">
        {{-- Tambahkan Row di sini agar card bisa berjajar ke samping --}}
        <div class="row">
            @forelse($menus as $menu)
                {{-- col-md-6 artinya membagi layar menjadi 2 kolom di PC --}}
                <div class="col-md-6 mb-4">
                    <div class="guma-menu-card-wrapper h-100">
                        
                        {{-- Gambar di Kiri Card --}}
                        <div class="guma-menu-img-box position-relative">
                            <img src="{{ asset($menu->image_path) }}" class="guma-menu-img-square shadow-sm" alt="{{ $menu->name }}">
                            
                            @if($menu->discount_price && $menu->discount_price < $menu->price)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2 shadow-sm">PROMO</span>
                            @endif
                        </div>

                        {{-- Keterangan Teks di Kanan Card --}}
                        <div class="guma-menu-info-top">
                            <h3 class="fw-bold">{{ $menu->name }}</h3>
                            <p class="text-muted small">{{ $menu->description }}</p>
                            
                            <div class="mt-auto">
                                @if($menu->discount_price && $menu->discount_price < $menu->price)
                                    <span class="text-muted text-decoration-line-through small me-2">
                                        IDR {{ number_format($menu->price, 0, ',', '.') }}
                                    </span>
                                    <h4 class="guma-menu-price d-inline text-danger">
                                        IDR {{ number_format($menu->discount_price, 0, ',', '.') }}
                                    </h4>
                                @else
                                    <h4 class="guma-menu-price">
                                        IDR {{ number_format($menu->price, 0, ',', '.') }}
                                    </h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted italic">Menu belum tersedia saat ini.</p>
                </div>
            @endforelse
        </div> {{-- End Row --}}
    </div>
</section>
@endsection