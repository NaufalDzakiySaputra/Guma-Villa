<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Packages;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'packages']);
        
        // Filter
        $filters = ['status', 'service_type', 'payment_status', 'payment_method'];
        foreach ($filters as $filter) {
            if ($request->has($filter) && $request->$filter != '') {
                $query->where($filter, $request->$filter);
            }
        }
        
        if ($request->has('checkin_date') && $request->checkin_date != '') {
            $query->whereDate('checkin_date', $request->checkin_date);
        }
        
        $reservations = $query->latest()->paginate(10);
        
        // Stats
        $totalCount = Reservation::count();
        $pendingCount = Reservation::where('status', 'pending')->count();
        $approvedCount = Reservation::where('status', 'approved')->count();
        $unpaidCount = Reservation::where('payment_status', 'pending')->count();
        $paidCount = Reservation::where('payment_status', 'paid')->count();
        $verifiedCount = Reservation::where('payment_status', 'verified')->count();
        
        return view('admin.reservations.index', compact(
            'reservations',
            'totalCount',
            'pendingCount',
            'approvedCount',
            'unpaidCount',
            'paidCount',
            'verifiedCount'
        ));
    }

    public function show($id)
    {
        $reservation = Reservation::with(['user', 'packages', 'payments'])
                                  ->findOrFail($id);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        $statuses = ['pending', 'approved', 'rejected'];
        $paymentStatuses = ['pending', 'paid', 'verified', 'expired', 'failed'];
        $paymentMethods = ['transfer', 'bank', 'credit_card', 'cash', 'qris', null];
        
        return view('admin.reservations.edit', compact(
            'reservation', 
            'statuses', 
            'paymentStatuses',
            'paymentMethods'
        ));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'payment_status' => 'required|in:pending,paid,verified,expired,failed',
            'payment_method' => 'nullable|in:transfer,bank,credit_card,cash,qris',
            'notes' => 'nullable|string|max:500',
        ]);

        $reservation->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes ?: $reservation->notes,
        ]);

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Status reservasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil dihapus!');
    }
}