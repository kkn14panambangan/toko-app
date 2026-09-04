@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <!-- Header -->
            <div class="text-center mb-4">
                <h1 class="fw-bold mb-2">
                    <i class="fas fa-store me-2 text-primary"></i>Masuk ke Toko
                </h1>
                <p class="text-muted">Masukkan data Anda untuk mulai berbelanja</p>
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

            <!-- Tabs Masuk/Daftar -->
            <ul class="nav nav-pills mb-4 justify-content-center" id="authTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="login-tab" data-bs-toggle="pill" data-bs-target="#login" type="button">
                        <i class="fas fa-sign-in-alt me-1"></i>Masuk
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="register-tab" data-bs-toggle="pill" data-bs-target="#register" type="button">
                        <i class="fas fa-user-plus me-1"></i>Daftar
                    </button>
                </li>
            </ul>

            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="tab-content" id="authTabContent">
                        
                        <!-- Form Masuk (Login) -->
                        <div class="tab-pane fade show active" id="login" role="tabpanel">
                            <form action="{{ route('admin.login.post') }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="login">
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-envelope me-1 text-primary"></i>Email
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" required placeholder="Masukkan email Anda">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-phone me-1 text-primary"></i>Nomor Telepon
                                    </label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           name="phone" required placeholder="08xx-xxxx-xxxx">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                </button>
                            </form>
                        </div>

                        <!-- Form Daftar (Register) -->
                        <div class="tab-pane fade" id="register" role="tabpanel">
                            <form action="{{ route('admin.login.post') }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="register">
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-user me-1 text-primary"></i>Nama Lengkap
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" required placeholder="Masukkan nama lengkap">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-envelope me-1 text-primary"></i>Email
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" required placeholder="Masukkan email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-phone me-1 text-primary"></i>Nomor Telepon
                                    </label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           name="phone" required placeholder="08xx-xxxx-xxxx">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection