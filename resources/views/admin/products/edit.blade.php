@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Produk</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Produk</label>
                            <input type="text" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" 
                                   name="nama" 
                                   value="{{ old('nama', $product->nama) }}" 
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="3"
                                      required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" 
                                       class="form-control @error('harga') is-invalid @enderror" 
                                       id="harga" 
                                       name="harga" 
                                       value="{{ old('harga', $product->harga) }}" 
                                       required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="number" 
                                       class="form-control @error('stok') is-invalid @enderror" 
                                       id="stok" 
                                       name="stok" 
                                       value="{{ old('stok', $product->stok) }}" 
                                       required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Preview Gambar Lama -->
                        @if($product->gambar)
                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div>
                                <img src="{{ Storage::url($product->gambar) }}" 
                                     alt="{{ $product->nama }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px; max-height: 200px;">
                            </div>
                        </div>
                        @endif

                        <!-- Upload Gambar Baru -->
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Upload Gambar Baru (opsional)</label>
                            <input type="file" 
                                   class="form-control @error('gambar') is-invalid @enderror" 
                                   id="gambar" 
                                   name="gambar" 
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Preview Gambar Baru -->
                            <div id="imagePreview" class="mt-2"></div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Batal
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
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" 
                     alt="Preview" 
                     class="img-thumbnail" 
                     style="max-width: 200px; max-height: 200px;">
            `;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection