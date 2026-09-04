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

    /* Grab Qty Control */
    .cart-ctrl-wrapper {
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2;
    }
    .grab-qty-ctrl {
        display: flex;
        align-items: center;
        gap: 4px;
        background: white;
        border: 1.5px solid #00B14F;
        border-radius: 20px;
        padding: 3px 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        white-space: nowrap;
    }
    .grab-qty-btn {
        background: none;
        border: none;
        color: #00880F;
        font-weight: 800;
        font-size: 1rem;
        line-height: 1;
        padding: 0 2px;
        cursor: pointer;
    }
    .grab-qty-num {
        font-weight: 700;
        color: #111827;
        font-size: 0.85rem;
        min-width: 16px;
        text-align: center;
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
    @php
        $groupedProducts = collect($products)->groupBy(function($product) {
            return $product->kategori ? ucfirst($product->kategori) : 'Kembang Tahu';
        });
    @endphp

    @forelse($groupedProducts as $category => $items)
        <h2 class="menu-section-title" id="cat-{{ Str::slug($category) }}">{{ strtoupper($category) }}</h2>
        <div class="grab-list-container pb-4">
            @foreach($items as $product)
            <div class="grab-item">
                <!-- Left: Text -->
                <div class="grab-item-content" onclick="openProductDetail('{{ $product->id }}', '{{ htmlspecialchars($product->nama_produk, ENT_QUOTES) }}', '{{ htmlspecialchars($product->deskripsi, ENT_QUOTES) }}', '{{ number_format($product->harga, 0, ',', '.') }}', '{{ $product->gambar ? Storage::url($product->gambar) : '' }}')" style="cursor: pointer;">
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
                        <img src="{{ Storage::url($product->gambar) }}" class="grab-item-img" alt="{{ $product->nama_produk }}" onclick="openProductDetail('{{ $product->id }}', '{{ htmlspecialchars($product->nama_produk, ENT_QUOTES) }}', '{{ htmlspecialchars($product->deskripsi, ENT_QUOTES) }}', '{{ number_format($product->harga, 0, ',', '.') }}', '{{ Storage::url($product->gambar) }}')" style="cursor: pointer;">
                    @else
                        <div class="grab-item-img d-flex align-items-center justify-content-center text-muted border" onclick="openProductDetail('{{ $product->id }}', '{{ htmlspecialchars($product->nama_produk, ENT_QUOTES) }}', '{{ htmlspecialchars($product->deskripsi, ENT_QUOTES) }}', '{{ number_format($product->harga, 0, ',', '.') }}', '')" style="cursor: pointer;">
                            <i class="fas fa-image fa-2x"></i>
                        </div>
                    @endif

                    @php $inCart = isset($sessionCart[$product->id]) ? $sessionCart[$product->id]['quantity'] : 0; @endphp

                    <!-- Cart Control -->
                    <div id="ctrl-{{ $product->id }}" class="cart-ctrl-wrapper">
                        @if($product->stok <= 0)
                            <button class="grab-btn-add" disabled>Habis</button>
                        @elseif($inCart > 0)
                            <div class="grab-qty-ctrl">
                                <button class="grab-qty-btn" onclick="updateQty('{{ $product->id }}', {{ $inCart - 1 }}, this)">−</button>
                                <span class="grab-qty-num" id="qty-{{ $product->id }}">{{ $inCart }}</span>
                                <button class="grab-qty-btn" onclick="updateQty('{{ $product->id }}', {{ $inCart + 1 }}, this)">+</button>
                            </div>
                        @else
                            <button class="grab-btn-add" onclick="addToCart('{{ $product->id }}', this)">Tambah</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @empty
        <div class="text-center py-5">
            <i class="fas fa-store-slash fa-3x text-muted mb-3 opacity-50"></i>
            <p class="text-muted fw-bold">Belum ada menu tersedia</p>
        </div>
    @endforelse
</div>

<!-- Floating Menu Button -->
<button class="floating-menu-btn border-0" data-bs-toggle="modal" data-bs-target="#categoryModal">
    <i class="fas fa-concierge-bell"></i> Menu
</button>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="margin: 20px;">
        <div class="modal-content border-0" style="background: transparent;">
            <div class="bg-white" style="border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); overflow: hidden;">
                <ul class="list-group list-group-flush">
                    @foreach($groupedProducts as $category => $items)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4" style="font-weight: 700; cursor: pointer; color: #111827; border-bottom: 1px solid #F3F4F6;" onclick="document.getElementById('cat-{{ Str::slug($category) }}').scrollIntoView({behavior: 'smooth', block: 'start'}); bootstrap.Modal.getInstance(document.getElementById('categoryModal')).hide();">
                            {{ strtoupper($category) }}
                            <span class="text-muted" style="font-size: 0.9rem; font-weight: 400;">{{ count($items) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Floating Close Button -->
            <div class="text-center mt-4">
                <button class="btn btn-danger rounded-pill px-4 fw-bold shadow" data-bs-dismiss="modal" style="background-color: #E02020; border: none; font-size: 0.95rem;">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Product Detail Offcanvas -->
<div class="offcanvas offcanvas-bottom d-flex flex-column" tabindex="-1" id="productDetailModal" style="height: auto; max-height: 90vh; border-top-left-radius: 20px; border-top-right-radius: 20px;">
    <!-- Pull Indicator & Close -->
    <div class="text-center pt-2 pb-1 position-relative bg-white" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
        <div style="width: 40px; height: 4px; background: #E5E7EB; border-radius: 2px; margin: 0 auto;"></div>
    </div>
    
    <div class="offcanvas-body p-0 flex-grow-1" style="overflow-y: auto;">
        <img id="detail-img" src="" class="w-100 d-none" style="height: 300px; object-fit: cover; background: #FFFFFF;">
        <div id="detail-img-placeholder" class="w-100 align-items-center justify-content-center text-muted d-none" style="height: 300px; background: #F3F4F6;">
            <i class="fas fa-image fa-4x opacity-25"></i>
        </div>
        
        <div class="p-4 bg-white">
            <h2 id="detail-title" class="fw-bold mb-1" style="font-size: 1.4rem;"></h2>
            <p id="detail-desc" class="text-muted mb-3" style="font-size: 0.9rem; line-height: 1.4;"></p>
            <h4 id="detail-price" class="fw-bold mb-4" style="font-size: 1.1rem;"></h4>
            
            <div class="d-flex justify-content-between gap-2 mb-2">
                <button class="btn btn-outline-secondary rounded-pill btn-sm flex-fill fw-bold d-flex align-items-center justify-content-center border" style="font-size: 0.8rem; color: #4B5563;"><i class="far fa-heart me-2 fs-6"></i> Simpan</button>
                <button class="btn btn-outline-secondary rounded-pill btn-sm flex-fill fw-bold d-flex align-items-center justify-content-center border" style="font-size: 0.8rem; color: #4B5563;"><i class="fas fa-exclamation-circle me-2 fs-6"></i> Lapor</button>
                <button class="btn btn-outline-secondary rounded-pill btn-sm flex-fill fw-bold d-flex align-items-center justify-content-center border" style="font-size: 0.8rem; color: #4B5563;"><i class="fas fa-share-alt me-2 fs-6"></i> Bagikan</button>
            </div>
        </div>
    </div>
    
    <!-- Footer Fixed Add Button -->
    <div class="p-3 border-top bg-white">
        <form action="{{ route('pelanggan.cart.add') }}" method="POST" id="detail-form" class="m-0">
            @csrf
            <input type="hidden" name="product_id" id="detail-id" value="">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-2" style="background-color: #00880F; border-color: #00880F; font-size: 1.05rem;">
                Tambah pembelian
            </button>
        </form>
    </div>
</div>


@php
    $sessionCart = session()->get('cart', []);
    $cartTotal = collect($sessionCart)->sum(fn($item) => $item['harga'] * $item['quantity']);
    $cartCount = collect($sessionCart)->sum('quantity');
@endphp

<a href="{{ route('pelanggan.cart') }}" class="text-decoration-none" id="cart-bar" style="display: {{ $cartCount > 0 ? 'block' : 'none' }};">
    <div style="position: fixed; bottom: 0; left: 0; right: 0; background: #00880F; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; z-index: 1040; box-shadow: 0 -4px 12px rgba(0,0,0,0.15);">
        <div class="d-flex align-items-center gap-3">
            <div id="cart-count-badge" style="background: rgba(255,255,255,0.2); border-radius: 8px; padding: 4px 10px; font-weight: 700; color: white; font-size: 0.9rem;">
                {{ $cartCount }} item
            </div>
            <span style="color: rgba(255,255,255,0.85); font-size: 0.8rem;">Lihat keranjang</span>
        </div>
        <div style="color: white; font-weight: 700; font-size: 1rem; display: flex; align-items: center; gap: 8px;">
            <span id="cart-total-label">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
            <i class="fas fa-shopping-basket" style="background: white; color: #00880F; padding: 6px 8px; border-radius: 8px; font-size: 0.9rem;"></i>
        </div>
    </div>
</a>

<script>
const CSRF = document.querySelector('meta[name=csrf-token]')?.content || '{{ csrf_token() }}';
const ADD_URL = '{{ route("pelanggan.api.cart.add") }}';
const UPDATE_BASE = '{{ url("pelanggan/api/cart/update") }}';

function updateCartBar(count, total) {
    const bar = document.getElementById('cart-bar');
    if (count > 0) {
        bar.style.display = 'block';
        document.getElementById('cart-count-badge').innerText = count + ' item';
        document.getElementById('cart-total-label').innerText = 'Rp ' + total;
    } else {
        bar.style.display = 'none';
    }
}

function addToCart(productId, btn) {
    btn.disabled = true;
    btn.innerText = '...';
    fetch(ADD_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ product_id: productId })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Render qty control
            const ctrl = document.getElementById('ctrl-' + productId);
            ctrl.innerHTML = `
                <div class="grab-qty-ctrl">
                    <button class="grab-qty-btn" onclick="updateQty('${productId}', ${data.quantity - 1}, this)">−</button>
                    <span class="grab-qty-num" id="qty-${productId}">${data.quantity}</span>
                    <button class="grab-qty-btn" onclick="updateQty('${productId}', ${data.quantity + 1}, this)">+</button>
                </div>`;
            updateCartBar(data.cartCount, data.cartTotal);
        }
    })
    .catch(() => { btn.disabled = false; btn.innerText = 'Tambah'; });
}

