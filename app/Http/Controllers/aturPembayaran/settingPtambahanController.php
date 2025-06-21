<?php

namespace App\Http\Controllers\aturPembayaran;
use App\Http\Controllers\Controller;

use App\Models\JenisPembayaran;
use App\Models\Siswa;
use App\Models\Periode;
use App\Models\PTambahan;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class settingPtambahanController extends Controller
{


    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'pt_id' => ['required', 'array', 'min:1'],
            'pt_id.*' => ['required', 'exists:jenis_pembayarans,id,tipe_pembayaran,tambahan'],
            'siswa_id' => ['required', 'exists:siswa,nis']
        ]);

        // Temukan siswa dan periode aktif
        $siswa = Siswa::where('nis', $validated['siswa_id'])->firstOrFail();
        $periodeAktif = Periode::where('status', 'aktif')->first();

        DB::beginTransaction();
        try {
            foreach ($validated['pt_id'] as $ptId) {
                // Dapatkan jenis pembayaran yang valid
                $jenisPembayaran = JenisPembayaran::where('id', $ptId)
                    ->where('tipe_pembayaran', 'tambahan')
                    ->firstOrFail();

              
              

                // Buat pembayaran tambahan
                PTambahan::create([
                    'jenis_pembayaran_id' => $ptId,
                    'periode_id' => $periodeAktif ? $periodeAktif->id : null,
                    'siswa_id' => $siswa->id,
                    'harga' => $jenisPembayaran->harga,
                   
                ]);
            }

            DB::commit();

            return redirect()
                ->to(route('kelola-pembayaran.index', ['nis' => $siswa->nis]) . '#tambahan')
                ->with('success', 'Pembayaran tambahan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan pembayaran: ' . $e->getMessage());
        }
    }
}
