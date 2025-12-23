<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Paket</title>
    <link rel="stylesheet" href="{{ asset('css/packages.css') }}">
</head>
<body>

<div class="container">
    <h2>Edit Paket</h2>

    {{-- error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('packages.update', $package->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Paket</label>
            <input type="text"
                   name="nama"
                   value="{{ old('nama', $package->nama) }}"
                   required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description"
                      rows="4">{{ old('description', $package->description) }}</textarea>
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number"
                   name="price"
                   value="{{ old('price', $package->price) }}"
                   required>
        </div>

        <div class="form-group">
            <label>Tipe Layanan</label>
            <select name="service_type" required>
                <option value="villa" {{ $package->service_type == 'villa' ? 'selected' : '' }}>Villa</option>
                <option value="wisata" {{ $package->service_type == 'wisata' ? 'selected' : '' }}>Wisata</option>
                <option value="nikah" {{ $package->service_type == 'nikah' ? 'selected' : '' }}>Nikah</option>
                <option value="mice" {{ $package->service_type == 'mice' ? 'selected' : '' }}>MICE</option>
            </select>
        </div>

        <div class="form-group">
            <label>Gambar Saat Ini</label><br>
            @if ($package->image_path)
                <img src="{{ asset('storage/'.$package->image_path) }}"
                     width="200"
                     style="margin-bottom:10px;">
            @else
                <p><i>Tidak ada gambar</i></p>
            @endif
        </div>

        <div class="form-group">
            <label>Ganti Gambar (opsional)</label>
            <input type="file" name="image">
        </div>

        <div class="form-action">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('packages.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

</body>
</html>