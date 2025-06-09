<div id="paymentModal" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden flex justify-center items-center bg-black bg-opacity-50">
    <div class="relative w-full max-w-md p-4">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <div class="flex items-center bg-primary justify-between p-1 md:p-3 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-lg font-semibold text-white dark:text-white">
                    Bayar
                </h3>
                <button type="button" class="text-white bg-transparent hover:bg-gray-200 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="paymentModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form action="{{ route('kelola-pembayaran.simpan') }}" id="formBayar" method="POST" action="">
                @csrf
                <div class="border-t p-4">
                   
                    <input type="hidden" name="dataPembayaran" id="dataPembayaranInput">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total Pembayaran:</span>
                        <span class="totalPembayaranSpan">Rp0</span>
                        <input type="hidden" name="total_pembayaran" id="totalPembayaranInput" value="0">
                    </div>
                    <div class="mt-2">
                        <label for="metode_bayar" class="block mb-2 text-sm font-medium text-gray-700">Metode Bayar</label>
                        <select id="metode_bayar" name="metode_bayar" class="block w-full p-1 border rounded focus:ring focus:ring-blue-200">
                            <option value="">Pilih Metode</option>
                            @foreach($metode as $m)
                            <option value="{{ $m->id }}">{{ $m->nama }}</option>
                            @endforeach
                        </select>
                        <div id="metodeBayarMsg" class="text-red-500 text-sm mt-1 hidden">Metode pembayaran harus dipilih.</div>
                    </div>

                    <div class="mt-2">
                        <label for="jumlah_uang" class="block mb-2 text-sm font-medium text-gray-700">Jumlah Uang</label>
                        <input type="number" id="jumlah_uang" name="jumlah_uang" class="block w-full p-1 border rounded focus:ring focus:ring-blue-200" placeholder="Masukkan jumlah uang" min="0" required>
                        <div id="uangKurangMsg" class="text-red-500 text-sm mt-1 hidden">Uang yang diberikan kurang dari total pembayaran.</div>
                    </div>
                    <div class="flex justify-between font-bold text-lg mt-2">
                        <span>kembalian:</span>
                        <span id="kembalianSpan">Rp0</span>
                    </div>

                    <div class="flex justify-between mt-6">
                        <button data-modal-hide="biayaTambahanModal"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded">
                            Simpan Pembayaran
                        </button>
                    </div>



                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("formBayar").addEventListener("submit", function(e) {
            const input = document.getElementById("dataPembayaranInput");
            input.value = JSON.stringify(daftarPembayaran);

            // Validasi metode bayar
            const metode = document.getElementById('metode_bayar').value;
            if (!metode) {
                isValid = false;
                document.getElementById('metodeBayarMsg').classList.remove('hidden');
            } else {
                document.getElementById('metodeBayarMsg').classList.add('hidden');
            }

            // Validasi apakah uang cukup
            const jumlahUang = parseFloat(document.getElementById('jumlah_uang').value) || 0;
            const total = daftarPembayaran.reduce((sum, item) => sum + item.harga, 0);
            if (jumlahUang < total) {
                e.preventDefault(); // hentikan submit
                document.getElementById('uangKurangMsg').classList.remove('hidden');
            } else {
                document.getElementById('uangKurangMsg').classList.add('hidden');
            }
        });

        const jumlahUangInput = document.getElementById('jumlah_uang');
        const kembalianSpan = document.getElementById('kembalianSpan');
        const uangKurangMsg = document.getElementById('uangKurangMsg');

        jumlahUangInput.addEventListener('input', () => {
            const jumlahUang = parseFloat(jumlahUangInput.value) || 0;
            const total = daftarPembayaran.reduce((sum, item) => sum + item.harga, 0);
            const kembalian = jumlahUang - total;

            // Update tampilan kembalian meskipun negatif
            kembalianSpan.innerText = 'Rp' + kembalian.toLocaleString();

            // Tampilkan atau sembunyikan pesan uang kurang
            if (kembalian < 0) {
                uangKurangMsg.classList.remove('hidden');
            } else {
                uangKurangMsg.classList.add('hidden');
            }
        });
    </script>