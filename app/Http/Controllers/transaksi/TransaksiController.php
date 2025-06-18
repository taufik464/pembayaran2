<?php

namespace App\Http\Controllers\transaksi;
use App\Http\Controllers\Controller;
use App\Models\Metode;
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
            $siswa = Siswa::where('nis', $nis)->first();

            if ($siswa) {
                // Ambil semua data pembayaran yang berelasi dengan siswa ini
                $bulanan = PBulanan::with('jenisPembayaran')
                    ->where('siswa_id', $siswa->id)
                    ->whereNull('transaksi_id')
                    ->get();

                $listtahunan = PTahunan::with('jenisPembayaran')
                    ->where('siswa_id', $siswa->id)
                    ->get();
                $tahunan = $listtahunan->filter(function ($item) {
                    return $item->status != 'Lunas';
                });

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
            if ($item['jenis'] === 'bulanan') {
                PBulanan::where('id', $item['id'])->update([
                'transaksi_id' => $transaksi->id,
                ]);
            } elseif ($item['jenis'] === 'tambahan') {
                PTambahan::where('id', $item['id'])->update([
                'transaksi_id' => $transaksi->id,
                ]);
            } elseif ($item['jenis'] === 'tahunan') {
                ATahunan::create([
                'tahunan_id' => $item['id'],
                'transaksi_id' => $transaksi->id,
                'nominal' => $item['harga'],
                ]);
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
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server ' );
        }
    }
}
