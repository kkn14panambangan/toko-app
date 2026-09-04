@extends('layouts.app')

@section('content')
<!-- Google Fonts: Poppins -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #FAFAFA; /* Off-white / Clean background */
        padding-bottom: 90px;
    }

    /* Clean Header */
    .clean-header {
        height: 140px;
        background: linear-gradient(135deg, #FAE3C6 0%, #F5C695 100%);
        border-bottom-left-radius: 30px;
        border-bottom-right-radius: 30px;
        position: relative;
    }

    /* Profile Avatar & Info */
    .profile-container {
        margin-top: -60px; /* Overlap the header */
        text-align: center;
        padding: 0 20px;
        position: relative;
        z-index: 10;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid #FFFFFF;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        object-fit: cover;
        background: #fff;
    }

    .profile-title {
        font-weight: 800;
        color: #2D3748;
        margin-top: 15px;
        margin-bottom: 2px;
        font-size: 1.5rem;
        letter-spacing: -0.5px;
    }

    .profile-subtitle {
        color: #C62A29; /* Red accent */
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .profile-address {
        color: #718096;
        font-size: 0.8rem;
        line-height: 1.4;
        max-width: 400px;
        margin: 0 auto 15px auto;
    }

    .info-badges {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .badge-clean {
        background: #FFFFFF;
        color: #4A5568;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #EDF2F7;
    }

    .badge-clean i {
        color: #F6AD55; /* Orange star */
    }

    /* Modern Sticky Categories */
    .sticky-categories {
        position: sticky;
        top: 0;
        z-index: 1020;
        background: rgba(250, 250, 250, 0.95);
        backdrop-filter: blur(8px);
        padding: 15px 0;
        border-bottom: 1px solid #EDF2F7;
    }

    .category-scroll {
        display: flex;
        overflow-x: auto;
        gap: 12px;
        padding: 0 20px;
        scrollbar-width: none;
    }
    
    .category-scroll::-webkit-scrollbar { display: none; }

    .btn-category {
        white-space: nowrap;
        padding: 8px 24px;
        border-radius: 30px;
        border: 1px solid #E2E8F0;
        background: #FFFFFF;
        color: #4A5568;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .btn-category.active {
        background: #C62A29; /* Red theme active */
        color: #FFFFFF;
        border-color: #C62A29;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(198, 42, 41, 0.2);
    }

    /* Clean Product Cards */
    .menu-item {
        background: #FFFFFF;
        border-radius: 16px;
        padding: 15px;
        margin-bottom: 15px;
        display: flex;
        gap: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03); /* Super soft shadow */
        border: 1px solid #F7FAFC;
        transition: transform 0.2s;
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
        background: #F7FAFC;
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
        font-size: 1rem;
        color: #2D3748;
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .menu-desc {
        font-size: 0.8rem;
        color: #A0AEC0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .menu-price {
        font-weight: 700;
        color: #2D3748;
        font-size: 1.1rem;
    }

    .btn-add {
        background: #FFFFFF;
        color: #4A8A34; /* Green Add button */
        border: 1.5px solid #4A8A34;
        padding: 4px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    
    .btn-add:active {
        background: #4A8A34;
        color: #FFFFFF;
    }

    .btn-add:disabled {
        border-color: #CBD5E0;
        color: #CBD5E0;
    }
</style>

<!-- Clean Header Background -->
<div class="clean-header"></div>

<!-- Profile Section -->
<div class="profile-container">
    <img src="{{ Storage::url('logo.jpg') }}" alt="Logo Toko" class="profile-avatar">
    <h1 class="profile-title">Kembang Tahu Pak Ujang</h1>
    <div class="profile-subtitle">Khas Panambangan</div>
    <p class="profile-address">
        <i class="fas fa-map-marker-alt me-1 text-danger"></i> Dusun 2 blok.cantilan balong RT 02 RW 04 Desa panambangan kec.sedong kab.cirebon Jawa barat, indonesia
    </p>
    
    <div class="info-badges">
        <div class="badge-clean">
            <i class="fas fa-star"></i> 4.9
        </div>
        <div class="badge-clean">
            <i class="far fa-clock me-1 text-muted"></i> {{ $setting->jam_buka ?? '08:00' }} - {{ $setting->jam_tutup ?? '17:00' }}
        </div>
    </div>
</div>

<!-- Sticky Categories -->
<div class="sticky-categories">
    <div class="category-scroll">
        <button class="btn-category active" data-category="all" onclick="filterCategory('all')">Paling Laris</button>
        <button class="btn-category" data-category="segar" onclick="filterCategory('segar')">Kembang Tahu Segar</button>
        <button class="btn-category" data-category="kering" onclick="filterCategory('kering')">Kembang Tahu Kering</button>
        <button class="btn-category" data-category="olahan" onclick="filterCategory('olahan')">Olahan</button>
        <button class="btn-category" data-category="kulit" onclick="filterCategory('kulit')">Kulit Tahu</button>
    </div>
</div>

<!-- Product List -->
<div class="container mt-4 px-3">
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
                                {{ $product->stok <= 0 ? 'Habis' : 'Tambah' }}
                            </button>
                        </form>
                    </div>
                </div>
                <div class="menu-img-container">
                    @if($product->gambar)
                        <img src="{{ Storage::url($product->gambar) }}" class="menu-img" alt="{{ $product->nama_produk }}">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted" style="background:#EDF2F7;">
                            <i class="fas fa-image fa-2x"></i>
                        </div>
                    @endif
                    @if($product->stok <= 0)
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center" style="border-radius:12px;">
                            <span class="badge bg-danger small">Habis</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3 opacity-50"></i>
            <p class="text-muted font-monospace">Menu belum tersedia</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Modern Contact Section -->
<div class="container py-4 mt-2 mb-4">
    <div class="bg-white rounded-4 p-4 shadow-sm text-center border-0">
        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-3" style="width: 50px; height: 50px;">
            <i class="fab fa-whatsapp fs-3"></i>
        </div>
        <h5 class="fw-bold mb-2 text-dark">Hubungi Kami</h5>
        <p class="text-muted small mb-4">Pesan sekarang atau tanyakan ketersediaan menu langsung melalui WhatsApp Bapak Ujang.</p>
        <a href="https://wa.me/6282213066810" target="_blank" class="btn btn-success rounded-pill px-4 py-2 fw-bold w-100" style="background-color: #25D366; border: none; box-shadow: 0 4px 10px rgba(37, 211, 102, 0.3);">
            Chat 082213066810
        </a>
        
        <hr class="my-4 text-muted opacity-10">
        
        <a href="{{ Storage::url('qr-menu.png') }}" download target="_blank" class="btn btn-light btn-sm rounded-pill px-4 text-muted border">
            <i class="fas fa-qrcode me-2"></i> Simpan QR Menu
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