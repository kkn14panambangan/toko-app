@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-boxes me-2 text-primary"></i>Daftar Barang
            </h2>
            <p class="text-muted mb-0">Kelola produk toko Anda</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-lg shadow-sm">
            <i class="fas fa-plus-circle me-2"></i>Tambah Barang
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($product->gambar)
                                        <img src="{{ Storage::url($product->gambar) }}" 
                                             alt="{{ $product->nama_produk }}" 
                                             class="img-thumbnail me-2" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $product->nama_produk }}</strong>
                                        <br>
                                        <small class="text-muted">ID: #{{ $product->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">{{ ucfirst($product->kategori) }}</span>
                            </td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>
                                @if($product->stok > 10)
                                    <span class="badge bg-success">{{ $product->stok }}</span>
                                @elseif($product->stok > 0)
                                    <span class="badge bg-warning text-dark">{{ $product->stok }}</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada produk</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($products->hasPages())
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection