<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ATahunan extends Model
{
    protected $table = 'a_tahunans';
    protected $fillable = [
        'tahunan_id',
        'transaksi_id',
        'nominal',
    ];

    public function pTahunan()
    {
        return $this->belongsTo(PTahunan::class, 'tahunan_id');
    }
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}
