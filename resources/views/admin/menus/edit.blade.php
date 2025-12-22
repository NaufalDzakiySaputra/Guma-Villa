<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu</title>
    <link rel="stylesheet" href="{{ asset('css/menus.css') }}">
</head>
<body>
<div class="container">
    <h4>Edit Menu</h4>
    <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <div class="form-group">
            <label>Nama Menu</label>
            <input type="text" name="name" class="input-field" value="{{ old('name', $menu->name) }}" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" class="input-field" rows="4">{{ old('description', $menu->description) }}</textarea>
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="price" class="input-field" value="{{ old('price', $menu->price) }}" required>
        </div>

        <div class="form-group">
            <label>Diskon (%)</label>
            <input type="number" name="discount" class="input-field" value="{{ old('discount', $menu->discount) }}">
        </div>

        <div class="form-group">
            <label>Gambar Saat Ini</label><br>
            @if($menu->image_path)
                <img src="{{ asset($menu->image_path) }}" class="img-preview">
            @else
                <p>Belum ada gambar</p>
            @endif
        </div>

        <div class="form-group">
            <label>Ganti Gambar</label>
            <input type="file" name="image" class="input-field">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('menus.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>