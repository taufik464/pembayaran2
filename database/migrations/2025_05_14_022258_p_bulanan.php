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
        Schema::create('p_bulanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa', 'nis')->onDelete('cascade');
            $table->foreignId('tahun_id')->constrained('periodes')->onDelete('cascade');
            $table->foreignId('jenis_pembayaran_id')->constrained('jenis_pembayarans',)->onDelete('cascade');
            $table->tinyInteger('bulan')->unsigned()->comment('1=Juli, 2=Agustus, ..., 12=Juni');
            $table->foreignId('transaksi_id')->nullable()->constrained('transaksi',)->onDelete('set null');
            $table->decimal('harga', 10,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_bulanan');
    }
};
