<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Packages;
use App\Models\Menus;
use App\Models\News;
use App\Models\Gallery;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getSidebarStats()
    {
        return [
            'reservations' => Reservation::count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'packages' => Packages::count(),
            'menus' => Menus::count(),
            'news' => News::count(),
            'gallery' => Gallery::count(),
        ];
    }
    
    public function getDashboardData()
    {
        return [
            'package_stats' => [
                'total' => Packages::count(),
                'villa' => Packages::where('service_type', 'villa')->count(),
                'wisata' => Packages::where('service_type', 'wisata')->count(),
            ],
            'menu_stats' => [
                'total' => Menus::count(),
                'with_discount' => Menus::where('discount', '>', 0)->count(),
                'avg_price' => Menus::avg('price'),
            ],
            'event_stats' => [
                'active' => News::where('event_date', '>=', now())->count(),
                'this_week' => News::whereBetween('event_date', [now(), now()->addDays(7)])->count(),
                'this_month' => News::whereMonth('event_date', now()->month)->count(),
            ],
            'gallery_stats' => [
                'total' => Gallery::count(),
                'recent' => Gallery::where('created_at', '>=', now()->subDays(7))->count(),
            ],
            'upcoming_events' => News::where('event_date', '>=', now())
                ->where('event_date', '<=', now()->addDays(7))
                ->orderBy('event_date')
                ->get(),
            'events_this_month' => News::whereMonth('event_date', now()->month)
                ->whereYear('event_date', now()->year)
                ->get(),
            'latest_package' => Packages::latest()->first(),
            'discount_menu' => Menus::where('discount', '>', 0)->latest()->first(),
            'recent_galleries' => Gallery::latest()->take(6)->get(),
        ];
    }
}