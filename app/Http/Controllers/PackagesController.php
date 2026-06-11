<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackagesController extends Controller
{
    public function index()
    {
        $packages = Packages::latest()->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'max_people'   => 'required|integer|min:1|max:1000',
            'service_type' => 'required|in:villa,wisata,nikah,mice',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama.required' => 'Nama paket wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'max_people.required' => 'Maksimal orang wajib diisi.',
            'max_people.integer' => 'Maksimal orang harus berupa angka.',
            'max_people.min' => 'Maksimal orang minimal 1.',
            'max_people.max' => 'Maksimal orang terlalu besar.',
            'service_type.required' => 'Jenis layanan wajib dipilih.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('packages', 'public');
        }

        $validated['user_id'] = auth()->id();

        Packages::create($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(Packages $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Packages $package)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'max_people'   => 'required|integer|min:1|max:1000',
            'service_type' => 'required|in:villa,wisata,nikah,mice',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama.required' => 'Nama paket wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'max_people.required' => 'Maksimal orang wajib diisi.',
            'max_people.integer' => 'Maksimal orang harus berupa angka.',
            'max_people.min' => 'Maksimal orang minimal 1.',
            'max_people.max' => 'Maksimal orang terlalu besar.',
            'service_type.required' => 'Jenis layanan wajib dipilih.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('image')) {
            if ($package->image_path) {
                Storage::disk('public')->delete($package->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('packages', 'public');
        }

        $package->update($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(Packages $package)
    {
        if ($package->image_path) {
            Storage::disk('public')->delete($package->image_path);
        }

        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil dihapus.');
    }
}