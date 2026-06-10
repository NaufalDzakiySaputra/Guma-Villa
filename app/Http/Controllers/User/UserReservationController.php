<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Packages;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserReservationController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Admin tidak dapat mengakses halaman reservasi user.');
        }

        $reservations = Reservation::where('user_id', Auth::id())
            ->with('packages')
            ->latest()
            ->paginate(10);

        return view('user.reservations.index', compact('reservations'));
    }

    public function show($id)
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Admin tidak dapat mengakses halaman reservasi user.');
        }

        $reservation = Reservation::where('user_id', Auth::id())
            ->with(['packages', 'payments'])
            ->findOrFail($id);

        return view('user.reservations.show', compact('reservation'));
    }

    public function create(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Proteksi Role
        |--------------------------------------------------------------------------
        | Hanya user biasa yang boleh membuat reservasi.
        | Admin tidak boleh masuk ke form reservasi pelanggan.
        */
        if (Auth::user()->role !== 'user') {
            abort(403, 'Admin tidak dapat melakukan reservasi.');
        }

        $packageId = $request->get('package_id');
        $date = $request->get('date', date('Y-m-d'));
        $jumlahOrang = $request->get('jumlah_orang', 1);

        $pendingData = Session::get('pending_reservation');

        /*
        |--------------------------------------------------------------------------
        | Jika belum ada pending reservation tapi ada package_id dari URL
        |--------------------------------------------------------------------------
        | Ambil data package dari database agar service_type tidak salah.
        */
        if (!$pendingData && $packageId) {
            $package = Packages::find($packageId);

            if (!$package) {
                return redirect()->route('user.paket')
                    ->with('error', 'Paket tidak ditemukan.');
            }

            $pendingData = [
                'package_id' => $package->id,
                'service_type' => $package->service_type,
                'date' => $date,
                'jumlah_orang' => $jumlahOrang,
            ];

            Session::put('pending_reservation', $pendingData);
        }

        if (!$pendingData) {
            return redirect()->route('user.paket')
                ->with('error', 'Silakan pilih paket terlebih dahulu.');
        }

        $package = Packages::find($pendingData['package_id']);

        if (!$package) {
            Session::forget('pending_reservation');

            return redirect()->route('user.paket')
                ->with('error', 'Paket tidak ditemukan.');
        }

        /*
        |--------------------------------------------------------------------------
        | Sinkronkan service_type
        |--------------------------------------------------------------------------
        | Ini penting agar paket villa/nikah/mice tidak salah tersimpan sebagai wisata.
        */
        $pendingData['service_type'] = $package->service_type;
        Session::put('pending_reservation', $pendingData);

        $total_amount = $package->price * ($pendingData['jumlah_orang'] ?? 1);

        return view('user.reservations.create', [
            'package' => $package,
            'pending_data' => $pendingData,
            'total_amount' => $total_amount,
            'user' => Auth::user(),
        ]);
    }

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Proteksi Role
        |--------------------------------------------------------------------------
        | Walaupun route sudah pakai middleware user, controller tetap dicek lagi.
        */
        if (Auth::user()->role !== 'user') {
            abort(403, 'Admin tidak dapat melakukan reservasi.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'no_telepon' => 'required|string|max:15',
            'checkin_date' => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after:checkin_date',
            'jumlah_orang' => 'required|integer|min:1',
            'payment_method' => 'required|in:transfer,bank,credit_card,cash,qris',
            'notes' => 'nullable|string|max:500',
        ]);

        $pendingData = Session::get('pending_reservation');

        if (!$pendingData) {
            return redirect()->route('user.paket')
                ->with('error', 'Sesi reservasi telah berakhir. Silakan pilih paket lagi.');
        }

        $package = Packages::find($pendingData['package_id']);

        if (!$package) {
            Session::forget('pending_reservation');

            return redirect()->route('user.paket')
                ->with('error', 'Paket tidak ditemukan.');
        }

        $total_amount = $package->price * $request->jumlah_orang;

        /*
        |--------------------------------------------------------------------------
        | Buat Reservasi
        |--------------------------------------------------------------------------
        | service_type diambil dari package langsung agar tidak salah.
        */
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'no_telepon' => $request->no_telepon,
            'package_id' => $package->id,
            'service_type' => $package->service_type,
            'date' => now(),
            'checkin_date' => $request->checkin_date,
            'checkout_date' => $request->checkout_date,
            'jumlah_orang' => $request->jumlah_orang,
            'total_amount' => $total_amount,
            'notes' => $request->notes,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        $payment = null;

        /*
        |--------------------------------------------------------------------------
        | Buat Data Pembayaran
        |--------------------------------------------------------------------------
        | Untuk transfer, bank, dan QRIS, user harus upload bukti pembayaran.
        */
        if (in_array($request->payment_method, ['transfer', 'bank', 'qris'])) {
            $payment = Payments::create([
                'reservation_id' => $reservation->id,
                'amount' => $total_amount,
                'method' => $request->payment_method,
                'transaction_code' => 'PAY-' . time() . '-' . $reservation->id,
                'status' => 'pending',
            ]);
        }

        Session::forget('pending_reservation');

        if ($payment) {
            return redirect()->route('user.payment.upload', $payment->id)
                ->with('success', 'Reservasi berhasil! Silakan upload bukti pembayaran.');
        }

        return redirect()->route('user.reservation.show', $reservation->id)
            ->with('success', 'Reservasi berhasil dibuat!');
    }
}