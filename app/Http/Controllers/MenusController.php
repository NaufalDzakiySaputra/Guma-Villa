<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    // Tampilkan semua menu
    public function index()
    {
        $menus = Menus::all();
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
            'price'       => 'required|numeric',
            'discount'    => 'nullable|numeric',
            'image_path'  => 'nullable|string',
        ]);

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

    // Update menu
    public function update(Request $request, Menus $menu)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'discount'    => 'nullable|numeric',
            'image_path'  => 'nullable|string',
        ]);

        $menu->update($validated);

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil diupdate!');
    }

    // Hapus menu
    public function destroy(Menus $menu)
    {
        $menu->delete();

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}
