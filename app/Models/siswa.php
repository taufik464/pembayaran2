<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    protected $table = 'siswa';

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

    public function pBulanan()
    {
        return $this->hasMany(PBulanan::class, 'siswa_id', 'nis');
    }
    public function pTahunan()
    {
        return $this->hasMany(PTahunan::class, 'siswa_id', 'nis');
    }
    public function pTambahan()
    {
        return $this->hasMany(PTambahan::class, 'siswa_id', 'nis');
    }
}
