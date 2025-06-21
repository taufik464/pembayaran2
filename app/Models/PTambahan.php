<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PTambahan extends Model
{
    protected $table = 'p_tambahan';
    protected $appends = ['status'];
    protected $fillable = [
        'jenis_pembayaran_id',
        'siswa_id',
        'periode_id',
        'transaksi_id',
        'harga',
    ];

    

    public function getStatusAttribute()
    {
        return $this->transaksi_id === null ? 'Belum Lunas' : 'Lunas';
    }


    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'jenis_pembayaran_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id' );
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
    
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
   
}
