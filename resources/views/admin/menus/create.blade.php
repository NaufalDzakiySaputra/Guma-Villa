<!DOCTYPE html>
<html>
<head>
    <title>Tambah Menu</title>
</head>
<body>

<h3>Tambah Menu</h3>

<form action="{{ route('menus.store') }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf

    <p>
        Nama Menu<br>
        <input type="text" name="name" required>
    </p>

    <p>
        Deskripsi<br>
        <textarea name="description"></textarea>
    </p>

    <p>
        Harga<br>
        <input type="number" name="price" required>
    </p>

    <p>
        Diskon (%)<br>
        <input type="number" name="discount">
    </p>

    <p>
        Gambar<br>
        <input type="file" name="image">
    </p>

    <button type="submit">Simpan</button>
    <a href="{{ route('menus.index') }}">Kembali</a>
</form>

</body>
</html>