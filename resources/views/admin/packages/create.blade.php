<!DOCTYPE html>
<html>
<head>
    <title>Tambah Package</title>
    <link rel="stylesheet" href="{{ asset('css/packages.css') }}">
</head>
<body>

<h1>Tambah Package</h1>

<form action="{{ route('packages.store') }}" 
      method="POST" 
      enctype="multipart/form-data">

    @csrf

    <p>
        Nama:<br>
        <input type="text" name="nama">
    </p>

    <p>
        Deskripsi:<br>
        <textarea name="description"></textarea>
    </p>

    <p>
        Harga:<br>
        <input type="number" name="price">
    </p>

    <p>
        Service Type:<br>
        <select name="service_type">
            <option value="villa">Villa</option>
            <option value="wisata">Wisata</option>
            <option value="nikah">Nikah</option>
            <option value="mice">MICE</option>
        </select>
    </p>

    <p>
        Gambar:<br>
        <input type="file" name="image">
    </p>

    <button type="submit">Simpan</button>
</form>

<a href="{{ route('packages.index') }}">⬅ Kembali</a>

</body>
</html>
