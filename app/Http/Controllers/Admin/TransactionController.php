<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Tampilkan daftar semua transaksi
     */
    public function index()
    {
        $transactions = Transaction::with(['items.product', 'user'])
            ->latest()
            ->paginate(15);
        
        $totalTransactions = Transaction::count();
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $totalRevenue = Transaction::where('status', 'success')->sum('total');
        
        return view('admin.transactions.index', compact(
            'transactions',
            'totalTransactions',
            'pendingTransactions',
            'totalRevenue'
        ));
    }

    /**
     * Tampilkan detail satu transaksi
     */
    public function show($id)
    {
        $transaction = Transaction::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Terima / Approve transaksi
     */
    public function accept(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Karena hanya QRIS, langsung ubah status jadi success
        $transaction->update(['status' => 'success']);
        
        return redirect()->route('admin.transactions.index')
            ->with('success', '✅ Transaksi berhasil diterima!');
    }

    /**
     * Tolak / Cancel transaksi
     */
    public function reject($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Ubah status menjadi cancelled
        $transaction->update(['status' => 'cancelled']);
        
        // Kembalikan stok produk ke inventory
        foreach ($transaction->items as $item) {
            if ($item->product) {
                $item->product->increment('stok', $item->jumlah);
            }
        }
        
        return redirect()->route('admin.transactions.index')
            ->with('success', '❌ Transaksi ditolak dan stok berhasil dikembalikan.');
    }

    /**
     * Hapus transaksi
     */
    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            
            // Jika transaksi masih pending, kembalikan stok
            if ($transaction->status == 'pending') {
                foreach ($transaction->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stok', $item->jumlah);
                    }
                }
            }
            
            // Hapus items transaksi terlebih dahulu
            $transaction->items()->delete();
            
            // Hapus transaksi
            $transaction->delete();
            
            return redirect()->route('admin.transactions.index')
                ->with('success', '✅ Transaksi berhasil dihapus!');
                
        } catch (\Exception $e) {
            return back()->with('error', '❌ Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}