<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Packages;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        if (Auth::user()->role !== 'user') {
            abort(403, 'Admin tidak dapat melakukan reservasi.');
        }

        $packageId = $request->get('package_id');
        $date = $request->get('date', date('Y-m-d'));
        $jumlahOrang = (int) $request->get('jumlah_orang', 1);

        if ($jumlahOrang < 1) {
            $jumlahOrang = 1;
        }

        $pendingData = Session::get('pending_reservation');

        /*
        |--------------------------------------------------------------------------
        | Kalau ada package_id dari URL, gunakan package_id terbaru
        |--------------------------------------------------------------------------
        | Ini mencegah session lama nyangkut saat user pindah paket.
        */
        if ($packageId) {
            $package = Packages::find($packageId);

            if (!$package) {
                return redirect()->route('user.paket')
                    ->with('error', 'Paket tidak ditemukan.');
            }

            $maxPeople = (int) ($package->max_people ?? 1);

            if ($maxPeople < 1) {
                $maxPeople = 1;
            }

            if ($jumlahOrang > $maxPeople) {
                $jumlahOrang = $maxPeople;
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

        $maxPeople = (int) ($package->max_people ?? 1);

        if ($maxPeople < 1) {
            $maxPeople = 1;
        }

        $jumlahOrang = (int) ($pendingData['jumlah_orang'] ?? 1);

        if ($jumlahOrang < 1) {
            $jumlahOrang = 1;
        }

        if ($jumlahOrang > $maxPeople) {
            $jumlahOrang = $maxPeople;
        }

        $pendingData['service_type'] = $package->service_type;
        $pendingData['jumlah_orang'] = $jumlahOrang;

        Session::put('pending_reservation', $pendingData);

        $total_amount = $package->price;

        return view('user.reservations.create', [
            'package' => $package,
            'pending_data' => $pendingData,
            'total_amount' => $total_amount,
            'user' => Auth::user(),
            'max_people' => $maxPeople,
        ]);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Admin tidak dapat melakukan reservasi.');
        }

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

        $maxPeople = (int) ($package->max_people ?? 1);

        if ($maxPeople < 1) {
            $maxPeople = 1;
        }

        /*
        |--------------------------------------------------------------------------
        | Normalisasi NIK
        |--------------------------------------------------------------------------
        | Semua selain angka dibuang.
        */
        $nik = preg_replace('/\D/', '', (string) $request->input('nik', ''));

        /*
        |--------------------------------------------------------------------------
        | Normalisasi No Telepon Indonesia
        |--------------------------------------------------------------------------
        | +62812xxx menjadi 0812xxx
        | 62812xxx menjadi 0812xxx
        */
        $noTelepon = preg_replace('/[\s\-\(\)]/', '', (string) $request->input('no_telepon', ''));

        if (substr($noTelepon, 0, 3) === '+62') {
            $noTelepon = '0' . substr($noTelepon, 3);
        } elseif (substr($noTelepon, 0, 2) === '62') {
            $noTelepon = '0' . substr($noTelepon, 2);
        }

        $request->merge([
            'nik' => $nik,
            'no_telepon' => $noTelepon,
        ]);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'no_telepon' => [
                'required',
                'regex:/^08[0-9]{8,11}$/',
            ],
            'checkin_date' => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after:checkin_date',
            'jumlah_orang' => 'required|integer|min:1|max:' . $maxPeople,
            'payment_method' => 'required|in:transfer,bank,credit_card,cash,qris',
            'notes' => 'nullable|string|max:500',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus berisi tepat 16 digit angka.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.regex' => 'Nomor telepon harus menggunakan format Indonesia, contoh: 081234567890.',
            'checkin_date.required' => 'Tanggal check-in wajib diisi.',
            'checkin_date.after_or_equal' => 'Tanggal check-in tidak boleh sebelum hari ini.',
            'checkout_date.required' => 'Tanggal check-out wajib diisi.',
            'checkout_date.after' => 'Tanggal check-out harus setelah tanggal check-in.',
            'jumlah_orang.required' => 'Jumlah orang wajib diisi.',
            'jumlah_orang.integer' => 'Jumlah orang harus berupa angka.',
            'jumlah_orang.min' => 'Jumlah orang minimal 1 orang.',
            'jumlah_orang.max' => 'Jumlah orang melebihi kapasitas maksimal paket, yaitu ' . $maxPeople . ' orang.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
            'notes.max' => 'Catatan maksimal 500 karakter.',
        ]);

        $jumlahOrang = (int) $request->jumlah_orang;

        /*
        |--------------------------------------------------------------------------
        | Total bayar dihitung ulang dari backend
        |--------------------------------------------------------------------------
        | Jadi user tidak bisa manipulasi total bayar dari inspect element.
        */

        $checkinDate = Carbon::parse($request->checkin_date);
        $checkoutDate = Carbon::parse($request->checkout_date);

        $jumlahHari = $checkinDate->diffInDays($checkoutDate);

        if ($jumlahHari < 1) {
            $jumlahHari = 1;
        }

        $total_amount = $package->price * $jumlahHari;

        $payment = null;
        $reservation = null;

        DB::transaction(function () use ($request, $package, $jumlahOrang, $total_amount, &$payment, &$reservation) {
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
                'jumlah_orang' => $jumlahOrang,
                'total_amount' => $total_amount,
                'notes' => $request->notes,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
            ]);

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
        });

        if ($payment) {
            return redirect()->route('user.payment.upload', $payment->id)
                ->with('success', 'Reservasi berhasil! Silakan upload bukti pembayaran.');
        }

        return redirect()->route('user.reservation.show', $reservation->id)
            ->with('success', 'Reservasi berhasil dibuat!');
    }
}