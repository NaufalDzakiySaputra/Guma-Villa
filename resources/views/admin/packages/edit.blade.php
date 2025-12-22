<!DOCTYPE html>
<html>
<head>
    <title>Edit Package</title>
</head>
<body>

<h1>Edit Package</h1>

<form action="{{ route('packages.update', $package->id) }}" 
      method="POST" 
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <p>
        Nama:<br>
        <input type="text" name="nama" value="{{ $package->nama }}">
    </p>

    <p>
        Deskripsi:<br>
        <textarea name="description">{{ $package->description }}</textarea>
    </p>

    <p>
        Harga:<br>
        <input type="number" name="price" value="{{ $package->price }}">
    </p>

    <p>
        Service Type:<br>
        <input type="text" name="service_type" value="{{ $package->service_type }}">
    </p>

    <p>
        Gambar:<br>
        <input type="file" name="image">
        @if($package->image_path)
            <br>
            <img src="{{ asset('storage/'.$package->image_path) }}" width="150">
        @endif
    </p>

    <button type="submit">Update</button>
</form>

<a href="{{ route('packages.index') }}">⬅ Kembali</a>

</body>
</html>
