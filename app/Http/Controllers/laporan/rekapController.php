<?php

namespace App\Http\Controllers\laporan;

use App\Http\Controllers\Controller;
use App\Models\JenisPembayaran;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Periode;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Exports\RekapExport;
use Maatwebsite\Excel\Facades\Excel;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $kelasId = $request->angkatan;
        $periodeId = $request->tahunajaran;
        $search = $request->search;

        // Data untuk dropdown filter
        $angkatans = Kelas::select('id', 'nama')->distinct()->get();
        $tahunAjarans = Periode::all();
        $jenisPembayaran = JenisPembayaran::all();

        // Inisialisasi query kosong
        $query = Siswa::query()->where('id', '<', 0); // Query kosong default

        // Hanya jalankan query jika KEDUA filter dipilih
        if ($kelasId && $periodeId) {
            $query = Siswa::with([
                'kelas',
                'pembayaranBulanan' => function ($q) use ($periodeId) {
                    $q->where('tahun_id', $periodeId);
                },
                'pTahunan' => function ($q) use ($periodeId) {
                    $q->where('tahun_id', $periodeId);
                },
                'pTambahan' => function ($q) use ($periodeId) {
                    $q->where('periode_id', $periodeId);
                },
                'aTahunan'
            ])->whereHas('kelas', function ($q) use ($kelasId) {
                $q->where('id', $kelasId);
            });

            // Filter pencarian jika ada
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nis', 'like', '%' . $search . '%')
                        ->orWhere('nama', 'like', '%' . $search . '%');
                });
            }
        }


        // Format data untuk view
        $dataSiswa = $query->get()->map(function ($siswa) {
            return [
                'id' => $siswa->id,
                'nis' => $siswa->nis,
                'nama' => $siswa->nama,
                'kelas' => optional($siswa->kelas)->nama ?? '-',
                'tingkatan' => optional($siswa->kelas)->tingkatan ?? '-',
                'pembayaran' => $this->formatPembayaran($siswa)
            ];
        });


        return view('laporan.rekap.index', [
            'dataSiswa' => $dataSiswa,
            'jenisP' => $jenisPembayaran,
            'angkatans' => $angkatans,
            'tahunAjarans' => $tahunAjarans,
            'selectedKelas' => $kelasId,
            'selectedTahun' => $periodeId,
            'bothFiltersSelected' => $kelasId && $periodeId // Tambahkan flag
        ]);
    }

    protected function formatPembayaran($siswa)
    {
        $formatted = [];

        // Pembayaran Bulanan
        foreach ($siswa->pembayaranBulanan as $bulanan) {
            $jenisId = $bulanan->jenis_pembayaran_id;
            if (!isset($formatted[$jenisId])) {
                $formatted[$jenisId] = [
                    'jenis_pembayaran_id' => $jenisId,
                    'dibayar' => 0,
                    'total_tagihan' => 0,
                    'punya_tanggungan' => true
                ];
            }
            $formatted[$jenisId]['total_tagihan'] += $bulanan->harga;
            if ($bulanan->pivot->transaksi_id) {
                $formatted[$jenisId]['dibayar'] += $bulanan->harga;
            }
        }

        // Pembayaran Tahunan
        foreach ($siswa->pTahunan as $tahunan) {
            $jenisId = $tahunan->jenis_pembayaran_id;
            if (!isset($formatted[$jenisId])) {
                $formatted[$jenisId] = [
                    'jenis_pembayaran_id' => $jenisId,
                    'dibayar' => 0,
                    'total_tagihan' => 0,
                    'punya_tanggungan' => true
                ];
            }
            $formatted[$jenisId]['total_tagihan'] += $tahunan->harga;
            $dibayar = $siswa->aTahunan->where('tahunan_id', $tahunan->id)->sum('nominal');
            $formatted[$jenisId]['dibayar'] += $dibayar;
        }

        // Pembayaran Tambahan
        foreach ($siswa->pTambahan as $tambahan) {
            // Hanya proses jika ada transaksi_id
            if ($tambahan->transaksi_id) {
                $jenisId = $tambahan->jenis_pembayaran_id;

                if (!isset($formatted[$jenisId])) {
                    $formatted[$jenisId] = [
                        'jenis_pembayaran_id' => $jenisId,
                        'dibayar' => 0,
                        'total_tagihan' => 0,
                        'punya_tanggungan' => true,
                        'is_tambahan' => true  // Flag khusus pembayaran tambahan
                    ];
                }

                $formatted[$jenisId]['total_tagihan'] += $tambahan->harga;
                $formatted[$jenisId]['dibayar'] += $tambahan->harga;
            }
        }


        return $formatted;
    }

   
}
