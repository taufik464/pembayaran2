<?php

namespace App\Http\Controllers\aturPembayaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Kelas;
use App\Models\PBulanan;
use App\Models\JenisPembayaran;
use App\Models\periode;
use App\Models\Siswa;
use App\Models\SiswaBulanan;
use Illuminate\Http\Request;

class SettingBulananController extends Controller
{
    public function index()
    {

        $pembayaran = JenisPembayaran::where('tipe_pembayaran', 'Bulanan')->get();
        $tahun = periode::all();
        $bulan = [
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
           
        ];

        // Kelas bisa kamu filter jika perlu berdasarkan tahun ajaran
      
        $kelas = Kelas::where('status', 'aktif')->get();
        $angkatan = Kelas::where('status',  'aktif')->select('tingkatan')->distinct()->pluck('tingkatan');
        return view('atur_pembayaran.setting_pembayaran.S_Bulanan', compact('pembayaran', 'kelas', 'bulan', 'angkatan', 'tahun'));
    }

    public function getByNis(Request $request)
    {
        $nis = $request->query('nis');

        $siswa = Siswa::where('nis', $nis)->first();

        if (!$siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        return response()->json(['nama' => $siswa->nama]);
    }

    // Simpan tarif tiap bulan per kelas
    public function store(Request $request)
    {
        $request->validate([
            'jenis_pembayaran' => 'required|exists:jenis_pembayarans,id',
            'kelas_or_angkatan' => 'required',
            'tahun' => 'required|exists:periodes,id',
            'bulan' => 'required|array',
            'nominal' => 'required|array',
            'nis' => 'nullable|string', // NIS bisa diisi atau tidak
        ]);

        $kelasIds = $this->getKelasIds($request->kelas_or_angkatan);
        $siswaList = $this->getSiswaList($kelasIds, $request->nis);

        if ($siswaList->isEmpty()) {
            return back()->withErrors(['Tidak ada siswa ditemukan untuk pilihan tersebut.']);
        }

        $duplikat = [];

        foreach ($siswaList as $siswa) {
            foreach ($request->bulan as $index => $bulan) {
                $nominal = $request->nominal[$index] ?? 0;

                if ($nominal <= 0) continue;

                // Cek apakah sudah ada relasi yang sama
                $existing = SiswaBulanan::where('siswa_id', $siswa->nis)
                    ->whereHas('bulanan', function ($q) use ($request, $bulan) {
                        $q->where('jenis_pembayaran_id', $request->jenis_pembayaran)
                            ->where('tahun_id', $request->tahun)
                            ->where('bulan', $bulan);
                    })
                    ->exists();

                if ($existing) {
                    $duplikat[] = "NIS {$siswa->nis} untuk bulan {$bulan}";
                    continue;
                }

                // Buat atau dapatkan record PBulanan
                $bulanan = PBulanan::firstOrCreate([
                    'jenis_pembayaran_id' => $request->jenis_pembayaran,
                    'tahun_id' => $request->tahun,
                    'bulan' => $bulan,
                    'harga' => $nominal,
                ]);

                // Buat record pivot
                SiswaBulanan::create([
                    'siswa_id' => $siswa->id,
                    'bulanan_id' => $bulanan->id,
                    // 'transaksi_id' bisa null jika belum dibayar
                ]);
            }
        }

        // Jika ada data duplikat, kembalikan ke form dengan error
        if (!empty($duplikat)) {
            return back()->withErrors([
                'duplicate' => 'Beberapa data gagal disimpan karena sudah ada: ' . implode(', ', $duplikat),
            ]);
        }

        return redirect()->route('jenis-pembayaran.index')->with('success', 'Data  berhasil disimpan.');
    }

    /**
     * Mengambil siswa dari banyak kelas
     */
    private function getSiswaList($kelasIds, $nis = null)
    {
        $query = Siswa::whereIn('kelas_id', $kelasIds);

        if ($nis) {
            $query->where('nis', $nis);
        }

        return $query->get();
    }

    private function getKelasIds($pilihan)
    {
        if ($pilihan === 'all') {
            return Kelas::pluck('id')->toArray();
        } elseif (Str::startsWith($pilihan, 'angkatan_')) {
            $angkatan = Str::replaceFirst('angkatan_', '', $pilihan);
            return Kelas::where('tingkatan', $angkatan)->pluck('id')->toArray();
        } elseif (Str::startsWith($pilihan, 'kelas_')) {
            return [Str::replaceFirst('kelas_', '', $pilihan)];
        }

        return [];
    }


    /* public function show($nis)
    {

        // Cari semua pembayaran bulanan untuk siswa dengan nis tertentu
        $bulanan = PBulanan::with(['siswa.kelas', 'jenisPembayaran', 'bulan'])
            ->where('siswa_id', $nis)          // filter berdasarkan kolom nis di tabel p_bulanan
            ->get();

        // Jika tidak ada data, tampilkan 404
        if ($bulanan->isEmpty()) {
            abort(404, 'Data pembayaran bulanan untuk NIS ' . $nis . ' tidak ditemukan.');
        }

        // Kirim collection $bulanan ke view
        return view('atur_pembayaran.p_bulanan.tabel', compact('bulanan', 'nis'));
    }

    /*public function edit($id)
    {
        $settingBulanan = PBulanan::findOrFail($id);
        $pembayaran = JenisPembayaran::with('periode')->findOrFail($settingBulanan->jenis_pembayaran_id);
        $bulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
        $kelas = Kelas::all();

        return view('atur_pembayaransetting_pembayaran.edit_S_Bulanan', compact('settingBulanan', 'pembayaran', 'kelas', 'bulan'));
    }*/
    /*public function update(Request $request, $id)
    {
        // Validasi input request
        $request->validate([
            'jenis_pembayaran' => 'required|exists:jenis_pembayarans,id',
            'kelas_id' => 'required',
            'bulan' => 'required|array',
            'nominal' => 'required|array',
        ]);

        // Ambil daftar bulan dan nominal dari request
        $bulanList = $request->bulan;
        $nominalList = $request->nominal;

        // Pastikan jumlah bulan dan nominal sesuai
        if (count($bulanList) !== count($nominalList)) {
            return back()->withErrors(['Data bulan dan nominal tidak sesuai.']);
        }

        // Ambil daftar siswa berdasarkan kelas yang dipilih
        $siswaList = $this->getSiswaList($request->kelas_id);

        if (!$siswaList) {
            return back()->withErrors(['Kelas tidak ditemukan atau tidak ada siswa dalam kelas tersebut.']);
        }

        // Update data ke PBulanan untuk setiap siswa dan bulan
        foreach ($siswaList as $siswa) {
            // Pastikan siswa memiliki NIS
            if (!$siswa->nis) {
                return back()->withErrors(['Siswa dengan NIS ' . $siswa->nis . ' tidak ditemukan.']);
            }

            foreach ($bulanList as $index => $bulan) {
                $nominal = $nominalList[$index] ?? 0;

                // Skip jika nominal tidak valid (<= 0)
                if ($nominal <= 0) {
                    continue;
                }

                // Cek apakah pembayaran sudah ada untuk siswa, jenis pembayaran, dan bulan yang sama
                $existingPayment = PBulanan::where('siswa_id', $siswa->nis)
                    ->where('jenis_pembayaran_id', $request->jenis_pembayaran)
                    ->where('bulan', $bulan)
                    ->first();

                // Jika sudah ada, lewati penyimpanan data ini
                if ($existingPayment) {
                    return back()->withErrors(['Siswa dengan NIS ' . $siswa->nis . ' sudah memiliki pembayaran untuk bulan ini dengan jenis pembayaran yang sama.']);
                }

                // Update data pembayaran bulanan ke PBulanan
                PBulanan::updateOrCreate(
                    [
                        'siswa_id'
                        => $siswa->nis, // Gunakan NIS sebagai ID
                        'jenis_pembayaran_id' => $request->jenis_pembayaran,
                        'bulan' => $bulan,
                    ],
                    [
                        'harga' => $nominal,
                    ]
                );
            }
        }
        return redirect()->route('jenis-pembayaran.index')
            ->with('success', 'Data setting bulanan berhasil diubah.');
    }*/
    /*public function destroy($nis, $id)
    {
        $bulanan = PBulanan::findOrFail($id);

        // Cek status lunas (misalnya id_transaksi tidak null)
        if ($bulanan->status === 'Lunas') {
            return redirect()->route('setting-bulanan.show', ['nis' => $nis])
                ->with('error', 'Data tidak bisa dihapus karena sudah lunas.');
        }

        $bulanan->delete();

        return redirect()->route('setting-bulanan.show', ['nis' => $nis])
            ->with('success', 'Data setting bulanan berhasil dihapus.');
    }*/
}
