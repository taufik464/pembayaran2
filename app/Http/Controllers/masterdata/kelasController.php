<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class kelasController extends Controller
{
    public function DaftarKelas()
    {

        $kelass = Kelas::all();
        return view('masterdata.kelas.index', compact('kelass'));
    }

    public function create()
    {

        //
    }

    public function SimpanKelas(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nama' => 'required|string|max:255',
            'tingkatan' => 'required|string|max:255 ',
            'status' => 'required|in:aktif,tidak aktif,lulus',

        ]);

        // Create a new class
        Kelas::create($request->all());


        // Redirect or return a response
        return redirect()->route('kelas.index')
            ->with('success', 'Class created successfully.');
    }

    public function edit($id)
    {
        // Find the class by ID
        $kelas = kelas::findOrFail($id);
        return view('masterdata.kelas.modal_update_kelas', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        // Validate the request data
        $request->validate([
            'nama' => 'required|string|max:255',
            'tingkatan' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak aktif,lulus',
        ]);
        // Find the class by ID
        $kelas = kelas::findOrFail($request->id);
        // Update the class with the validated data
        $kelas->update([
            'nama' => $request->nama,
            'tingkatan' => $request->tingkatan,
            'status' => $request->status,
        ]);
        // Save the changes
        $kelas->save();
        // Redirect or return a response

        return redirect()->route('kelas.index')
            ->with('success', 'Class created successfully.');

        // Validate and update the class
        // Redirect or return a response
    }

    public function destroy($id)
    {
        // Find the class by ID
        $kelas = kelas::findOrFail($id);

        // Delete the class
        $kelas->delete();

        // Redirect or return a response
        return redirect()->route('kelas.index')
            ->with('success', 'Class deleted successfully.');
    }
}
