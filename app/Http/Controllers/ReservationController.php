<?php

namespace App\Http\Controllers;

use App\Models\Reservation; // ← SINGULAR Reservation
use App\Models\Package;     // ← Juga singular jika model-mu Package (bukan Packages)
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the reservations.
     */
    public function index(Request $request)
    {
        // Query untuk filter
        $query = Reservation::with(['user', 'package']);
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('service_type') && $request->service_type != '') {
            $query->where('service_type', $request->service_type);
        }
        
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date', $request->date);
        }
        
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }
        
        $reservations = $query->latest()->paginate(10);
        
        // Hitung stats
        $totalCount = Reservation::count();
        $pendingCount = Reservation::where('status', 'pending')->count();
        $approvedCount = Reservation::where('status', 'approved')->count();
        $paidCount = Reservation::where('payment_status', 'paid')
            ->orWhere('payment_status', 'verified')
            ->count();
        
        return view('admin.reservations.index', compact(
            'reservations',
            'totalCount',
            'pendingCount',
            'approvedCount',
            'paidCount'
        ));
    }

    /**
     * Show the form for creating a new reservation.
     * (Ini untuk user, bukan admin - bisa dihapus jika tidak butuh)
     */
    public function create()
    {
        // Hapus method ini jika admin tidak perlu buat reservasi
        // Atau comment jika ingin di-disable sementara
        // $packages = Package::where('status', true)->get();
        // return view('reservations.create', compact('packages'));
        
        abort(404, 'Admin tidak dapat membuat reservasi baru');
    }

    /**
     * Store a newly created reservation in storage.
     * (Ini untuk user, bukan admin)
     */
    public function store(Request $request)
    {
        // Hapus method ini jika admin tidak perlu buat reservasi
        // Atau redirect ke index
        return redirect()->route('reservations.index')
            ->with('info', 'Admin tidak dapat membuat reservasi baru');
    }

    /**
     * Display the specified reservation.
     */
    public function show($id)
    {
        $reservation = Reservation::with(['user', 'package'])->findOrFail($id);
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified reservation.
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $statuses = ['pending', 'approved', 'rejected'];
        $paymentStatuses = ['unpaid', 'paid', 'verified'];
        
        return view('admin.reservations.edit', compact('reservation', 'statuses', 'paymentStatuses'));
    }

    /**
     * Update the specified reservation in storage.
     * (Admin update status)
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'payment_status' => 'required|in:unpaid,paid,verified',
            'notes' => 'nullable|string|max:500',
        ]);

        $reservation->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'notes' => $request->notes ?: $reservation->notes,
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Status reservasi berhasil diperbarui!');
    }

    /**
     * Remove the specified reservation from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Reservasi berhasil dihapus!');
    }
}