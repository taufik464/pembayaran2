<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metode extends Model
{
    protected $table = 'metode_bayar';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'metode_bayar_id');
    }
}
