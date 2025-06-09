<div id="biayaTambahanModal" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden flex justify-center items-center bg-black bg-opacity-50">
    <div class="relative w-full max-w-md p-4">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <div class=" flex items-center bg-primary justify-between p-1 md:p-3 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-lg font-semibold text-white dark:text-white">
                    Biaya Tambahan
                </h3>
                <button type="button" class="text-white bg-transparent hover:bg-gray-200 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="biayaTambahanModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form method="POST" action="{{ route('setting-tambahan.tambah') }}" class="space-y-2 px-4 py-3">

                @csrf
                @foreach ($Btambah as $bt)
                <label class="flex items-center justify-between border p-2 rounded">
                    <input type="hidden" name="siswa_id" value="{{ $siswa->nis }}">
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="pt_id[]" value="{{ $bt->id }}" class="form-checkbox text-blue-600">
                        <span>{{ $bt->nama }}</span>
                    </div>
                    <span>{{ $bt->harga }}</span>
                </label>
                @endforeach
                <div class="flex justify-between mt-6">
                    <button data-modal-hide="biayaTambahanModal"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded">
                        Tambahkan
                    </button>
                </div>
            </form>


        </div>
    </div>
</div>