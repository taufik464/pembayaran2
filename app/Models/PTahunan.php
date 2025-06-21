<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Schema;


class PTahunan extends Model
{
    protected $table = 'p_tahunans';
   
    protected $fillable = [
        'jenis_pembayaran_id',
        'tahun_id',
        'harga',
    ];
   

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
        return $this->belongsToMany(Siswa::class, 'siswa_p_tahunan', 'tahunan_id', 'siswa_id');
    }
    public function tahun()
    {
        return $this->belongsTo(Periode::class, 'tahun_id',);
    }
    public function aTahunan()
    {
        return $this->hasMany(ATahunan::class, 'tahunan_id', 'id');
    }
}
