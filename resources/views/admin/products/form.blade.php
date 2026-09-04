@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-{{ isset($product) ? 'edit' : 'plus' }} me-2"></i>
                        {{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        @if(isset($product))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="nama_produk" class="form-label fw-bold">Nama Produk</label>
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" 
                                   id="nama_produk" name="nama_produk" 
                                   value="{{ old('nama_produk', $product->nama_produk ?? '') }}" required>
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label fw-bold">Kategori</label>
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="segar" {{ (old('kategori', $product->kategori ?? '') == 'segar') ? 'selected' : '' }}>Segar</option>
                                <option value="kering" {{ (old('kategori', $product->kategori ?? '') == 'kering') ? 'selected' : '' }}>Kering</option>
                                <option value="olahan" {{ (old('kategori', $product->kategori ?? '') == 'olahan') ? 'selected' : '' }}>Olahan</option>
                                <option value="kulit" {{ (old('kategori', $product->kategori ?? '') == 'kulit') ? 'selected' : '' }}>Kulit</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label fw-bold">Harga (Rp)</label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                       id="harga" name="harga" 
                                       value="{{ old('harga', $product->harga ?? '') }}" required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label fw-bold">Stok</label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                       id="stok" name="stok" 
                                       value="{{ old('stok', $product->stok ?? '') }}" required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- BAGIAN FOTO PRODUK -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <label class="form-label fw-bold">
                                <i class="fas fa-image me-1"></i>Foto Produk
                            </label>
                            
                            <!-- Preview Gambar Lama dari Database -->
                            @if(isset($product) && $product->gambar)
                                <div class="mb-3">
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        Foto saat ini:
                                    </p>
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset('storage/' . $product->gambar) }}" 
                                             alt="Foto Produk" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px; max-height: 200px; object-fit: cover;"
                                             onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}'; this.alt='Gambar tidak tersedia';">
                                        <span class="position-absolute top-0 end-0 badge bg-success">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    </div>
                                    <p class="text-muted small mt-2 mb-0">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Path: <code>storage/{{ $product->gambar }}</code>
                                    </p>
                                </div>
                            @else
                                <div class="mb-3">
                                    <div class="alert alert-warning py-2">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        <small>Belum ada foto produk. Silakan upload foto di bawah ini.</small>
                                    </div>
                                </div>
                            @endif

                            <!-- Upload Gambar Baru -->
                            <label for="gambar" class="form-label fw-semibold">
                                {{ isset($product) && $product->gambar ? 'Ganti Foto (opsional)' : 'Upload Foto (wajib)' }}
                            </label>
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                                   id="gambar" name="gambar" accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Format: JPG, PNG, GIF, WEBP (Maks. 2MB). 
                                {{ isset($product) && $product->gambar ? 'Kosongkan jika tidak ingin mengubah foto.' : '' }}
                            </small>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Preview Gambar Baru yang Dipilih -->
                            <div id="imagePreview" class="mt-3"></div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = ''; // Bersihkan preview sebelumnya
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validasi ukuran file (maks 2MB)
        if (file.size > 2 * 1024 * 1024) {
            preview.innerHTML = `
                <div class="alert alert-danger py-2">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <small>Ukuran file terlalu besar! Maksimal 2MB.</small>
                </div>
            `;
            input.value = ''; // Reset input
            return;
        }
        
        // Validasi tipe file
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            preview.innerHTML = `
                <div class="alert alert-danger py-2">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <small>Format file tidak valid! Gunakan JPG, PNG, GIF, atau WEBP.</small>
                </div>
            `;
            input.value = ''; // Reset input
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="mt-2">
                    <p class="text-muted small mb-2">
                        <i class="fas fa-eye text-primary me-1"></i>
                        Preview foto baru:
                    </p>
                    <div class="position-relative d-inline-block">
                        <img src="${e.target.result}" 
                             class="img-thumbnail" 
                             style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        <span class="position-absolute top-0 end-0 badge bg-primary">
                            <i class="fas fa-star"></i> Baru
                        </span>
                    </div>
                    <p class="text-muted small mt-2 mb-0">
                        <i class="fas fa-file-image me-1"></i>
                        ${file.name} (${(file.size / 1024).toFixed(2)} KB)
                    </p>
                </div>
            `;
        }
        reader.readAsDataURL(file);
    }
}
</script>

<style>
.img-thumbnail {
    border: 2px solid #dee2e6;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.badge {
    font-size: 0.75rem;
}

code {
    background: #f8f9fa;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.85rem;
    color: #d63384;
}
</style>
@endsection