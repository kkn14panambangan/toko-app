<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('kode_transaksi')->unique();
            $table->decimal('total', 10, 2);
            $table->enum('metode_pembayaran', ['tunai', 'qris'])->default('tunai');
            $table->enum('status', ['pending', 'success', 'cancelled'])->default('pending');
            $table->datetime('tanggal_transaksi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};