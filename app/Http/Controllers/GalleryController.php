<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // Tampilkan semua foto
    public function index()
    {
        $galleries = Gallery::all();
        return view('galleries.index', compact('galleries'));
    }

    // Form upload foto
    public function create()
    {
        return view('galleries.create');
    }

    // Simpan foto baru
    public function store(Request $request)
    {
        Gallery::create($request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'required|string',
            'uploaded_by' => 'required|exists:users,id',
        ]));

        return redirect()->route('galleries.index')->with('success', 'Foto berhasil ditambahkan!');
    }

    // Form edit foto
    public function edit(Gallery $gallery)
    {
        return view('galleries.edit', compact('gallery'));
    }

    // Update foto
    public function update(Request $request, Gallery $gallery)
    {
        $gallery->update($request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'required|string',
            'uploaded_by' => 'required|exists:users,id',
        ]));

        return redirect()->route('galleries.index')->with('success', 'Foto berhasil diupdate!');
    }

    // Hapus foto
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('galleries.index')->with('success', 'Foto berhasil dihapus!');
    }
}
