<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu</title>
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
</head>
<body>

<div class="container">
    <h3>Edit Menu</h3>

    <form action="{{ route('menus.update', $menu->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Menu</label>
            <input type="text" name="name"
                   value="{{ old('name', $menu->name) }}" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description">{{ old('description', $menu->description) }}</textarea>
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="price"
                   value="{{ old('price', $menu->price) }}" required>
        </div>

        <div class="form-group">
            <label>Diskon (%)</label>
            <input type="number" name="discount"
                   value="{{ old('discount', $menu->discount) }}">
        </div>

        <div class="form-group">
            <label>Gambar Saat Ini</label><br>
            @if($menu->image_path)
                <img src="{{ asset($menu->image_path) }}" width="150">
            @else
                <em>Belum ada gambar</em>
            @endif
        </div>

        <div class="form-group">
            <label>Ganti Gambar</label>
            <input type="file" name="image">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('menus.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>
