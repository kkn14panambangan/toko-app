@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="fas fa-cog me-2 text-primary"></i>Pengaturan Toko
        </h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Card Pengaturan -->
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-store me-2 text-primary"></i>Konfigurasi Toko
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        
                        <!-- Status Toko -->
                        <!-- Status Toko -->
<!-- Status Toko -->
<div class="mb-4">
    <label class="form-label fw-semibold">
        <i class="fas fa-toggle-on me-2 text-primary"></i>Status Toko
    </label>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="status-card p-3 border rounded h-100" style="cursor: pointer; transition: all 0.3s; min-height: 120px;" 
                 onclick="toggleStatus('open')">
                <input class="form-check-input d-none" type="radio" name="status_toko" id="status_open" value="open" {{ old('status_toko', $setting->status_toko ?? 'open') == 'open' ? 'checked' : '' }}>
                <div class="d-flex align-items-center h-100">
                    <div class="status-icon me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background-color: #d4edda;">
                        <i class="fas fa-check-circle text-success fs-3"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Buka</h6>
                        <small class="text-muted d-block">Toko buka, pelanggan bisa belanja</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="status-card p-3 border rounded h-100" style="cursor: pointer; transition: all 0.3s; min-height: 120px;"
                 onclick="toggleStatus('close')">
                <input class="form-check-input d-none" type="radio" name="status_toko" id="status_close" value="close" {{ old('status_toko', $setting->status_toko ?? 'close') == 'close' ? 'checked' : '' }}>
                <div class="d-flex align-items-center h-100">
                    <div class="status-icon me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background-color: #f8d7da;">
                        <i class="fas fa-times-circle text-danger fs-3"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Tutup</h6>
                        <small class="text-muted d-block">Toko tutup, pelanggan tidak bisa checkout</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                        <!-- Jam Operasional -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-clock me-2 text-primary"></i>Jam Operasional
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Jam Buka</label>
                                        <input type="time" class="form-control form-control-lg" name="jam_buka" 
                                               value="{{ old('jam_buka', $setting->jam_buka ?? '08:00') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Jam Tutup</label>
                                        <input type="time" class="form-control form-control-lg" name="jam_tutup" 
                                               value="{{ old('jam_tutup', $setting->jam_tutup ?? '17:00') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Toko -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Informasi Toko
                            </label>
                            <div class="mb-3">
                                <label class="form-label small">Nama Toko</label>
                                <input type="text" class="form-control" name="nama_toko" 
                                       value="{{ old('nama_toko', $setting->nama_toko ?? '') }}" placeholder="Contoh: Kembang Tahu 66">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3" 
                                          placeholder="Deskripsi singkat tentang toko Anda">{{ old('deskripsi', $setting->deskripsi ?? '') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Alamat</label>
                                <input type="text" class="form-control" name="alamat" 
                                       value="{{ old('alamat', $setting->alamat ?? '') }}" placeholder="Alamat lengkap toko">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Nomor Telepon/WA</label>
                                <input type="text" class="form-control" name="telepon" 
                                       value="{{ old('telepon', $setting->telepon ?? '') }}" placeholder="08xx-xxxx-xxxx">
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="alert alert-info mt-4 mb-0" style="border-radius: 10px;">
                <i class="fas fa-lightbulb me-2"></i>
                <strong>Tips:</strong> Jika toko sedang tutup, pelanggan masih bisa melihat produk tetapi tidak bisa melakukan checkout.
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Singkat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Produk:</span>
                        <strong>{{ \App\Models\Product::count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Transaksi Hari Ini:</span>
                        <strong>{{ \App\Models\Transaction::whereDate('created_at', today())->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Pelanggan Aktif:</span>
                        <strong>{{ \App\Models\User::where('role', 'pelanggan')->count() }}</strong>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-success text-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-shield-alt me-2"></i>Keamanan
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-2 small">Pastikan Anda logout setelah selesai menggunakan dashboard admin.</p>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-select radio button saat klik card
document.querySelectorAll('.form-check').forEach(card => {
    card.addEventListener('click', function() {
        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;
        
        // Reset semua card
        document.querySelectorAll('.form-check').forEach(c => {
            c.classList.remove('border-primary', 'border-danger');
            c.style.backgroundColor = '';
        });
        
        // Highlight card yang dipilih
        if (radio.value === 'open') {
            this.classList.add('border-primary');
            this.style.backgroundColor = '#f8f9fa';
        } else {
            this.classList.add('border-danger');
            this.style.backgroundColor = '#fff5f5';
        }
    });
});
</script>
@endsection   