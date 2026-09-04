<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung total produk (aman, tidak bergantung kolom)
        $totalProducts = Product::count();
        
        // Hitung total transaksi (aman, tidak bergantung kolom)
        $totalTransactions = Transaction::count();
        
        // Hitung total pendapatan - CEK DULU KOLOM APA YANG ADA
        $totalRevenue = 0;
        
        // Cek kolom mana yang tersedia di tabel transactions
        $columns = Schema::getColumnListing('transactions');
        
        if (in_array('total_harga', $columns)) {
            $totalRevenue = Transaction::sum('total_harga');
        } elseif (in_array('total', $columns)) {
            $totalRevenue = Transaction::sum('total');
        } elseif (in_array('amount', $columns)) {
            $totalRevenue = Transaction::sum('amount');
        } elseif (in_array('grand_total', $columns)) {
            $totalRevenue = Transaction::sum('grand_total');
        }
        // Jika tidak ada kolom yang cocok, $totalRevenue tetap 0
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalTransactions',
            'totalRevenue'
        ));
    }
}