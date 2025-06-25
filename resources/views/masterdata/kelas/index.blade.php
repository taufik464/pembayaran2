<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Kelas') }}
        </h2>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/dashboard" class="inline-flex items-center text-xs font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-2 h-2 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="route('siswa.index')" class="ms-1 text-xs font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Data kelas</a>
                    </div>
                </li>

            </ol>
        </nav>
    </x-slot>




    <div class="bg-white rounded-lg text-gray-900 dark:bg-gray-800 dark:text-gray-100">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 ">
            <div class="flex items-center justify-between">
                <x-search action="{{ route('kelas.index') }}" />
                <button data-modal-target="tambahKelasModal" data-modal-toggle="tambahKelasModal" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none dark:focus:ring-green-800">
                    Tambah Data
                </button>
                @include('masterdata.kelas.modal_create_kelas')
            </div>
            <table class="w-full mt-2 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Angkatan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kode Kelas
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelass as $kelas)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="NIS" class="px-6 py-3 font-xs text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $loop->iteration }}
                        </th>
                        <td class="px-6 py-3">
                            {{ $kelas->nama }}
                        </td>
                        <td class="px-6 py-3">
                            {{ $kelas->tingkatan }}
                        </td>
                        <td class="px-6 py-3">
                            {{ $kelas->status }}
                        </td>
                        <td class="px-6 py-3">
                            {{ $kelas->id }}
                        </td>
                        <td class="px-2 py-2 relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-600 hover:text-black focus:outline-none">
                                &#8942; <!-- Tiga titik vertikal -->
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-36 bg-white border rounded shadow-md">
                                <button data-modal-target="editKelasModal-{{ $kelas->id }}" data-modal-toggle="editKelasModal-{{ $kelas->id }}" class="w-full text-left block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">Edit</button>


                                <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @include('masterdata.kelas.modal_update_kelas', ['kelas' => $kelas])
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>
</x-app-layout>