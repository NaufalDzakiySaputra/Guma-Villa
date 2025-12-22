<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Berita</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2 class="mb-4">Tambah Berita</h2>

    <a href="{{ route('news.index') }}" class="btn btn-secondary mb-3">
        ← Kembali
    </a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Judul Berita</label>
            <input type="text"
                   name="title"
                   class="form-control"
                   value="{{ old('title') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description"
                      rows="5"
                      class="form-control"
                      required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Event</label>
            <input type="date"
                   name="event_date"
                   class="form-control"
                   value="{{ old('event_date') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar (Opsional)</label>
            <input type="file"
                   name="image"
                   class="form-control"
                   accept="image/*">
        </div>

        <button class="btn btn-primary">
            Simpan
        </button>
    </form>

</div>

</body>
</html>
