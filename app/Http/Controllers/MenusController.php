<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenusController extends Controller
{
    // Tampilkan semua menu
    public function index()
    {
        $menus = Menus::latest()->get();
        return view('admin.menus.index', compact('menus'));
    }

    // Form tambah menu
    public function create()
    {
        return view('admin.menus.create');
    }

    // Simpan menu baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'discount'    => 'nullable|numeric|min:0|max:100',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $validated['image_path'] = 'storage/' . $path;
        }

        // Set discount ke 0 jika null atau kosong
        if (empty($validated['discount'])) {
            $validated['discount'] = 0;
        }

        Menus::create($validated);

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    // Form edit menu
    public function edit(Menus $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    // Update menu - DIPERBAIKI untuk handle remove_image
    public function update(Request $request, Menus $menu)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'discount'    => 'nullable|numeric|min:0|max:100',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ===========================================
        // HANDLE GAMBAR (3 kemungkinan):
        // 1. Hapus gambar (remove_image = 1)
        // 2. Upload gambar baru (ada file image)
        // 3. Pertahankan gambar lama (tidak ada input)
        // ===========================================

        // 1. Jika request hapus gambar
        if ($request->has('remove_image') && $request->remove_image == '1') {
            // Hapus file dari storage
            if ($menu->image_path && Storage::disk('public')->exists(str_replace('storage/', '', $menu->image_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $menu->image_path));
            }
            // Set image_path ke null
            $validated['image_path'] = null;
        }
        // 2. Jika upload gambar baru
        elseif ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image_path && Storage::disk('public')->exists(str_replace('storage/', '', $menu->image_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $menu->image_path));
            }
            
            // Upload gambar baru
            $path = $request->file('image')->store('menus', 'public');
            $validated['image_path'] = 'storage/' . $path;
        }
        // 3. Jika tidak ada perubahan gambar, pertahankan yang lama
        else {
            // Jangan ubah image_path, biarkan tetap seperti sebelumnya
            unset($validated['image_path']);
        }

        // Set discount ke 0 jika null atau kosong
        if (empty($validated['discount'])) {
            $validated['discount'] = 0;
        }

        // Update data
        $menu->update($validated);

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    // Hapus menu
    public function destroy(Menus $menu)
    {
        // Hapus gambar jika ada
        if ($menu->image_path && Storage::disk('public')->exists(str_replace('storage/', '', $menu->image_path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $menu->image_path));
        }

        $menu->delete();

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}