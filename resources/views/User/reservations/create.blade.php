{{-- resources/views/user/reservations/create.blade.php --}}
@extends('layouts.frontend')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                {{-- HEADER --}}
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Form Reservasi</h2>
                    <p class="text-muted">Lengkapi data diri untuk melanjutkan reservasi</p>
                </div>
                
                {{-- CARD FORM --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        
                        {{-- INFO PAKET --}}
                        <div class="alert alert-info border-0 mb-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-box fa-lg"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="alert-heading mb-2">Paket yang Dipilih</h5>
                                    <p class="mb-1"><strong>Nama Paket:</strong> {{ $package->nama }}</p>
                                    <p class="mb-1"><strong>Jenis Layanan:</strong> {{ ucfirst($pending_data['service_type'] ?? 'wisata') }}</p>
                                    <p class="mb-0"><strong>Harga per Paket:</strong> IDR {{ number_format($package->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- FORM RESERVASI --}}
                        <form action="{{ route('user.reservation.store') }}" method="POST">
                            @csrf
                            
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Data Diri</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap *</label>
                                    <input type="text" 
                                           name="nama_lengkap" 
                                           id="nama_lengkap"
                                           class="form-control @error('nama_lengkap') is-invalid @enderror"
                                           value="{{ old('nama_lengkap', auth()->user()->name ?? '') }}"
                                           required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="form-label">NIK (16 digit) *</label>
                                    <input type="text" 
                                           name="nik" 
                                           id="nik"
                                           class="form-control @error('nik') is-invalid @enderror"
                                           value="{{ old('nik') }}"
                                           maxlength="16"
                                           required>
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="no_telepon" class="form-label">No. Telepon/WhatsApp *</label>
                                    <input type="tel" 
                                           name="no_telepon" 
                                           id="no_telepon"
                                           class="form-control @error('no_telepon') is-invalid @enderror"
                                           value="{{ old('no_telepon') }}"
                                           required>
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="jumlah_orang" class="form-label">Jumlah Orang *</label>
                                    <input type="number" 
                                           name="jumlah_orang" 
                                           id="jumlah_orang"
                                           class="form-control @error('jumlah_orang') is-invalid @enderror"
                                           value="{{ old('jumlah_orang', $pending_data['jumlah_orang'] ?? 1) }}"
                                           min="1"
                                           required>
                                    @error('jumlah_orang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <h5 class="fw-bold mb-3 mt-4 border-bottom pb-2">Tanggal Pelaksanaan</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="checkin_date" class="form-label">Tanggal Check-in *</label>
                                    <input type="date" 
                                           name="checkin_date" 
                                           id="checkin_date"
                                           class="form-control @error('checkin_date') is-invalid @enderror"
                                           value="{{ old('checkin_date', $pending_data['date'] ?? date('Y-m-d')) }}"
                                           min="{{ date('Y-m-d') }}"
                                           required>
                                    @error('checkin_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="checkout_date" class="form-label">Tanggal Check-out *</label>
                                    <input type="date" 
                                           name="checkout_date" 
                                           id="checkout_date"
                                           class="form-control @error('checkout_date') is-invalid @enderror"
                                           value="{{ old('checkout_date') }}"
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                           required>
                                    @error('checkout_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <h5 class="fw-bold mb-3 mt-4 border-bottom pb-2">Pembayaran</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Metode Pembayaran *</label>
                                    <select name="payment_method" 
                                            class="form-select @error('payment_method') is-invalid @enderror"
                                            required>
                                        <option value="">Pilih Metode</option>
                                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                        <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bayar di Bank</option>
                                        <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                                        <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash di Tempat</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Total Pembayaran</label>
                                    <div class="input-group">
                                        <span class="input-group-text">IDR</span>
                                        <input type="text" 
                                               class="form-control bg-light"
                                               value="{{ number_format($total_amount, 0, ',', '.') }}"
                                               readonly>
                                    </div>
                                    <small class="text-muted">Harga: IDR {{ number_format($package->price, 0, ',', '.') }} × {{ $pending_data['jumlah_orang'] ?? 1 }} orang</small>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="notes" class="form-label">Catatan Tambahan (Opsional)</label>
                                <textarea name="notes" 
                                          id="notes" 
                                          rows="3"
                                          class="form-control @error('notes') is-invalid @enderror"
                                          placeholder="Contoh: Permintaan khusus, makanan alergi, kebutuhan khusus, dll.">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- TOMBOL --}}
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold">
                                    <i class="fas fa-paper-plane me-2"></i> Konfirmasi Reservasi
                                </button>
                                <a href="{{ route('user.paket') }}" class="btn btn-outline-secondary py-3">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Paket
                                </a>
                            </div>
                            
                        </form>
                        
                    </div>
                </div>
                
                {{-- INFORMASI --}}
                <div class="mt-4 text-center">
                    <div class="alert alert-light border">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        <strong>Informasi Penting:</strong>
                        <ul class="mb-0 mt-2 text-start">
                            <li>Reservasi akan diproses dalam 1×24 jam</li>
                            <li>Tim kami akan menghubungi Anda untuk konfirmasi</li>
                            <li>Untuk pembayaran transfer, harap upload bukti setelah reservasi</li>
                            <li>Pembatalan reservasi maksimal H-3 sebelum check-in</li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

<script>
// Auto set checkout date (1 hari setelah checkin)
document.getElementById('checkin_date').addEventListener('change', function() {
    const checkinDate = new Date(this.value);
    const checkoutDate = new Date(checkinDate);
    checkoutDate.setDate(checkoutDate.getDate() + 1);
    
    const formattedDate = checkoutDate.toISOString().split('T')[0];
    document.getElementById('checkout_date').value = formattedDate;
    document.getElementById('checkout_date').min = formattedDate;
});
</script>
@endsection