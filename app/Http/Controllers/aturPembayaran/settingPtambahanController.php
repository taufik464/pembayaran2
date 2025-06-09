<?php

namespace App\Http\Controllers\aturPembayaran;
use App\Http\Controllers\Controller;

use App\Models\JenisPembayaran;
use App\Models\PembayaranLain;
use App\Models\PTambahan;

use Illuminate\Http\Request;

class settingPtambahanController extends Controller
{
   

    public function store(Request $request)
    {
        // Logic to handle storing additional payment settings
        $request->validate([
            'pt_id' => ['required', 'array'],
            'pt_id.*' => ['required', 'exists:jenis_pembayarans,id'],
            'siswa_id' => 'required|exists:siswa,nis',
        ]);

        foreach ($request->pt_id as $ptId) {
            $nominal = JenisPembayaran::where('id', $ptId)
                ->where('tipe_pembayaran', 'tambahan')
                ->value('harga');

            PTambahan::create([
            'jenis_pembayaran_id' => $ptId,
            'siswa_id' => $request->siswa_id,
            'harga' => $nominal,
            ]);
        }


        // Save the additional payment setting logic here

        return redirect()->to(route('kelola-pembayaran.index', ['nis' => $request->siswa_id]) . '#tambahan')
            ->with('success', 'Setting saved successfully.');
    }
}
