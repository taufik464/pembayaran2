<!-- Modal -->
<div id="strukModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full inset-0 h-modal h-full">
    <div class="relative p-4 w-full max-w-3xl h-full md:h-auto mx-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Struk Pembayaran
                </h3>
                <button type="button" id="closeModalBtn" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6" id="strukModalBody">
                <!-- Struk dimuat via AJAX -->
            </div>
            <!-- Modal footer (optional) -->
            <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                <button id="printStrukBtn" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cetak</button>
                <button id="closeModalFooterBtn" type="button" class="text-gray-500 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-200">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.js"></script>

@if(session('showCetakStruk'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById('strukModal');
        const modalBody = document.getElementById('strukModalBody');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const closeModalFooterBtn = document.getElementById('closeModalFooterBtn');
        const printBtn = document.getElementById('printStrukBtn');

        // Fungsi buka modal
        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Fungsi tutup modal
        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modalBody.innerHTML = '';
        }

        // Fetch konten struk
        fetch("{{ route('cetak-struk', session('transaksi_id')) }}")
            .then(res => res.text())
            .then(html => {
                modalBody.innerHTML = html;
                openModal();
            });

        // Event tombol close
        closeModalBtn.addEventListener('click', closeModal);
        closeModalFooterBtn.addEventListener('click', closeModal);

        // Cetak isi modal
        printBtn.addEventListener('click', () => {
            const printContents = modalBody.innerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload(); // reload agar state kembali normal
        });

        // Tutup modal klik di luar modal konten
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    });
</script>
@endif