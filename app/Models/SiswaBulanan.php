<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SiswaBulanan extends Pivot
{
    protected $table = 'siswa_bulanan';
    
    // Tambahkan ini jika menggunakan incrementing ID di pivot table
    public $incrementing = true;
    
    protected $fillable = [
        'siswa_id', 'bulanan_id', 'transaksi_id'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'nis');
    }

    public function bulanan()
    {
        return $this->belongsTo(PBulanan::class, 'bulanan_id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}
