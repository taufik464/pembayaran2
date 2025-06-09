<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Data Jenis Pembayaran') }}
        </h2>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/dashboard" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{  route('jenis-pembayaran.index')}}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Data Jenis Pembayaran</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{  route('jenis-pembayaran.edit')}}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Edit Data Jenis Pembayaran</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="p-6 mt-4 bg-white rounded-lg rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Edit Jenis Pembayaran</h2>
        <form action="{{ route('jenis-pembayaran.update', ['jenis_pembayaran' => $jenis_pembayaran->id]) }}" method="POST" class="grid gap-4 mb-4 grid-cols-2">
            @csrf
            @method('PUT')

            <div class="col-span-2">
                <label for="nama">Nama Pembayaran</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $jenis_pembayaran->nama) }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                    placeholder="Nama Pembayaran" required>
            </div>

            <div class="col-span-2">
                <label for="tipe">Tipe Pembayaran</label>
                <select name="tipe" id="tipe"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                    <option value="">-- Pilih Tipe Pembayaran --</option>
                    @foreach ($tipe as $item)
                    <option value="{{ $item }}" {{ old('tipe', $jenis_pembayaran->tipe_pembayaran) == $item ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-2">
                <label for="periode_id">Tahun Ajaran</label>
                <select name="periode_id" id="periode_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach ($tahun as $item)
                    <option value="{{ $item->id }}" {{ old('periode_id', $jenis_pembayaran->periode_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->tahun_awal }} - {{ $item->tahun_akhir }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-2 flex justify-end gap-2">
                <a href="{{ route('jenis-pembayaran.index') }}"
                    class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-sm px-5 py-2.5">Kembali</a>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-app-layout>