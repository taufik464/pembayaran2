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
                        <svg class="w-3 h-3 me-2.5" ...>...</svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" ...>...</svg>
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
                    <select name="kelas_or_angkatan" id="kelas_or_angkatan" class="...">
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
                    <select name="tahun" id="tahun" class="..." required>
                        <option value="" disabled selected>Pilih Tahun Ajaran</option>
                        @foreach($tahun as $t)
                        <option value="{{ $t->id }}">{{ $t->tahun }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- NIS -->
                <div class="flex flex-col w-full md:w-2/12 gap-2 justify-end">
                    <label for="nis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        NIS <span class="text-[10px] text-gray-500 font-normal ml-1">(Siswa tertentu)</span>
                    </label>
                    <input type="text" name="nis" id="nis" class="..." placeholder="Masukkan NIS">
                </div>

                <!-- Nama Siswa -->
                <div class="flex flex-col w-full md:w-3/12 gap-2">
                    <label for="nama_siswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Siswa</label>
                    <input type="text" name="nama_siswa" id="nama_siswa" class="..." placeholder="Nama siswa" readonly>
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
                                <input type="text" name="nominal[]" value="{{ $p->harga }}" class="...">
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