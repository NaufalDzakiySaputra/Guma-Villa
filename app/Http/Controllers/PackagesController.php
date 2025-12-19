<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    // Tampilkan semua package
    public function index()
    {
        $packages = Packages::all();
        return view('packages.index', compact('packages'));
    }

    // Form tambah package
    public function create()
    {
        return view('packages.create');
    }

    // Simpan package baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric',
            'service_type' => 'required|in:villa,wisata,nikah,mice',
        ]);

        Package::create($validated);

        return redirect()->route('packages.index')->with('success', 'Package berhasil ditambahkan!');
    }

    // Form edit package
    public function edit(Package $package)
    {
        return view('packages.edit', compact('package'));
    }

    // Update package
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric',
            'service_type' => 'required|in:villa,wisata,nikah,mice',
        ]);

        $packages->update($validated);

        return redirect()->route('packages.index')->with('success', 'Package berhasil diupdate!');

        
    }

    // Hapus package
    public function destroy(Package $package)
    {
        $packages->delete();
        return redirect()->route('packages.index')->with('success', 'Package berhasil dihapus!');
    }
}
