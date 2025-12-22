@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Tambah Menu</h4>

    <form action="{{ route('menus.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Menu</label>
            <input type="text" name="name"
                   class="form-control"
                   value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description"
                      class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price"
                   class="form-control"
                   value="{{ old('price') }}" required>
        </div>

        <div class="mb-3">
            <label>Diskon (%)</label>
            <input type="number" name="discount"
                   class="form-control"
                   value="{{ old('discount') }}">
        </div>

        <div class="mb-3">
            <label>Image Path</label>
            <input type="text" name="image_path"
                   class="form-control"
                   value="{{ old('image_path') }}">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('menus.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>
@endsection
