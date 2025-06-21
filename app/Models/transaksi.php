<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class transaksi extends Model
{
    protected $table = 'transaksi';
   

    protected $fillable = [
        'user_id',
        'metode_bayar_id',
        'tanggal',
        'uang_bayar',
      
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function metodeBayar()
    {
        return $this->belongsTo(Metode::class, 'metode_bayar_id');
    }
    public function aTahunan()
    {
        return $this->hasMany(ATahunan::class, 'transaksi_id');
    }
    public function pBulanan()
    {
        return $this->hasManyThrough(
            PBulanan::class,
            SiswaBulanan::class,
            'transaksi_id', // foreign key di siswa_bulanan
            'id',           // foreign key di p_bulanans
            'id',           // local key di transaksi
            'bulanan_id'    // local key di siswa_bulanan
        );
    }
    public function pTambahan()
    {
        return $this->hasMany(PTambahan::class, 'transaksi_id');
    }
    public function siswaBulanan(): HasOne
    {
        return $this->hasOne(SiswaBulanan::class, 'transaksi_id');
    }

    public function siswa()
    {
        return $this->siswaBulanan->siswa();
    }
   

}
