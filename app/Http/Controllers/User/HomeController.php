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
     * Handle tombol "Pesan Sekarang" untuk user BELUM login
     */
    public function pesanSekarang(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'service_type' => 'required|in:villa,wisata,nikah,mice',
            'date' => 'required|date|after_or_equal:today',
            'jumlah_orang' => 'required|integer|min:1',
        ]);
        
        // Simpan data ke session
        Session::put('pending_reservation', [
            'package_id' => $request->package_id,
            'service_type' => $request->service_type,
            'date' => $request->date,
            'jumlah_orang' => $request->jumlah_orang,
        ]);
        
        // Redirect ke login (karena user belum login)
        return redirect()->route('login')
            ->with('info', 'Silakan login untuk melanjutkan reservasi.');
    }
}