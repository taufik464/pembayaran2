<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Setting Pembayaran Bulanan') }}
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
                        <a href="route('siswa.index')" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Data kelas</a>
                    </div>
                </li>

            </ol>
        </nav>
    </x-slot>

    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded-lg">
        <ul class="text-sm list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <div class="p-6 mt-4 bg-white rounded shadow">

        <form action="{{ route('setting-bulanan.store') }}" method="POST" class="w-full">
            @csrf

            <div class="flex flex-wrap gap-6">
                <!-- Kolom kiri -->
                <div class="flex flex-col w-full md:w-5/12 gap-4">
                    <div class="bg-blue-500 text-white p-3 rounded">
                        <h3 class="text-lg font-semibold">Pilih Kelas</h3>
                    </div>

                    <div class="bg-gray-100 p-4 rounded-lg">
                        <div class="mb-4">
                            <label for="jenis_pembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Bayar</label>
                            <select name="jenis_pembayaran" id="jenis_pembayaran" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" disabled selected>Pilih Pembayaran</option>
                                @foreach($pembayaran as $p)
                                <option value="{{ $p->id }}" data-harga="{{ $p->harga }}">
                                    {{ $p->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="tahun" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Ajaran</label>
                            <select name="tahun" id="tahun" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" disabled selected>Pilih Tahun Ajaran</option>

                                @foreach($tahun as $t)
                                <option value="{{ $t->id }}">
                                    {{ $t->tahun }}
                                </option>
                                @endforeach
                            </select>
                        </div>



                        <div class="mb-4">
                            <label for="small-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                            <select name="kelas_or_angkatan" id="kelas_or_angkatan" class="block  w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option disabled selected>Pilih Kelas atau Angkatan</option>
                                <option value="all">Semua Kelas</option>
                                <optgroup label="Berdasarkan Angkatan (Tingkatan)">
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
                        <h3 class="block text-lg font-semibold mb-4">Jika hanya siswa tertentu</h3>

                        <div class="mb-4">
                            <label for="nis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIS</label>
                            <input type="text" name="nis" id="nis" class="block w-full p-2 mb-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Masukkan NIS">
                        </div>

                        <div class="mb-4">
                            <label for="nama_siswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Siswa</label>
                            <input type="text" name="nama_siswa" id="nama_siswa" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Nama siswa akan muncul otomatis" readonly>
                        </div>

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
                                            $('#nama_siswa').val(response.nama);
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
                    </div>


                </div>

                <!-- Kolom kanan -->
                <div class="flex flex-col w-full md:w-6/12 gap-4">
                    <div class="bg-blue-500 text-white p-3 rounded">
                        <h3 class="text-lg font-semibold">Kolom Harga</h3>
                    </div>

                    <div class="w-full bg-gray-100 p-4 rounded-lg">
                        <label class="block text-lg font-semibold mb-4">Tarif Setiap Bulan Tidak Sama</label>

                        <div class="flex flex-col gap-3">
                            @foreach($bulan as $b)
                            <div class="flex items-center gap-4">
                                <!-- Label di kiri -->
                                <label class="w-32 text-sm font-medium">{{ $b }}</label>

                                <!-- Input di kanan -->
                                <div class="flex-1">
                                    <input type="hidden" name="bulan[]" value="{{ $loop->iteration }}">
                                    <input
                                        type="number"
                                        name="nominal[]"
                                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rp ..."
                                        step="500"
                                        @if($b=='Juli' ) id="input-juli" @endif>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-between items-center">
                <!-- Tombol Kembali (kiri) -->
                <a href="{{ route('jenis-pembayaran.index') }}"
                    class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Kembali
                </a>

                <!-- Tombol Simpan (kanan) -->
                <button type="submit"
                    class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const jenisPembayaranSelect = document.getElementById('jenis_pembayaran');
        const nominalInputs = document.querySelectorAll('input[name="nominal[]"]');

        // Saat jenis pembayaran berubah
        jenisPembayaranSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');

            if (harga) {
                nominalInputs.forEach(input => {
                    input.value = harga;
                });
            }
        });

        // Autofill semua bulan jika ENTER ditekan di input Juli
        const nominalSamaInput = document.getElementById('input-juli');
        nominalSamaInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                const value = nominalSamaInput.value;
                nominalInputs.forEach(input => {
                    input.value = value;
                });
            }
        });
    });
</script>