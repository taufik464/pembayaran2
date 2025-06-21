<?php

namespace App\Http\Controllers;


use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Periode;
use App\Exports\ExportStyles;
use Illuminate\Http\Request;



class ExportController extends Controller
{
    use ExportStyles;

    public function exportRekap(Request $request)
    {
        $kelasId = $request->angkatan;
        $periodeId = $request->tahunajaran;

        $periode = Periode::findOrFail($periodeId); // Now $periode is an object
        $kelas = Kelas::findOrFail($kelasId);

        $tahunAjaran = str_replace(['/', '\\'], '-', $periode->tahun_awal . '_' . $periode->tahun_akhir);
        $namaKelas = str_replace(['/', '\\'], '-', $kelas->nama);

        $filename = "Rekap_Pembayaran_Kelas_{$namaKelas}_Tahun_{$tahunAjaran}.xlsx";
        // Ambil data sesuai filter (sama seperti di RekapController)
        $data = Siswa::with([
            'kelas',
            'pembayaranBulanan' => fn($q) => $q->where('tahun_id', $periodeId),
            'pTahunan' => fn($q) => $q->where('tahun_id', $periodeId),
            'pTambahan' => fn($q) => $q->where('periode_id', $periodeId),
            'aTahunan'
        ])
            ->whereHas('kelas', fn($q) => $q->where('id', $kelasId))
            ->get()
            ->map(function ($siswa) {
                $pembayaran = $this->formatPembayaran($siswa);
            
                $row = [
                    'No' => '', // Akan diisi oleh FastExcel secara otomatis
                    'NIS' => $siswa->nis,
                    'Kelas' => $siswa->kelas->nama,
                    'Nama Siswa' => $siswa->nama,
                ];

                // Tambahkan kolom pembayaran
                foreach ($pembayaran as $jenisId => $item) {
                    $row[$item['jenis']] = $this->formatCellPembayaran($item);

                }

                return $row;
           
            });
        

        $kelas = Kelas::find($kelasId)->nama;
        $periode = Periode::find($periodeId)->tahun_awal . '-' . Periode::find($periodeId)->tahun_akhir;
        $filename = "Rekap_Pembayaran_Kelas_{$kelas}_Tahun_{$periode}.xlsx";

       
        return (new FastExcel($data))
            ->download($filename, null, $this->applyStyles($data));
    }

    protected function formatPembayaran($siswa)
    {
        // Sama seperti method di RekapController
        $formatted = [];

        foreach ($siswa->pembayaranBulanan as $bulanan) {
            if (!isset($formatted[$bulanan->jenis_pembayaran_id])) {
                $formatted[$bulanan->jenis_pembayaran_id] = [
                    'jenis' => $bulanan->jenisPembayaran->nama,
                    'dibayar' => 0,
                    'total_tagihan' => 0
                ];
            }
            $formatted[$bulanan->jenis_pembayaran_id]['total_tagihan'] += $bulanan->harga;
            if ($bulanan->pivot->transaksi_id) {
                $formatted[$bulanan->jenis_pembayaran_id]['dibayar'] += $bulanan->harga;
            }
        }

        // ... (lengkapi untuk pTahunan dan pTambahan seperti di RekapController)
        // Pembayaran Tahunan
        // Pembayaran Tahunan
        foreach ($siswa->pTahunan as $tahunan) {
            $jenisId = $tahunan->jenis_pembayaran_id;
            if (!isset($formatted[$jenisId])) {
            $formatted[$jenisId] = [
                'jenis' => $tahunan->jenisPembayaran->nama,
                'dibayar' => 0,
                'total_tagihan' => 0
            ];
            }
            $formatted[$jenisId]['total_tagihan'] += $tahunan->harga;
            $dibayar = $siswa->aTahunan->where('tahunan_id', $tahunan->id)->sum('nominal');
            $formatted[$jenisId]['dibayar'] += $dibayar;
        }

        // Pembayaran Tambahan
        foreach ($siswa->pTambahan as $tambahan) {
            $jenisId = $tambahan->jenis_pembayaran_id;

            if (!isset($formatted[$jenisId])) {
                $formatted[$jenisId] = [
                    'jenis' => $tambahan->jenisPembayaran->nama,
                    'dibayar' => 0,
                    'total_tagihan' => 0,
                    'is_tambahan' => true
                ];
               
            }

            // Jumlahkan tagihan dan pembayaran
            $formatted[$jenisId]['total_tagihan'] += $tambahan->harga;

            if ($tambahan->transaksi_id) {
                $formatted[$jenisId]['dibayar'] += $tambahan->harga;
            }
        }

        return $formatted;
    }

    protected function formatCellPembayaran($item)
    {
        if (isset($item['is_tambahan'])) {
            return $item['dibayar'] > 0
                ? 'Rp ' . number_format($item['dibayar'], 0, ',', '.')
                : '-';
        }

        if ($item['dibayar'] <= 0) {
            return '0';
        }

        return $item['dibayar'] >= $item['total_tagihan']
            ? 'Rp ' . number_format($item['dibayar'], 0, ',', '.')
            : 'Rp ' . number_format($item['dibayar'], 0, ',', '.') . ' (Belum Lunas)';
    }
}
