<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Berita</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2 class="mb-4">Manajemen Berita</h2>

    <a href="{{ route('news.create') }}" class="btn btn-primary mb-3">
        + Tambah Berita
    </a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tanggal</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($news as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->event_date->format('d M Y') }}</td>
                    <td>
                        @if ($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" width="80">
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('news.edit', $item) }}" class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('news.destroy', $item) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin hapus berita ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Belum ada berita.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

</body>
</html>
