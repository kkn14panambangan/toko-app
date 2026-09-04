<nav class="bg-gray-800 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="text-xl font-bold flex items-center">
            <span class="text-2xl mr-2"></span>
            Kembang Tahu 66
        </a>
        <div class="space-x-4">
            <a href="{{ route('home') }}" class="hover:text-blue-300 transition">Beranda</a>
            <a href="{{ route('pelanggan.shop') }}" class="hover:text-blue-300 transition">Toko</a>
            <a href="{{ route('pelanggan.cart') }}" class="hover:text-blue-300 transition">Keranjang</a>
            @if(session('admin_logged_in'))
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-300 transition">Admin</a>
            @endif
        </div>
    </div>
</nav>