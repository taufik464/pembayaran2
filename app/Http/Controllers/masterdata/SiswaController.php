<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('kelas');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhereHas('kelas', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        $siswas = $query->latest()->paginate(15)->withQueryString();
        return view('masterdata.siswa.index', compact('siswas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('masterdata.siswa.tambah', compact('kelas'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $path = $request->file('file')->getRealPath();

        (new FastExcel)->import($path, function ($row) {
            return Siswa::updateOrCreate(
                ['nis' => $row['nis']],
                [
                    'nis' => $row['nis'],
                    'nisn' => $row['nisn'],
                    'nama' => $row['nama'],
                    'kelas_id' => $row['kelas'],
                    'no_hp' => $row['nohp'],   
                ]
            );
        });

        return back()->with('success', 'Data siswa berhasil diimpor!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nis' => 'required|string|unique:siswa',
            'nisn' => 'required|string|unique:siswa',
            'kelas_id' => 'required|exists:kelas,id',
            'no_hp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('siswa_foto', 'public');
        }

        $siswaData = $request->except('foto');
       // $user = User::create([

       //     'username' => $request->nis,
       //     'password' => bcrypt($request->nisn),
       // ]);

       // $siswaData['user_id'] = $user->id;
        $siswaData['foto'] = $fotoPath;

        Siswa::create($siswaData);

        return redirect()->route('siswa.index')->with('success', 'Siswa created successfully.');
    }

    

    public function edit($id)
    {
        // Find the siswa by ID
        $siswa = Siswa::with('kelas')->findOrFail($id);
        $kelas = Kelas::all();

        return view('masterdata.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:siswa,nis,' . $id,
            'nama' => 'required|string|max:100',
            'nisn' => 'required|string|max:20|unique:siswa,nisn,' . $id,
            'kelas_id' => 'required|exists:kelas,id',
            'no_hp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswaData = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $siswaData['foto'] = $request->file('foto')->store('siswa_foto', 'public');
        }

        $siswa->update($siswaData);

        return redirect()->route('siswa.index')->with('success', 'Siswa updated successfully.');
    }

    public function destroy($id)
    {
        // Find the siswa by ID
        $siswa = Siswa::findOrFail($id);

        // Delete the siswa
        $siswa->delete();

        // Redirect or return a response
        return redirect()->route('siswa.index')->with('success', 'Siswa deleted successfully.');
    }
}
