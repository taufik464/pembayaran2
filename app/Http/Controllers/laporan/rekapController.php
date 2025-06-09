<?php

namespace App\Http\Controllers\laporan;
use App\Http\Controllers\Controller;
use App\Models\JenisPembayaran;
use App\Models\Siswa;
use App\Models\periode;
use Illuminate\Http\Request;

class rekapController extends Controller
{
    public function index(Request $request)
    {
        $tahunAjarans = periode::all();
        $tahunTerpilih = $request->tahunajaran;

        $jenisP = JenisPembayaran::all();

        $siswas = Siswa::with(['kelas', 'pBulanan', 'pTahunan', 'pTambahan'])
            ->when($tahunTerpilih, function ($query) use ($tahunTerpilih) {
                $query->whereHas('pTahunan', function ($q) use ($tahunTerpilih) {
                    $q->where('tahun_ajaran_id', $tahunTerpilih);
                })
                ->orWhereHas('pBulanan', function ($q) use ($tahunTerpilih) {
                    $q->where('tahun_ajaran_id', $tahunTerpilih);
                })
                ->orWhereHas('pTambahan', function ($q) use ($tahunTerpilih) {
                    $q->where('tahun_ajaran_id', $tahunTerpilih);
                });
            })
            ->get();

        return view('laporan.rekap.index', compact('jenisP', 'siswas', 'tahunAjarans'));
    }
   

  
}
