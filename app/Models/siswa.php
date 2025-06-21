<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
   
    public $incrementing = false;  
   

    protected $fillable = [
        'nama',
        'nis',
        'nisn',
        'kelas_id',
        'user_id',
        'no_hp',
        'foto',

    ];

    public function kelas()
    {
        return $this->belongsTo(kelas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaranBulanan(): BelongsToMany
    {
        return $this->belongsToMany(pBulanan::class, 'siswa_bulanan', 'siswa_id', 'bulanan_id')
            ->using(SiswaBulanan::class)
            ->withPivot('transaksi_id')
            ->withTimestamps();
    }


    public function transaksi()
    {
        return $this->hasManyThrough(
            Transaksi::class,
            SiswaBulanan::class,
            'siswa_id', // Foreign key on siswa_bulanan table
            'id', // Foreign key on transaksi table
            'id', // Local key on siswa table
            'transaksi_id' // Local key on siswa_bulanan table
        );
    }
    public function pTahunan()
    {
        return $this->belongsToMany(PTahunan::class, 'siswa_p_tahunan', 'siswa_id', 'tahunan_id');
           
    }
    public function pTambahan()
    {
        return $this->hasMany(PTambahan::class, 'siswa_id', 'id');
    }
    public function aTahunan()
    {
        return $this->hasMany(ATahunan::class, 'siswa_id');
    }
}
