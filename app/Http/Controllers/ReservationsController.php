<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationsController extends Controller
{
    // Tampilkan semua reservasi (admin)
    public function index()
    {
        $reservations = Reservation::with('user', 'package')->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    // Form buat reservasi (user)
    public function create()
    {
        $packages = Package::all();
        return view('reservations.create', compact('packages'));
    }

    // Simpan reservasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'reservation_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Reservation::create($validated);

        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dibuat!');
    }

    // Hapus reservasi (admin)
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dihapus!');
    }
}
