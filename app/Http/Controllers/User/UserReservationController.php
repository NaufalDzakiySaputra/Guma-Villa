<?php

namespace App\Http\Controllers\User; // PASTIKAN INI

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Packages;
use App\Models\Payments; // Pastikan ini Payments (plural)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('packages')
            ->latest()
            ->paginate(10);
            
        return view('user.reservations.index', compact('reservations'));
    }
    
    public function show($id)
    {
        $reservation = Reservation::where('user_id', Auth::id())
            ->with(['packages', 'payments'])
            ->findOrFail($id);
            
        return view('user.reservations.show', compact('reservation'));
    }
    
    public function create(Request $request)
    {
        $packageId = $request->get('package_id');
        $date = $request->get('date', date('Y-m-d'));
        $jumlahOrang = $request->get('jumlah_orang', 1);
        
        $pendingData = Session::get('pending_reservation');
        
        if (!$pendingData && $packageId) {
            $pendingData = [
                'package_id' => $packageId,
                'service_type' => 'wisata',
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
        
        $total_amount = $package->price * ($pendingData['jumlah_orang'] ?? 1);
        
        return view('user.reservations.create', [
            'package' => $package,
            'pending_data' => $pendingData,
            'total_amount' => $total_amount,
            'user' => Auth::user()
        ]);
    }
    
    public function store(Request $request)
    {
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
                ->with('error', 'Sesi reservasi telah berakhir.');
        }
        
        $package = Packages::find($pendingData['package_id']);
        
        if (!$package) {
            Session::forget('pending_reservation');
            return redirect()->route('user.paket')
                ->with('error', 'Paket tidak ditemukan.');
        }
        
        $total_amount = $package->price * $request->jumlah_orang;
        
        // Buat reservasi
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'no_telepon' => $request->no_telepon,
            'package_id' => $pendingData['package_id'],
            'service_type' => $pendingData['service_type'],
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
        
        // Buat payment record untuk transfer/bank/qris
        if (in_array($request->payment_method, ['transfer', 'bank', 'qris'])) {
            Payments::create([ // PERHATIAN: Payments (plural)
                'reservation_id' => $reservation->id,
                'amount' => $total_amount,
                'method' => $request->payment_method,
                'transaction_code' => 'PAY-' . time() . '-' . $reservation->id,
                'status' => 'pending',
            ]);
        }
        
        Session::forget('pending_reservation');
        
        if (in_array($request->payment_method, ['transfer', 'bank', 'qris'])) {
            return redirect()->route('user.payment.upload', $reservation->payments()->first()->id)
                ->with('success', 'Reservasi berhasil! Silakan upload bukti pembayaran.');
        }
        
        return redirect()->route('user.reservation.show', $reservation->id)
            ->with('success', 'Reservasi berhasil dibuat!');
    }
}