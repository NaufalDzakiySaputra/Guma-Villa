<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <link rel="stylesheet" href="{{ asset('css/menus.css') }}">
</head>
<body>
    <div class="container-x form-container">
        <h4 style="text-align: center;">Edit Menu</h4>
        
        <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('PUT')
            
            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="name" class="input-field" value="{{ $menu->name }}">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="input-field" rows="4">{{ $menu->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="price" class="input-field" value="{{ $menu->price }}">
            </div>

            <div class="form-group">
                <label>Diskon (%)</label>
                <input type="number" name="discount" class="input-field" value="{{ $menu->discount }}">
            </div>

            <div class="form-group">
                <label>Gambar Saat Ini</label>
                @if($menu->image_path)
                    <img src="{{ asset($menu->image_path) }}" class="img-edit-preview">
                @endif
                <input type="file" name="image" class="input-field">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-fixed">Update</button>
                <a href="{{ route('menus.index') }}" class="btn btn-secondary btn-fixed">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>