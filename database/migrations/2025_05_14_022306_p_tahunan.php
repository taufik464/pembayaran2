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
        Schema::create('p_tahunans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_pembayaran_id')->constrained('jenis_pembayarans')->onDelete('cascade');
            $table->foreignId('tahun_id')->constrained('periodes')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_tahunans');
    }
};
