<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\periode;
use Illuminate\Support\Facades\DB;


class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunajarans = periode::all();
        return view('masterdata.tahun_ajaran.index', compact('tahunajarans'));
    }
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'tahun_awal' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'tahun_akhir' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'required'
        ]);

        if ($request->status === 'aktif') {
            DB::table('periodes')->update(['status' => 'tidak aktif']);
        }


        // Create a new class
        periode::create($request->all());


        // Redirect or return a response
        return redirect()->route('tahun_ajaran.index')
            ->with('success', 'Class created successfully.');
    }

    public function edit($id)
    {
        $tahunajaran = periode::findOrFail($id);
        return view('masterdata.modal_update_tahunajaran', compact('tahunajaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_awal' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'tahun_akhir' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'required'
        ]);

        if ($request->status === 'aktif') {
            DB::table('periodes')->update(['status' => 'tidak aktif']);
        }

        $tahunajaran = periode::findOrFail($id);
        $tahunajaran->update($request->all());

        return redirect()->route('tahun_ajaran.index')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy($id)
    {
        // Find the class by ID
        $tahunajaran = periode::findOrFail($id);

        // Delete the class
        $tahunajaran->delete();

        // Redirect or return a response
        return redirect()->route('tahun_ajaran.index')
            ->with('success', 'Class deleted successfully.');
    }
}
