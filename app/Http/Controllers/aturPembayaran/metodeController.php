<?php

namespace App\Http\Controllers\aturPembayaran;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Metode;

class metodeController extends Controller
{
    public function index()
    {

        $metode = Metode::all();
        return view('atur_pembayaran.metode.index', compact('metode'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nama' => 'required|string|max:50',
        ]);

        // Create a new class
        Metode::create($request->all());


        // Redirect or return a response
        return redirect()->route('metode.index')
            ->with('success', 'Class created successfully.');
    }

    public function update(Request $request, Metode $metode)
    {
        // Validate the request data
        $request->validate([
            'nama' => 'required|string|max:50',
        ]);
        // Find the class by ID
        $metode = Metode::findOrFail($request->id);
        // Update the class with the validated data
        $metode->update([
            'nama' => $request->nama,
        ]);
        // Save the changes
        $metode->save();
        // Redirect or return a response

        return redirect()->route('metode.index')
            ->with('success', 'Class created successfully.');

    }

    public function destroy($id)
    {
        // Find the class by ID
        $metode = Metode::findOrFail($id);
        // Delete the class
        $metode->delete();
        // Redirect or return a response
        return redirect()->route('metode.index')
            ->with('success', 'Class deleted successfully.');
    }


}