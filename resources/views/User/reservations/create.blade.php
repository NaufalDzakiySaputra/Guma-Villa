@extends('layouts.frontend')

@section('content')
@php
    $maxPeople = (int) ($max_people ?? $package->max_people ?? 1);
    $maxPeople = $maxPeople < 1 ? 1 : $maxPeople;

    $currentPeople = (int) old('jumlah_orang', $pending_data['jumlah_orang'] ?? 1);
    $currentPeople = max(1, min($currentPeople, $maxPeople));

    $price = (int) $package->price;

    $checkinDate = old('checkin_date', $pending_data['date'] ?? date('Y-m-d'));
    $checkoutDate = old('checkout_date', date('Y-m-d', strtotime($checkinDate . ' +1 day')));

    $checkinTime = strtotime($checkinDate);
    $checkoutTime = strtotime($checkoutDate);

    $currentDays = 1;

    if ($checkinTime && $checkoutTime && $checkoutTime > $checkinTime) {
        $currentDays = max(1, (int) (($checkoutTime - $checkinTime) / 86400));
    }

    $currentTotal = $price * $currentDays;
    $minCheckoutDate = date('Y-m-d', strtotime($checkinDate . ' +1 day'));
@endphp

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="text-center mb-5">
                    <h2 class="fw-bold">Form Reservasi</h2>
                    <p class="text-muted">Lengkapi data diri untuk melanjutkan reservasi</p>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <div class="alert alert-info border-0 mb-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-box fa-lg"></i>
                                </div>

                                <div class="ms-3">
                                    <h5 class="alert-heading mb-2">Paket yang Dipilih</h5>

                                    <p class="mb-1">
                                        <strong>Nama Paket:</strong> {{ $package->nama }}
                                    </p>

                                    <p class="mb-1">
                                        <strong>Jenis Layanan:</strong>
                                        {{ ucfirst($pending_data['service_type'] ?? $package->service_type) }}
                                    </p>

                                    <p class="mb-1">
                                        <strong>Harga per Hari:</strong>
                                        IDR {{ number_format($price, 0, ',', '.') }}
                                    </p>

                                    <p class="mb-0">
                                        <strong>Maksimal Orang:</strong> {{ $maxPeople }} orang
                                    </p>
                                </div>
                            </div>
                        </div>

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
                                           minlength="16"
                                           maxlength="16"
                                           inputmode="numeric"
                                           pattern="[0-9]{16}"
                                           placeholder="Masukkan 16 digit NIK"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)"
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
                                           maxlength="20"
                                           inputmode="tel"
                                           placeholder="Contoh: 081234567890"
                                           required>

                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <small class="text-muted">
                                        Gunakan format 08xxxxxxxxxx atau +628xxxxxxxxxx.
                                    </small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jumlah_orang" class="form-label">Jumlah Orang *</label>
                                    <input type="number"
                                           name="jumlah_orang"
                                           id="jumlah_orang"
                                           class="form-control @error('jumlah_orang') is-invalid @enderror"
                                           value="{{ $currentPeople }}"
                                           min="1"
                                           max="{{ $maxPeople }}"
                                           inputmode="numeric"
                                           onfocus="this.select()"
                                           required>

                                    @error('jumlah_orang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <small class="text-muted">
                                        Maksimal {{ $maxPeople }} orang untuk paket ini. Jumlah orang tidak memengaruhi total harga.
                                    </small>
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
                                           value="{{ $checkinDate }}"
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
                                           value="{{ $checkoutDate }}"
                                           min="{{ $minCheckoutDate }}"
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
                                               id="total_payment_display"
                                               class="form-control bg-light"
                                               value="{{ number_format($currentTotal, 0, ',', '.') }}"
                                               readonly>
                                    </div>

                                    <small class="text-muted" id="total_payment_note">
                                        Harga: IDR {{ number_format($price, 0, ',', '.') }} × {{ $currentDays }} hari
                                    </small>
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

                <div class="mt-4 text-center">
                    <div class="alert alert-light border">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        <strong>Informasi Penting:</strong>
                        <ul class="mb-0 mt-2 text-start">
                            <li>Reservasi akan diproses dalam 1×24 jam</li>
                            <li>Tim kami akan menghubungi Anda untuk konfirmasi</li>
                            <li>Total pembayaran dihitung berdasarkan jumlah hari yang dipesan</li>
                            <li>Jumlah orang hanya digunakan untuk menyesuaikan kapasitas paket</li>
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
document.addEventListener('DOMContentLoaded', function () {
    const checkinInput = document.getElementById('checkin_date');
    const checkoutInput = document.getElementById('checkout_date');
    const jumlahInput = document.getElementById('jumlah_orang');
    const totalDisplay = document.getElementById('total_payment_display');
    const totalNote = document.getElementById('total_payment_note');

    const price = Number(@json($price));

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function getJumlahHari() {
        if (!checkinInput || !checkoutInput) {
            return 1;
        }

        const checkinValue = checkinInput.value;
        const checkoutValue = checkoutInput.value;

        if (!checkinValue || !checkoutValue) {
            return 1;
        }

        const checkinDate = new Date(checkinValue);
        const checkoutDate = new Date(checkoutValue);

        if (isNaN(checkinDate.getTime()) || isNaN(checkoutDate.getTime())) {
            return 1;
        }

        const diffTime = checkoutDate.getTime() - checkinDate.getTime();
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        return diffDays < 1 ? 1 : diffDays;
    }

    function updateTotal() {
        if (!totalDisplay || !totalNote) {
            return;
        }

        const jumlahHari = getJumlahHari();
        const total = price * jumlahHari;

        totalDisplay.value = formatRupiah(total);
        totalNote.innerText = `Harga: IDR ${formatRupiah(price)} × ${jumlahHari} hari`;
    }

    function normalizeJumlahOrang() {
        if (!jumlahInput) {
            return;
        }

        const maxPeople = parseInt(jumlahInput.getAttribute('max') || 1);
        let jumlah = parseInt(jumlahInput.value || 1);

        if (isNaN(jumlah) || jumlah < 1) {
            jumlah = 1;
        }

        if (jumlah > maxPeople) {
            jumlah = maxPeople;
        }

        jumlahInput.value = jumlah;
    }

    if (checkinInput && checkoutInput) {
        checkinInput.addEventListener('change', function () {
            const checkinDate = new Date(this.value);

            if (isNaN(checkinDate.getTime())) {
                return;
            }

            const checkoutDate = new Date(checkinDate);
            checkoutDate.setDate(checkoutDate.getDate() + 1);

            const formattedDate = checkoutDate.toISOString().split('T')[0];

            checkoutInput.value = formattedDate;
            checkoutInput.min = formattedDate;

            updateTotal();
        });

        checkoutInput.addEventListener('change', updateTotal);
    }

    if (jumlahInput) {
        jumlahInput.addEventListener('blur', normalizeJumlahOrang);
        jumlahInput.addEventListener('change', normalizeJumlahOrang);
    }

    updateTotal();
});
</script>
@endsection