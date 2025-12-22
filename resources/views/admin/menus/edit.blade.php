<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h4 class="mb-3">Edit Menu</h4>

    <form action="{{ route('menus.update', $menu->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Menu</label>
            <input type="text" name="name"
                   class="form-control"
                   value="{{ old('name', $menu->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description"
                      class="form-control">{{ old('description', $menu->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price"
                   class="form-control"
                   value="{{ old('price', $menu->price) }}" required>
        </div>

        <div class="mb-3">
            <label>Diskon (%)</label>
            <input type="number" name="discount"
                   class="form-control"
                   value="{{ old('discount', $menu->discount) }}">
        </div>

        <div class="mb-3">
            <label>Gambar Saat Ini</label><br>
            @if($menu->image_path)
                <img src="{{ asset($menu->image_path) }}"
                     width="150"
                     class="mb-2 rounded">
            @else
                <p class="text-muted">Belum ada gambar</p>
            @endif
        </div>

        <div class="mb-3">
            <label>Ganti Gambar</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('menus.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>

</body>
</html>