<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\GalleryController;



Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
 {
    Route::resource('news', NewsController::class);
};
 {
    Route::resource('packages', PackagesController::class);
    };
Route::middleware(['auth'])->group(function () {
    Route::resource('payments', PaymentsController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('reservations', ReservationsController::class);
});
 {
    Route::resource('menus', MenusController::class);
};

    Route::resource('menus', MenusController::class);

{
    Route::resource('gallery', GalleryController::class);
};
