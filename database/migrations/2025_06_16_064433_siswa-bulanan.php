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
        Schema::create('siswa_bulanan', function (Blueprint $table) {
            $table->foreignId('siswa_id')->constrained('siswa',);
            $table->foreignId('bulanan_id')->constrained('p_bulanans');
            $table->foreignId('transaksi_id')->nullable()->constrained('transaksi');
            $table->primary(['siswa_id', 'bulanan_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_bulanan');
    }
};
