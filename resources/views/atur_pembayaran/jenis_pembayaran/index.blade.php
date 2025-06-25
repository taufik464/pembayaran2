<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Jenis Pembayaran') }}
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
            </ol>
        </nav>
    </x-slot>

    <div class="p-6 mt-4 bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <x-search action="{{ route('jenis-pembayaran.index') }}" />
            <div class="flex items-center space-x-2">
                <a type="button" href="{{ route('setting-bulanan.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm text-center leading-tight w-fit block">
                    Setting Bulanan
                </a>
                <a type="button" href="{{ route('setting-tahunan.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm text-center leading-tight w-fit block">
                    Setting Tahunan
                </a>
                <a href="{{  route('jenis-pembayaran.create')}}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm text-center leading-tight w-fit block">Tambah Data</a>
            </div>
        </div>

        <table class="w-full text-left border border-gray-200 dark:border-gray-700 rounded">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">#</th>
                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Nama Pembayaran</th>
                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Harga</th>
                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Tipe</th>
                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jenis_pembayaran as $index => $item)
                <tr class="border-t dark:border-gray-700">
                    <td class="px-2 py-2 text-gray-900 dark:text-gray-100">{{ $loop->iteration}}</td>
                    <td class="px-2 py-2 text-gray-900 dark:text-gray-100">{{ $item->nama }}</td>
                    <td class="px-2 py-2 text-gray-900 dark:text-gray-100">{{ $item->harga }}</td>
                    <td class="px-2 py-2 text-gray-900 dark:text-gray-100">{{ $item->tipe_pembayaran }}</td>
                    <td class="px-2 py-2 relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white focus:outline-none">
                            &#8942;
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-36 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded shadow-md">
                            <a href="{{ route('jenis-pembayaran.edit', ['jenis_pembayaran' => $item->id]) }}" class="block px-4 py-2 text-sm text-blue-600 dark:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700">Edit</a>
                            <form action="{{ route('jenis-pembayaran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>