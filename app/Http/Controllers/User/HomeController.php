<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Packages;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $packages = Packages::latest()->take(4)->get();
        $news = News::latest()->take(3)->get();
        $galleries = Gallery::latest()->take(6)->get();
        $menus = Menus::latest()->take(4)->get();

        return view('user.beranda', compact('packages', 'news', 'galleries', 'menus'));
    }

    public function paket()
    {
        $packages = Packages::all();

        return view('user.paket', compact('packages'));
    }

    public function paketDetail($id)
    {
        $package = Packages::findOrFail($id);

        return view('user.paket-detail', compact('package'));
    }

    public function menu()
    {
        $menus = Menus::all();

        return view('user.menu', compact('menus'));
    }

    public function galeri()
    {
        $galleries = Gallery::all();

        return view('user.galeri', compact('galleries'));
    }

    public function berita()
    {
        $news = News::latest()->get();

        return view('user.berita', compact('news'));
    }

    public function tentang()
    {
        return view('user.about');
    }

    /**
     * Handle tombol "Pesan Sekarang"
     */
    public function pesanSekarang(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'service_type' => 'required|in:villa,wisata,nikah,mice',
            'date' => 'required|date|after_or_equal:today',
            'jumlah_orang' => 'required|integer|min:1',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin tidak boleh masuk alur reservasi
        |--------------------------------------------------------------------------
        | Jika admin klik tombol "Pesan Sekarang", jangan simpan session
        | pending_reservation. Langsung arahkan ke dashboard admin.
        */
        if (Auth::check() && Auth::user()->role === 'admin') {
            Session::forget('pending_reservation');

            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin tidak dapat melakukan reservasi sebagai pelanggan.');
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan data reservasi sementara
        |--------------------------------------------------------------------------
        | Data ini dipakai kalau user belum login.
        | Setelah login, user akan diarahkan ke form reservasi.
        */
        Session::put('pending_reservation', [
            'package_id' => $request->package_id,
            'service_type' => $request->service_type,
            'date' => $request->date,
            'jumlah_orang' => $request->jumlah_orang,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Jika user sudah login
        |--------------------------------------------------------------------------
        | Langsung arahkan ke form reservasi.
        */
        if (Auth::check() && Auth::user()->role === 'user') {
            return redirect()->route('user.reservation.create')
                ->with('success', 'Silakan lengkapi data reservasi.');
        }

        /*
        |--------------------------------------------------------------------------
        | Jika belum login
        |--------------------------------------------------------------------------
        | Arahkan ke halaman login terlebih dahulu.
        */
        return redirect()->route('login')
            ->with('info', 'Silakan login untuk melanjutkan reservasi.');
    }
}