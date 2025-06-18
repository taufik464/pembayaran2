<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rekapitulasi Data') }}
        </h2>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/dashboard" class="inline-flex items-center text-xs font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-2 h-2 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('siswa.index') }}" class="ms-1 text-xs font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                            Data Kelas
                        </a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="bg-white rounded-lg text-gray-900">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <div class="pb-4">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari siswa...">
                    </div>
                </div>

                <form id="filterKelasForm" method="GET" action="{{ route('rekap.index') }}" class="flex items-center space-x-2">
                    <select id="angkatan" name="angkatan" onchange="this.form.submit()"
                        class="block w-48 p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih kelas</option>
                        @foreach($angkatans as $a)
                        @if($a)
                        <option value="{{ $a->id }}" {{ request('angkatan') == $a->id ? 'selected' : '' }}>
                            {{ $a->tingkatan }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                </form>

                <form id="filterForm" method="GET" action="{{ route('rekap.index') }}" class="flex items-center space-x-2">
                    <select id="tahunajaran" name="tahunajaran" onchange="this.form.submit()"
                        class="block w-48 p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach($tahunAjarans as $tahun)
                        <option value="{{ $tahun->id }}" {{ request('tahunajaran') == $tahun->id ? 'selected' : '' }}>
                            {{ $tahun->tahun_awal }}/{{ $tahun->tahun_akhir }}
                        </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">NO</th>
                            <th class="px-6 py-3">NIS</th>
                            <th class="px-6 py-3">KELAS</th>
                            <th class="px-6 py-3">NAMA SISWA</th>
                            @foreach($jenisP as $jp)
                            <th class="px-6 py-3">{{ strtoupper($jp->nama) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataSiswa as $no => $data)
                        @php $siswa = $data['siswa']; @endphp
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4">{{ $no + 1 }}</td>
                            <td class="px-6 py-4">{{ $siswa->nis }}</td>
                            <td class="px-6 py-4">{{ $siswa->kelas->nama ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $siswa->nama }}</td>

                            @foreach($jenisP as $jp)
                            <td class="px-6 py-4">
                                @if($jp->tipe_pembayaran === 'bulanan')
                                @php
                                $dataBulanan = $siswa->pBulanan->where('jenis_pembayaran_id', $jp->id);
                                @endphp
                                @if($dataBulanan->isEmpty())
                                X
                                @else
                                @php
                                $dibayar = $dataBulanan->whereNotNull('transaksi_id')->sum('harga');
                                @endphp
                                {{ $dibayar > 0 ? 'Rp ' . number_format($dibayar, 0, ',', '.') : 'Rp 0' }}
                                @endif

                                @elseif($jp->tipe_pembayaran === 'tahunan')
                                @php
                                $dataTahunan = $siswa->pTahunan->where('jenis_pembayaran_id', $jp->id)->first();
                                @endphp
                                {{ $dataTahunan && $dataTahunan->transaksi_id ? 'Rp ' . number_format($dataTahunan->dibayar, 0, ',', '.') : 'X' }}

                                @else
                                @php
                                $dataTambahan = $siswa->pTambahan->where('jenis_pembayaran_id', $jp->id);
                                @endphp
                                @if($dataTambahan->isEmpty())
                                X
                                @else
                                @php
                                $dibayarTambahan = $dataTambahan->whereNotNull('transaksi_id')->sum('harga');
                                @endphp
                                {{ $dibayarTambahan > 0 ? 'Rp ' . number_format($dibayarTambahan, 0, ',', '.') : 'Rp 0' }}
                                @endif
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @empty
                        <tr class="bg-white border-b">
                            <td colspan="{{ 4 + count($jenisP) }}" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data siswa yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>