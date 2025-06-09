<div id="bulanan" role="tabpanel" class="hidden">
    <h3 class="font-semibold mb-2">Pembayaran Bulanan</h3>
    <table class="w-full text-sm border">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Tahun</th>
                <th class="px-4 py-2">Nominal</th>
                <th class="px-4 py-2">Status</th>

            </tr>
        </thead>
        <tbody>
            @forelse ($bulanan as $item)
            <tr class="border-b cursor-pointer hover:bg-blue-100"
                onclick="tambahPembayaran( '{{$item->id }}', '{{ $item->jenisPembayaran->nama }} - {{ $item->nama_bulan }}', '{{ $item->harga }}', 'bulanan')">
                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-2">{{ $item->jenisPembayaran->nama }} - {{ $item->nama_bulan }}</td>
                <td class="px-4 py-2">{{ $item->tahun->tahun }}</td>
                <td class="px-4 py-2">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                <td class="px-4 py-2">{{ $item->status }}</td>

            </tr>
            @empty
            <tr class="border-b">
                <td colspan="4" class="px-4 py-2 text-center text-gray-500">Tidak ada data pembayaran bulanan.</td>
            </tr>
            @endforelse

        </tbody>
    </table>
</div>

<div id="tahunan" role="tabpanel" class="hidden">
    <h3 class="font-semibold mb-2">Pembayaran Tahunan</h3>
    @include('transaksi.cicilanTahunan')
    <table class="w-full text-sm border">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Nominal</th>
                <th class="px-4 py-2">Dibayar</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tahunan as $item)
            <tr class="border-b cursor-pointer hover:bg-blue-100" onclick="tambahPembayaran( '{{$item->id }}', '{{ $item->jenisPembayaran->nama }}', '{{ $item->harga - $item->dibayar }}', 'tahunan' )">

                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-2">{{ $item->jenisPembayaran->nama }}</td>
                <td class="px-4 py-2">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                <td class="px-4 py-2">Rp{{ number_format($item->dibayar, 0, ',', '.') }}</td>
                <td class="px-4 py-2">{{ $item->status }}</td>
                <td class="px-4 py-2">
                    <button type="button" data-modal-target="cicilanModal-{{ $item->id }}" data-modal-toggle="cicilanModal-{{ $item->id }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" onclick="event.stopPropagation()">Cicil</button>
                </td>

            </tr>
            @empty
            <td class="border-b py-6">
            <td colspan="5" class="px-4 py-6 text-center text-gray-500">Tidak ada data pembayaran tahunan.</td>
            </td>
            @endforelse

        </tbody>
    </table>
</div>

<div id="tambahan" role="tabpanel" class="hidden">
    <div class="flex items-center justify-between mb-2">
        <h3 class="font-semibold">Pembayaran Tambahan</h3>
        <button
            type="button" data-modal-target="biayaTambahanModal" data-modal-toggle="biayaTambahanModal"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-4 rounded shadow-lg">
            Tambah
        </button>
    </div>
    @include('transaksi.biayaTambahanModal')
    <table class="w-full text-sm border">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Nominal</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tambahan as $item)
            <tr class="border-b cursor-pointer hover:bg-blue-100"
                onclick="tambahPembayaran( '{{$item->id }}', '{{ $item->jenisPembayaran->nama ?? '-' }}', '{{ $item->harga }}', 'tambahan' )">
                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-2">{{ $item->jenisPembayaran->nama ?? '-'}}</td>
                <td class="px-4 py-2">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                <td class="px-4 py-2">{{ $item->status }}</td>
            </tr>
            @empty
            <tr class="border-b">
                <td colspan="4" class="px-4 py-2 text-center text-gray-500">Tidak ada data pembayaran tambahan.</td>
            </tr>
            @endforelse

        </tbody>

    </table>

</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>