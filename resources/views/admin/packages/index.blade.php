<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Menu</title>
    <link rel="stylesheet" href="{{ asset('css/menus.css') }}">
</head>
<body>
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="header-wrapper">
        <h4>Daftar Menu</h4>
        <a href="{{ route('menus.create') }}" class="btn btn-primary">+ Tambah Menu</a>
    </div>

    <div class="menu-grid">
        @forelse ($menus as $menu)
            <div class="card">
                @if($menu->image_path)
                    <img src="{{ asset($menu->image_path) }}" class="card-img">
                @else
                    <div class="no-image">Tidak ada gambar</div>
                @endif

                <div class="card-body">
                    <h5>{{ $menu->name }}</h5>
                    <p>{{ $menu->description ?? 'Tidak ada deskripsi' }}</p>

                    <div class="price-container">
                        @if($menu->discount)
                            @php $final = $menu->price - ($menu->price * ($menu->discount / 100)); @endphp
                            <div class="price-old">Rp {{ number_format($menu->price,2,',','.') }}</div>
                            <div class="price-new">Rp {{ number_format($final,2,',','.') }}</div>
                        @else
                            <div class="price-regular">Rp {{ number_format($menu->price,2,',','.') }}</div>
                        @endif
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p>Menu belum tersedia</p>
        @endforelse
    </div>
</div>
</body>
</html>