<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['hair', 'face', 'nail']);
            $table->string('category_name', 120);
            $table->string('name', 160);
            $table->text('description');
            $table->unsignedSmallInteger('duration'); // menit
            // Salah satu dari price / price_range wajib diisi, divalidasi
            // di Admin\ServiceController (bukan CHECK constraint, biar portable).
            $table->unsignedInteger('price')->nullable();
            $table->string('price_range', 60)->nullable();
            $table->timestamps();

            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
