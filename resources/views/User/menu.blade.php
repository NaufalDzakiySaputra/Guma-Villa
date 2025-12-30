@extends('layouts.frontend')

@section('content')
<section class="guma-hero" style="background-image: url('{{ asset('images/hero/menu-hero.jpeg') }}');">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-white mb-0">MENU KAMI</h1>
    </div>
</section>

<div class="py-4 text-center">
    <h2 class="fw-bold" style="color: #333;">Menu Terbaik Kami</h2>
    <div style="width: 60px; height: 4px; background: #84752b; margin: 10px auto;"></div>
</div>

<section class="guma-menu-container" 
    style="background-image: linear-gradient(rgba(243, 233, 215, 0.85), rgba(243, 233, 215, 0.85)), url('{{ asset('images/bg-menu.jpg') }}'); 
           background-size: cover; 
           background-attachment: fixed; 
           padding: 60px 0;">
    <div class="container">
    
        <div class="row">
            @forelse($menus as $menu)
                {{-- col-md-6 membuat 2 kolom di laptop/PC --}}
                <div class="col-md-6 mb-4">
                    <div class="guma-menu-card-wrapper h-100 d-flex align-items-center shadow-sm p-3 bg-white" style="border-radius: 15px;">
                        
                        {{-- Sisi Kiri: Gambar Menu --}}
                        <div class="guma-menu-img-box position-relative me-3" style="flex-shrink: 0;">
                            <img src="{{ asset($menu->image_path) }}" class="guma-menu-img-square" alt="{{ $menu->name }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 12px;">
                            
                            @if($menu->discount_price && $menu->discount_price < $menu->price)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-1 shadow-sm" style="font-size: 0.7rem;">PROMO</span>
                            @endif
                        </div>

                        {{-- Sisi Kanan: Keterangan --}}
                        <div class="guma-menu-info-top d-flex flex-column h-100 justify-content-start">
                            <h3 class="fw-bold h5 mb-1" style="color: #333;">{{ $menu->name }}</h3>
                            <p class="text-muted small mb-2" style="line-height: 1.3;">{{ $menu->description }}</p>
                            
                            <div class="mt-auto">
                                @if($menu->discount_price && $menu->discount_price < $menu->price)
                                    {{-- Harga Coret --}}
                                    <span class="text-muted text-decoration-line-through small me-2" style="font-size: 0.85rem; text-decoration: line-through;">
                                        IDR {{ number_format($menu->price, 0, ',', '.') }}
                                    </span>
                                    {{-- Harga Diskon --}}
                                    <h4 class="guma-menu-price d-inline text-danger fw-bold h6 mb-0">
                                        IDR {{ number_format($menu->discount_price, 0, ',', '.') }}
                                    </h4>
                                @else
                                    {{-- Harga Normal --}}
                                    <h4 class="guma-menu-price fw-bold h6 mb-0">
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
        </div>
    </div>
</section>
@endsection