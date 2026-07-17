<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambah status 'completed' di antara 'paid' dan 'cancelled'.
     * Ini yang dipakai admin untuk menandai pesanan sudah selesai
     * diproses/diambil, sama seperti status 'completed' di bookings.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid', 'completed', 'cancelled'])
                ->default('pending')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid', 'cancelled'])
                ->default('pending')
                ->change();
        });
    }
};
