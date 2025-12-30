<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\HomeController;

// === ROUTE AUTH ===
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===================== ADMIN ROUTES GROUP =====================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::post('/users/store-new', [AdminController::class, 'storeUser'])->name('users.store_new');
    
    Route::resource('news', NewsController::class);
    Route::resource('packages', PackagesController::class);
    Route::resource('payments', PaymentsController::class);
    Route::resource('menus', MenusController::class);
    Route::resource('gallery', GalleryController::class);
    
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::get('/{id}', [ReservationController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ReservationController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ReservationController::class, 'update'])->name('update');
        Route::delete('/{id}', [ReservationController::class, 'destroy'])->name('destroy');
    });
});

// ===================== ROUTE KHUSUS TAMPILAN USER (FRONTEND) ==================
Route::group(['as' => 'user.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/paket-wisata', [HomeController::class, 'paket'])->name('paket');
    
    // --- TAMBAHAN ROUTE DETAIL DISINI ---
    Route::get('/paket-wisata/{id}', [HomeController::class, 'paketDetail'])->name('paket.detail');
    
    Route::get('/daftar-menu', [HomeController::class, 'menu'])->name('menu');
    Route::get('/galeri-foto', [HomeController::class, 'galeri'])->name('galeri');
    Route::get('/berita-terbaru', [HomeController::class, 'berita'])->name('berita');
    Route::get('/tentang-kami', [HomeController::class, 'tentang'])->name('about');
});