function updateQty(productId, newQty, btn) {
    btn.disabled = true;
    fetch(UPDATE_BASE + '/' + productId, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ quantity: newQty })
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        const ctrl = document.getElementById('ctrl-' + productId);
        if (newQty <= 0) {
            ctrl.innerHTML = `<button class="grab-btn-add" onclick="addToCart('${productId}', this)">Tambah</button>`;
        } else {
            document.getElementById('qty-' + productId).innerText = newQty;
            // Update the onclick values
            const btns = ctrl.querySelectorAll('.grab-qty-btn');
            btns[0].setAttribute('onclick', `updateQty('${productId}', ${newQty - 1}, this)`);
            btns[1].setAttribute('onclick', `updateQty('${productId}', ${newQty + 1}, this)`);
        }
        updateCartBar(data.cartCount, data.cartTotal);
    })
    .catch(() => { btn.disabled = false; });
}

// Open Product Detail Modal
function openProductDetail(id, title, desc, price, img) {
    document.getElementById('detail-id').value = id;
    document.getElementById('detail-title').innerText = title;
    document.getElementById('detail-desc').innerText = desc;
    document.getElementById('detail-price').innerText = price;
    
    if (img) {
        document.getElementById('detail-img').src = img;
        document.getElementById('detail-img').classList.remove('d-none');
        document.getElementById('detail-img-placeholder').classList.add('d-none');
        document.getElementById('detail-img-placeholder').classList.remove('d-flex');
    } else {
        document.getElementById('detail-img').classList.add('d-none');
        document.getElementById('detail-img-placeholder').classList.remove('d-none');
        document.getElementById('detail-img-placeholder').classList.add('d-flex');
    }
    
    var modal = new bootstrap.Offcanvas(document.getElementById('productDetailModal'));
    modal.show();
}

// Mock interaction for Delivery/Pickup toggle
document.querySelectorAll('.grab-toggle-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.grab-toggle-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>
@endsection