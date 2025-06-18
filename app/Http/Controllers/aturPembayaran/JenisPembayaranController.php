<?php

namespace App\Http\Controllers\aturPembayaran;
use App\Http\Controllers\Controller;
use App\Models\JenisPembayaran;
use App\Models\Periode;
use Illuminate\Http\Request;
use App\Models\PBulanan;
use App\Models\PTahunan;

class JenisPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_pembayaran = JenisPembayaran::all();
        return view('atur_pembayaran.jenis_pembayaran.index', compact('jenis_pembayaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $tipe = ['Bulanan', 'Tahunan', 'Tambahan'];
        
        return view('atur_pembayaran.jenis_pembayaran.tambah', compact('tipe'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'harga' => 'required',

        ]);

        JenisPembayaran::create([
            'nama' => $request->nama,
            'tipe_pembayaran' => $request->tipe,
            'harga' => $request->harga,
        ]);

        return redirect()->route('jenis-pembayaran.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Ambil data jenis pembayaran beserta relasi periode-nya
        $pembayaran = JenisPembayaran::with('periode')->findOrFail($id);

        // Inisialisasi variabel collection kosong supaya selalu ada
        $bulanan = collect();
        $tahunan = collect();

        if ($pembayaran->tipe_pembayaran === 'Bulanan') {
            $bulanan = PBulanan::with(['siswa.kelas'])
                ->where('jenis_pembayaran_id', $id)
                ->get()
                ->groupBy('siswa_id')
                ->map(function ($items) {
                    $first = $items->first();
                    $semuaLunas = $items->every(fn($item) => $item->status === 'Lunas');
                    return (object) [
                        'siswa_id' => $first->siswa_id,
                        'nama' => $first->siswa->nama ?? '-',
                        'kelas' => $first->siswa->kelas->nama_kelas ?? '-',
                        'harga' => $items->sum('harga'),
                        'status' => $semuaLunas ? 'Lunas' : 'Belum Lunas',
                    ];
                })
                ->values();
        } elseif ($pembayaran->tipe_pembayaran === 'Tahunan') {
            $tahunan = PTahunan::with(['siswa.kelas'])
                ->where('jenis_pembayaran_id', $id)
                ->get();
        }

        // Kirim data ke view, termasuk bulanan dan tahunan
        return view('atur_pembayaran.jenis_pembayaran.show', compact('pembayaran', 'bulanan', 'tahunan'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisPembayaran $jenis_pembayaran)
    {
        $tipe = ['Bulanan', 'Tahunan'];
        $tahun = Periode::all();
        return view('atur_pembayaran.jenis_pembayaran.edit', compact('jenis_pembayaran', 'tipe', 'tahun'));
    }

    public function update(Request $request, JenisPembayaran $jenis_pembayaran)
    {
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'periode_id' => 'required',
        ]);

        $jenis_pembayaran->update([
            'nama' => $request->nama,
            'tipe_pembayaran' => $request->tipe,
            'periode_id' => $request->periode_id,
        ]);

        return redirect()->route('jenis-pembayaran.index')->with('success', 'Data berhasil diubah');
    }

    public function redirectSettingTarif($id)
    {
        $pembayaran = JenisPembayaran::findOrFail($id);

        if ($pembayaran->tipe_pembayaran === 'Bulanan') {
            return redirect()->route('setting-bulanan.index', 1);
        } elseif ($pembayaran->tipe_pembayaran === 'Tahunan') {
            return redirect()->route('setting-tahunan.index', $pembayaran->id);
        }

        abort(404, 'Tipe pembayaran tidak dikenali');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $jenisPembayaran = JenisPembayaran::findOrFail($id);
            $jenisPembayaran->delete();
            return redirect()->route('jenis-pembayaran.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception ) {
            return redirect()->route('jenis-pembayaran.index')->with('error', 'Gagal menghapus data');
        }
    }
}
