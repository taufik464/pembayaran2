@if(count($siswa))
<h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight my-6">Data Siswa</h1>
<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th class="px-4 py-3 text-center">
                <input type="checkbox" id="checkAll" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
            </th>
            <th class="px-6 py-3">NIS</th>
            <th class="px-6 py-3">Kelas</th>
            <th class="px-6 py-3">Nama Siswa</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($siswa as $s)
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-4 py-3 text-center">
                <input type="checkbox" name="siswa[]" value="{{ $s->nis }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
            </td>
            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $s->nis }}</td>
            <td class="px-6 py-4">{{ $s->kelas->nama }}</td>
            <td class="px-6 py-4">{{ $s->nama }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p class="text-center text-gray-600 dark:text-gray-300 mt-4">Tidak ada siswa di kelas ini.</p>
@endif