<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class periode extends Model
{
    use HasFactory;
    protected $table = 'periodes';
    protected $appends = ['tahun'];

    protected $fillable = [
        'tahun_awal',
        'tahun_akhir',
        'status',

    ];


    public function getTahunAttribute()
    {
        return $this->tahun_awal . ' - ' . $this->tahun_akhir;
    }
    public function Bulanan()
    {
        return $this->hasMany(PBulanan::class);
    }
    public function Tahunan()
    {
        return $this->hasMany(PTahunan::class);
    }
    public function Tambahan() {
        return $this->hasMany(PTambahan::class);
    }

    
}
