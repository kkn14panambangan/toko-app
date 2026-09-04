@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard Admin
        </h1>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </button>
        </form>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex p-3 mb-3">
                        <i class="fas fa-boxes fa-2x text-primary"></i>
                    </div>
                    <h5 class="card-title">Kelola Barang</h5>
                    <p class="text-muted">Tambah, edit, dan hapus produk toko</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-2"></i>Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex p-3 mb-3">
                        <i class="fas fa-shopping-bag fa-2x text-success"></i>
                    </div>
                    <h5 class="card-title">Transaksi Masuk</h5>
                    <p class="text-muted">Lihat dan kelola transaksi pembayaran</p>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-success">
                        <i class="fas fa-arrow-right me-2"></i>Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex p-3 mb-3">
                        <i class="fas fa-cog fa-2x text-warning"></i>
                    </div>
                    <h5 class="card-title">Pengaturan Toko</h5>
                    <p class="text-muted">Atur status & jam operasional</p>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-warning">
                        <i class="fas fa-arrow-right me-2"></i>Buka
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection