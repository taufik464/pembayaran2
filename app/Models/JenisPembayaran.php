<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    protected $table = 'jenis_pembayarans';
    protected $fillable = [
        'nama',
        'tipe_pembayaran',
        'harga',
    ];
    
    public function pBulanan()
    {
        return $this->hasMany(PBulanan::class, 'jenis_pembayaran_id');
    }
    public function pTahunan()
    {
        return $this->hasMany(PTahunan::class, 'jenis_pembayaran_id');
    }
    public function pTambahan()
    {
        return $this->hasMany(PTambahan::class, 'jenis_pembayaran_id');
    }
}
