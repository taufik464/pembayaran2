<x-app-layout>
    <x-slot name="header">


        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Naik Kelas') }}
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
                        <a href={{ "route('naik_kelas.index')" }} class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Naik kelas</a>
                    </div>
                </li>

            </ol>
        </nav>
    </x-slot>

    <div class="bg-white rounded-lg text-gray-50 dark:text-gray-100">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
            <form method="POST" action="{{ route('naik_kelas.simpan') }}">
                @csrf

                <div class="w-full flex items-end justify-center gap-6 mb-6">
                    {{-- Kelas Awal --}}
                    <div>
                        <label for="kelas_awal" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Kelas Awal</label>
                        <select name="kelas_awal" id="kelas_awal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 w-48 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Pilih Kelas Awal</option>
                            @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-3xl mt-6">➡️</div>

                    {{-- Kelas Tujuan --}}
                    <div>
                        <label for="kelas_tujuan" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Kelas Tujuan</label>
                        <select name="kelas_tujuan" id="kelas_tujuan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 w-48 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Pilih Kelas Tujuan</option>
                            @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">
                        Simpan
                    </button>
                </div>

                <div id="siswa-container" class="mt-6">
                   
                    {{-- AJAX akan load table siswa ke sini --}}
                </div>
            </form>
        </div>
    </div>
    @vite('resources/js/naik-kelas.js')

</x-app-layout>