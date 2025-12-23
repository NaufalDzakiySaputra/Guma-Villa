<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title >Daftar Menu</title>
    <link rel="stylesheet" href="{{ asset('css/menus.css') }}">
</head>
<body>
    <header class="main-header">
        <div class="header-wrapper">
            <h4>Daftar Menu</h4>
            <a href="{{ route('menus.create') }}" class="btn btn-primary btn-auto">+ Tambah Menu Baru</a>
        </div>
    </header>

    <div class="container">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="menu-grid">
            @foreach ($menus as $menu)
                <div class="card">
                    @if($menu->image_path)
                        <img src="{{ asset($menu->image_path) }}" class="img-menu">
                    @else
                        <div class="no-image">Tidak ada gambar</div>
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $menu->name }}</h5>
                        <p class="card-text">{{ $menu->description }}</p>

                        <div class="price-wrapper">
                            @if($menu->discount > 0)
                                <span class="price-old">{{ $menu->format_harga }}</span>
                                <div class="price-new">{{ $menu->format_diskon }}</div>
                            @else
                                <div class="price-new">{{ $menu->format_harga }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-warning btn-fixed">Edit</a>
                        <form action="{{ route('menus.destroy', $menu->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-fixed" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>