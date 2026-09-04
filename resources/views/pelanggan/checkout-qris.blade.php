@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 500px;">
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white border-0 py-3 text-center">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-qrcode me-2 text-primary"></i>Pembayaran QRIS
            </h5>
        </div>
        <div class="card-body p-4 text-center">
            
            <p class="text-muted mb-4">Silakan scan QR Code di bawah ini menggunakan aplikasi DANA, GoPay, OVO, ShopeePay, atau Mobile Banking Anda.</p>
            
            <div class="qr-container mb-4 mx-auto" style="border: 2px solid #E5E7EB; border-radius: 20px; padding: 20px; background: white; max-width: 300px;">
                <!-- QR Code image that we copied to public/qris-payment.jpg -->
                <img src="{{ asset('qris-payment.jpg') }}" alt="QRIS Kembang Tahu" class="img-fluid rounded" style="width: 100%;">
            </div>
            
            <div class="alert alert-info rounded-3 mb-4 text-start">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-info-circle fs-4 me-2"></i>
                    <strong>Total Pembayaran</strong>
                </div>
                <h3 class="fw-bold mb-0 text-primary">Rp {{ number_format($transaction->total, 0, ',', '.') }}</h3>
            </div>
            
            <p class="text-sm text-muted mb-4">
                Kode Transaksi: <strong>{{ $transaction->kode_transaksi }}</strong>
            </p>

            <a href="{{ route('pelanggan.checkout.success', $transaction->id) }}" class="btn w-100 rounded-pill fw-bold py-3 mb-2" style="background-color: #00880F; color: white; font-size: 1.1rem; box-shadow: 0 4px 12px rgba(0, 136, 15, 0.2);">
                Saya Sudah Bayar
            </a>
            
            <a href="{{ route('pelanggan.checkout.success', $transaction->id) }}" class="btn btn-outline-secondary w-100 rounded-pill fw-bold py-2">
                Nanti Saja
            </a>
        </div>
    </div>
</div>

<style>
.qr-container {
    box-shadow: 0 8px 24px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
}
.qr-container:hover {
    transform: translateY(-5px);
}
.btn:hover {
    transform: translateY(-2px);
}
</style>
@endsection
