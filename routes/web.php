<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\GalleryController;
// === TAMBAHKAN INI ===
use App\Http\Controllers\AuthController;  // Import AuthController
use App\Http\Controllers\Admin\UserController;  // Import UserController untuk manage users
// =====================

// === ROUTE AUTH MANUAL ===
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// =========================

Route::get('/', function () {
    return view('welcome'); // atau redirect ke admin
});

Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ===================== ADMIN ROUTES GROUP =====================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // User Management (BARU)
    Route::resource('users', UserController::class)->names('admin.users');
    
    // Admin CRUD routes yang sudah ada
    Route::resource('news', NewsController::class);
    Route::resource('packages', PackagesController::class);
    Route::resource('payments', PaymentsController::class);
    Route::resource('menus', MenusController::class);
    Route::resource('gallery', GalleryController::class);
});

// Reservations routes (tetap di luar group kalau mau accessible tanpa prefix admin)
Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
Route::put('reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
Route::delete('reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');