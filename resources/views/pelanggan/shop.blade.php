@extends('layouts.app')

@section('content')
<style>
    /* Cafe Menu Styles */
    body {
        background-color: #f4f6f8;
        padding-bottom: 80px; /* Space for bottom nav */
    }
    
    .resto-header {
        position: relative;
        height: 220px;
        background: url('{{ Storage::url('logo.jpg') }}') center/cover no-repeat;
        border-bottom-left-radius: 25px;
        border-bottom-right-radius: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .resto-header::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.2) 100%);
    }

    .resto-info {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 20px;
        color: white;
        z-index: 1;
    }

    .info-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 0.8rem;
        display: inline-block;
        margin-right: 5px;
        border: 1px solid rgba(255,255,255,0.3);
    }

    /* Sticky Categories */
    .sticky-categories {
        position: sticky;
        top: 0;
        z-index: 1020;
        background: rgba(244, 246, 248, 0.95);
        backdrop-filter: blur(10px);
        padding: 12px 0;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }

    .category-scroll {
        display: flex;
        overflow-x: auto;
        gap: 10px;
        padding: 0 15px;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    
    .category-scroll::-webkit-scrollbar {
        display: none;
    }

    .btn-category {
        white-space: nowrap;
        padding: 8px 20px;
        border-radius: 25px;
        border: none;
        background: white;
        color: #555;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .btn-category.active {
        background: #8b5a2b; /* Warm brown */
        color: white;
    }

    /* Product List View */
    .menu-item {
        background: white;
        border-radius: 15px;
        padding: 12px;
        margin-bottom: 12px;
        display: flex;
        gap: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: transform 0.2s;
        border: 1px solid rgba(0,0,0,0.02);
    }
    
    .menu-item:active {
        transform: scale(0.98);
    }

    .menu-img-container {
        width: 100px;
        height: 100px;
        flex-shrink: 0;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        background: #eee;
    }

    .menu-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .menu-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .menu-title {
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 4px;
        color: #2c3e50;
        line-height: 1.2;
    }

    .menu-desc {
        font-size: 0.8rem;
        color: #7f8c8d;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .menu-price {
        font-weight: 700;
        color: #8b5a2b;
        font-size: 1.05rem;
    }

    .btn-add {
        background: #8b5a2b;
        color: white;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        box-shadow: 0 2px 5px rgba(139, 90, 43, 0.4);
        transition: all 0.2s;
    }
    
    .btn-add:active {
        background: #6b4420;
        transform: scale(0.9);
    }

    .btn-add:disabled {
        background: #ccc;
        box-shadow: none;
    }
</style>

<!-- Hero Banner (Resto Style) -->
<div class="resto-header">
    <div class="resto-info">
        <h1 class="fw-bold mb-0 h3">{{ 'Kembang Tahu Pak Ujang' }}</h1>
        <h2 class="h6 mb-2 text-warning fw-semibold fst-italic">Khas Panambangan</h2>
        <p class="mb-2 text-white-50 small"><i class="fas fa-map-marker-alt me-1"></i>{{ $setting->alamat ?? 'Cirebon, Jawa Barat' }}</p>
        <div>
            <span class="info-badge"><i class="fas fa-star text-warning me-1"></i>4.9</span>
            <span class="info-badge"><i class="far fa-clock me-1"></i>{{ $setting->jam_buka ?? '08:00' }} - {{ $setting->jam_tutup ?? '17:00' }}</span>
        </div>
    </div>
</div>

<!-- Sticky Categories -->
<div class="sticky-categories">
    <div class="category-scroll">
        <button class="btn-category active" data-category="all" onclick="filterCategory('all')">Menu Kami</button>
        <button class="btn-category" data-category="segar" onclick="filterCategory('segar')">Kembang Tahu Segar</button>
        <button class="btn-category" data-category="kering" onclick="filterCategory('kering')">Kembang Tahu Kering</button>
        <button class="btn-category" data-category="olahan" onclick="filterCategory('olahan')">Olahan</button>
        <button class="btn-category" data-category="kulit" onclick="filterCategory('kulit')">Kulit Tahu</button>
    </div>
</div>

<!-- Product List -->
<div class="container mt-3 px-3">
    <div class="row" id="productsContainer">
        @forelse($products as $product)
        <div class="col-12 col-md-6 col-lg-4 product-item" data-category="{{ $product->kategori }}">
            <div class="menu-item">
                <div class="menu-content pe-2">
                    <div>
                        <h3 class="menu-title">{{ $product->nama_produk }}</h3>
                        <p class="menu-desc">{{ $product->deskripsi }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="menu-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        
                        <form action="{{ route('pelanggan.cart.add') }}" method="POST" class="m-0">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-add" {{ $product->stok <= 0 ? 'disabled' : '' }}>
                                <i class="fas fa-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="menu-img-container">
                    @if($product->gambar)
                        <img src="{{ Storage::url($product->gambar) }}" class="menu-img" alt="{{ $product->nama_produk }}">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted">
                            <i class="fas fa-image fa-2x"></i>
                        </div>
                    @endif
                    @if($product->stok <= 0)
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center">
                            <span class="badge bg-danger small">Habis</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
            <p class="text-muted">Menu belum tersedia</p>
        </div>
        @endforelse
    </div>
</div>

<!-- E-Catalog Info Section -->
<div class="container py-4 mt-2 mb-4">
    <div class="bg-white rounded-4 p-4 shadow-sm text-center border">
        <h5 class="fw-bold mb-2" style="color: #8b5a2b;"><i class="fas fa-info-circle me-2"></i>Tentang Kami</h5>
        <p class="text-muted small mb-0">{{ $setting->deskripsi ?? 'Nikmati kembang tahu segar dan berkualitas dari Kembang Tahu Pak Ujang.' }}</p>
        <hr class="my-3 text-muted opacity-25">
        <a href="{{ Storage::url('qr-menu.png') }}" download target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fas fa-qrcode me-1"></i> Simpan QR Menu
        </a>
    </div>
</div>

<script>
function filterCategory(category) {
    document.querySelectorAll('.btn-category').forEach(btn => btn.classList.remove('active'));
    document.querySelector(`[data-category="${category}"]`).classList.add('active');
    
    document.querySelectorAll('.product-item').forEach(product => {
        if (category === 'all' || product.dataset.category === category) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}
</script>
@endsection