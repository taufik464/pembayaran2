<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class PBulanan extends Model
{
    protected $table = 'p_bulanans';
    protected $appends = ['status', 'nama_bulan', 'total_bayar'];

    protected $fillable = [
        'jenis_pembayaran_id',
        'tahun_id',
        'bulan',
        'harga',
    ];


    public function getStatusAttribute()
    {
        // Cek apakah relasi pivot tersedia dan transaksi_id tidak null
        if (!isset($this->pivot) || $this->pivot->transaksi_id === null) {
            return 'Belum Lunas';
        }
        return 'Lunas';
    }

    public function getTotalBayarAttribute()
    {
        // Ambil siswa_id dari relasi pivot jika ada
        $siswaId = $this->siswaBulanan->siswa_id ?? null;

        if ($siswaId === null) {
            return 0;
        }

        return self::where('transaksi_id', '!=', null)
            ->where('tahun_id', $this->tahun_id)
            ->whereHas('siswa', function ($query) use ($siswaId) {
                $query->where('siswa_id', $siswaId);
            })
            ->sum('harga');
    }

    public function getNamaBulanAttribute()
    {
        $bulan = [
            1 => 'Juli',
            2 => 'Agustus',
            3 => 'September',
            4 => 'Oktober',
            5 => 'November',
            6 => 'Desember',
            7 => 'Januari',
            8 => 'Februari',
            9 => 'Maret',
            10 => 'April',
            11 => 'Mei',
            12 => 'Juni',
           
        ];

        return $bulan[$this->bulan] ?? 'Bulan tidak valid';
    }

    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'jenis_pembayaran_id');
    }


    public function siswa(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'siswa_bulanan', 'bulanan_id', 'siswa_id')
            ->using(SiswaBulanan::class)
            ->withPivot('transaksi_id')
            ->withTimestamps();
    }

    public function transaksi()
    {
        return $this->hasManyThrough(
            Transaksi::class,
            SiswaBulanan::class,
            'bulanan_id', // Foreign key on siswa_bulanan table
            'id', // Foreign key on transaksi table
            'id', // Local key on p_bulanans table
            'transaksi_id' // Local key on siswa_bulanan table
        );
    }
    public function tahun()
    {
        return $this->belongsTo(Periode::class, 'tahun_id');
    }
}
