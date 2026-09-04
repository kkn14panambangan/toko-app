@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Header -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px; overflow: hidden;">
                <div class="card-body text-center py-5" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="success-icon mb-3">
                        <i class="fas fa-check-circle fa-5x text-white"></i>
                    </div>
                    <h2 class="text-white fw-bold mb-2">Transaksi Berhasil!</h2>
                    <p class="text-white-50 mb-0">Pesanan Anda telah kami terima dan sedang diproses</p>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-receipt me-2 text-primary"></i>Detail Transaksi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted d-block mb-1">Kode Transaksi</small>
                                <h5 class="fw-bold text-primary mb-0">{{ $transaction->kode_transaksi }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted d-block mb-1">Tanggal</small>
                                <h5 class="fw-bold mb-0">{{ $transaction->tanggal_transaksi ? \Carbon\Carbon::parse($transaction->tanggal_transaksi)->format('d/m/Y H:i') : $transaction->created_at->format('d/m/Y H:i') }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted d-block mb-1">Metode Pembayaran</small>
                                <h5 class="fw-bold mb-0">
                                    <i class="fas fa-{{ $transaction->metode_pembayaran == 'Qris' ? 'qrcode text-primary' : 'money-bill-wave text-success' }} me-1"></i>
                                    {{ $transaction->metode_pembayaran }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted d-block mb-1">Status</small>
                                <h5 class="fw-bold mb-0">
                                    @if($transaction->status == 'success')
                                        <span class="text-success"><i class="fas fa-check-circle me-1"></i>Diterima</span>
                                    @elseif($transaction->status == 'pending')
                                        <span class="text-warning"><i class="fas fa-clock me-1"></i>Menunggu Konfirmasi</span>
                                    @else
                                        <span class="text-danger"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>

                    <!-- Items List -->
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-box me-2 text-primary"></i>Produk yang Dibeli
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalItems = 0; @endphp
                                @foreach($transaction->items as $item)
                                    @php $subtotal = $item->harga * $item->jumlah; $totalItems += $item->jumlah; @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->gambar)
                                                    <img src="{{ Storage::url($item->product->gambar) }}" 
                                                         class="rounded me-2" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                                <strong>{{ $item->product->nama_produk ?? 'Produk tidak tersedia' }}</strong>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->jumlah }}</td>
                                        <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Total Items:</th>
                                    <td class="text-end fw-bold">{{ $totalItems }}</td>
                                </tr>
                                <tr class="table-primary">
                                    <th colspan="3" class="text-end fs-5">Total Pembayaran:</th>
                                    <td class="text-end fs-5 text-primary fw-bold">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Status Message -->
                    <div class="alert {{ $transaction->status == 'success' ? 'alert-success' : ($transaction->status == 'pending' ? 'alert-warning' : 'alert-danger') }} mt-4 mb-0">
                        @if($transaction->status == 'success')
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Transaksi Berhasil!</strong><br>
                            <small>Pembayaran telah diverifikasi oleh admin. Terima kasih!</small>
                        @elseif($transaction->status == 'pending')
                            <i class="fas fa-clock me-2"></i>
                            <strong>Menunggu Konfirmasi Admin</strong><br>
                            <small>Transaksi Anda sedang diproses. Mohon tunggu konfirmasi dari admin.</small>
                            @if($transaction->metode_pembayaran == 'Qris')
                                <hr class="my-2">
                                <small><i class="fas fa-info-circle me-1"></i>Jika Anda memilih QRIS, silakan scan QR Code yang telah ditampilkan sebelumnya.</small>
                            @endif
                        @else
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>Transaksi Ditolak</strong><br>
                            <small>Maaf, transaksi Anda tidak dapat diproses.</small>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row g-3">
                <div class="col-md-6">
                    <a href="{{ route('pelanggan.shop') }}" class="btn btn-primary btn-lg w-100 py-3">
                        <i class="fas fa-shopping-bag me-2"></i>Lanjutkan Belanja
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('pelanggan.history') }}" class="btn btn-outline-primary btn-lg w-100 py-3">
                        <i class="fas fa-history me-2"></i>Lihat Riwayat Transaksi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.success-icon {
    animation: bounceIn 0.8s ease;
}

@keyframes bounceIn {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
</style>
@endsection