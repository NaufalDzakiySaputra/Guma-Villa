<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Foto</title>
    <link rel="stylesheet" href="{{ asset('css/gallery.css') }}">
</head>
<body>

<div class="container">
    <h1>Tambah Foto</h1>

    <form action="{{ route('gallery.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <p>
            <label>Judul</label>
            <input type="text" name="title" placeholder="Judul foto">
        </p>

        <p>
            <label>Foto</label>
            <input type="file" name="image" required>
        </p>

        <button type="submit" class="btn btn-primary">
            Simpan
        </button>

        <a href="{{ route('gallery.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>

</body>
</html>
