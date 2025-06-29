@foreach($tahunan as $item)
<!-- Modal body -->
<div id="cicilanModal-{{ $item->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center bg-primary justify-between p-2 md:p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-lg font-semibold text-white dark:text-white">
                    Tambah Cicilan - {{ $item->nama }}
                </h3>
                <button type="button" class="text-white bg-transparent hover:bg-gray-200 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="cicilanModal-{{ $item->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="grid gap-4 p-4 mb-4 grid-cols-2 ">
                <div class="col-span-2">
                    <label for="sisa_tagihan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left">Sisa Tagihan</label>
                    <input type="text" id="sisa_tagihan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="Rp{{ number_format($item->harga - $item->dibayar, 0, ',', '.') }}" readonly>
                </div>
                <div class="col-span-2">
                    <label for="jumlah-{{ $item->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left">Jumlah Bayar*</label>
                    <input type="number" name="jumlah" id="jumlah-{{ $item->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan jumlah bayar" required min="1" max="{{ $item->harga - $item->dibayar }}">
                </div>
                <div class="col-span-2 flex justify-end">
                    <button type="button" onclick="
                        const jumlahBayar = document.getElementById('jumlah-{{ $item->id }}').value;
                        tambahPembayaran('{{ $item->id }}', '{{ $item->nama }}', jumlahBayar, 'tahunan', '{{ $siswa->id }}')
                    " class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" data-modal-toggle="cicilanModal-{{ $item->id }}">
                        Simpan Pembayaran
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
@endforeach