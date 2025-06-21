<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;

use App\Models\Transaksi;

class CetakStrukController extends Controller
{
    public function cetakStruk($id)
    {
       
        // Mengambil data siswa melalui relasi 'pBulanan', 'aTahunan', atau 'pTambahan'
        $transaksi = Transaksi::with(['pBulanan', 'aTahunan.pTahunan', 'pTambahan.siswa','metodeBayar'])->findOrFail($id);
   
        $siswa = null;
        // Cek isi transaksi untuk debugging
        if ($transaksi->pBulanan->isNotEmpty()) {
            $firstsiswa = $transaksi->pBulanan->first();
            $siswa = $firstsiswa->siswa->first();
        } elseif ($transaksi->aTahunan->isNotEmpty()) {
            $aTahunan = $transaksi->aTahunan->first();
            $pTahunan = optional($aTahunan)->pTahunan;
            $siswa = optional($pTahunan?->siswa)->first();
        } elseif ($transaksi->pTambahan->isNotEmpty()) {
            $siswa = $transaksi->pTambahan->first()->siswa;
        }

        $nis = optional($siswa)->nis;

        //rincian pembayaran
        // Siapkan rincian pembayaran
        $rincian = collect();

        // Rincian dari pBulanan
        $groupedBulanan = $transaksi->pBulanan->groupBy(function ($item) {
            return optional($item->jenisPembayaran)->nama;
        });

        foreach ($groupedBulanan as $jenis => $items) {
            $bulanList = $items->pluck('nama_bulan')->filter()->unique()->values()->toArray();
            $totalHarga = $items->sum('harga');

            if (!empty($jenis) && $totalHarga > 0) {
            $rincian->push([
                'nama' => $jenis . (count($bulanList) ? ' - ' . implode(', ', $bulanList) : ''),
                'harga' => $totalHarga,
            ]);
            }
        }

        // Rincian dari aTahunan
        // Rincian dari aTahunan
        foreach ($transaksi->aTahunan as $item) {
            $jenisPembayaran = optional(optional($item->pTahunan)->jenisPembayaran)->nama;
            if (!empty($jenisPembayaran) && !empty($item->nominal)) {
            $rincian->push([
                'nama' => $jenisPembayaran,
                'harga' => $item->nominal,
            ]);
            }
        }

        // Rincian dari pTambahan
        foreach ($transaksi->pTambahan as $item) {
            $jenisPembayaran = optional($item->jenisPembayaran)->nama;
            if (!empty($jenisPembayaran) && !empty($item->harga)) {
            $rincian->push([
                'nama' => $jenisPembayaran,
                'harga' => $item->harga,
            ]);
            }
        }
        

        // Menghitung total pembayaran
        $totalPembayaran = $rincian->sum('harga');
        //menghitung kembalian
        $kembalian = $transaksi->uang_bayar - $totalPembayaran;

       
        return view('transaksi.struk.struk', compact('transaksi', 'siswa', 'rincian', 'totalPembayaran', 'kembalian'));
    }
}
