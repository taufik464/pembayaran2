<?php

namespace App\Http\Controllers\aturPembayaran;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\PTahunan;
use App\Models\JenisPembayaran;
use App\Models\Siswa;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingTahunanController extends Controller
{
    public function index()
    {
        // Ambil data pembayaran tahunan
        $pembayaran = JenisPembayaran::where('tipe_pembayaran', 'Tahunan')->get();

        // Ambil kelas yang aktif
        $kelas = Kelas::where('status', 'aktif')->get();

        // Ambil daftar angkatan unik dari kelas yang aktif
        $angkatan = Kelas::where('status', 'aktif')->select('tingkatan')->distinct()->pluck('tingkatan');

        // Ambil semua data tahun ajaran
        $tahun = Periode::all();

        // Kirim data ke view
        return view('atur_pembayaran.setting_pembayaran.S_Tahunan', compact('pembayaran', 'kelas', 'angkatan', 'tahun'));
    }
    public function getByNis(Request $request)
    {
        $nis = $request->query('nis');

        $siswa = Siswa::where('id', $nis)->first();

        if (!$siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        return response()->json(['nama' => $siswa->nama]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'kelas_or_angkatan' => 'required',
            'tahun' => 'required|exists:periodes,id',
            'jenis_pembayaran' => 'required|array',
            'nominal' => 'required|array',
            'nis' => 'nullable|string'
        ]);

        // Ambil data siswa berdasarkan input
        $siswaList = collect();

        if ($request->nis) {
            $siswa = Siswa::where('nis', $request->nis)->first();
            if ($siswa) {
                $siswaList->push($siswa);
            } else {
                return back()->withErrors(['nis' => 'Siswa dengan NIS tersebut tidak ditemukan.']);
            }
        } else {
            if (str_starts_with($request->kelas_or_angkatan, 'angkatan_')) {
                $angkatan = str_replace('angkatan_', '', $request->kelas_or_angkatan);
                $siswaList = Siswa::whereHas('kelas', function ($query) use ($angkatan) {
                    $query->where('tingkatan', $angkatan)->where('status', 'aktif');
                })->get();
            } elseif (str_starts_with($request->kelas_or_angkatan, 'kelas_')) {
                $kelasId = str_replace('kelas_', '', $request->kelas_or_angkatan);
                $siswaList = Siswa::where('kelas_id', $kelasId)->get();
            } elseif ($request->kelas_or_angkatan === 'all') {
                $siswaList = Siswa::whereHas('kelas', function ($query) {
                    $query->where('status', 'aktif');
                })->get();
            }
        }

        if ($siswaList->isEmpty()) {
            return back()->withErrors(['kelas_or_angkatan' => 'Tidak ada siswa yang ditemukan.']);
        }

        $sudahAda = [];
        $siswaDisimpan = [];

        DB::beginTransaction();
        try {
            foreach ($siswaList as $siswa) {
                foreach ($request->jenis_pembayaran as $index => $jenisId) {
                    $cek = PTahunan::where('siswa_id', $siswa->id)
                        ->where('tahun_id', $request->tahun)
                        ->where('jenis_pembayaran_id', $jenisId)
                        ->first();
                    if ($cek) {
                        $sudahAda[] = $siswa->nama . ' (' . $siswa->nis . ') - ' . JenisPembayaran::find($jenisId)->nama;
                        continue; // Abaikan siswa yang sudah ada
                    }
                    PTahunan::create([
                        'siswa_id' => $siswa->id,
                        'tahun_id' => $request->tahun,
                        'jenis_pembayaran_id' => $jenisId,
                        'harga' => $request->nominal[$index] ?? 0,
                    ]);
                    $siswaDisimpan[] = $siswa->nama . ' (' . $siswa->nis . ') - ' . JenisPembayaran::find($jenisId)->nama;
                }
            }
            DB::commit();

            $pesan = [];
            if (!empty($siswaDisimpan)) {
                $pesan[] = 'Pembayaran tahunan berhasil disimpan untuk: ' . implode(', ', $siswaDisimpan) . '.';
            }
            if (!empty($sudahAda)) {
                $pesan[] = 'Sudah ada pembayaran untuk: ' . implode(', ', $sudahAda) . '.';
            }
            return redirect()->route('setting-tahunan.index')->with('success', implode(' ', $pesan));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. ' . $e->getMessage()]);
        }
    }

/*
    public function destroy($id)
    {
        $pembayaran = PTahunan::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('jenis-pembayaran.index')->with('success', 'Data berhasil dihapus.');
    }
    public function edit($id)
    {
        $pembayaran = PTahunan::findOrFail($id);
        return view('staff.setting_pembayaran.edit_tahunan', compact('pembayaran'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_pembayaran_id' => 'required|exists:jenis_pembayarans,id',
            'tarif' => 'required|decimal:0,2',
        ]);

        $pembayaran = PTahunan::findOrFail($id);
        $pembayaran->update([
            'jenis_pembayaran_id' => $request->jenis_pembayaran_id,
            'harga' => $request->tarif,
        ]);

        return redirect()->route('jenis-pembayaran.index')->with('success', 'Data berhasil diubah.');
    }*/
}
