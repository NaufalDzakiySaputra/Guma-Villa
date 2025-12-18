<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menus;
use App\Models\Packages;
use App\Models\Gallery;
use App\Models\Reservations;
use App\Models\Payments;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'totalUsers'        => User::count(),
            'totalMenus'        => Menus::count(),
            'totalPackages'     => Packages::count(),
            'totalGalleries'    => Gallery::count(),
            'totalReservations' => Reservations::count(),
            'totalPayments'     => Payments::count(),
        ]);
    }
}
