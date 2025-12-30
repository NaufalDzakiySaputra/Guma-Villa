@extends('layouts.frontend')

@section('content')
<section class="py-5" style="background-color: #f8f5f0; min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm p-4 text-center" style="border-radius: 20px;">
                    <div class="mb-4">
                        {{-- Mengambil inisial nama jika foto belum ada di database --}}
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=84752b&color=fff&size=150" 
                             class="rounded-circle shadow" alt="User Avatar">
                    </div>

                    <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    <div class="mb-4">
                        {{-- Badge dinamis berdasarkan kolom role di database --}}
                        @if($user->role === 'admin')
                            <span class="badge bg-danger px-4 py-2" style="font-size: 0.8rem;">ADMINISTRATOR</span>
                        @else
                            <span class="badge bg-success px-4 py-2" style="font-size: 0.8rem;">MEMBER GUMA</span>
                        @endif
                    </div>

                    <hr class="my-4" style="opacity: 0.1;">

                    <div class="d-grid gap-2">
                        @if($user->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-dark py-2">
                                <i class="fas fa-tachometer-alt me-2"></i> Ke Dashboard Admin
                            </a>
                        @endif

                        {{-- Tombol Kembali ke Beranda --}}
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary py-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 py-2">
                                <i class="fas fa-sign-out-alt me-2"></i> Keluar dari Akun
                            </button>
                        </form>
                    </div>
                </div>
                
                <p class="text-center mt-4 text-muted small">Guma Landscape &copy; 2025</p>
            </div>
        </div>
    </div>
</section>
@endsection