<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user', 'reservation')->latest()->get();
        return view('payments.index', compact('payments'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,rejected']);
        $payment->update(['status' => $request->status]);

        return redirect()->route('payments.index')->with('success', 'Status pembayaran diperbarui!');
    }
}
