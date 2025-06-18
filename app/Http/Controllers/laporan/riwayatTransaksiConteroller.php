<?php

namespace App\Http\Controllers\laporan;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;


class riwayatTransaksiConteroller extends Controller
{
    public function index(){
        // Ambil semua transaksi beserta relasi yang diperlukan
        $transaksi = Transaksi::with(['pBulanan.siswa', 'aTahunan.pTahunan.siswa', 'pTambahan.siswa'])->get();
       
        $riwayat = [];

        foreach ($transaksi as $trx) {
            $namaSiswa = null;
            $totalPembayaran = 0;

          


            // Cek dan ambil nama siswa dari relasi yang tersedia
            if ($trx->pBulanan && $trx->pBulanan->isNotEmpty()) {
            $siswa = $trx->pBulanan->first()->siswa;
            $namaSiswa = optional($siswa)->nama;
            $totalPembayaran += $trx->pBulanan->sum('harga');
            }
            

            if ($trx->aTahunan && $trx->aTahunan->isNotEmpty()) {
            $aTahunan = $trx->aTahunan->first();
            $siswa = optional($aTahunan->pTahunan)->siswa;
            if (!$namaSiswa) {
                $namaSiswa = optional($siswa)->nama;
            }
            $totalPembayaran += $trx->aTahunan->sum('nominal');
            }

            if ($trx->pTambahan && $trx->pTambahan->isNotEmpty()) {
            $siswa = $trx->pTambahan->first()->siswa;
            if (!$namaSiswa) {
                $namaSiswa = optional($siswa)->nama;
            }
            $totalPembayaran += $trx->pTambahan->sum('harga');
            }
            

            // Tambahkan data transaksi lain yang diinginkan, misal: tanggal, keterangan, metode pembayaran, dll
            $riwayat[] = [
            'tanggal' => $trx->created_at,
            'transaksi' => $trx,
            'nama_siswa' => $namaSiswa,
            'total_pembayaran' => $totalPembayaran,
            'metode_pembayaran' => $trx->metodeBayar->nama,
            'Jumlah_uang' => $trx->uang_bayar,
            'Staff' => $trx->user->staff->nama ?? 'master',
            
            ];
        }
     

        return view('laporan.riwayat.index', compact('riwayat'));


    }
}
