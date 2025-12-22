<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // upload file
        $validated['image_path'] = $request->file('image')
            ->store('gallery', 'public');

        // sementara null (karena tanpa auth)
        $validated['uploaded_by'] = null;

        Gallery::create($validated);

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Gallery berhasil ditambahkan');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // hapus foto lama
            Storage::disk('public')->delete($gallery->image_path);

            $validated['image_path'] = $request->file('image')
                ->store('gallery', 'public');
        }

        $gallery->update($validated);

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Gallery berhasil diupdate');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Gallery berhasil dihapus');
    }
}
