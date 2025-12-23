<link rel="stylesheet" href="{{ asset('css/menus.css') }}">

<div class="container">
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="header-wrapper">
        <h4>Daftar Menu</h4>
        <a href="{{ route('menus.create') }}" class="btn btn-primary btn-auto">+ Tambah Menu Baru</a>
    </div>

    <div class="menu-grid">
        @foreach ($menus as $menu)
            <div class="card">
                <img src="{{ asset($menu->image_path) }}" class="img-menu">
                
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
                        <button type="submit" class="btn btn-danger btn-fixed">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>