<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;


class PTahunan extends Model
{
    protected $table = 'p_tahunans';
    protected $appends = ['status', 'dibayar'];
    protected $fillable = [
        'jenis_pembayaran_id',
        'tahun_id',
        'siswa_id',
        'harga',
    ];

    public function getStatusAttribute()
    {
        
        return $this->harga == $this->dibayar ? 'Lunas' : 'Belum Lunas';
    }
    public function getDibayarAttribute()
    {
        

        return ATahunan::where('tahunan_id', $this->id)->sum('nominal');
    }

    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'nis');
    }
}
