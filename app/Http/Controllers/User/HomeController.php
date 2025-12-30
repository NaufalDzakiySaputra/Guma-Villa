<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Packages;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Menus;
use Illuminate\Http\Request;

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

    // PERBAIKAN: Tambahkan pengambilan data agar tidak error "Undefined variable"
    public function paket() 
    { 
        // Mengambil semua data paket dari database
        $packages = Packages::all(); 
        
        // Mengirim data ke view User.paket
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
}