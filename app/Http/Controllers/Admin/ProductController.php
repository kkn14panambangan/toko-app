<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori' => 'required|in:segar,kering,olahan,kulit',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // PERBAIKAN 1: Gunakan storeAs agar nama file unik dan tidak bentrok
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $validated['gambar'] = $file->storeAs('products', $namaFile, 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', '✅ Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.form', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori' => 'required|in:segar,kering,olahan,kulit',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // PERBAIKAN 2: Logika hapus & upload yang lebih aman untuk Windows
        if ($request->hasFile('gambar')) {
            // 1. Hapus foto lama secara langsung dari folder public/storage
            if ($product->gambar) {
                $pathLama = public_path('storage/' . $product->gambar);
                if (file_exists($pathLama)) {
                    unlink($pathLama); // Hapus file fisik
                }
            }
            
            // 2. Simpan foto baru dengan nama unik
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $validated['gambar'] = $file->storeAs('products', $namaFile, 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', '✅ Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // PERBAIKAN 3: Hapus foto saat produk dihapus
        if ($product->gambar) {
            $pathLama = public_path('storage/' . $product->gambar);
            if (file_exists($pathLama)) {
                unlink($pathLama);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', '✅ Produk berhasil dihapus!');
    }
}