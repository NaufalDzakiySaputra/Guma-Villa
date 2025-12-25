<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\GalleryController;

Route::get('/', function () {
    return view('welcome'); // atau redirect ke admin
});

Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Admin CRUD routes
Route::resource('news', NewsController::class);
Route::resource('packages', PackagesController::class);
Route::resource('payments', PaymentsController::class);
Route::resource('menus', MenusController::class);
Route::resource('gallery', GalleryController::class);

Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
Route::put('reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
Route::delete('reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');