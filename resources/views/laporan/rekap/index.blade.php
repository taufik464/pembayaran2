<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rekapitulasi Data Pembayaran') }}
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
                        <a href="{{ route('rekap.index') }}" class="ms-1 text-xs font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                            Rekap Pembayaran
                        </a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto ">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Filter Section -->
                    <form method="GET" action="{{ route('rekap.index') }}" class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                        <!-- Search Input -->
                        <div class="w-full md:w-auto">
                            <label for="table-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" id="table-search" name="search" value="{{ request('search') }}" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full md:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari siswa...">
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                            <!-- Kelas Filter -->
                            <select id="angkatan" name="angkatan"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-2x1 p-2"
                                onchange="this.form.submit()">
                                <option value="">Semua Kelas</option>
                                @foreach($angkatans as $a)
                                <option value="{{ $a->id }}" {{ $selectedKelas == $a->id ? 'selected' : '' }}>
                                    Kelas {{ $a->nama }}
                                </option>
                                @endforeach
                            </select>
                            <!-- Tahun Ajaran Filter -->
                            <select id="tahunajaran" name="tahunajaran"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                                onchange="this.form.submit()">

                                @foreach($tahunAjarans as $tahun)
                                <option value="{{ $tahun->id }}" {{ $selectedTahun == $tahun->id ? 'selected' : '' }}>
                                    {{ $tahun->tahun_awal }}/{{ $tahun->tahun_akhir }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @if(request('angkatan') && request('tahunajaran'))
                        <a href="{{ route('export.rekap', [
        'angkatan' => request('angkatan'),
        'tahunajaran' => request('tahunajaran')
    ]) }}" class="bg-green-600 text-white px-4 py-2 rounded inline-flex items-center">
                            <i class="fas fa-file-excel mr-2"></i> Export Excel
                        </a>
                        @else
                        <button class="bg-gray-400 text-white px-4 py-2 rounded inline-flex items-center cursor-not-allowed" disabled>
                            <i class="fas fa-file-excel mr-2"></i> Export Excel
                        </button>
                        <p class="text-sm text-gray-500 mt-1">Pilih kelas dan tahun ajaran terlebih dahulu</p>
                        @endif
                    </form>


                    <!-- Table Section -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">NIS</th>
                                    <th scope="col" class="px-6 py-3">Kelas</th>
                                    <th scope="col" class="px-6 py-3">Nama Siswa</th>
                                    @foreach($jenisP as $jp)
                                    <th scope="col" class="px-6 py-3 text-center">{{ $jp->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$bothFiltersSelected)
                                <tr class="bg-white border-b not-found-row">
                                    <td colspan="{{ 4 + count($jenisP) }}" class="px-6 py-4 text-center">
                                        <div class="p-4 text-sm text-gray-800 rounded-lg bg-blue-50">
                                            Silakan pilih <strong>kelas</strong> dan <strong>tahun ajaran</strong> untuk melihat data.
                                        </div>
                                    </td>
                                </tr>
                                @else
                                @forelse($dataSiswa as $index => $siswa)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $siswa['nis'] }}</td>
                                    <td class="px-6 py-4">{{ $siswa['kelas'] }}</td>
                                    <td class="px-6 py-4">{{ $siswa['nama'] }}</td>

                                    @foreach($jenisP as $jp)
                                    <td class="px-6 py-4 text-center">
                                        @php
                                        $pembayaran = $siswa['pembayaran'][$jp->id] ?? null;
                                        @endphp

                                        @if($pembayaran)
                                        @if(isset($pembayaran['is_tambahan']))
                                        {{-- Khusus Pembayaran Tambahan --}}
                                        @if($pembayaran['dibayar'] > 0)
                                        <span class="text-green-600 font-medium">
                                            {{ number_format($pembayaran['dibayar'], 0, ',', '.') }}
                                        </span>
                                        @else
                                        {{-- Tidak mungkin masuk sini karena sudah difilter di controller --}}
                                        <span class="text-gray-400">-</span>
                                        @endif
                                        @else
                                        {{-- Pembayaran Bulanan/Tahunan --}}
                                        @if($pembayaran['dibayar'] > 0)
                                        @if($pembayaran['dibayar'] >= $pembayaran['total_tagihan'])
                                        <span class="text-green-600 font-medium">
                                            {{ number_format($pembayaran['dibayar'], 0, ',', '.') }}
                                        </span>
                                        @else
                                        <span class="text-red-500 font-medium">
                                            {{ number_format($pembayaran['dibayar'], 0, ',', '.') }}
                                        </span>
                                        @endif
                                        @else
                                        <span class="text-red-500">0</span>
                                        @endif
                                        @endif
                                        @else
                                        <span class="text-gray-400">X</span>
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @empty
                                <tr class="bg-white border-b not-found-row">
                                    <td colspan="{{ 4 + count($jenisP) }}" class="px-6 py-4 text-center">
                                        <div class="p-4 text-sm text-gray-800 rounded-lg bg-gray-50">
                                            Tidak ada data siswa yang ditemukan untuk filter yang dipilih.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Info Legend -->
                    <div class="mt-4 flex flex-wrap gap-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                            <span>Sudah Lunas</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                            <span>Belum Lunas</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 bg-gray-400 rounded-full mr-2"></span>
                            <span>Tidak Ada Tanggungan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('table-search');
            const form = document.querySelector('form');

            if (searchInput && form) {
                // Search functionality
                searchInput.addEventListener('input', function() {
                    const searchValue = this.value.toLowerCase();
                    const rows = document.querySelectorAll('tbody tr:not(.not-found-row)');
                    let visible = 0;

                    rows.forEach(row => {
                        const nis = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                        const nama = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';

                        if (nis.includes(searchValue) || nama.includes(searchValue)) {
                            row.style.display = '';
                            visible++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Show/hide not found message
                    const notFoundRows = document.querySelectorAll('.not-found-row');
                    notFoundRows.forEach(row => {
                        if (visible === 0 && searchValue.length > 0) {
                            row.style.display = '';
                            const div = row.querySelector('div');
                            if (div) div.textContent = 'Tidak ada data siswa yang cocok dengan pencarian.';
                        } else if (visible === 0) {
                            row.style.display = '';
                            const div = row.querySelector('div');
                            if (div) div.textContent = 'Tidak ada data siswa yang ditemukan untuk filter yang dipilih.';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });

                // Form validation
                form.addEventListener('submit', function(e) {
                    const kelas = document.getElementById('angkatan')?.value;
                    const tahun = document.getElementById('tahunajaran')?.value;

                    if (!kelas || !tahun) {
                        e.preventDefault();
                        alert('Silakan pilih kelas dan tahun ajaran terlebih dahulu!');
                    }
                });
            }
        });

        function exportToExcel() {
            // Ambil elemen tabel
            const table = document.querySelector('table');

            // Konversi tabel ke workbook
            const workbook = XLSX.utils.table_to_book(table);

            // Generate nama file
            const kelas = document.getElementById('angkatan')?.options[document.getElementById('angkatan').selectedIndex]?.text || 'SemuaKelas';
            const tahun = document.getElementById('tahunajaran')?.options[document.getElementById('tahunajaran').selectedIndex]?.text || 'SemuaTahun';
            const fileName = `Rekap_Pembayaran_${kelas}_${tahun}.xlsx`;

            // Export ke file Excel
            XLSX.writeFile(workbook, fileName);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    @endpush

</x-app-layout>