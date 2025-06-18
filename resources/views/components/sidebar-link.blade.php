@props(['href' => '#', 'icon' => '', 'active' => false])


<a href="{{ $href }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-primary hover:text-white  dark:hover:bg-gray-700 group {{ $active ? 'bg-primary text-white dark:bg-primary dark:text-white' : '' }}">
    <svg class="shrink-0 w-5 h-5 transition duration-75  group-hover:text-white dark:group-hover:text-white {{ $active ? 'text-white fill-white' : 'text-gray-400 dark:text-gray-400' }}" xmlns="http://www.w3.org/2000/svg" fill="{{ $active ? 'white' : 'currentColor' }}" viewBox="0 0 20 18">
        {!! $icon !!}
    </svg>
    <span class="flex-1 ms-3 whitespace-nowrap">{{ $slot }}</span>
</a>