<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \DB::table('users')->insert([
            ['id' => 1, 'name' => 'robbi', 'email' => 'yourbold7@gmail.com', 'password' => '$2y$12$HMX/lOef6RanQ8Hu.hHdcecxX4/j1LPMC0q6yQfdtwTE7qI7oEO/S', 'role' => 'admin', 'created_at' => '2026-08-31 12:10:10', 'updated_at' => '2026-08-31 23:29:58'],
            ['id' => 2, 'name' => 'Admin', 'email' => 'admin@example.com', 'password' => '$2y$12$jhrMGQu4fvETOfjVJXTgruzILK7I6AK6rxkL1avl4cHgdOEHT7mXm', 'role' => 'admin', 'created_at' => '2026-08-31 20:18:15', 'updated_at' => '2026-08-31 20:18:15'],
            ['id' => 3, 'name' => 'KENZO YT', 'email' => 'robbyc_andres@gmail.com', 'password' => '$2y$12$6twapdbKONmQDp1TP0LH5uRvfd4zvdnRVEA02tlzDmo1Ab4ROaGki', 'role' => 'pelanggan', 'created_at' => '2026-08-31 23:49:52', 'updated_at' => '2026-08-31 23:49:52'],
            ['id' => 4, 'name' => 'robbi', 'email' => 'kenxo@gmail.com', 'password' => '$2y$12$y6qlcLhoH86eW2H50F/iE.7tRsRLJUJSZvoycnunH6lTxmMzrJrLy', 'role' => 'admin', 'created_at' => '2026-08-31 23:57:44', 'updated_at' => '2026-09-01 00:22:36'],
            ['id' => 6, 'name' => 'Super Admin', 'email' => 'admin@tokokembangtahu66.com', 'password' => '$2y$12$TWdV/YA3UmxO4ql32cXqLuLortUDwZLAjy080dGpsEJTxZSTXLxoG', 'role' => 'admin', 'created_at' => '2026-09-01 00:38:36', 'updated_at' => '2026-09-01 00:38:36'],
        ]);

        \DB::table('settings')->insert([
            ['key' => 'status_toko', 'value' => 'open', 'created_at' => '2026-09-01 02:18:12', 'updated_at' => '2026-09-01 02:18:12'],
            ['key' => 'jam_buka', 'value' => '08:00:00', 'created_at' => '2026-09-01 02:18:12', 'updated_at' => '2026-09-01 02:18:12'],
            ['key' => 'jam_tutup', 'value' => '17:00:00', 'created_at' => '2026-09-01 02:18:12', 'updated_at' => '2026-09-01 02:18:12']
        ]);

        \DB::table('products')->insert([
            ['id' => 2, 'nama_produk' => 'Kembang Tahu Segar', 'kategori' => 'segar', 'deskripsi' => null, 'harga' => 5000.00, 'stok' => 10, 'gambar' => 'products/1788260770_WhatsApp Image 2026-09-01 at 12.57.09.jpeg', 'created_at' => '2026-08-31 13:09:34', 'updated_at' => '2026-09-01 04:08:24']
        ]);
    }
}