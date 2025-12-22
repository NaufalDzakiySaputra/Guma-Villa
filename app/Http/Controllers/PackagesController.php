<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackagesController extends Controller
{
    // Tampilkan semua paket
    public function index()
    {
        $packages = Packages::latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    // Tampilkan form tambah paket
    public function create()
    {
        return view('admin.packages.create');
    }


    // Simpan paket baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'service_type' => 'required|in:villa,wisata,nikah,mice',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('packages', 'public');
        }

        $validated['user_id'] = auth()->id();

        Packages::create($validated);

        return redirect()->route('packages.index')->with('success', 'Paket berhasil ditambahkan!');
    }

    // Tampilkan form edit paket
    public function edit(Packages $package)
    {
        return view('admin.packages.edit', compact('package'));
    }


    // Update data paket
    public function update(Request $request, Packages $packages)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'service_type' => 'required|in:villa,wisata,nikah,mice',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($packages->image_path) {
                Storage::disk('public')->delete($packages->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('packages', 'public');
        }

        $packages->update($validated);

        return redirect()->route('packages.index')->with('success', 'Paket berhasil diperbarui!');
    }

    // Hapus paket
    public function destroy(Packages $package)
    {
        if ($package->image_path) {
            Storage::disk('public')->delete($package->image_path);
        }

        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Paket berhasil dihapus!');
    }
}
