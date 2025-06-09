<div id="editKelasModal-{{ $kelas->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative  p-4 w-120 max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class=" flex items-center bg-primary justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-lg font-semibold text-white dark:text-white">
                    Edit Data Kelas
                </h3>
                <button type="button" class="text-white bg-transparent hover:bg-gray-200 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="editKelasModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <form action="{{ route('kelas.update', $kelas->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left">Nama</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $kelas->nama) }}" class="uppercase bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama Kelas" required oninput="this.value = this.value.toUpperCase();">
                            @error('nama')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <label for="tingkatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left">Tingkatan</label>
                            <input type="text" name="tingkatan" id="tingkatan" value="{{ old('tingkatan', $kelas->tingkatan) }}" class="uppercase bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tingkatan kelas" required oninput="this.value = this.value.toUpperCase();">
                            @error('tingkatan')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left">Status</label>
                            <div class="flex space-x-6">
                                <div class="flex items-center">
                                    <input id="radio-aktif" type="radio" value="aktif" name="status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $kelas->status == 'aktif' ? 'checked' : '' }}>
                                    <label for="radio-aktif" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 text-left">Aktif</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="radio-tidak-aktif" type="radio" value="tidak aktif" name="status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $kelas->status == 'tidak aktif' ? 'checked' : '' }}>
                                    <label for="radio-tidak-aktif" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 text-left">Tidak Aktif</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="radio-lulus" type="radio" value="lulus" name="status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $kelas->status == 'lulus' ? 'checked' : '' }}>
                                    <label for="radio-lulus" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 text-left">Lulus</label>
                                </div>
                            </div>
                            @error('status')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-2 flex justify-end">
                            <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                               
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal body -->


        </div>
    </div>
</div>