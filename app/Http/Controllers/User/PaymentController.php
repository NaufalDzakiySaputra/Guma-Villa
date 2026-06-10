<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Tampilkan form upload bukti pembayaran
     */
    public function upload($id)
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Admin tidak dapat mengakses pembayaran user.');
        }

        $payment = Payments::whereHas('reservation', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('reservation')->findOrFail($id);

        return view('user.payments.upload', compact('payment'));
    }

    /**
     * Simpan bukti pembayaran dari user
     */
    public function storeProof(Request $request, $id)
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Admin tidak dapat mengupload bukti pembayaran.');
        }

        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $payment = Payments::whereHas('reservation', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('reservation')->findOrFail($id);

        if ($request->hasFile('proof_image')) {
            $path = $request->file('proof_image')->store('payment_proofs', 'public');

            $payment->update([
                'proof_image' => $path,
                'status' => 'pending',
            ]);

            $payment->reservation->update([
                'payment_status' => 'pending',
            ]);
        }

        return redirect()->route('user.reservation.show', $payment->reservation_id)
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }
}