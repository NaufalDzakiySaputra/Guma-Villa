<?php

namespace App\Http\Controllers;

use App\Models\Payments; // PERUBAHAN: Payments bukan Payment
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payments::with(['reservation', 'reservation.user', 'verifier'])
                          ->latest()
                          ->paginate(10);
        
        return view('admin.payments.index', compact('payments'));
    }
    
    public function edit($id)
    {
        $payment = Payments::with(['reservation', 'reservation.user'])
                         ->findOrFail($id);
        
        $statuses = ['pending', 'success', 'failed', 'verified', 'expired'];
        
        return view('admin.payments.edit', compact('payment', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payments::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,success,failed,verified,expired',
            'payment_notes' => 'nullable|string|max:500',
        ]);
        
        $updateData = [
            'status' => $request->status,
            'payment_notes' => $request->payment_notes,
        ];
        
        if ($request->status === 'verified') {
            $updateData['verified_at'] = now();
            $updateData['verified_by'] = auth()->id();
            
            // Update juga payment_status di reservation
            $payment->reservation->update(['payment_status' => 'verified']);
        }
        
        $payment->update($updateData);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Status pembayaran diperbarui!');
    }
}