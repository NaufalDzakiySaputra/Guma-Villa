<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Packages;
use App\Models\Menus;
use App\Models\News;
use App\Models\Gallery;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman Dashboard dengan statistik lengkap.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Statistik Dasar
        $stats = [
            'total_news'    => News::count(),
            'total_gallery' => Gallery::count(),
        ];

        // Tambahkan statistik khusus Admin jika role sesuai
        if ($user && $user->role === 'admin') {
            $stats['total_packages'] = Packages::count();
            $stats['total_menus']    = Menus::count();
            $stats['total_users']    = User::count();
        }

        $recent_galleries = Gallery::latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recent_galleries'));
    }

    /**
     * Fungsi untuk menyimpan User atau Admin baru.
     * Dipanggil saat Admin mengisi form "Tambah User".
     */
    public function storeUser(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,user',
        ]);

        // Simpan ke database
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role, // Admin menentukan role di sini
        ]);

        return redirect()->back()->with('success', 'User/Admin baru berhasil ditambahkan!');
    }

    /**
     * Data statistik untuk sidebar atau API.
     */
    public function getSidebarStats()
    {
        return [
            'reservations'         => Reservation::count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'packages'             => Packages::count(),
            'menus'                => Menus::count(),
            'news'                 => News::count(),
            'gallery'              => Gallery::count(),
        ];
    }
}