<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\PBulanan;
use App\Models\PTambahan;
use App\Models\ATahunan;
use Illuminate\Http\Request;

class dashboard extends Controller
{
    public function index()
    {

        $today = Carbon::today();

        // Step 1: Ambil transaksi hari ini
        $transaksiHariIni = Transaksi::whereDate('tanggal', $today)->pluck('id');

        // Step 2: Hitung total dari masing-masing tabel yang terhubung
        $totalBulanan = PBulanan::whereIn('transaksi_id', $transaksiHariIni)->sum('harga');
        $totalTahunan = ATahunan::whereIn('transaksi_id', $transaksiHariIni)->sum('nominal'); 
        $totalTambahan = PTambahan::whereIn('transaksi_id', $transaksiHariIni)->sum('harga');

        // Step 3: Jumlahkan semua
        $totalHarian = $totalBulanan + $totalTahunan + $totalTambahan;



        return view('dashboard.dashboard', compact('totalHarian'));
    }
}
