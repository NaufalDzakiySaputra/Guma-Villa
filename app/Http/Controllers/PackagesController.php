<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackagesController extends Controller
{
    // Menampilkan semua data paket
    public function index()
    {
        $packages = Packages::with('user')->latest()->get();
        return view('packages.index', compact('packages'));
    }

    // Menampilkan form tambah paket
    public function create()
    {
        return view('packages.create');
    }

    // Menyimpan data paket baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'service_type' => 'required|string|max:100',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('packages', 'public');
        }

        $validated['user_id'] = auth()->id();

        Packages::create($validated);

        return redirect()->route('packages.index')->with('success', 'Paket berhasil ditambahkan!');
    }

    // Menampilkan form edit paket
    public function edit(Packages $packages)
    {
        return view('packages.edit', compact('packages'));
    }

    // Menyimpan perubahan data paket
    public function update(Request $request, Packages $packages)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'service_type' => 'required|string|max:100',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($packages->image_path) {
                Storage::disk('public')->delete($packages->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('packages', 'public');
        }

        $packages->update($validated);

        return redirect()->route('packages.index')->with('success', 'Paket berhasil diperbarui!');
    }

    // Menghapus data paket
    public function destroy(Packages $packages)
    {
        if ($packages->image_path) {
            Storage::disk('public')->delete($packages->image_path);
        }

        $packages->delete();

        return redirect()->route('packages.index')->with('success', 'Paket berhasil dihapus!');
    }
}
