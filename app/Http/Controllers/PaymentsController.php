<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        
        // 🔥 UBAH: 'success' menjadi 'paid'
        $statuses = ['pending', 'paid', 'failed', 'verified', 'expired'];
        
        return view('admin.payments.edit', compact('payment', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        // 🔥 UBAH: 'success' menjadi 'paid'
        $request->validate([
            'status' => 'required|in:pending,paid,failed,verified,expired',
            'payment_notes' => 'nullable|string|max:500',
        ]);
        
        DB::beginTransaction();
        
        try {
            $payment = Payments::findOrFail($id);
            
            $oldStatus = $payment->status;
            $newStatus = $request->status;
            
            $updateData = [
                'status' => $newStatus,
                'payment_notes' => $request->payment_notes,
            ];
            
            if ($newStatus === 'verified' && $oldStatus !== 'verified') {
                $updateData['verified_at'] = now();
                $updateData['verified_by'] = auth()->id();
            }
            
            if ($oldStatus === 'verified' && $newStatus !== 'verified') {
                $updateData['verified_at'] = null;
                $updateData['verified_by'] = null;
            }
            
            $payment->update($updateData);
            
            // 🔥 SEDERHANA: Langsung update reservation
            $payment->reservation->update([
                'payment_status' => $newStatus
            ]);
            
            // 🔥 UBAH: 'success' menjadi 'paid'
            if (in_array($newStatus, ['paid', 'verified'])) {
                if ($payment->reservation && $payment->reservation->status !== 'approved') {
                    $payment->reservation->update(['status' => 'approved']);
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.payments.index')
                ->with('success', 'Status pembayaran berhasil diperbarui!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    // 🔥 HAPUS method syncPaymentStatusToReservation (tidak perlu lagi)
    
    public function quickVerify($id)
    {
        DB::beginTransaction();
        
        try {
            $payment = Payments::findOrFail($id);
            
            $payment->update([
                'status' => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);
            
            // 🔥 SEDERHANA: Langsung update
            $payment->reservation->update([
                'payment_status' => 'verified',
                'status' => 'approved'
            ]);
            
            DB::commit();
            
            return redirect()->back()
                ->with('success', 'Pembayaran berhasil diverifikasi!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}