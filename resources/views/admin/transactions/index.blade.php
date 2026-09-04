@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%); min-height: 100vh;">
    
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="color: #2c3e50;">
                <i class="fas fa-receipt me-2" style="color: #f39c12;"></i>Manajemen Transaksi
            </h1>
            <p class="text-muted mb-0">Kelola semua transaksi toko Anda</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-white-50 mb-2 small text-uppercase fw-semibold">Total Transaksi</p>
                            <h2 class="text-white fw-bold mb-0">{{ $totalTransactions ?? 0 }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-shopping-cart fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-white-50 mb-2 small text-uppercase fw-semibold">Menunggu Konfirmasi</p>
                            <h2 class="text-white fw-bold mb-0">{{ $pendingTransactions ?? 0 }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-clock fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-white-50 mb-2 small text-uppercase fw-semibold">Total Pendapatan</p>
                            <h2 class="text-white fw-bold mb-0">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-wallet fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-list me-2 text-primary"></i>Daftar Transaksi
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th class="fw-semibold text-dark py-3">Kode Transaksi</th>
                            <th class="fw-semibold text-dark py-3">Tanggal</th>
                            <th class="fw-semibold text-dark py-3">Pembayaran</th>
                            <th class="fw-semibold text-dark py-3">Total</th>
                            <th class="fw-semibold text-dark py-3">Status</th>
                            <th class="fw-semibold text-dark py-3 text-center" style="min-width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>
                                <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="fw-bold text-primary text-decoration-none">
                                    {{ $transaction->kode_transaksi }}
                                </a>
                            </td>
                            <td>
                                <div>
                                    <small class="text-muted d-block">{{ $transaction->created_at->format('d/m/Y') }}</small>
                                    <small class="text-muted">{{ $transaction->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <i class="fas fa-{{ str_contains(strtolower($transaction->metode_pembayaran ?? ''), 'qris') ? 'qrcode' : 'money-bill-wave' }} me-1"></i>
                                    {{ ucfirst($transaction->metode_pembayaran ?? '-') }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold" style="color: #2c3e50;">
                                    Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                @if($transaction->status == 'success')
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>Diterima
                                    </span>
                                @elseif($transaction->status == 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        <i class="fas fa-clock me-1"></i>Menunggu
                                    </span>
                                @elseif($transaction->status == 'cancelled')
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i>Ditolak
                                    </span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <!-- Tombol Detail -->
                                    <a href="{{ route('admin.transactions.show', $transaction->id) }}" 
                                       class="btn btn-sm btn-outline-primary me-1"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($transaction->status == 'pending')
                                        <!-- Tombol Terima -->
                                        <form action="{{ route('admin.transactions.accept', $transaction->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-success me-1"
                                                    title="Terima Transaksi"
                                                    onclick="return confirm('Yakin ingin menerima transaksi ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        <!-- Tombol Tolak -->
                                        <form action="{{ route('admin.transactions.reject', $transaction->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-warning me-1"
                                                    title="Tolak Transaksi"
                                                    onclick="return confirm('Yakin ingin menolak transaksi ini? Stok akan dikembalikan.')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger"
                                                title="Hapus Transaksi"
                                                onclick="return confirm('️ PERINGATAN!\n\nYakin ingin menghapus transaksi ini?\nTindakan ini tidak dapat dibatalkan.\n\nKode: {{ $transaction->kode_transaksi }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada transaksi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if(isset($transactions) && $transactions instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4 d-flex justify-content-center">
            {{ $transactions->links() }}
        </div>
    @endif
</div>

<style>
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.badge {
    font-weight: 600;
    font-size: 0.85rem;
}

.table tbody tr {
    transition: background-color 0.2s ease;
}

.table tbody tr:hover {
    background-color: #f8f9fa !important;
}

.btn-group .btn {
    border-radius: 8px !important;
}
</style>
@endsection