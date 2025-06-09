<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Pembayaran') }}
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
                        <svg class="rtl:rotate-180  w-2 h-2 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="route('kelola-pembayaran.index')" class="ms-1 text-xs font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Kelola Pembayaran</a>
                    </div>
                </li>

            </ol>
        </nav>
    </x-slot>

    <div class="flex flex-col lg:flex-row lg:gap-4">
        <div class="flex-1 flex flex-col gap-4 mb-4 lg:mb-0">
            <form method="GET" action="{{ route('kelola-pembayaran.index') }}" class="flex items-center p-2 gap-2 mi bg-white rounded-md">
                <input type="text" name="nis" class="border px-2 py-1 rounded w-60" placeholder="Masukkan NIS" value="{{ request('nis') }}">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded">Cari</button>
            </form>
            @if ($siswa)

            <!-- Informasi Siswa -->
            <div class="flex items-start gap-4 bg-white p-4 rounded shadow mt-2">
                <div class="text-6xl text-gray-600">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="flex-1">
                    <div class="mt-1 ml-1 space-y-2 text-sm text-gray-700">
                        <div class="grid grid-cols-[min-content_auto] gap-x-2">
                            <div class="font-medium min-w-[60px]">Nama</div>
                            <div>: {{ $siswa->nama }}</div>

                            <div class="font-medium min-w-[60px]">NISN</div>
                            <div>: {{ $siswa->nis }}</div>

                            <div class="font-medium min-w-[60px]">Kelas</div>
                            <div>: {{ $siswa->kelas->nama }}</div> {{-- Pastikan relasi kelas ada --}}
                        </div>

                    </div>
                </div>

            </div>


            <div class="w-full flex flex-col items-center mt-2  bg-white p-4 rounded shadow ">
                <!-- Tab Navigasi -->
                <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border border-gray-300 rounded-lg" id="custom-tabs" role="tablist" data-tabs-toggle="#tab-content" data-tabs-active-classes="bg-blue-500 text-white" data-tabs-inactive-classes="text-black hover:bg-gray-100">
                    <li class="me-2">
                        <button id="bulanan-tab" data-tabs-target="#bulanan" type="button" role="tab" class="inline-block px-6 py-2 rounded-md">Bulanan</button>
                    </li>
                    <li class="me-2">
                        <button id="tahunan-tab" data-tabs-target="#tahunan" type="button" role="tab" class="inline-block px-6 py-2 rounded-md">Tahunan</button>
                    </li>
                    <li>
                        <button id="tambahan-tab" data-tabs-target="#tambahan" type="button" role="tab" class="inline-block px-6 py-2 rounded-md">Lainnya</button>
                    </li>
                </ul>

                {{-- Konten Tab --}}
                <div id="tab-content" class="w-full mt-2 bg-white rounded shadow p-2 min-h-[220px] max-h-[300px] overflow-y-auto">
                    @include('transaksi.tabel-transaksi', [
                    'bulanan' => $bulanan,
                    'tahunan' => $tahunan,
                    'tambahan' => $tambahan,

                    ])
                </div>
            </div>

            @elseif(request('nis'))
            <!-- Pesan jika tidak ditemukan -->
            <div class="bg-white text-gray-700 px-4 py-2 rounded shadow mt-2">
                Data siswa dengan NIS <strong>{{ request('nis') }}</strong> tidak ditemukan.
            </div>
            @endif

        </div>
        <div class="w-full lg:w-3/12">
            <div class="h-400 bg-white p-4 rounded shadow  min-h-[446px] h-full  ">
                <div class="">
                    <h1 class="text-xl font-bold">Total Pembayaran</h1>
                    <h1 class="text-xl mt-1 font-bold" id="totalHarga">Rp. 0</h1>

                    <button
                        type="button"
                        onclick="prepareModalBayar()"
                        class="w-full mt-4 text-xl font-medium text-center text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-300 rounded-full text-sm px-5 py-1 me-2 mb-2"
                        data-modal-target="paymentModal"
                        data-modal-toggle="paymentModal">
                        Bayar
                    </button>

                </div>
                <div class="mt-4 ">
                    <h2 class="text-xl font-semibold mb-2">Daftar Pembayaran</h2>

                    <div id="listPembayaran" class="mb-4 max-h-[320px] overflow-y-auto"></div>

                </div>

            </div>

        </div>
    </div>

    @include('transaksi.bayar-modal')

    @if(session('showCetakStruk'))
    @include('transaksi.struk.cetak-struk-modal')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('cetakStrukModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // untuk tampilkan modal flex-center
        });
    </script>
    @endif


</x-app-layout>

<script>
    function showTab(tab) {
        document.querySelectorAll('.table-content').forEach(el => el.style.display = 'none');
        document.getElementById('table-' + tab).style.display = 'block';

        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('bg-blue-400', 'text-white', 'font-bold');
            el.classList.add('text-black');
        });
        const activeBtn = document.getElementById('btn-' + tab);
        activeBtn.classList.add('bg-blue-400', 'text-white', 'font-bold');
        activeBtn.classList.remove('text-black');
    }

    // Tampilkan tabel Bulanan default saat halaman load
    document.addEventListener('DOMContentLoaded', () => {
        showTab('bulanan');
    });


    console.log("File tambahDaftar.js loaded!");
    let daftarPembayaran = [];

    function tambahPembayaran(id, nama, harga, jenis) {
        const sudahAda = daftarPembayaran.find(item => item.id === id && item.jenis === jenis);
        if (sudahAda) {
            alert("Sudah ditambahkan!");
            return;
        }

        daftarPembayaran.push({
            id,
            nama,
            harga: parseFloat(harga),
            jenis
        });
        updateDaftarPembayaran();
    }

    function hapusPembayaran(index) {
        daftarPembayaran.splice(index, 1);
        updateDaftarPembayaran();
    }

    function updateDaftarPembayaran() {
        const container = document.getElementById("listPembayaran");
        container.innerHTML = "";

        let total = 0;

        daftarPembayaran.forEach((item, index) => {
            total += item.harga;

            const card = document.createElement("div");
            card.className = "flex justify-between items-center bg-white shadow px-4 py-2 mb-2 rounded border";

            card.innerHTML = `
      <div>
        <p class="font-semibold text-sm">${item.nama}</p>
        <p class="text-gray-700 text-sm">Rp${item.harga.toLocaleString()}</p>
      </div>
      <button onclick="hapusPembayaran(${index})" class="text-red-600 hover:text-red-800">
        <span class="text-red-600">🗑️</span>
      </button>
    `;
            container.appendChild(card);
        });

        document.getElementById("totalHarga").innerText = "Total: Rp" + total.toLocaleString();
    }

    function prepareModalBayar() {
        if (daftarPembayaran.length === 0) {
            alert("Silakan tambahkan item pembayaran terlebih dahulu.");
            return;
        }

        // (opsional) Hitung total dan tampilkan di span total
        const total = daftarPembayaran.reduce((sum, item) => sum + item.harga, 0);
        document.querySelector("#paymentModal .totalPembayaranSpan").innerText = "Rp" + total.toLocaleString();

        // Modal tetap dibuka karena ada `data-modal-toggle`
    }
</script>