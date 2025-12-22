<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu</title>
    <link rel="stylesheet" href="{{ asset('css/menus.css') }}">
</head>
<body>
<div class="container">
    <h4>Tambah Menu</h4>
    <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nama Menu</label>
            <input type="text" name="name" class="input-field" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" class="input-field" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="price" class="input-field" required>
        </div>
        <div class="form-group">
            <label>Diskon (%)</label>
            <input type="number" name="discount" class="input-field">
        </div>
        <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="image" class="input-field">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('menus.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>