<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Setting Pembayaran Tahunan') }}
        </h2>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/dashboard" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <!-- icon home -->
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
                        <a href="{{ route('siswa.index') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Data kelas</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>


    <div class="bg-white p-4 my-4">
        <form id="formPembayaran" action="{{ route('setting-tahunan.store') }}" method="POST" class="w-full">
            @csrf

            <div class="flex flex-wrap gap-6">
                <!-- Kelas / Angkatan -->
                <div class="flex flex-col w-full md:w-3/12 gap-2">
                    <label for="kelas_or_angkatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                    <select name="kelas_or_angkatan" id="kelas_or_angkatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option disabled selected>Pilih Kelas atau Angkatan</option>
                        <option value="all">Semua Kelas</option>
                        <optgroup label="Berdasarkan Angkatan">
                            @foreach($angkatan as $a)
                            <option value="angkatan_{{ $a }}">Angkatan {{ $a }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Berdasarkan Kelas">
                            @foreach($kelas as $k)
                            <option value="kelas_{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <!-- Tahun Ajaran -->
                <div class="flex flex-col w-full md:w-3/12 gap-2">
                    <label for="tahun" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Ajaran</label>
                    <select name="tahun" id="tahun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                        <option value="" disabled selected>Pilih Tahun Ajaran</option>
                        @foreach($tahun as $t)
                        <option value="{{ $t->id }}">{{ $t->tahun }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- NIS -->
                <div class="flex flex-col w-full md:w-2/12 gap-2 justify-end">
                    <label for="nis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        NIS <span class="text-[10px] text-gray-500 font-normal ml-1">(Jika hanya satu siswa)</span>
                    </label>
                    <input type="text" name="nis" id="nis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan NIS">
                </div>

                <!-- Nama Siswa -->
                <div class="flex flex-col w-full md:w-3/12 gap-2">
                    <label for="nama_siswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Siswa</label>
                    <input type="text" name="nama_siswa" id="nama_siswa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama siswa" readonly>
                </div>

                <!-- Tombol -->
                <div class="flex items-end gap-4 mt-4">
                    <a href="{{ route('jenis-pembayaran.index') }}" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm">Kembali</a>
                    <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm">Simpan</button>
                </div>
            </div>

            <hr class="my-4 border-black">

            <!-- Tabel Pembayaran -->
            <div class="overflow-x-auto">
                <h2 class="text-lg font-semibold mb-2">Jenis Pembayaran</h2>
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <tbody>
                        @foreach($pembayaran as $p)
                        <tr class="border-b dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="text-center px-4 py-2">
                                <input type="checkbox" name="jenis_pembayaran[]" value="{{ $p->id }}">
                            </td>
                            <td class="px-4 py-2">{{ $p->nama }}</td>
                            <td class="px-4 py-2">
                                <input type="text" name="nominal[]" value="{{ $p->harga }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <!-- jQuery AJAX untuk ambil nama siswa -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#nis').on('input', function() {
            let nis = $(this).val();
            if (nis.length >= 4) {
                $.ajax({
                    url: '{{ route("siswa.getByNis") }}',
                    type: 'GET',
                    data: {
                        nis: nis
                    },
                    success: function(response) {
                        $('#nama_siswa').val(response.nama ?? 'Tidak ditemukan');
                    },
                    error: function() {
                        $('#nama_siswa').val('Siswa tidak ditemukan');
                    }
                });
            } else {
                $('#nama_siswa').val('');
            }
        });
    </script>
</x-app-layout>