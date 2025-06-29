@props(['active' => false])

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 dark:bg-gray-900 dark:border-gray-700 sm:translate-x-0" aria-label="Sidebar">
    <a href="{{ route('dashboard') }}" class="flex ms-2 py-3 md:me-24">
        <x-application-logo class="h-9 me-3" />
        <span class="ml-3 self-center text-ms font-semibold sm:text-2 whitespace-nowrap text-black dark:text-white">Administrasi Pembayaran</span>
    </a>
    <div class="h-full mt- px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-900">
        <ul class="space-y-2 font-medium">

            <li>
                <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                    icon="<svg class='w-5 h-5 text-gray-800 transition duration-75 group-hover:text-white dark:text-gray-400 dark:group-hover:text-white' xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 22 21'>
                    <path d=' M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z' />
                <path d='M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z' />
                </svg>">
                    {{ __('Dashboard') }}
                </x-sidebar-link>
            </li>

            <li>
                <button type="button" class="flex items-center w-full hover:text-white p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-primary dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="master-data">
                    <svg class="w-6 h-6 text-gray-800 group-hover:text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-3 8a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H9Zm2 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H9Z" clip-rule="evenodd" />
                    </svg>

                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Master Data</span>
                    <svg class="w-3 h-3 text-gray-800 grup-hover:text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="master-data" class="hidden ml-8 py-2 space-y-2">
                    <li>
                        <x-sidebar-link :href="route('staff.index')" :active="request()->routeIs('staff.index')"

                            icon="<svg class='w-6 h-6 hover:text-white text-gray-800 group-hover:text-white dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>
                            <path d='M16 10c0-.55228-.4477-1-1-1h-3v2h3c.5523 0 1-.4477 1-1Z' />
                            <path d='M13 15v-2h2c1.6569 0 3-1.3431 3-3 0-1.65685-1.3431-3-3-3h-2.256c.1658-.46917.256-.97405.256-1.5 0-.51464-.0864-1.0091-.2454-1.46967C12.8331 4.01052 12.9153 4 13 4h7c.5523 0 1 .44772 1 1v9c0 .5523-.4477 1-1 1h-2.5l1.9231 4.6154c.2124.5098-.0287 1.0953-.5385 1.3077-.5098.2124-1.0953-.0287-1.3077-.5385L15.75 16l-1.827 4.3846c-.1825.438-.6403.6776-1.0889.6018.1075-.3089.1659-.6408.1659-.9864v-2.6002L14 15h-1ZM6 5.5C6 4.11929 7.11929 3 8.5 3S11 4.11929 11 5.5 9.88071 8 8.5 8 6 6.88071 6 5.5Z' />
                            <path d='M15 11h-4v9c0 .5523-.4477 1-1 1-.55228 0-1-.4477-1-1v-4H8v4c0 .5523-.44772 1-1 1s-1-.4477-1-1v-6.6973l-1.16797 1.752c-.30635.4595-.92722.5837-1.38675.2773-.45952-.3063-.5837-.9272-.27735-1.3867l2.99228-4.48843c.09402-.14507.2246-.26423.37869-.34445.11427-.05949.24148-.09755.3763-.10887.03364-.00289.06747-.00408.10134-.00355H15c.5523 0 1 .44772 1 1 0 .5523-.4477 1-1 1Z' />
                            </svg>
                            ">
                            {{ __('Staff') }}
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link :href="route('tahun_ajaran.index')" :active="request()->routeIs('tahun_ajaran.index')"
                            icon=" <svg class='w-6 h-6 text-gray-800 group-hover:text-white dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>
                            <path fill-rule='evenodd' d='M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z' clip-rule='evenodd' />
                            </svg> ">
                            {{ __('Tahun Ajaran') }}
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link :href="route('kelas.index')" :active="request()->routeIs('kelas.index')"
                            icon=" <svg class='w-6 h-6 text-gray-800 group-hover:text-white dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>
                            <path d='M3 4.92857C3 3.90506 3.80497 3 4.88889 3H19.1111C20.195 3 21 3.90506 21 4.92857V13h-3v-2c0-.5523-.4477-1-1-1h-4c-.5523 0-1 .4477-1 1v2H3V4.92857ZM3 15v1.0714C3 17.0949 3.80497 18 4.88889 18h3.47608L7.2318 19.3598c-.35356.4243-.29624 1.0548.12804 1.4084.42428.3536 1.05484.2962 1.40841-.128L10.9684 18h2.0632l2.2002 2.6402c.3535.4242.9841.4816 1.4084.128.4242-.3536.4816-.9841.128-1.4084L15.635 18h3.4761C20.195 18 21 17.0949 21 16.0714V15H3Z' />
                            <path d='M16 12v1h-2v-1h2Z' />
                            </svg>
                            ">
                            {{ __('Kelas') }}
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link :href="route('siswa.index')" :active="request()->routeIs('siswa.index')"
                            icon=" <svg class='w-6 h-6 text-gray-800 group-hover:text-white dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>
                            <path d='M12.4472 2.10557c-.2815-.14076-.6129-.14076-.8944 0L5.90482 4.92956l.37762.11119c.01131.00333.02257.00687.03376.0106L12 6.94594l5.6808-1.89361.3927-.13363-5.6263-2.81313ZM5 10V6.74803l.70053.20628L7 7.38747V10c0 .5523-.44772 1-1 1s-1-.4477-1-1Zm3-1c0-.42413.06601-.83285.18832-1.21643l3.49538 1.16514c.2053.06842.4272.06842.6325 0l3.4955-1.16514C15.934 8.16715 16 8.57587 16 9c0 2.2091-1.7909 4-4 4-2.20914 0-4-1.7909-4-4Z' />
                            <path d='M14.2996 13.2767c.2332-.2289.5636-.3294.8847-.2692C17.379 13.4191 19 15.4884 19 17.6488v2.1525c0 1.2289-1.0315 2.1428-2.2 2.1428H7.2c-1.16849 0-2.2-.9139-2.2-2.1428v-2.1525c0-2.1409 1.59079-4.1893 3.75163-4.6288.32214-.0655.65589.0315.89274.2595l2.34883 2.2606 2.3064-2.2634Z' />
                            </svg>">
                            {{ __('Siswa') }}
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link :href="route('naik_kelas.index')" :active="request()->routeIs('naik_kelas.index')"
                            icon="
                            <svg class='w-6 h-6 group-hover:text-white transition duration-75 {{ request()->routeIs('naik_kelas.index') ? 'text-white' : 'text-gray-800 dark:text-white' }}' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
                                <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207' />
                            </svg>
                            ">
                            {{ __('Naik Kelas') }}
                        </x-sidebar-link>
                    </li>

                </ul>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-primary hover:text-white dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="pengaturan-pembayaran">
                    <svg class="w-6 h-6 text-gray-800 group-hover:text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M11 16.5a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0Zm4.5 2.5v-1.5H14v-2h1.5V14h2v1.5H19v2h-1.5V19h-2Z" clip-rule="evenodd" />
                        <path d="M3.987 4A2 2 0 0 0 2 6v9a2 2 0 0 0 2 2h5v-2H4v-5h16V6a2 2 0 0 0-2-2H3.987Z" />
                        <path fill-rule="evenodd" d="M5 12a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Z" clip-rule="evenodd" />
                    </svg>
                    <span class="flex-1 ms-3 hover:text-white text-left rtl:text-right whitespace-nowrap hover:text-white">Atur Pembayaran</span>
                    <svg class="w-3 h-3 text-gray-800 dark:text-white grup-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="pengaturan-pembayaran" class="hidden ml-8 py-2 space-y-2">
                    <li>
                        <x-sidebar-link :href="route('jenis-pembayaran.index')" :active="request()->routeIs('jenis-pembayaran.index')"
                            icon=" <svg class='w-6 h-6 text-gray-800 group-hover:text-white dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>
                            <path d='M3 5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5Zm2 0v14h14V5H5Zm2 3h10v2H7V8Zm0 4h10v2H7v-2Zm0 4h6v2H7v-2Z' />
                            </svg>
                            ">
                            {{ __('Jenis pembayaran') }}
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link :href="route('metode.index')" :active="request()->routeIs('metode.index')"
                            icon=" <svg class='w-6 h-6 group-hover:text-white text-gray-800 dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
                            <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2' />
                            </svg>
                            ">
                            {{ __('Metode Bayar') }}
                        </x-sidebar-link>
                    </li>

                </ul>
            </li>
            <li>
                <x-sidebar-link :href="route('kelola-pembayaran.index')" :active="request()->routeIs('kelola-pembayaran.index')"
                    icon=" <svg class='w-6 h-6 group-hover:text-white text-gray-800 dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>
                    <path fill-rule='evenodd' d='M4 5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H4Zm0 6h16v6H4v-6Z' clip-rule='evenodd' />
                    <path fill-rule='evenodd' d='M5 14a1 1 0 0 1 1-1h2a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Zm5 0a1 1 0 0 1 1-1h5a1 1 0 1 1 0 2h-5a1 1 0 0 1-1-1Z' clip-rule='evenodd' />
                    </svg>">
                    {{ __('Pembayaran') }}
                </x-sidebar-link>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base hover:text-white text-gray-900 transition duration-75 rounded-lg group hover:bg-primary dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="laporan">
                    <svg class="w-6 h-6 text-gray-800 group-hover:text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z" clip-rule="evenodd" />
                    </svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Laporan</span>
                    <svg class="w-3 h-3 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="laporan" class="hidden py-2 space-y-2 ml-8" x-data="{ isOpen: $persist(false).as('laporanMenuState') }" :class="{ 'hidden': !isOpen }">
                    <li>
                        <x-sidebar-link :href="route('riwayat.index')" :active="request()->routeIs('riwayat.index')" @click="isOpen = true"
                            icon=" <svg class='w-6 h-6 text-gray-800 group-hover:text-white dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>
                            <path fill-rule='evenodd' d='M9 2a1 1 0 0 0-1 1H6a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-2a1 1 0 0 0-1-1H9Zm1 2h4v2h1a1 1 0 1 1 0 2H9a1 1 0 0 1 0-2h1V4Zm5.707 8.707a1 1 0 0 0-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z' clip-rule='evenodd' />
                            </svg>
                            ">
                            {{ __('Riwayat Transaksi') }}
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link :href="route('rekap.index')" :active="request()->routeIs('rekap.index')" @click="isOpen = true"
                            icon=" <svg class='w-6 h-6 text-gray-800 group-hover:text-white dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
                            <path stroke='currentColor' stroke-width='2' d='M3 11h18M3 15h18M8 10.792V19m4-8.208V19m4-8.208V19M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z' />
                            </svg>
                            ">
                            {{ __('Rekapitulasi data') }}
                        </x-sidebar-link>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</aside>