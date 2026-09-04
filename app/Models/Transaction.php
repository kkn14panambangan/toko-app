<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Field yang boleh diisi secara massal
     */
    protected $fillable = [
    'user_id',
    'kode_transaksi',
    'total',
    'uang_dibayar',      // ← TAMBAHKAN
    'kembalian',         // ← TAMBAHKAN
    'metode_pembayaran',
    'status',
    'tanggal_transaksi',
];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'total' => 'decimal:2',
    ];

    /**
     * Relasi ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel transaction_items
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}