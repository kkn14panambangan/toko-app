@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%); min-height: 100vh;">
    
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Transaksi
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle me-2"></i>Error:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Kolom Kiri: Info Transaksi -->
        <div class="col-lg-5">
            <!-- Card Header dengan Gradient -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px; overflow: hidden;">
                <div class="card-body p-4 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <small class="opacity-75 text-uppercase fw-semibold">Kode Transaksi</small>
                            <h3 class="fw-bold mb-0">{{ $transaction->kode_transaksi }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-2">
                            <i class="fas fa-receipt fa-2x text-white"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="far fa-calendar me-2"></i>
                        <span>{{ \Carbon\Carbon::parse($transaction->tanggal_transaksi ?? $transaction->created_at)->format('d F Y, H:i') }} WIB</span>
                    </div>
                </div>
            </div>

            <!-- Info Detail -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-info-circle me-2 text-primary"></i>Informasi Transaksi
                    </h5>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Metode Pembayaran</small>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-{{ $transaction->metode_pembayaran == 'Qris' ? 'qrcode text-primary' : 'money-bill-wave text-success' }} fa-lg me-2"></i>
                            <span class="fw-semibold fs-5">{{ $transaction->metode_pembayaran }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Status Transaksi</small>
                        @if($transaction->status == 'success')
                            <span class="badge bg-success px-3 py-2 fs-6"><i class="fas fa-check-circle me-1"></i>Diterima</span>
                        @elseif($transaction->status == 'pending')
                            <span class="badge bg-warning text-dark px-3 py-2 fs-6"><i class="fas fa-clock me-1"></i>Menunggu</span>
                        @elseif($transaction->status == 'cancelled')
                            <span class="badge bg-danger px-3 py-2 fs-6"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Pelanggan</small>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div>
                                <strong>{{ $transaction->user->name ?? 'Guest' }}</strong>
                                <small class="text-muted d-block">{{ $transaction->user->email ?? '-' }}</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div>
                        <small class="text-muted d-block mb-1">Total Pembayaran</small>
                        <h2 class="fw-bold text-primary mb-0">Rp {{ number_format($transaction->total, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>

            <!-- Action Buttons (Hanya muncul jika status pending) -->
            @if($transaction->status == 'pending')
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-cogs me-2 text-warning"></i>Aksi Admin
                    </h5>
                    
                    <form action="{{ route('admin.transactions.accept', $transaction->id) }}" method="POST" class="mb-3" onsubmit="return confirm('Yakin ingin menerima transaksi ini?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success w-100 py-2">
                            <i class="fas fa-check-circle me-2"></i>Terima Transaksi
                        </button>
                    </form>

                    <form action="{{ route('admin.transactions.reject', $transaction->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak transaksi ini? Stok akan dikembalikan.');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning w-100 py-2">
                            <i class="fas fa-times-circle me-2"></i>Tolak Transaksi
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Kolom Kanan: Detail Produk -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-box-open me-2 text-primary"></i>Detail Produk
                    </h5>
                </div>
                <div class="card-body p-4">
                    @php $totalItems = 0; @endphp
                    @foreach($transaction->items as $item)
                        @php $subtotal = $item->harga * $item->jumlah; $totalItems += $item->jumlah; @endphp
                        <div class="product-item mb-3 p-3 border rounded-3">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    @if($item->product && $item->product->gambar)
                                        <img src="{{ Storage::url($item->product->gambar) }}" class="img-fluid rounded" style="width: 70px; height: 70px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                            <i class="fas fa-image text-muted fa-2x"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-5">
                                    <h6 class="fw-bold mb-1">{{ $item->product->nama_produk ?? 'Produk tidak tersedia' }}</h6>
                                    <small class="text-muted"><i class="fas fa-tag me-1"></i>Rp {{ number_format($item->harga, 0, ',', '.') }} /pcs</small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="badge bg-primary fs-6 px-3 py-2">x{{ $item->jumlah }}</span>
                                </div>
                                <div class="col-md-3 text-end">
                                    <span class="fw-bold text-primary fs-5">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Summary -->
                    <div class="bg-light rounded-3 p-3 mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Items:</span>
                            <span class="fw-semibold">{{ $totalItems }} produk</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Metode Pembayaran:</span>
                            <span class="fw-semibold">{{ $transaction->metode_pembayaran }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold fs-5">Total Pembayaran:</span>
                            <span class="fw-bold fs-4 text-primary">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.card:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important; }
.product-item { transition: all 0.3s ease; background: white; }
.product-item:hover { background: #f8f9fa !important; transform: translateX(5px); box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
.btn { transition: all 0.3s ease; }
.btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
</style>
@endsection