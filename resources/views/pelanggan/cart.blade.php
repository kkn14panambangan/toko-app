@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fw-bold mb-0">
                    <i class="fas fa-shopping-cart me-2 text-primary"></i>Keranjang Belanja
                </h1>
                <a href="{{ route('pelanggan.shop') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Lanjutkan Belanja
                </a>
            </div>

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

            @if($cart && count($cart) > 0)
                <!-- Cart Items -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        @php $total = 0; @endphp
                        @foreach($cart as $productId => $item)
                            @php 
                                $subtotal = $item['harga'] * $item['quantity']; 
                                $total += $subtotal; 
                            @endphp
                            <div class="cart-item mb-3 pb-3 border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        @if(isset($item['gambar']) && $item['gambar'])
                                            <img src="{{ Storage::url($item['gambar']) }}" 
                                                 class="img-fluid rounded" 
                                                 alt="{{ $item['nama'] }}"
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 80px; height: 80px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="fw-bold mb-1">{{ $item['nama'] }}</h6>
                                        <p class="text-muted small mb-0">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center">
                                            <form action="{{ route('pelanggan.cart.update', $productId) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </form>
                                            <input type="text" 
                                                   class="form-control form-control-sm text-center mx-2" 
                                                   value="{{ $item['quantity'] }}" 
                                                   readonly
                                                   style="width: 60px;">
                                            <form action="{{ route('pelanggan.cart.update', $productId) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="fw-bold text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <form action="{{ route('pelanggan.cart.remove', $productId) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger" onclick="return confirm('Hapus produk ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Checkout Section -->
                <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Total Pembayaran</h5>
                            <h3 class="text-primary fw-bold mb-0">Rp {{ number_format($total, 0, ',', '.') }}</h3>
                        </div>

                        <!-- QR Code Display -->
                        <div class="mb-4">
                            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: white;">
                                <div class="card-body p-4 text-center">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-qrcode me-2 text-primary"></i>Scan QR Code untuk Pembayaran
                                    </h5>
                                    <div class="qrcode-container mb-3 p-3 bg-white rounded-3 d-inline-block" style="border: 3px solid #667eea;">
                                        <img id="qrCodeImage" 
                                             src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=QRIS-Pembayaran-KembangTahu66-Rp{{ $total }}" 
                                             alt="QR Code Pembayaran" 
                                             class="img-fluid"
                                             style="width: 250px; height: 250px;">
                                    </div>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Scan QR Code di atas menggunakan aplikasi e-wallet atau mobile banking Anda
                                    </p>
                                    <div class="alert alert-info mt-3 mb-0">
                                        <small>
                                            <i class="fas fa-clock me-1"></i>
                                            <strong>Total:</strong> Rp {{ number_format($total, 0, ',', '.') }}<br>
                                            <i class="fas fa-store me-1"></i>
                                            <strong>Toko:</strong> Kembang Tahu 66
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('pelanggan.checkout') }}" method="POST" id="checkoutForm">
                            @csrf
                            <input type="hidden" name="total" value="{{ $total }}">
                            <input type="hidden" name="metode_pembayaran" value="Qris">
                            
                            <button type="submit" class="btn btn-success btn-lg w-100 py-3">
                                <i class="fas fa-check-circle me-2"></i>Checkout Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 15px;">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart fa-5x text-muted mb-3 opacity-25"></i>
                        <h4 class="text-muted mb-3">Keranjang Belanja Kosong</h4>
                        <p class="text-muted mb-4">Mulai belanja untuk menambahkan produk ke keranjang</p>
                        <a href="{{ route('pelanggan.shop') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-store me-2"></i>Mulai Belanja
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.cart-item {
    transition: all 0.3s ease;
}

.cart-item:hover {
    background: #f8f9fa;
    border-radius: 10px;
    padding-left: 10px;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
}

.qrcode-container {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>
@endsection