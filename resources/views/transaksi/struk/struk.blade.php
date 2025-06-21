

<div class=" bg-white text-black">
    <div class="w-[300px] border border-blue-400 p-4 text-sm font-sans">
        <div class="flex justify-center">
            <img src="{{ asset('img/logo_alhikmah.jpg') }}" alt="Application Logo" class="h-20 w-auto fill-current text-gray-800 dark:text-gray-200">
        </div>
        <h1 class="text-center font-bold text-lg">SMA AL HIKMAH MUNCAR</h1>
        <p class="text-center text-xs mb-1">Jl. KH Abdul Mannan. KM 02, Sumberberas</p>

        <div class="text-xs mt-2">
            <div class="flex justify-between">
                <span>no. tr{{ $transaksi->id }}</span>
                @if(is_null($transaksi->metodeBayar))
                <span class="text-red-500">Metode bayar tidak ditemukan</span>
                @else
                <span>{{ $transaksi->metodeBayar->nama }}</span>
                @endif
            </div>
            <div class="flex justify-end">
                <span>{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d.m.Y/H.i.s') }}</span>
            </div>
        </div>

        <hr class="my-2 border-dashed border-t border-gray-400">

        <div class="text-xs space-y-1">
            <div><span>Nama</span> : {{ optional($siswa)->nama ?? '-' }}</div>
            <div><span>NIS</span> : {{ $siswa->nis }}</div>
            <div><span>Kelas</span> : {{ $siswa->kelas->nama }}</div>
        </div>

        <hr class="my-2 border-dashed border-t border-gray-400">

        <div class="text-xs space-y-1">
            @forelse($rincian as $item)
            <div class="flex justify-between">
                <span>{{ $item['nama'] }}</span>
                <span>{{ number_format($item['harga'], 0, ',', '.') }}</span>
            </div>
            @empty
            <div class="text-center text-gray-500">Tidak ada rincian pembayaran.</div>
            @endforelse

        </div>

        <hr class="my-2 border-dashed border-t border-gray-400">

        <div class="text-xs space-y-1">
            <div class="flex justify-between font-bold">
                <span>Total</span>
                <span>{{ number_format($totalPembayaran, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Jumlah uang</span>
                <span>{{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kembalian</span>
                <span>{{ number_format($kembalian, 0, ',', '.') }}</span>
            </div>
        </div>

        <p class="text-center font-bold mt-4">-- Terima Kasih --</p>
    </div>
</div>

