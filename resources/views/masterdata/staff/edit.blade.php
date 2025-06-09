<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Staff
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow dark:bg-gray-800">
            <form action="{{ route('staff.update', $staff->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block mb-1">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $staff->nama) }}" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $staff->email) }}" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $staff->no_hp) }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $staff->jabatan) }}" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">User ID</label>
                    <input type="number" name="user_id" value="{{ old('user_id', $staff->user_id) }}" class="w-full border p-2 rounded" required>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('staff.index') }}" class="px-4 py-2 bg-gray-300 rounded mr-2">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>