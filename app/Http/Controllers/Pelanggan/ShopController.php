<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * Tampilkan halaman toko/shop
     */
    public function index()
    {
        $setting = Setting::first();
        $products = Product::where('stok', '>', 0)->latest()->get();
        
        return view('pelanggan.shop', compact('products', 'setting'));
    }

    /**
     * Tampilkan detail produk
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $setting = Setting::first();
        
        return view('pelanggan.product-detail', compact('product', 'setting'));
    }

    /**
     * Tambah produk ke keranjang
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        if ($product->stok < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $request->quantity;
        } else {
            $cart[$request->product_id] = [
                "nama" => $product->nama_produk,
                "harga" => $product->harga,
                "quantity" => $request->quantity,
                "gambar" => $product->gambar
            ];
        }

        session()->put('cart', $cart);
        
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Tampilkan halaman keranjang
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('pelanggan.cart', compact('cart'));
    }

    /**
     * Update quantity produk di keranjang
     */
    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $product = Product::find($id);
            
            if ($product && $product->stok >= $request->quantity && $request->quantity > 0) {
                $cart[$id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
        }
        
        return back()->with('success', 'Keranjang berhasil diupdate!');
    }

    /**
     * Hapus produk dari keranjang
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return back()->with('success', 'Produk dihapus dari keranjang!');
    }

    /**
     * Proses checkout
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:Tunai,Qris,tunai,qris',
            'total' => 'required|numeric|min:0'
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return back()->with('error', 'Keranjang belanja kosong!');
        }

        DB::beginTransaction();
        
        try {
            $transaction = Transaction::create([
                'kode_transaksi' => 'TRX-' . date('Ymd') . '-' . str_pad(Transaction::count() + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => auth()->id() ?? null,
                'total' => $request->total,
                'metode_pembayaran' => strtolower($request->metode_pembayaran),
                'tanggal_transaksi' => now(),
                'status' => 'pending',
            ]);

            foreach ($cart as $productId => $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $productId,
                    'jumlah' => $item['quantity'],
                    'harga' => $item['harga']
                ]);

                $product = Product::find($productId);
                if ($product) {
                    $product->decrement('stok', $item['quantity']);
                }
            }

            session()->forget('cart');
            DB::commit();

            if (strtolower($request->metode_pembayaran) === 'qris') {
                return redirect()->route('pelanggan.checkout.qris', $transaction->id);
            }

            return redirect()->route('pelanggan.checkout.success', $transaction->id)
                           ->with('success', 'Transaksi berhasil!');
                       
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Halaman QRIS
     */
    public function checkoutQris($id)
    {
        $transaction = Transaction::with(['items.product'])->findOrFail($id);
        
        if ($transaction->status != 'pending' || strtolower($transaction->metode_pembayaran) != 'qris') {
            return redirect()->route('pelanggan.checkout.success', $id);
        }
        
        return view('pelanggan.checkout-qris', compact('transaction'));
    }

    /**
     * Halaman sukses checkout
     */
    public function checkoutSuccess($id)
    {
        $transaction = Transaction::with(['items.product'])->findOrFail($id);
        return view('pelanggan.checkout-success', compact('transaction'));
    }

    /**
     * Riwayat transaksi user
     */
    public function history()
    {
        $transactions = Transaction::where('user_id', auth()->id() ?? 0)
            ->with(['items.product'])
            ->latest()
            ->paginate(10);
            
        return view('pelanggan.history', compact('transactions'));
    }

    // ==========================================
    // METHOD BARU: PROFIL PENGGUNA
    // ==========================================

    /**
     * Tampilkan halaman profil
     */
    public function profile()
    {
        return view('pelanggan.profile');
    }

    /**
     * Update profil pelanggan
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);
        
        $user->update($validated);
        
        return back()->with('success', '✅ Profil berhasil diperbarui!');
    }

    // ==========================================
    // AJAX CART METHODS
    // ==========================================

    public function ajaxAddToCart(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $product = Product::findOrFail($request->product_id);

        if ($product->stok <= 0) {
            return response()->json(['success' => false, 'message' => 'Stok habis']);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += 1;
        } else {
            $cart[$request->product_id] = [
                'nama'     => $product->nama_produk,
                'harga'    => $product->harga,
                'quantity' => 1,
                'gambar'   => $product->gambar,
            ];
        }

        session()->put('cart', $cart);
        $cartTotal = collect($cart)->sum(fn($i) => $i['harga'] * $i['quantity']);
        $cartCount = collect($cart)->sum('quantity');

        return response()->json([
            'success'   => true,
            'quantity'  => $cart[$request->product_id]['quantity'],
            'cartCount' => $cartCount,
            'cartTotal' => number_format($cartTotal, 0, ',', '.'),
        ]);
    }

    public function ajaxUpdateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (!isset($cart[$id])) {
            return response()->json(['success' => false]);
        }

        $qty = (int) $request->quantity;
        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['quantity'] = $qty;
        }

        session()->put('cart', $cart);
        $cartTotal = collect($cart)->sum(fn($i) => $i['harga'] * $i['quantity']);
        $cartCount = collect($cart)->sum('quantity');

        return response()->json([
            'success'   => true,
            'quantity'  => $qty,
            'cartCount' => $cartCount,
            'cartTotal' => number_format($cartTotal, 0, ',', '.'),
        ]);
    }

    public function ajaxCartStatus()
    {
        $cart = session()->get('cart', []);
        $cartTotal = collect($cart)->sum(fn($i) => $i['harga'] * $i['quantity']);
        $cartCount = collect($cart)->sum('quantity');
        return response()->json([
            'cartCount' => $cartCount,
            'cartTotal' => number_format($cartTotal, 0, ',', '.'),
        ]);
    }
}