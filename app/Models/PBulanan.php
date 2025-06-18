<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PBulanan extends Model
{
    protected $table = 'p_bulanans';
    protected $appends = ['status', 'nama_bulan', 'total_bayar'];

    protected $fillable = [
        'jenis_pembayaran_id',
        'tahun_id',
        'siswa_id',
        'bulan',
        'transaksi_id',
        'harga',
    ];


    public function getStatusAttribute()
    {
        return $this->transaksi_id === null ? 'Belum Lunas' : 'Lunas';
    }

    public function getTotalBayarAttribute()
    {
        return self::where('transaksi_id', '!=', null)
            ->where('tahun_id', $this->tahun_id)
            ->where('siswa_id', $this->siswa_id)
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


    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
    
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
    public function tahun()
    {
        return $this->belongsTo(Periode::class, 'tahun_id');
    }
}
