<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Menampilkan daftar berita (Admin)
     */
    public function index()
    {
        $news = News::with('user')->latest()->get();
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

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request
                ->file('image')
                ->store('news', 'public');
        }

        // Tanpa auth (testing)
       $validated['user_id'] = auth()->id();

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
     * Memperbarui data berita
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'event_date'  => 'required|date',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request
                ->file('image')
                ->store('news', 'public');
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
        $news->delete();

        return redirect()
            ->route('news.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
}