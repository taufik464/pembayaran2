<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Data Staff') }}
        </h2>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse mt-1">
                <li class="inline-flex items-center">
                    <a href="/dashboard" class="inline-flex items-center text-xs font-medium text-gray-700 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 dark:text-gray-300 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('staff.index') }}" class="ms-1 text-xs font-medium text-gray-700 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 md:ms-2">Data Staff</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>


    <div class="bg-white dark:bg-gray-800 rounded-lg text-gray-900 dark:text-gray-100">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 bg-white dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <x-search action="{{ route('staff.index') }}" />
                <a href="{{ route('staff.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none dark:focus:ring-green-800">
                    Tambah Data
                </a>
            </div>

            <table class="w-full mt-2 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium dark:text-white">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium dark:text-white">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium dark:text-white">
                            No Hp
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium dark:text-white">
                            Jabatan
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium dark:text-white">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staffs as $staff)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $staff->nama }}
                        </td>
                        <td class="px-6 py-3 font-medium dark:text-white">
                            {{ $staff->email }}
                        </td>
                        <td class="px-6 py-3 font-medium dark:text-white">
                            {{ $staff->no_hp }}
                        </td>
                        <td class="px-6 py-3 font-medium dark:text-white">
                            {{ $staff->jabatan }}
                        </td>
                        <td class="px-2 py-3 relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-600 dark:text-white hover:text-black dark:hover:text-white focus:outline-none">
                                &#8942;
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-36 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded shadow-md">
                                <a href="{{ route('staff.edit', $staff->id) }}" class="block px-4 py-2 text-sm text-blue-600 dark:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700">Edit</a>
                                <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">Hapus</button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>