<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan
     */
    public function index()
    {
        // Ambil data setting pertama dari database
        $setting = Setting::first();
        
        // Jika tabel masih kosong, siapkan data default agar form tidak error
        if (!$setting) {
            $setting = new Setting();
            $setting->status_toko = 'open';
            $setting->jam_buka = '08:00';
            $setting->jam_tutup = '17:00';
            $setting->nama_toko = 'Toko Saya';
            $setting->deskripsi = 'Deskripsi toko';
            $setting->alamat = 'Alamat toko';
            $setting->telepon = '0812-xxxx-xxxx';
        }

        return view('admin.settings.index', compact('setting'));
    }

    /**
     * Update pengaturan toko
     */
    public function update(Request $request)
    {
        // 1. Validasi input dari form
        $validated = $request->validate([
            'status_toko' => 'required|in:open,close',
            'jam_buka'    => 'required',
            'jam_tutup'   => 'required',
            'nama_toko'   => 'nullable|string|max:255',
            'deskripsi'   => 'nullable|string',
            'alamat'      => 'nullable|string|max:255',
            'telepon'     => 'nullable|string|max:50',
        ]);

        // 2. Cari data setting atau buat baru jika belum ada
        $setting = Setting::first();

        if ($setting) {
            // Jika data sudah ada, lakukan UPDATE
            $setting->update($validated);
        } else {
            // Jika data belum ada (tabel kosong), lakukan CREATE
            Setting::create($validated);
        }

        // 3. Redirect kembali dengan pesan sukses
        return back()->with('success', '✅ Pengaturan berhasil diperbarui!');
    }
}