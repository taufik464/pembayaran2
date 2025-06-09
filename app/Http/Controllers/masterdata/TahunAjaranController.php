<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\periode;
class TahunAjaranController extends Controller
{
    public function index(){
        $tahunajarans = periode::all();
        return view('masterdata.tahun_ajaran.index',compact('tahunajarans'));
        }
    public function store(Request $request)
    {
        // Validate the request data
       $request->validate([
    'tahun_awal' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
    'tahun_akhir' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
]);

        

        // Create a new class
        periode::create($request->all());


        // Redirect or return a response
        return redirect()->route('tahun_ajaran.index')
            ->with('success', 'Class created successfully.');
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
