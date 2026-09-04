@extends('layouts.app')

@section('content')
<!-- Google Fonts: Inter (Lebih mirip GrabFood) -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    body {
        font-family: 'Inter', sans-serif;
        background-color: #F3F4F6; /* Gray background */
        padding-bottom: 90px;
    }

    /* Grab Header Cover */
    .grab-header {
        height: 220px;
        background: url('{{ Storage::url('logo.jpg') }}') center/cover no-repeat;
        position: relative;
    }
    
    .grab-header::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 100%);
    }

    /* Floating Store Card */
    .grab-store-card {
        background: #FFFFFF;
        border-radius: 24px;
        margin: -60px 15px 15px 15px;
        padding: 20px;
        position: relative;
        z-index: 10;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }

    .store-title {
        font-weight: 800;
        color: #1F2937;
        font-size: 1.4rem;
        margin-bottom: 8px;
        line-height: 1.2;
    }

    .store-meta {
        font-size: 0.85rem;
        color: #4B5563;
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .grab-delivery-toggle {
        display: flex;
        background: #F3F4F6;
        border-radius: 30px;
        padding: 4px;
        margin-bottom: 15px;
    }

    .grab-toggle-btn {
        flex: 1;
        text-align: center;
        padding: 8px 0;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 26px;
        color: #4B5563;
    }

    .grab-toggle-btn.active {
        background: #00B14F; /* Grab Green */
        color: #FFFFFF;
        box-shadow: 0 2px 4px rgba(0, 177, 79, 0.3);
    }

    .grab-action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .grab-action-btn {
        padding: 8px 15px;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        background: #FFFFFF;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Menu Section Container */
    .grab-menu-section {
        background: #FFFFFF;
        margin-top: 10px;
        padding-top: 20px;
    }

    .menu-section-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #111827;
        padding: 0 20px 15px 20px;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Grab List Item */
    .grab-item {
        display: flex;
        padding: 15px 20px;
        border-bottom: 1px dashed #E5E7EB;
        gap: 15px;
    }
    
    .grab-item:last-child {
        border-bottom: none;
    }

    .grab-item-content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .grab-item-title {
        font-weight: 700;
        font-size: 1.05rem;
        color: #1F2937;
        margin-bottom: 6px;
        line-height: 1.3;
    }

    .grab-item-desc {
        font-size: 0.8rem;
        color: #6B7280;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .grab-item-price {
        font-weight: 700;
        color: #111827;
        font-size: 1rem;
        margin-top: auto;
    }

    /* Grab Image & Add Button */
    .grab-img-wrapper {
        position: relative;
        width: 110px;
        height: 110px;
        flex-shrink: 0;
    }

    .grab-item-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
        background: #F3F4F6;
    }

    .grab-btn-add {
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: #FFFFFF;
        color: #00B14F;
        border: 1.5px solid #00B14F;
        padding: 4px 18px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        white-space: nowrap;
        transition: all 0.2s;
        z-index: 2;
    }
    
    .grab-btn-add:active {
        background: #F0FDF4;
        transform: translateX(-50%) scale(0.95);
    }
    
    .grab-btn-add:disabled {
        border-color: #D1D5DB;
        color: #9CA3AF;
        background: #F3F4F6;
        box-shadow: none;
    }

    /* Floating Red Menu Button */
    .floating-menu-btn {
        position: fixed;
        bottom: 80px; /* Above bottom nav */
        left: 50%;
        transform: translateX(-50%);
        background: #E02020; /* Grab Red / Warning color */
        color: #FFFFFF;
        padding: 10px 24px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.95rem;
        box-shadow: 0 4px 12px rgba(224, 32, 32, 0.4);
        z-index: 1030;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: transform 0.2s;
    }
    
    .floating-menu-btn:active {
        transform: translateX(-50%) scale(0.95);
    }
</style>

<!-- Top Header Cover -->
<div class="grab-header">
</div>

<!-- Floating Store Card -->
<div class="grab-store-card">
    <h1 class="store-title">Kembang Tahu Pak Ujang</h1>
    <h2 class="text-muted mb-2" style="font-size: 1rem; font-weight: 500;">Khas Panambangan</h2>
    <div class="store-meta">
        <a href="https://www.google.com/maps/search/?api=1&query=Kembang+Tahu+Pak+Ujang,+Desa+Panambangan,+Sedong,+Cirebon" target="_blank" class="text-decoration-none d-flex align-items-center">
            <i class="fas fa-star text-warning me-1"></i> <span class="fw-bold me-1 text-dark">5.0</span> <span class="text-muted">(0 ulasan)</span> <i class="fas fa-chevron-right ms-2 text-muted" style="font-size: 0.7rem;"></i>
        </a>
    </div>
    <div class="store-meta text-muted mb-3" style="font-size: 0.8rem; line-height: 1.4;">
        <i class="fas fa-map-marker-alt me-2 mt-1" style="float: left;"></i> 
        <span style="display: block; margin-left: 20px;">Dusun 2 blok cantilan balong RT 02 RW 04 Desa panambangan kec. sedong kab. cirebon Jawa barat, indonesia</span>
    </div>

<!-- Action Buttons -->
    <div class="grab-action-buttons mt-3">
        <a href="https://wa.me/6282213066810" target="_blank" class="grab-action-btn text-decoration-none">
            <i class="fab fa-whatsapp text-success fs-5"></i> Chat WhatsApp
        </a>
        <a href="{{ Storage::url('qr-menu.png') }}" target="_blank" class="grab-action-btn text-decoration-none">
            <i class="fas fa-qrcode text-muted"></i> QR Menu
        </a>
    </div>
</div>



<!-- Menu Section -->
<div class="grab-menu-section" id="menu-section">
    <h2 class="menu-section-title">Semua Menu</h2>
    
    <div class="grab-list-container pb-5">
        @forelse($products as $product)
        <div class="grab-item">
            <!-- Left: Text -->
            <div class="grab-item-content">
                @if($product->kategori == 'segar')
                    <div class="text-danger mb-1" style="font-size: 0.7rem; font-weight: 700;">
                        <i class="fas fa-shopping-bag me-1"></i> Sering dibeli lagi
                    </div>
                @endif
                <h3 class="grab-item-title">{{ $product->nama_produk }}</h3>
                <p class="grab-item-desc">{{ $product->deskripsi }}</p>
                <div class="grab-item-price">{{ number_format($product->harga, 0, ',', '.') }}</div>
            </div>
            
            <!-- Right: Image & Button -->
            <div class="grab-img-wrapper">
                @if($product->gambar)
                    <img src="{{ Storage::url($product->gambar) }}" class="grab-item-img" alt="{{ $product->nama_produk }}">
                @else
                    <div class="grab-item-img d-flex align-items-center justify-content-center text-muted border">
                        <i class="fas fa-image fa-2x"></i>
                    </div>
                @endif
                
                <form action="{{ route('pelanggan.cart.add') }}" method="POST" class="m-0">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="grab-btn-add" {{ $product->stok <= 0 ? 'disabled' : '' }}>
                        {{ $product->stok <= 0 ? 'Habis' : 'Tambah' }}
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="fas fa-store-slash fa-3x text-muted mb-3 opacity-50"></i>
            <p class="text-muted fw-bold">Belum ada menu tersedia</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Floating Menu Button -->
<a href="#menu-section" class="floating-menu-btn">
    <i class="fas fa-concierge-bell"></i> Menu
</a>

<script>
// Mock interaction for Delivery/Pickup toggle
document.querySelectorAll('.grab-toggle-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.grab-toggle-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>
@endsection