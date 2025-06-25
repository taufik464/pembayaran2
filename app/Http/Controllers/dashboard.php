<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\PTambahan;
use App\Models\pTahunan;
use App\Models\ATahunan;
use App\Models\SiswaBulanan;
use App\Models\Siswa;

use Illuminate\Http\Request;

class dashboard extends Controller
{
    public function index()
    {

        $today = Carbon::today();

        // Step 1: Ambil transaksi hari ini
        $transaksiHariIni = Transaksi::whereDate('tanggal', $today)->pluck('id');

        // Step 2: Hitung total dari masing-masing tabel yang terhubung
        $totalBulanan = SiswaBulanan::whereIn('transaksi_id', $transaksiHariIni)
            ->join('p_bulanans', 'siswa_bulanan.bulanan_id', '=', 'p_bulanans.id')
            ->sum('p_bulanans.harga');
        $totalTahunan = ATahunan::whereIn('transaksi_id', $transaksiHariIni)->sum('nominal'); 
        $totalTambahan = PTambahan::whereIn('transaksi_id', $transaksiHariIni)->sum('harga');

        // Step 3: Jumlahkan semua
        $totalHarian = $totalBulanan + $totalTahunan + $totalTambahan;

// Menghitung jumlah siswa
$jumlahSiswa = Siswa::count();

// Menghitung pendapatan berdasarkan periode (misal: bulan ini)
$startOfMonth = Carbon::now()->startOfMonth();
$endOfMonth = Carbon::now()->endOfMonth();

$transaksiPeriode = Transaksi::whereBetween('tanggal', [$startOfMonth, $endOfMonth])->pluck('id');

$totalBulananPeriode = SiswaBulanan::whereIn('transaksi_id', $transaksiPeriode)
    ->join('p_bulanans', 'siswa_bulanan.bulanan_id', '=', 'p_bulanans.id')
    ->sum('p_bulanans.harga');
$totalTahunanPeriode = ATahunan::whereIn('transaksi_id', $transaksiPeriode)->sum('nominal');
$totalTambahanPeriode = PTambahan::whereIn('transaksi_id', $transaksiPeriode)->sum('harga');

$totalPeriode = $totalBulananPeriode + $totalTahunanPeriode + $totalTambahanPeriode;



        // Menghitung semua pembayaran siswa yang sudah dan belum
        // Step 2: Hitung total dari masing-masing tabel yang terhubung
      
        $tBulanan = SiswaBulanan::join('p_bulanans', 'siswa_bulanan.bulanan_id', '=', 'p_bulanans.id')->sum('p_bulanans.harga');
        $tTahunan = Siswa::join('siswa_p_tahunan', 'siswa.id', '=', 'siswa_p_tahunan.siswa_id')
            ->join('p_tahunans', 'siswa_p_tahunan.tahunan_id', '=', 'p_tahunans.id')
            ->sum('p_tahunans.harga');
        $tTambahan = PTambahan::sum('harga');
        $totalestimasi = $tBulanan + $tTahunan + $tTambahan;



        return view('dashboard.dashboard', compact('totalHarian', 'jumlahSiswa', 'totalPeriode', 'totalestimasi'));
    }
}
