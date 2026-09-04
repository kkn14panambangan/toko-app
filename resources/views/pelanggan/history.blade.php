@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fw-bold mb-0">
                    <i class="fas fa-history me-2 text-primary"></i>Riwayat Transaksi
                </h1>
            </div>

            @if($transactions && $transactions->count() > 0)
                <div class="row g-4">
                    @foreach($transactions as $transaction)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                            <!-- Card Header dengan Status -->
                            <div class="card-header border-0 py-3" 
                                 style="background: {{ $transaction->status == 'success' ? 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)' : ($transaction->status == 'pending' ? 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)' : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)') }};">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-white">
                                        <h5 class="mb-1 fw-bold">
                                            <i class="fas fa-receipt me-2"></i>{{ $transaction->kode_transaksi }}
                                        </h5>
                                        <small class="opacity-75">
                                            <i class="far fa-calendar me-1"></i>{{ $transaction->created_at->format('d/m/Y') }}
                                            <i class="far fa-clock ms-2 me-1"></i>{{ $transaction->created_at->format('H:i') }}
                                        </small>
                                    </div>
                                    <div class="col-md-4 text-white text-center">
                                        @if($transaction->status == 'success')
                                            <span class="badge bg-white text-success fs-6 px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i>Transaksi Diterima
                                            </span>
                                        @elseif($transaction->status == 'pending')
                                            <span class="badge bg-white text-warning fs-6 px-3 py-2">
                                                <i class="fas fa-clock me-1"></i>Menunggu Konfirmasi
                                            </span>
                                        @else
                                            <span class="badge bg-white text-danger fs-6 px-3 py-2">
                                                <i class="fas fa-times-circle me-1"></i>Transaksi Ditolak
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 text-white text-md-end mt-2 mt-md-0">
                                        <h3 class="fw-bold mb-0">Rp {{ number_format($transaction->total, 0, ',', '.') }}</h3>
                                        <small class="opacity-75">{{ $transaction->metode_pembayaran }}</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Card Body -->
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-box me-2 text-primary"></i>Detail Pesanan
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
                                                            <div>
                                                                <strong>{{ $item->product->nama_produk ?? 'Produk tidak tersedia' }}</strong>
                                                            </div>
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
                                                <th class="text-end">{{ $totalItems }}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="text-end">Metode Pembayaran:</th>
                                                <td class="text-end">{{ $transaction->metode_pembayaran }}</td>
                                            </tr>
                                            @if($transaction->status == 'success' && $transaction->metode_pembayaran == 'Tunai')
                                            <tr>
                                                <th colspan="3" class="text-end">Uang Dibayar:</th>
                                                <td class="text-end">Rp {{ number_format($transaction->uang_dibayar ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="text-end">Kembalian:</th>
                                                <td class="text-end text-success">Rp {{ number_format($transaction->kembalian ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            @endif
                                            <tr class="table-primary">
                                                <th colspan="3" class="text-end fs-5">Total Pembayaran:</th>
                                                <th class="text-end fs-5 text-primary">Rp {{ number_format($transaction->total, 0, ',', '.') }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Status Message -->
                                <div class="alert {{ $transaction->status == 'success' ? 'alert-success' : ($transaction->status == 'pending' ? 'alert-warning' : 'alert-danger') }} mt-3 mb-0">
                                    @if($transaction->status == 'success')
                                        <i class="fas fa-check-circle me-2"></i>
                                        <strong>Transaksi Berhasil!</strong><br>
                                        Pembayaran telah diverifikasi oleh admin. Terima kasih!
                                    @elseif($transaction->status == 'pending')
                                        <i class="fas fa-clock me-2"></i>
                                        <strong>Menunggu Konfirmasi</strong><br>
                                        Transaksi Anda sedang diproses oleh admin. Mohon tunggu.
                                    @else
                                        <i class="fas fa-times-circle me-2"></i>
                                        <strong>Transaksi Ditolak</strong><br>
                                        Maaf, transaksi Anda tidak dapat diproses.
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $transactions->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 15px;">
                    <div class="card-body">
                        <i class="fas fa-receipt fa-5x text-muted mb-3 opacity-25"></i>
                        <h4 class="text-muted mb-3">Belum Ada Transaksi</h4>
                        <p class="text-muted mb-4">Anda belum memiliki riwayat transaksi</p>
                        <a href="{{ route('pelanggan.shop') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.table th {
    font-weight: 600;
    font-size: 0.9rem;
}

.badge {
    font-weight: 600;
}
</style>
@endsection