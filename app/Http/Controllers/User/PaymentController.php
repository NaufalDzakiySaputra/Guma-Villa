<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payments; // PERUBAHAN: Payments bukan Payment
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Tampilkan form upload bukti pembayaran
     */
    public function upload($id)
    {
        $payment = Payments::whereHas('reservation', function($query) { // PERUBAHAN: Payments
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        return view('user.payments.upload', compact('payment'));
    }

    /**
     * Simpan bukti pembayaran
     */
    public function storeProof(Request $request, $id)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $payment = Payments::whereHas('reservation', function($query) { // PERUBAHAN: Payments
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        // Upload file
        if ($request->hasFile('proof_image')) {
            $path = $request->file('proof_image')->store('payment_proofs', 'public');
            $payment->update([
                'proof_image' => $path,
                'status' => 'pending'
            ]);
        }

        return redirect()->route('user.reservation.show', $payment->reservation_id)
            ->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}