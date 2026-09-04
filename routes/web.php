<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Pelanggan\ShopController;

// ==========================================
// FALLBACK LOGIN (Agar middleware auth tidak error)
// ==========================================
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// ==========================================
// HALAMAN UTAMA
// ==========================================
Route::get('/', [ShopController::class, 'index'])->name('home');

// ==========================================
// ROUTE PELANGGAN
// ==========================================
Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/products/{id}', [ShopController::class, 'show'])->name('products.show');
    Route::post('/cart/add', [ShopController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
    Route::post('/cart/update/{id}', [ShopController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{id}', [ShopController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout', [ShopController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/{id}/qris', [ShopController::class, 'checkoutQris'])->name('checkout.qris');
    Route::get('/checkout/success/{id}', [ShopController::class, 'checkoutSuccess'])->name('checkout.success');
    Route::get('/history', [ShopController::class, 'history'])->name('history');
    Route::get('/profile', [ShopController::class, 'profile'])->name('profile');
    Route::put('/profile', [ShopController::class, 'updateProfile'])->name('profile.update');

    // AJAX Cart API
    Route::post('/api/cart/add', [ShopController::class, 'ajaxAddToCart'])->name('api.cart.add');
    Route::post('/api/cart/update/{id}', [ShopController::class, 'ajaxUpdateCart'])->name('api.cart.update');
    Route::get('/api/cart/status', [ShopController::class, 'ajaxCartStatus'])->name('api.cart.status');
});

// ==========================================
// LOGIN ADMIN (PUBLIK - TANPA PROTEKSI)
// ==========================================
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

// ==========================================
// ROUTE ADMIN (DIPROTEKSI MIDDLEWARE 'auth')
// ==========================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{id}/accept', [TransactionController::class, 'accept'])->name('transactions.accept');
    Route::patch('/transactions/{id}/reject', [TransactionController::class, 'reject'])->name('transactions.reject');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    
    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});
Route::get('/setup-db-2026', function() {
    \Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
    return "Database has been refreshed and seeded successfully.";
});


