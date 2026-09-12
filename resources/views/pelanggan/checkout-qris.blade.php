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
            
            <p class="text-muted mb-4">Silakan klik tombol di bawah ini untuk membuka halaman pembayaran (Bisa langsung menyambung ke DANA, GoPay, OVO, dll).</p>
            
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

            <button id="pay-button" class="btn w-100 rounded-pill fw-bold py-3 mb-2" style="background-color: #00880F; color: white; font-size: 1.1rem; box-shadow: 0 4px 12px rgba(0, 136, 15, 0.2);">
                <i class="fas fa-wallet me-2"></i> Bayar Sekarang
            </button>
            
            <a href="{{ route('pelanggan.checkout.success', $transaction->id) }}" class="btn btn-outline-secondary w-100 rounded-pill fw-bold py-2 mt-2">
                Nanti Saja
            </a>
        </div>
    </div>
</div>

<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
      snap.pay('{{ $transaction->snap_token }}', {
        onSuccess: function(result){
          window.location.href = "{{ route('pelanggan.checkout.success', $transaction->id) }}";
        },
        onPending: function(result){
          window.location.href = "{{ route('pelanggan.checkout.success', $transaction->id) }}";
        },
        onError: function(result){
          alert("Pembayaran gagal!");
        },
        onClose: function(){
          alert('Anda menutup popup tanpa menyelesaikan pembayaran');
        }
      });
    };
</script>

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
