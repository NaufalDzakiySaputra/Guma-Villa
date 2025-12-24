<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Menampilkan daftar berita (Admin)
     */
    public function index()
    {
        $news = News::latest()->get();
        return view('admin.news.index', compact('news'));
    }

    /**
     * Menampilkan form tambah berita
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Menyimpan data berita baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'event_date'  => 'required|date',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request
                ->file('image')
                ->store('news', 'public');
        }

        // Tanpa auth (testing)
        // $validated['user_id'] = auth()->id();
        $validated['user_id'] = null; // Karena tanpa auth

        News::create($validated);

        return redirect()
            ->route('news.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit berita
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Memperbarui data berita - DIPERBAIKI
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'event_date'  => 'required|date',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ===========================================
        // HANDLE GAMBAR (3 kemungkinan):
        // 1. Hapus gambar (remove_image = 1)
        // 2. Upload gambar baru (ada file image)
        // 3. Pertahankan gambar lama (tidak ada input)
        // ===========================================

        // 1. Jika request hapus gambar
        if ($request->has('remove_image') && $request->remove_image == '1') {
            // Hapus file dari storage jika ada
            if ($news->image_path && Storage::disk('public')->exists($news->image_path)) {
                Storage::disk('public')->delete($news->image_path);
            }
            // Set image_path ke null
            $validated['image_path'] = null;
        }
        // 2. Jika upload gambar baru
        elseif ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($news->image_path && Storage::disk('public')->exists($news->image_path)) {
                Storage::disk('public')->delete($news->image_path);
            }
            
            // Upload gambar baru
            $validated['image_path'] = $request
                ->file('image')
                ->store('news', 'public');
        }
        // 3. Jika tidak ada perubahan gambar, pertahankan yang lama
        else {
            // Jangan ubah image_path, biarkan tetap seperti sebelumnya
            unset($validated['image_path']);
        }

        $news->update($validated);

        return redirect()
            ->route('news.index')
            ->with('success', 'Berita berhasil diupdate!');
    }

    /**
     * Menghapus berita
     */
    public function destroy(News $news)
    {
        // Hapus gambar jika ada
        if ($news->image_path && Storage::disk('public')->exists($news->image_path)) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()
            ->route('news.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
}