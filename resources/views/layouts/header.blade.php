@php
    $headerClass = 'bg-white border-gray-200 text-gray-900 dark:bg-gray-900 dark:border-gray-700 dark:text-white';
    $logoTextClass = 'text-gray-900 dark:text-white';
    $iconClass = 'text-gray-500 hover:text-gray-900 hover:bg-gray-100 focus:ring-gray-200 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700';

    $unreadCount = $unreadCount ?? 0;
    $notifications = $notifications ?? collect([]);
@endphp

<nav class="fixed left-0 right-0 top-0 z-50 border-b transition-colors duration-300 {{ $headerClass }}">
    <div class="flex flex-wrap justify-between items-center px-4 py-2.5">

        <!-- LEFT: Toggle + Logo -->
        <div class="flex justify-start items-center">
            <!-- Mobile Sidebar Toggle -->
            <button
                data-drawer-target="drawer-navigation"
                data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="p-2 mr-2 rounded-lg cursor-pointer md:hidden focus:ring-2 {{ $iconClass }}"
            >
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Toggle sidebar</span>
            </button>

            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center mr-4">
                <div class="mr-3 p-1 bg-blue-600 rounded text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="self-center text-2xl font-semibold whitespace-nowrap {{ $logoTextClass }}">
                    Request Hub
                </span>
            </a>
        </div>

        <!-- RIGHT: Icons -->
        <div class="flex items-center lg:order-2 space-x-3">

            <!-- THEME TOGGLE -->
            <button id="theme-toggle" type="button" class="p-2 rounded-lg text-sm focus:outline-none focus:ring-4 {{ $iconClass }}">
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
            </button>

            <!-- NOTIFICATIONS -->
            <div class="relative">
                <button id="notif-btn" type="button" class="p-2 rounded-lg focus:ring-4 focus:outline-none {{ $iconClass }}">
                    <span class="sr-only">View notifications</span>
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                    </svg>
                    @if($unreadCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </button>
                <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50">
                    <div class="py-2">
                        <div class="px-4 py-2 border-b border-gray-100 bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            @forelse($notifications as $notif)
                                <a href="{{ route('notifications.read', $notif->id) }}" class="flex items-start px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                                    <div class="ml-3 w-full">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $notif->data['title'] ?? 'Notification' }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">{{ $notif->data['message'] ?? '' }}</p>
                                    </div>
                                </a>
                            @empty
                                <p class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">No new notifications</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- USER MENU (Fixed Layout) -->
            <!-- 1. Added 'relative' wrapper class here -->
            <div class="relative ml-3">
                <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" alt="user photo" />
                </button>

                <!-- 2. Added 'absolute right-0 top-8' classes here -->
                <div id="user-dropdown" class="hidden absolute right-0 top-8 z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                    <div class="py-3 px-4">
                        <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                        <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                    </div>
                    <ul class="py-1 text-gray-700 dark:text-gray-200" aria-labelledby="user-menu-button">
                        <li><a href="{{ route('profile.edit') }}" class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">My profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</nav>

<script>
    // Theme and Dropdown Logic
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            lightIcon.classList.remove('hidden');
        } else {
            darkIcon.classList.remove('hidden');
        }

        themeToggleBtn.addEventListener('click', function() {
            darkIcon.classList.toggle('hidden');
            lightIcon.classList.toggle('hidden');
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });

        // Dropdown Click Handlers
        const notifBtn = document.getElementById('notif-btn');
        const notifDropdown = document.getElementById('notif-dropdown');
        if(notifBtn && notifDropdown) {
            notifBtn.addEventListener('click', e => { e.stopPropagation(); notifDropdown.classList.toggle('hidden'); document.getElementById('user-dropdown').classList.add('hidden'); });
        }

        const userBtn = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');
        if(userBtn && userDropdown) {
            userBtn.addEventListener('click', e => { e.stopPropagation(); userDropdown.classList.toggle('hidden'); document.getElementById('notif-dropdown').classList.add('hidden'); });
        }

        document.addEventListener('click', e => {
            if (!notifBtn?.contains(e.target) && !notifDropdown?.contains(e.target)) notifDropdown?.classList.add('hidden');
            if (!userBtn?.contains(e.target) && !userDropdown?.contains(e.target)) userDropdown?.classList.add('hidden');
        });
    });
</script>
