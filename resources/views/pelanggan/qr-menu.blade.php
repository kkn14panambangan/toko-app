@extends('layouts.app')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden; max-width: 500px; width: 100%; background-color: #2F1E14;">
        <div class="card-header border-0 py-3 text-center" style="background-color: #2F1E14;">
            <a href="{{ route('pelanggan.shop') }}" class="btn btn-sm btn-outline-light position-absolute rounded-circle" style="left: 15px; top: 15px; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-color: #D4AF37; color: #D4AF37;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h5 class="mb-0 fw-bold" style="color: #D4AF37; font-family: 'Great Vibes', cursive; font-size: 2rem;">
                QR Menu
            </h5>
        </div>
        <div class="card-body p-0 text-center" style="background-color: #1A1614;">
            <!-- The actual QR Image -->
            <img src="{{ asset('qr-menu.png') }}" alt="QR Menu Kembang Tahu" class="img-fluid" style="width: 100%;">
            
            <div class="p-4" style="background-color: #2F1E14;">
                <a href="{{ asset('qr-menu.png') }}" download="QR_Menu_Kembang_Tahu.png" class="btn w-100 rounded-pill fw-bold py-3 mb-2" style="background-color: #D4AF37; color: #1A1614; font-size: 1.1rem; box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);">
                    <i class="fas fa-download me-2"></i> Simpan Gambar
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap');
body {
    background-color: #f8f9fa;
}
.btn:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
}
</style>
@endsection
