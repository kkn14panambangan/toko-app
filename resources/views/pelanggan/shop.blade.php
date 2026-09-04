@extends('layouts.app')

@section('content')
<!-- Hero Banner -->
<div class="position-relative overflow-hidden">
    <div class="text-white py-5 position-relative" style="background: url('{{ asset('storage/logo.jpg') }}') center/cover no-repeat;">
        <!-- Overlay -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0, 0, 0, 0.7);"></div>
        
        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-2">{{ $setting->nama_toko ?? 'Kembang Tahu 65' }}</h1>
                    <p class="lead mb-0">{{ $setting->deskripsi ?? 'Kembang Tahu Segar' }}</p>
                </div>
                <div class="col-lg-4 text-lg-end d-none d-lg-block">
                    <i class="fas fa-store fa-5x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Store Info Bar -->
    <div class="bg-white shadow-sm border-bottom">
        <div class="container">
            <div class="py-3">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="far fa-clock text-primary me-2 fa-lg"></i>
                            <div>
                                <small class="text-muted d-block">Jam Buka</small>
                                <span class="fw-semibold">{{ $setting->jam_buka ?? '08:00' }} - {{ $setting->jam_tutup ?? '17:00' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-danger me-2 fa-lg"></i>
                            <div>
                                <small class="text-muted d-block">Lokasi</small>
                                <span class="fw-semibold">{{ $setting->alamat ?? 'Kota Anda' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-phone text-success me-2 fa-lg"></i>
                            <div>
                                <small class="text-muted d-block">Kontak</small>
                                <span class="fw-semibold">{{ $setting->telepon ?? '0822-1306-6810' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Filter -->
<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-2">Kategori Produk</h2>
        <p class="text-muted">Pilih kategori untuk melihat produk</p>
    </div>
    
    <div class="d-flex justify-content-center gap-2 mb-5 flex-wrap">
        <button class="btn btn-category active" data-category="all" onclick="filterCategory('all')">
            <i class="fas fa-th me-2"></i>Semua
        </button>
        <button class="btn btn-category" data-category="segar" onclick="filterCategory('segar')">
            <i class="fas fa-leaf me-2"></i>Kembang Tahu Segar
        </button>
        <button class="btn btn-category" data-category="kering" onclick="filterCategory('kering')">
            <i class="fas fa-box me-2"></i>Kembang Tahu Kering
        </button>
        <button class="btn btn-category" data-category="olahan" onclick="filterCategory('olahan')">
            <i class="fas fa-utensils me-2"></i>Olahan Kembang Tahu
        </button>
        <button class="btn btn-category" data-category="kulit" onclick="filterCategory('kulit')">
            <i class="fas fa-layer-group me-2"></i>Kulit Tahu
        </button>
    </div>

    <!-- Products Grid -->
    <div class="row g-4" id="productsContainer">
        @forelse($products as $product)
        <div class="col-md-6 col-lg-3 product-item" data-category="{{ $product->kategori }}">
            <div class="card product-card h-100 border-0 shadow-sm">
                <div class="position-relative overflow-hidden" style="height: 220px; background: #f8f9fa;">
                    @if($product->gambar)
                        <img src="{{ asset('storage/' . $product->gambar) }}" 
                             class="card-img-top h-100 w-100" 
                             style="object-fit: cover;" 
                             alt="{{ $product->nama_produk }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                    @if($product->stok <= 0)
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center">
                            <span class="badge bg-danger fs-6">Stok Habis</span>
                        </div>
                    @endif
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-primary">{{ ucfirst($product->kategori) }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-2">{{ $product->nama_produk }}</h5>
                    <p class="card-text text-muted small mb-3">{{ Str::limit($product->deskripsi, 80) }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="text-primary fw-bold fs-5">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            @if($product->stok > 0)
                                <span class="badge bg-success">Stok: {{ $product->stok }}</span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </div>
                    </div>
                    <form action="{{ route('pelanggan.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" 
                                class="btn btn-primary w-100" 
                                {{ $product->stok <= 0 ? 'disabled' : '' }}>
                            <i class="fas fa-cart-plus me-2"></i>
                            {{ $product->stok > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada produk tersedia</h5>
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
.btn-category {
    padding: 10px 25px;
    border-radius: 50px;
    border: 2px solid #dee2e6;
    background: white;
    color: #6c757d;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-category:hover, .btn-category.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.product-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}

.product-card .card-img-top {
    transition: transform 0.3s ease;
}

.product-card:hover .card-img-top {
    transform: scale(1.05);
}
</style>

<script>
function filterCategory(category) {
    // Update active button
    document.querySelectorAll('.btn-category').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-category="${category}"]`).classList.add('active');
    
    // Filter products
    const products = document.querySelectorAll('.product-item');
    products.forEach(product => {
        if (category === 'all' || product.dataset.category === category) {
            product.style.display = 'block';
            setTimeout(() => {
                product.style.opacity = '1';
                product.style.transform = 'scale(1)';
            }, 10);
        } else {
            product.style.opacity = '0';
            product.style.transform = 'scale(0.8)';
            setTimeout(() => {
                product.style.display = 'none';
            }, 300);
        }
    });
}
</script>
@endsection