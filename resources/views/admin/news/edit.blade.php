<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Berita</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2 class="mb-4">Edit Berita</h2>

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

    <form action="{{ route('news.update', $news) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Judul Berita</label>
            <input type="text"
                   name="title"
                   class="form-control"
                   value="{{ old('title', $news->title) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description"
                      rows="5"
                      class="form-control"
                      required>{{ old('description', $news->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Event</label>
            <input type="date"
                   name="event_date"
                   class="form-control"
                   value="{{ old('event_date', $news->event_date->format('Y-m-d')) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar (Opsional)</label>
            <input type="file"
                   name="image"
                   class="form-control"
                   accept="image/*">
        </div>

        @if ($news->image_path)
            <div class="mb-3">
                <p>Gambar Saat Ini:</p>
                <img src="{{ asset('storage/' . $news->image_path) }}" width="150">
            </div>
        @endif

        <button class="btn btn-primary">
            Update
        </button>
    </form>

</div>

</body>
</html>
