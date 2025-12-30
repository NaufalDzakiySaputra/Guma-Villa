<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;

// === ROUTE AUTH MANUAL ===
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});

// ===================== ADMIN ROUTES GROUP =====================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // User Management
    Route::resource('users', UserController::class);
    
    // Admin CRUD routes yang sudah ada
    Route::resource('news', NewsController::class);
    Route::resource('packages', PackagesController::class);
    Route::resource('payments', PaymentsController::class);
    Route::resource('menus', MenusController::class);
    Route::resource('gallery', GalleryController::class);
    
    // ========== ADMIN RESERVATION ROUTES ==========
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::get('/{id}', [ReservationController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ReservationController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ReservationController::class, 'update'])->name('update');
        Route::delete('/{id}', [ReservationController::class, 'destroy'])->name('destroy');
    });
});

// ===================== USER RESERVATION ROUTES (Jika dibutuhkan nanti) =====================
// Route::middleware(['auth'])->group(function () {
//     Route::get('/my-reservations', [ReservationController::class, 'userIndex'])->name('my.reservations');
//     Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
//     Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
// });