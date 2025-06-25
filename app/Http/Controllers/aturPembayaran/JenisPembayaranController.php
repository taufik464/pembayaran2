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
    public function index(Request $request)
    {
        $query = JenisPembayaran::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('tipe_pembayaran', 'like', '%' . $search . '%');
        }

        $jenis_pembayaran = $query->get();

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
    


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($jenis_pembayaran)
    {

        
        $jenis_pembayaran = JenisPembayaran::findOrFail($jenis_pembayaran);
       
        $tipe = ['Bulanan', 'Tahunan', 'Tambahan'];
        return view('atur_pembayaran.jenis_pembayaran.edit', compact('jenis_pembayaran', 'tipe'));
       
    }
    public function update(Request $request, JenisPembayaran $jenis_pembayaran)
    {
      
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'harga' => 'required|numeric',
           
        ]);

        $jenis_pembayaran->update([
            'nama' => $request->nama,
            'tipe_pembayaran' => $request->tipe,
            'harga' => $request->harga,
           
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
