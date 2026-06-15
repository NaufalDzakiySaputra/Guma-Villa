<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payments::with(['reservation', 'reservation.user'])
            ->latest()
            ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    public function edit($id)
    {
        $payment = Payments::with(['reservation', 'reservation.user'])
            ->findOrFail($id);

        $statuses = ['pending', 'paid', 'verified', 'failed', 'expired'];

        return view('admin.payments.edit', compact('payment', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,verified,failed,expired',
            'payment_notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            $payment = Payments::with('reservation')->findOrFail($id);

            $newStatus = $request->status;

            $updateData = [
                'status' => $newStatus,
                'payment_notes' => $request->payment_notes,
            ];

            if (in_array($newStatus, ['paid', 'verified'])) {
                $updateData['paid_at'] = now();
            }

            if ($newStatus === 'verified') {
                $updateData['verified_at'] = now();
                $updateData['verified_by'] = auth()->id();
            }

            if (in_array($newStatus, ['pending', 'failed', 'expired'])) {
                $updateData['paid_at'] = null;
                $updateData['verified_at'] = null;
                $updateData['verified_by'] = null;
            }

            $payment->update($updateData);

            if ($payment->reservation) {
                $reservationStatus = 'pending';

                if (in_array($newStatus, ['paid', 'verified'])) {
                    $reservationStatus = 'approved';
                }

                if (in_array($newStatus, ['failed', 'expired'])) {
                    $reservationStatus = 'rejected';
                }

                $payment->reservation->update([
                    'payment_status' => $newStatus,
                    'status' => $reservationStatus,
                ]);
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

    public function showProof($id)
    {
        $payment = Payments::findOrFail($id);

        if (!$payment->proof_image) {
            return redirect()->back()
                ->with('error', 'Bukti pembayaran belum diupload.');
        }

        if (!Storage::disk('public')->exists($payment->proof_image)) {
            return redirect()->back()
                ->with('error', 'File bukti pembayaran tidak ditemukan.');
        }

        return response()->file(
            Storage::disk('public')->path($payment->proof_image)
        );
    }
}