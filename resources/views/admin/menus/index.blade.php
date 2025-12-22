<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Menu</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Menu</h4>
        <a href="{{ route('menus.create') }}" class="btn btn-primary">
            + Tambah Menu
        </a>
    </div>

    <div class="row">
        @forelse ($menus as $menu)
            <div class="col-md-4 mb-4">
                <div class="card h-100">

                    @if($menu->image_path)
                        <img src="{{ asset($menu->image_path) }}"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">
                    @else
                        <div class="bg-light text-center py-5">
                            <span class="text-muted">Tidak ada gambar</span>
                        </div>
                    @endif

                    <div class="card-body">
                        <h5>{{ $menu->name }}</h5>
                        <p class="text-muted">
                            {{ $menu->description ?? 'Tidak ada deskripsi' }}
                        </p>

                        @if($menu->discount)
                            @php
                                $final = $menu->price - ($menu->price * ($menu->discount / 100));
                            @endphp
                            <small class="text-decoration-line-through">
                                Rp {{ number_format($menu->price,2,',','.') }}
                            </small>
                            <div class="fw-bold text-success">
                                Rp {{ number_format($final,2,',','.') }}
                            </div>
                        @else
                            <div class="fw-bold">
                                Rp {{ number_format($menu->price,2,',','.') }}
                            </div>
                        @endif
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('menus.edit', $menu->id) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('menus.destroy', $menu->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin hapus menu?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Menu belum tersedia
                </div>
            </div>
        @endforelse
    </div>
</div>

</body>
</html>