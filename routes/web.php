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
use App\Http\Controllers\User\UserReservationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\PaymentController as UserPaymentController;

// ROUTE AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
Route::put('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('user.profile.update');

// ADMIN ROUTES GROUP
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::post('/users/store-new', [AdminController::class, 'storeUser'])->name('users.store_new');
    
    Route::resource('news', NewsController::class);
    Route::resource('packages', PackagesController::class);
    
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentsController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [PaymentsController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PaymentsController::class, 'update'])->name('update');
        Route::get('/proof/{id}', [PaymentsController::class, 'showProof'])->name('proof.show');
    });
    
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

// ROUTE KHUSUS TAMPILAN USER (FRONTEND
Route::group(['as' => 'user.'], function () {
    // Public routes
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/paket-wisata', [HomeController::class, 'paket'])->name('paket');
    Route::get('/paket-wisata/{id}', [HomeController::class, 'paketDetail'])->name('paket.detail');
    Route::get('/daftar-menu', [HomeController::class, 'menu'])->name('menu');
    Route::get('/galeri-foto', [HomeController::class, 'galeri'])->name('galeri');
    Route::get('/berita-terbaru', [HomeController::class, 'berita'])->name('berita');
    Route::get('/tentang-kami', [HomeController::class, 'tentang'])->name('about');
    
    // ROUTE RESERVASI
    // Untuk user BELUM login (simpan session → redirect ke login)
    Route::post('/pesan-sekarang', [HomeController::class, 'pesanSekarang'])->name('pesan.sekarang');
    
    // Untuk user SUDAH login (langsung ke form reservasi)
    Route::middleware(['auth'])->group(function () {
        // Reservasi User
        Route::prefix('reservasi')->name('reservation.')->group(function () {
            Route::get('/', [UserReservationController::class, 'create'])->name('create');
            Route::post('/', [UserReservationController::class, 'store'])->name('store');
            Route::get('/saya', [UserReservationController::class, 'index'])->name('my');
            Route::get('/{id}', [UserReservationController::class, 'show'])->name('show');
        });
        
        // Pembayaran User
        Route::prefix('pembayaran')->name('payment.')->group(function () {
            Route::get('/upload/{id}', [UserPaymentController::class, 'upload'])->name('upload');
            Route::post('/upload/{id}', [UserPaymentController::class, 'storeProof'])->name('store.proof');
        });
    });
});