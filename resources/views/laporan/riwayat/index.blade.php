<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Data Riwayat Transaksi') }}
        </h2>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse mt-1">
                <li class="inline-flex items-center">
                    <a href="/dashboard" class="inline-flex items-center text-xs font-medium text-gray-700 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 dark:text-gray-300 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('riwayat.index') }}" class="ms-1 text-xs font-medium text-gray-700 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 md:ms-2">Riwayat Transaksi</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto ">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="flex items-center justify-between pb-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" id="search-input" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari transaksi...">
                            </div>
                        </div>

                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-3 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Nama Siswa</th>
                                    <th scope="col" class="px-6 py-3">Total Pembayaran</th>
                                    <th scope="col" class="px-6 py-3">Metode Bayar</th>
                                    <th scope="col" class="px-6 py-3">Jumlah Uang</th>
                                    <th scope="col" class="px-6 py-3">Kembalian</th>
                                    <th scope="col" class="px-6 py-3">Staff</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $index => $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['tanggal'] }}</td>
                                    <td class="px-6 py-4">

                                        {{ $item['nama_siswa'] }}

                                    </td>
                                    <td class="px-6 py-4">Rp {{ number_format($item['total_pembayaran'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">{{ $item['metode_pembayaran'] }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($item['jumlah_uang'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($item['kembalian'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">{{ $item['staff'] }}</td>
                                    <td class="px-2 py-2 relative" x-data="{ open: false }">
                                        <button @click="open = !open" class="text-gray-600 hover:text-black focus:outline-none">
                                            &#8942; <!-- Tiga titik vertikal -->
                                        </button>

                                        <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-36 bg-white border rounded shadow-md">
                                            <button onclick="showDetail('{{ $index }}')" class="w-full text-left block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">
                                                Detail
                                            </button>
                                            <button class="w-full text-left block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">
                                                Cetak Struk
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="detail-{{ $index }}" class="hidden bg-gray-50 dark:bg-gray-700">
                                    <td colspan="9" class="px-6 py-4">
                                        <div class="mb-2 font-semibold">Detail Pembayaran:</div>
                                        @foreach($item['detail_pembayaran'] as $detail)
                                        <div class="mb-1 pl-4">
                                            • {{ $detail['jenis'] }} - {{ $detail['nama'] }}:
                                            <span class="font-semibold">Rp {{ number_format($detail['jumlah'], 0, ',', '.') }}</span>
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center">Tidak ada data transaksi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Search functionality yang lebih robust
        document.getElementById('search-input').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('tbody tr.bg-white, tbody tr.bg-gray-50');

            rows.forEach(row => {
                const isDetailRow = row.id.startsWith('detail-');
                const text = row.textContent.toLowerCase();
                const shouldShow = text.includes(searchValue);

                // Handle both main rows and detail rows
                if (shouldShow) {
                    row.style.display = '';
                    // Jika ini adalah row utama, pastikan detail row terkait juga ditampilkan jika sedang terbuka
                    if (!isDetailRow) {
                        const detailRow = row.nextElementSibling;
                        if (detailRow && detailRow.classList.contains('bg-gray-50') && !detailRow.classList.contains('hidden')) {
                            detailRow.style.display = '';
                        }
                    }
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Show/hide detail dengan animasi
        function showDetail(index) {
            try {
                const detailRow = document.getElementById(`detail-${index}`);
                if (!detailRow) {
                    console.error(`Detail row with ID detail-${index} not found`);
                    return;
                }

                // Toggle dengan animasi
                if (detailRow.classList.contains('hidden')) {
                    detailRow.classList.remove('hidden');
                    detailRow.style.display = '';
                    detailRow.animate(
                        [{
                            opacity: 0
                        }, {
                            opacity: 1
                        }], {
                            duration: 200,
                            easing: 'ease-in-out'
                        }
                    );
                } else {
                    detailRow.animate(
                        [{
                            opacity: 1
                        }, {
                            opacity: 0
                        }], {
                            duration: 200,
                            easing: 'ease-in-out'
                        }
                    ).onfinish = () => {
                        detailRow.classList.add('hidden');
                    };
                }
            } catch (error) {
                console.error('Error in showDetail:', error);
            }
        }
    </script>
    @endpush
</x-app-layout>