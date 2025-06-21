<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\Metode;
use App\Models\SiswaBulanan;
use App\Models\PBulanan;
use App\Models\PTahunan;
use App\Models\ATahunan;
use App\Models\JenisPembayaran;
use App\Models\PTambahan;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;



class TransaksiController extends Controller
{

    public function index(Request $request)
    {
        $nis = $request->input('nis');
        $siswa = null;
        $bulanan = collect();
        $tahunan = collect();
        $tambahan = collect();

        if ($nis) {
            // Ambil data siswa berdasarkan NIS
            $siswa = Siswa::with(['pembayaranBulanan' => function ($query) {
                $query->whereNull('transaksi_id')
                    ->with('jenisPembayaran');
            }])->where('nis', $nis)->first();
            if ($siswa) {
                // Ambil semua data pembayaran yang berelasi dengan siswa ini
                $bulanan = $siswa->pembayaranBulanan;

                // Jika relasi many-to-many antara siswa dan PTahunan
                // Ambil data dari relasi siswaTahunan dan pTahunan

                // Ambil data PTahunan yang belum lunas untuk siswa ini


                $tahunan = collect($siswa->pTahunan)->map(function ($pTahunan) use ($siswa) {
                    $dibayar = $siswa->aTahunan
                        ->where('tahunan_id', $pTahunan->id)
                        ->sum('nominal');

                    return (object)[
                        'id'     => (int) $pTahunan->id,
                        'nama'   => (string) data_get($pTahunan, 'jenisPembayaran.nama', '-'),
                        'tahun'  => (string) data_get($pTahunan, 'tahun.tahun', '-'),
                        'harga'  => (int) $pTahunan->harga,
                        'dibayar' => (int) $dibayar,
                        'status' => (string) ($dibayar >= $pTahunan->harga ? 'Lunas' : 'Belum Lunas'),
                    ];
                })->filter(function ($item) {
                    return $item->status === 'Belum Lunas';
                })->values();

              
                // Filter hanya tagihan yang belum lunas



                $tambahan = PTambahan::with('jenisPembayaran')
                    ->where('siswa_id', $siswa->id)
                    ->whereNull('transaksi_id')
                    ->get();

                if ($bulanan->isEmpty() && $tahunan->isEmpty() && $tambahan->isEmpty()) {
                    session()->flash('message', 'Data tanggungan tidak ada.');
                }
            }
        }

        $metode = Metode::all();
        if ($metode->isEmpty()) {
            session()->flash('message', 'Data metode pembayaran tidak ada.');
        }

        $Btambah = JenisPembayaran::where('tipe_pembayaran', 'Tambahan')->get();
        if ($Btambah->isEmpty()) {
            session()->flash('message', 'Data pembayaran tambahan tidak ada.');
        }


        return view('transaksi.index', compact('siswa', 'bulanan', 'tahunan', 'tambahan', 'Btambah', 'metode'));
    }


    public function SimpanTransaksi(request $request)
    {

        $validated = $request->validate([

            'metode_bayar' => 'required|exists:metode_bayar,id',
            'jumlah_uang' => 'required|numeric|min:0',
            'dataPembayaran' => 'required|string',
            'total_pembayaran' => 'required|numeric|min:0',
        ]);
        // Validasi jumlah uang yang dibayar


        $data = json_decode($request->dataPembayaran, true);

        DB::beginTransaction();

        try {
            // 1. Buat Transaksi
            if ($validated['jumlah_uang'] >= $validated['total_pembayaran']) {
                $transaksi = Transaksi::create([
                    'user_id' => auth('web')->id(),
                    'metode_bayar_id' => $validated['metode_bayar'],
                    'tanggal' => now(),
                    'uang_bayar' => $validated['jumlah_uang'],
                ]);
            } else {
                return redirect()->back()->with('error', 'Jumlah uang yang dibayar tidak mencukupi total pembayaran.');
            }

            // 2. Loop dan update/insert berdasarkan jenis
            foreach ($data as $item) {
                switch ($item['jenis']) {
                    case 'bulanan':
                        // Update the pivot record
                        SiswaBulanan::where('siswa_id', $item['siswaId'])
                            ->where('bulanan_id', $item['id'])
                            ->update(['transaksi_id' => $transaksi->id]);
                        break;

                    case 'tambahan':
                        PTambahan::where('id', $item['id'])->update([
                            'transaksi_id' => $transaksi->id,
                        ]);
                        break;

                    case 'tahunan':
                        ATahunan::create([
                            'siswa_id' => $item['siswaId'],
                            'tahunan_id' => $item['id'],
                            'transaksi_id' => $transaksi->id,
                            'nominal' => $item['harga'],
                        ]);
                        break;
                }
            }

            DB::commit();

            return redirect()->back()->with([
                'success' => 'Pembayaran berhasil disimpan.',
                'showCetakStruk' => true,
                'transaksi_id' => $transaksi->id,
                'dataPembayaran' => $request->dataPembayaran,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server ' . $e->getMessage());
        }
    }
}
