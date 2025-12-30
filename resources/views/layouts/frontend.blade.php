@extends('layouts.frontend')

@section('title', 'Menu Cafe - Guma Landscape')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: #A0522D;">Menu Cafe Guma</h1>
        <p class="text-muted">Nikmati berbagai pilihan makanan dan minuman terbaik kami</p>
    </div>
    
    <!-- Placeholder untuk menu -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-coffee fa-3x mb-3" style="color: #A0522D;"></i>
                    <h5 class="card-title">Minuman</h5>
                    <p class="card-text">Kopi, teh, jus, dan berbagai minuman segar lainnya.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-utensils fa-3x mb-3" style="color: #A0522D;"></i>
                    <h5 class="card-title">Makanan</h5>
                    <p class="card-text">Makanan berat dan ringan dengan cita rasa terbaik.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-birthday-cake fa-3x mb-3" style="color: #A0522D;"></i>
                    <h5 class="card-title">Snack & Dessert</h5>
                    <p class="card-text">Camilan dan dessert untuk teman bersantai Anda.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <p class="text-muted">Menu lengkap akan segera tersedia.</p>
    </div>
</div>
@endsection
