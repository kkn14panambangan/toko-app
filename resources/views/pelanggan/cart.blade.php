@extends('layouts.app')

@section('content')
@php
    $total = 0;
    foreach($cart as $item) {
        $total += $item['harga'] * $item['quantity'];
    }
    $cartCount = collect($cart)->sum('quantity');
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    body { font-family: 'Inter', sans-serif; background: #F3F4F6; padding-bottom: 100px; }

    .cart-header {
        background: white;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }
    .cart-header-back {
        width: 36px; height: 36px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: #F3F4F6;
        border: none;
        color: #111827;
        font-size: 1rem;
        text-decoration: none;
    }
    .cart-header-title { font-weight: 700; font-size: 1.1rem; color: #111827; }

    .store-info-bar {
        background: white;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #F3F4F6;
    }
    .store-icon {
        width: 36px; height: 36px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .store-icon img { width: 100%; height: 100%; object-fit: cover; }
    .store-name { font-weight: 700; font-size: 0.9rem; color: #111827; }
    .store-sub { font-size: 0.75rem; color: #6B7280; }

    .cart-item-row {
        background: white;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        border-bottom: 1px solid #F9FAFB;
    }
    .cart-item-img {
        width: 72px; height: 72px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
        background: #F3F4F6;
    }
    .qty-control {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .qty-btn {
        width: 28px; height: 28px;
        border-radius: 50%;
        border: 1.5px solid #00880F;
        background: white;
        color: #00880F;
        font-size: 0.9rem;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700;
        cursor: pointer;
    }
    .qty-num { font-weight: 700; color: #111827; min-width: 18px; text-align: center; }

    .section-card {
        background: white;
        margin: 10px 0 0;
        padding: 16px 20px;
    }
    .section-title { font-weight: 700; font-size: 0.9rem; color: #111827; margin-bottom: 12px; }
    .section-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; font-size: 0.875rem; color: #374151; }
    .section-row.total { font-weight: 700; font-size: 1rem; color: #111827; border-top: 1px solid #F3F4F6; padding-top: 12px; margin-top: 4px; }

    .payment-method-btn {
        display: flex; align-items: center; justify-content: space-between;
        background: #F0FDF4;
        border: 1.5px solid #00880F;
        border-radius: 10px;
        padding: 12px 16px;
        cursor: pointer;
        margin-bottom: 6px;
        font-weight: 600;
        color: #005F0A;
        font-size: 0.9rem;
    }
    .payment-method-btn.inactive {
        background: white;
        border-color: #E5E7EB;
        color: #374151;
    }

    .sticky-checkout {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: white;
        padding: 12px 20px;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.08);
        z-index: 200;
    }
    .checkout-btn {
        background: #00880F;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 20px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 700;
        font-size: 0.95rem;
    }
    .checkout-btn-left { display: flex; align-items: center; gap: 12px; }
    .checkout-count {
        background: rgba(255,255,255,0.2);
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 0.85rem;
    }
</style>

<!-- Header -->
<div class="cart-header">
    <a href="{{ route('pelanggan.shop') }}" class="cart-header-back">
        <i class="fas fa-arrow-left"></i>
    </a>
    <span class="cart-header-title">Keranjang</span>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mx-3 mt-2" role="alert" style="font-size: 0.85rem;">
    <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mx-3 mt-2" role="alert" style="font-size: 0.85rem;">
    <i class="fas fa-exclamation-circle me-1"></i>{{ session('error') }}
    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
</div>
@endif

@if($cart && count($cart) > 0)

<!-- Store Info -->
<div class="store-info-bar">
    <div class="store-icon">
        <img src="{{ Storage::url('logo.jpg') }}" alt="Logo">
    </div>
    <div>
        <div class="store-name">Kembang Tahu Pak Ujang</div>
        <div class="store-sub">Khas Panambangan</div>
    </div>
</div>

<!-- Cart Items -->
<div style="background: white;">
    @foreach($cart as $productId => $item)
    @php $subtotal = $item['harga'] * $item['quantity']; @endphp
    <div class="cart-item-row">
        @if(isset($item['gambar']) && $item['gambar'])
            <img src="{{ Storage::url($item['gambar']) }}" class="cart-item-img" alt="{{ $item['nama'] }}">
        @else
            <div class="cart-item-img d-flex align-items-center justify-content-center text-muted" style="background: #F3F4F6;">
                <i class="fas fa-image fa-lg"></i>
            </div>
        @endif

        <div class="flex-grow-1">
            <div style="font-weight: 700; font-size: 0.95rem; color: #111827; margin-bottom: 2px;">{{ $item['nama'] }}</div>
            <div style="font-size: 0.8rem; color: #6B7280; margin-bottom: 8px;">Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
            
            <div class="d-flex align-items-center justify-content-between">
                <div class="qty-control">
                    <!-- Minus / Remove -->
                    @if($item['quantity'] <= 1)
                    <form action="{{ route('pelanggan.cart.remove', $productId) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="qty-btn" style="border-color: #EF4444; color: #EF4444;">
                            <i class="fas fa-trash-alt" style="font-size: 0.7rem;"></i>
                        </button>
                    </form>
                    @else
                    <form action="{{ route('pelanggan.cart.update', $productId) }}" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                        <button type="submit" class="qty-btn"><i class="fas fa-minus" style="font-size: 0.7rem;"></i></button>
                    </form>
                    @endif

                    <span class="qty-num">{{ $item['quantity'] }}</span>

                    <!-- Plus -->
                    <form action="{{ route('pelanggan.cart.update', $productId) }}" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                        <button type="submit" class="qty-btn"><i class="fas fa-plus" style="font-size: 0.7rem;"></i></button>
                    </form>
                </div>

                <div style="font-weight: 700; color: #111827; font-size: 0.95rem;">
                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Metode Pembayaran -->
<div class="section-card">
    <div class="section-title">Metode Pembayaran</div>
    <label class="payment-method-btn" onclick="selectPayment('Qris', this)">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-qrcode" style="color: #00880F;"></i> QRIS
        </div>
        <i class="fas fa-check-circle" style="color: #00880F;"></i>
    </label>
    <label class="payment-method-btn inactive" onclick="selectPayment('Tunai', this)">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-money-bill-wave" style="color: #6B7280;"></i> Tunai
        </div>
        <i class="far fa-circle" style="color: #D1D5DB;"></i>
    </label>
</div>

<!-- Ringkasan Harga -->
<div class="section-card mb-4">
    <div class="section-title">Ringkasan Pesanan</div>
    @foreach($cart as $item)
    <div class="section-row">
        <span>{{ $item['nama'] }} × {{ $item['quantity'] }}</span>
        <span>Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</span>
    </div>
    @endforeach
    <div class="section-row total">
        <span>Total Pembayaran</span>
        <span style="color: #00880F;">Rp {{ number_format($total, 0, ',', '.') }}</span>
    </div>
</div>

<!-- Sticky Checkout Button -->
<form action="{{ route('pelanggan.checkout') }}" method="POST" id="checkoutForm">
    @csrf
    <input type="hidden" name="total" value="{{ $total }}">
    <input type="hidden" name="metode_pembayaran" id="metode_pembayaran" value="Qris">
    
    <div class="sticky-checkout">
        <button type="submit" class="checkout-btn">
            <div class="checkout-btn-left">
                <span class="checkout-count">{{ $cartCount }} item</span>
                <span>Pesan Sekarang</span>
            </div>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </button>
    </div>
</form>

@else
<!-- Empty Cart -->
<div class="d-flex flex-column align-items-center justify-content-center" style="height: 70vh; text-align: center; padding: 20px;">
    <div style="font-size: 5rem; margin-bottom: 16px; opacity: 0.2;">🛒</div>
    <div style="font-weight: 700; font-size: 1.1rem; color: #111827; margin-bottom: 8px;">Keranjang Kosong</div>
    <div style="font-size: 0.85rem; color: #6B7280; margin-bottom: 24px;">Mulai tambahkan menu yang kamu suka!</div>
    <a href="{{ route('pelanggan.shop') }}" class="btn btn-success rounded-pill px-4 fw-bold" style="background: #00880F; border: none;">
        Lihat Menu
    </a>
</div>
@endif

<script>
function selectPayment(method, el) {
    document.getElementById('metode_pembayaran').value = method;
    document.querySelectorAll('.payment-method-btn').forEach(btn => {
        btn.classList.add('inactive');
        btn.querySelector('i:last-child').className = 'far fa-circle';
        btn.querySelector('i:last-child').style.color = '#D1D5DB';
    });
    el.classList.remove('inactive');
    el.querySelector('i:last-child').className = 'fas fa-check-circle';
    el.querySelector('i:last-child').style.color = '#00880F';
}
</script>
@endsection