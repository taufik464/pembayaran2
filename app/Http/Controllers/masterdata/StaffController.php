<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;

class StaffController extends Controller
{
    public function index()
    {
        // Menampilkan semua data staff
        $staffs = Staff::all();
        return view('masterdata.staff.index', compact('staffs'));
    }

    public function create()
    {
        // Tampilkan form untuk menambah data staff
        return view('masterdata.staff.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nik' => 'required|string|max:20|   unique:staff,id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'no_hp' => 'nullable|string|max:20',
            'jabatan' => 'required|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (User::where('email', $validated['email'])->exists()) {
            return redirect()->back()->withErrors(['email' => 'Email sudah terdaftar.'])->withInput();
        }

        // Buat user baru terlebih dahulu
        $user = User::create([
            'username' => $validated['nik'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'staff', // Atur role sesuai kebutuhan
        ]);

       

        // Buat staff baru dan hubungkan dengan user
        Staff::create([
            'id' => $validated['nik'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'jabatan' => $validated['jabatan'],
            'user_id' => $user->id,
        ]);

        return redirect()->route('staff.index')->with('success', 'Data staff berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $staff = Staff::findOrFail($id);
        return view('masterdata.staff.show', compact('staff'));
    }

    public function edit(string $id)
    {
        $staff = Staff::findOrFail($id);
        return view('masterdata.staff.edit', compact('staff'));
    }

    public function update(Request $request, string $id)
    {
        $staff = Staff::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'no_hp' => 'nullable|string|max:20',
            'jabatan' => 'required|string|max:100',
            'user_id' => 'required|exists:users,id',
        ]);

        $staff->update($validated);

        return redirect()->route('staff.index')->with('success', 'Data staff berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Data staff berhasil dihapus.');
    }
}
