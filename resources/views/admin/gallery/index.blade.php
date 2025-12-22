<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <link rel="stylesheet" href="{{ asset('css/gallery.css') }}">
</head>
<body>

<div class="container">
    <h1>Gallery</h1>

    <a href="{{ route('gallery.create') }}" class="btn btn-primary">
        ➕ Tambah Foto
    </a>

    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Judul</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($galleries as $gallery)
                <tr>
                    <td>
                        <img src="{{ asset('storage/'.$gallery->image_path) }}" width="120">
                    </td>
                    <td>{{ $gallery->title }}</td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('gallery.edit', $gallery->id) }}"
                               class="btn btn-secondary">
                                Edit
                            </a>

                            <form action="{{ route('gallery.destroy', $gallery->id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger"
                                        onclick="return confirm('Hapus foto ini?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
