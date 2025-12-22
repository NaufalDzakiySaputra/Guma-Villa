<h1>Daftar Packages</h1>

<a href="{{ route('packages.create') }}">➕ Tambah Package</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Nama</th>
        <th>Harga</th>
        <th>Service Type</th>
        <th>Aksi</th>
    </tr>

    @foreach ($packages as $package)
        <tr>
            <td>{{ $package->nama }}</td>
            <td>{{ $package->price }}</td>
            <td>{{ $package->service_type }}</td>
            <td>
                <a href="{{ route('packages.edit', $package->id) }}">Edit</a>

                <form action="{{ route('packages.destroy', $package->id) }}"
                      method="POST"
                      style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
