<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="bg-white min-h-[475px] shadow-sm sm:rounded-lg">
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4  ">
            <!-- Pendapatan Harian -->
            <div class="bg-violet-100 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600 mb-1">Pendapatan Harian</p>
                <p class="text-xl font-semibold">Rp. {{ number_format($totalHarian, 0, ',', '.') }}</p>
            </div>

            <!-- Pendapatan Keseluruhan -->
            <div class="bg-blue-100 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600 mb-1">Pendapatan Keseluruhan</p>
                <p class="text-xl font-semibold">Rp. 100 JT</p>
            </div>

            <!-- Estimasi Pendapatan -->
            <div class="bg-violet-100 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600 mb-1">Estimasi Pendapatan</p>
                <p class="text-xl font-semibold">Rp. 500 JT</p>
            </div>

            <!-- Jumlah Siswa -->
            <div class="bg-blue-100 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600 mb-1">Siswa</p>
                <p class="text-xl font-semibold">2,318</p>
            </div>
        </div>
    </div>
</x-app-layout>