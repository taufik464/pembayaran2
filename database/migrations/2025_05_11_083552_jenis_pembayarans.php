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
        Schema::create('Jenis_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->decimal('harga', 10, 2);
            $table->enum('tipe_pembayaran', ['Bulanan', 'Tahunan', 'Tambahan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pembayarans');
    }
};
