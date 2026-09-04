@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">📦 Kelola Produk</h1>
        <p class="text-gray-600">Kelola produk toko Anda</p>
    </div>
    <a href="{{ route('admin.products.create') }}" 
       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center">
        <span class="text-xl mr-2">+</span> Tambah Produk
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($products as $product)
            <tr>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        @if($product->gambar)
                            <img src="{{ asset('storage/' . $product->gambar) }}" class="w-12 h-12 object-cover rounded mr-3">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded mr-3"></div>
                        @endif
                        <div>
                            <div class="font-semibold text-gray-800">{{ $product->nama_produk }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($product->deskripsi, 50) }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        @if($product->kategori == 'segar') bg-blue-100 text-blue-800
                        @elseif($product->kategori == 'kering') bg-yellow-100 text-yellow-800
                        @elseif($product->kategori == 'olahan') bg-green-100 text-green-800
                        @else bg-purple-100 text-purple-800
                        @endif">
                        {{ ucfirst($product->kategori) }}
                    </span>
                </td>
                <td class="px-6 py-4 font-semibold">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <span class="{{ $product->stok > 10 ? 'text-green-600' : 'text-red-600' }} font-semibold">
                        {{ $product->stok }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada produk</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection