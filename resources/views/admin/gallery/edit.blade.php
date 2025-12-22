<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Foto</title>
    <link rel="stylesheet" href="{{ asset('css/gallery.css') }}">
</head>
<body>

<div class="container">
    <h1>Edit Foto</h1>

    <form action="{{ route('gallery.update', $gallery->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <p>
            <label>Judul</label>
            <input type="text"
                   name="title"
                   value="{{ $gallery->title }}">
        </p>

        <div class="image-preview">
            <label>Foto Saat Ini</label>
            <img src="{{ asset('storage/'.$gallery->image_path) }}">
        </div>

        <p>
            <label>Ganti Foto (opsional)</label>
            <input type="file" name="image">
        </p>

        <button type="submit" class="btn btn-primary">
            Update
        </button>

        <a href="{{ route('gallery.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>

</body>
</html>
