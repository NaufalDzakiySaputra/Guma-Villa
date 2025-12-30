@extends('layouts.frontend')

@section('content')
<section class="py-5 bg-package-section">
    <div class="container">

        {{-- HEADER --}}
        <div class="text-center mb-5">
            <h2 class="fw-bold">
                Galeri <span class="text-accent">Guma Landscape</span>
            </h2>
            <p class="text-muted mb-0">
                Dokumentasi kegiatan dan keindahan alam kami
            </p>
        </div>

        {{-- GALLERY GRID --}}
        <div class="row g-4">
            @forelse ($galleries as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item shadow-sm rounded overflow-hidden">

                        <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal{{ $item->id }}">
                            <img
                                src="{{ asset('storage/' . $item->image_path) }}"
                                class="img-fluid w-100"
                                style="height:260px; object-fit:cover;"
                                alt="{{ $item->title ?? 'Gallery Image' }}"
                                onerror="this.src='{{ asset('images/default-gallery.jpg') }}'">
                        </a>

                        @if($item->title)
                            <div class="p-3 bg-white">
                                <h6 class="mb-0 fw-semibold text-center">
                                    {{ $item->title }}
                                </h6>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- MODAL PREVIEW --}}
                <div class="modal fade" id="galleryModal{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0">
                            <div class="modal-body p-0">
                                <img
                                    src="{{ asset('storage/' . $item->image_path) }}"
                                    class="img-fluid w-100 rounded"
                                    alt="{{ $item->title ?? 'Gallery Image' }}">
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center shadow-sm border-0">
                        <i class="fas fa-image me-2"></i>
                        Belum ada galeri yang ditampilkan.
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</section>
@endsection
