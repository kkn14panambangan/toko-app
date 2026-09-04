<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'uang_dibayar')) {
                $table->decimal('uang_dibayar', 15, 2)->nullable()->after('total');
            }
            if (!Schema::hasColumn('transactions', 'kembalian')) {
                $table->decimal('kembalian', 15, 2)->nullable()->after('uang_dibayar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['uang_dibayar', 'kembalian']);
        });
    }
};