{{-- resources/views/user/payments/upload.blade.php --}}
@extends('layouts.frontend')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                
                {{-- HEADER --}}
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Upload Bukti Pembayaran</h2>
                    <p class="text-muted">Reservasi #{{ $payment->reservation->id }}</p>
                </div>
                
                {{-- CARD FORM --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        
                        {{-- PAYMENT INFO --}}
                        <div class="alert alert-info border-0 mb-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle fa-lg"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="alert-heading mb-2">Detail Pembayaran</h6>
                                    <p class="mb-1"><strong>Kode Transaksi:</strong> {{ $payment->transaction_code }}</p>
                                    <p class="mb-1"><strong>Total:</strong> IDR {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                    <p class="mb-0"><strong>Metode:</strong> {{ ucfirst($payment->method) }}</p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- FORM UPLOAD --}}
                        <form action="{{ route('user.payment.store.proof', $payment->id) }}" 
                              method="POST" 
                              enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="proof_image" class="form-label fw-bold">
                                    <i class="fas fa-image me-1"></i> File Bukti Pembayaran *
                                </label>
                                <input type="file" 
                                       name="proof_image" 
                                       id="proof_image"
                                       class="form-control @error('proof_image') is-invalid @enderror"
                                       accept="image/*"
                                       required>
                                @error('proof_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <small>Format: JPG, PNG, JPEG (max 2MB)</small>
                                </div>
                            </div>
                            
                            {{-- PREVIEW AREA --}}
                            <div class="mb-4" id="preview-container" style="display: none;">
                                <label class="form-label">Preview Gambar</label>
                                <div class="border rounded p-3 text-center">
                                    <img id="image-preview" class="img-fluid rounded" style="max-height: 300px;">
                                </div>
                            </div>
                            
                            {{-- INSTRUKSI --}}
                            <div class="alert alert-warning border-0 mb-4">
                                <h6 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Instruksi:</h6>
                                <ol class="mb-0 ps-3">
                                    <li>Pastikan gambar bukti pembayaran jelas terbaca</li>
                                    <li>Nominal, nama pengirim, dan tanggal harus terlihat</li>
                                    <li>Proses verifikasi membutuhkan waktu 1×24 jam</li>
                                    <li>Status akan berubah setelah admin memverifikasi</li>
                                </ol>
                            </div>
                            
                            {{-- TOMBOL --}}
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg py-3">
                                    <i class="fas fa-upload me-2"></i> Upload Bukti Pembayaran
                                </button>
                                <a href="{{ route('user.reservation.show', $payment->reservation_id) }}" 
                                   class="btn btn-outline-secondary py-3">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Detail Reservasi
                                </a>
                            </div>
                            
                        </form>
                        
                    </div>
                </div>
                
                {{-- BANK ACCOUNTS --}}
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-university me-2"></i>Rekening Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Bank</th>
                                        <th>No. Rekening</th>
                                        <th>Atas Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>BCA</strong></td>
                                        <td><code>123 456 7890</code></td>
                                        <td>PT Guma Landscape</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mandiri</strong></td>
                                        <td><code>098 765 4321</code></td>
                                        <td>PT Guma Landscape</td>
                                    </tr>
                                    <tr>
                                        <td><strong>BRI</strong></td>
                                        <td><code>567 890 1234</code></td>
                                        <td>PT Guma Landscape</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

<script>
// Image preview
document.getElementById('proof_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');
    const container = document.getElementById('preview-container');
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
        }
        
        reader.readAsDataURL(file);
    } else {
        container.style.display = 'none';
    }
});
</script>
@endsection