<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rekapitulasi Data') }}
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

    <div class="bg-white rounded-lg text-gray-900 dark:text-gray-100">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 ">
            <div class="flex items-center justify-between">
                <div class="pb-4 bg-white dark:bg-gray-900">
                    <label for="tabl</div>e-search" class="sr-only">Search</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 rtl:inset-r-</div>0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text</div>-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="table-search" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
                        <form id="filterForm" method="GET" action="{{ route('rekap.index') }}" class="flex items-center space-x-2">
                            <select id="tahunajaran" name="tahunajaran" onchange="document.getElementById('filterForm').submit()"
                                class="block w-48 mt-2 ps-2 py-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 
                                focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach($tahunAjarans as $tahun)
                                <option value="{{ $tahun->id }}" {{ request('tahunajaran') == $tahun->id ? 'selected' : '' }}>
                                    {{ $tahun->nama }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                </div>

            </div>

            <table class="w-full mt-2 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">No</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">NIS</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Kelas</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">Nama Siswa</th>
                        @foreach($jenisP as $jp)
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">{{ $jp->nama }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @forelse($siswas as $no => $siswa)
                    <tr>
                        <td class="px-6 py-3 whitespace-nowrap">{{ $no + 1 }}</td>
                        <td class="px-6 py-3 whitespace-nowrap">{{ $siswa->nis }}</td>
                        <td class="px-6 py-3 whitespace-nowrap">{{ $siswa->kelas->nama }}</td>
                        <td class="px-6 py-3 whitespace-nowrap">{{ $siswa->nama }}</td>

                        @foreach($jenisP as $jp)
                        <td class="px-6 py-3 whitespace-nowrap">
                            @if($jp->tipe_pembayaran === 'bulanan')
                            @php
                            $bulanan = $siswa->pPulanan->where('jenis_pembayaran_id', $jp->id);
                            @endphp
                            {{ $bulanan->count() > 0 ? $bulanan->count() . ' bulan' : '-' }}
                            @else
                            @php
                            $tahunan = $siswa->pTahunan->firstWhere('jenis_pembayaran_id', $jp->id);
                            @endphp
                            {{ $tahunan && $tahunan->harga ? 'Rp ' . number_format($tahunan->harga, 0, ',', '.') : '-' }}
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ 3 + count($jenisP) }}" class="text-center py-4">Tidak ada data siswa.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>


        </div>
    </div>
</x-app-layout>