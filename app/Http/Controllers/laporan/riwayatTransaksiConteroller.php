<?php

namespace App\Http\Controllers\laporan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class riwayatTransaksiConteroller extends Controller
{
    public function index()
    {
        // Ambil transaksi dengan relasi yang diperlukan
        $transaksis = Transaksi::with([
            'siswaBulanan.siswa',
            'siswaBulanan.bulanan.jenisPembayaran',
            'aTahunan.pTahunan.siswa',
            'aTahunan.pTahunan.jenisPembayaran',
            'pTambahan.siswa',
            'pTambahan.jenisPembayaran',
            'metodeBayar',
            'user.staff'
        ])
            ->orderBy('created_at', 'desc')
            ->get();


        $riwayat = [];

        foreach ($transaksis as $transaksi) {
            $detailPembayaran = [];
            $namaSiswa = null;
            $totalPembayaran = 0;

            $siswaBulanan = $transaksi->siswaBulanan;

            // Tahap 1: Cek apakah $siswaBulanan ada
            if ($siswaBulanan && isset($siswaBulanan->bulanan) && isset($siswaBulanan->siswa)) {

                $harga = $siswaBulanan->bulanan->harga ?? 0;

                $totalPembayaran += $harga;

                $detailPembayaran[] = [
                    'jenis' => 'Bulanan',
                    'nama' => optional($siswaBulanan->bulanan->jenisPembayaran)->nama ?? 'Jenis Pembayaran Tidak Diketahui',
                    'jumlah' => $harga,
                    'siswa_id' => $siswaBulanan->siswa->id ?? null,
                    'siswa_nama' => $siswaBulanan->siswa->nama ?? 'Siswa Tidak Diketahui'
                ];

                // Tahap 5: Simpan nama siswa pertama jika belum ada
                if (!$namaSiswa && isset($siswaBulanan->siswa->nama)) {
                    $namaSiswa = $siswaBulanan->siswa->nama;
                }
            }







            // Handle Pembayaran Tahunan
            if ($transaksi->aTahunan && $transaksi->aTahunan->isNotEmpty()) {
                foreach ($transaksi->aTahunan as $tahunan) {
                    // Dapatkan siswa melalui tabel pivot
                    $siswaIds = DB::table('siswa_p_tahunan')
                        ->where('tahunan_id', $tahunan->pTahunan->id)
                        ->pluck('siswa_id');

                    // Ambil data siswa pertama (atau sesuaikan dengan kebutuhan)
                    $siswa = Siswa::find($siswaIds->first());

                    if ($siswa) {
                        if (!$namaSiswa) {
                            $namaSiswa = $siswa->nama;
                        }
                        
                    $totalPembayaran += $tahunan->nominal;
                    $detailPembayaran[] = [
                        'jenis' => 'Tahunan',
                        'nama' => $tahunan->pTahunan->jenisPembayaran->nama ?? '-',
                        'jumlah' => $tahunan->nominal,
                        'siswa_id' => optional($siswa)->id
                    ];
                }
            }
        }
           

            // Handle Pembayaran Tambahan
            if ($transaksi->pTambahan->isNotEmpty()) {
                foreach ($transaksi->pTambahan as $tambahan) {
                    $siswa = $tambahan->siswa;

                    if (!$namaSiswa) {
                        $namaSiswa = optional($siswa)->nama;
                    }

                    $totalPembayaran += $tambahan->harga;
                    $detailPembayaran[] = [
                        'jenis' => 'Tambahan',
                        'nama' => $tambahan->jenisPembayaran->nama,
                        'jumlah' => $tambahan->harga,
                        'siswa_id' => optional($siswa)->id
                    ];
                }
            }
            
        

            $riwayat[] = [
                'id' => $transaksi->id,
                'tanggal' => $transaksi->created_at->format('d/m/Y H:i'),
                'nama_siswa' => $namaSiswa ?? 'Tidak diketahui',
                'total_pembayaran' => $totalPembayaran,
                'metode_pembayaran' => optional($transaksi->metodeBayar)->nama ?? '-',
                'jumlah_uang' => $transaksi->uang_bayar,
                'kembalian' => $transaksi->uang_bayar - $totalPembayaran,
                'staff' => optional($transaksi->user->staff)->nama ?? 'Admin',
                'detail_pembayaran' => $detailPembayaran,
                'transaksi_id' => $transaksi->id,

            ];
        }
      
    
        return view('laporan.riwayat.index', compact('riwayat'));
    }
}
