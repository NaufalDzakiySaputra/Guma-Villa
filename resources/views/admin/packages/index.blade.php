<!DOCTYPE html>
<html>
<head>
    <title>Daftar Packages</title>
    <link rel="stylesheet" href="{{ asset('css/packages.css') }}">
</head>
<body>

<div class="container">
    <h1>Daftar Packages</h1>

    <a href="{{ route('packages.create') }}" class="btn">➕ Tambah Package</a>

    <table>
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Service Type</th>
            <th>Aksi</th>
        </tr>

        @foreach ($packages as $package)
        <tr>
            <td>{{ $package->nama }}</td>
            <td>Rp {{ number_format($package->price) }}</td>
            <td>{{ ucfirst($package->service_type) }}</td>
            <td>
                <a href="{{ route('packages.edit', $package->id) }}" class="btn">Edit</a>

                <form action="{{ route('packages.destroy', $package->id) }}"
                      method="POST"
                      style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

</body>
</html>