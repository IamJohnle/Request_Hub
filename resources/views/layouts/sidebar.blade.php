    @php
        $isAdmin = Auth::user()->role === 'admin';

        // 1. CONTAINER CLASSES (Dynamic Light/Dark)
        // Light: White background, Gray text
        // Dark: Gray-800 background, White text
        $sidebarClass = 'bg-white border-gray-200 text-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-white';

        // 2. LINK CLASSES
        // Light: Gray text, Light Gray Hover
        // Dark: Light Gray text, Dark Gray Hover
        $linkClass = 'text-gray-700 hover:bg-gray-100 hover:text-blue-700 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white group';

        // 3. ACTIVE LINK CLASSES
        // Light: Gray-100 background, Blue text
        // Dark: Gray-700 background, White text
        $activeClass = 'bg-gray-100 text-blue-700 dark:bg-gray-700 dark:text-white';

        // 4. ICON CLASSES
        $iconClass = 'text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white';
    @endphp

    <aside
    id="drawer-navigation"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full border-r md:translate-x-0 {{ $sidebarClass }}"
    aria-label="Sidebar">

    <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">

        <!-- LOGO / HEADER -->
        <a href="{{ route('dashboard') }}" class="flex items-center pl-2.5 mb-8">
            <span class="self-center text-xl font-bold whitespace-nowrap uppercase tracking-wider text-blue-600 dark:text-white">
                {{ $isAdmin ? 'Admin' : "Employee's" }}
            </span>
        </a>

        <!-- MENU LIST -->
        <ul class="space-y-2 font-medium">

            {{-- ============================== --}}
            {{--          ADMIN MENU            --}}
            {{-- ============================== --}}
            @if($isAdmin)

                {{-- 1. Dashboard --}}
                <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? $activeClass : $linkClass }}">
                    <svg class="w-5 h-5 {{ $iconClass }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ml-3">Dashboard</span>
                </a>
                </li>

                {{-- 2. Manage Requests --}}
                <li>
                <a href="{{ route('admin.requests.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.requests.index') ? $activeClass : $linkClass }}">
                    <svg class="flex-shrink-0 w-5 h-5 {{ $iconClass }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Manage Requests</span>
                    <!-- Badge -->
                    <span class="inline-flex items-center justify-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full dark:bg-gray-700 dark:text-gray-300">New</span>
                </a>
                </li>


                {{-- 3. Reports --}}
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.reports.index') ? $activeClass : $linkClass }}">
                        <svg class="flex-shrink-0 w-5 h-5 {{ $iconClass }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12.25V1m0 11.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M12 7.5V1m0 6.5a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M20 16.9V1m0 15.9a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5"/>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Reports</span>
                    </a>
                </li>
                {{-- 4. Employees --}}
                <li>
                <a href="{{ route('admin.employees.index') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('employees.*') ? $activeClass : $linkClass }}">
                    <svg class="flex-shrink-0 w-5 h-5 {{ $iconClass }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Employees</span>
                </a>
                </li>

                {{-- 5. Notifications --}}
                <li>
                <a href="{{ route('admin.notifications.index') }}" class="flex items-center p-2 rounded-lg {{ $linkClass }}">
                    <svg class="flex-shrink-0 w-5 h-5 {{ $iconClass }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M15.133 10.632v-1.8a5.406 5.406 0 0 0-4.154-5.262.955.955 0 0 0 .021-.106V1.1a1 1 0 0 0-2 0v2.364a.955.955 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C4.867 13.018 3 13.614 3 14.807 3 15.4 3.405 16 4.56 16h10.88c1.155 0 1.56-.6 1.56-1.193 0-1.192-1.867-1.789-1.867-4.175ZM12 17a3 3 0 1 1-6 0 1 1 0 0 1 0-2h6a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Notifications</span>
                <!-- Only show the badge if there are actually alerts -->
                @if(isset($alerts) && $alerts > 0)
                    <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-200">
                        {{ $alerts }}
                    </span>
                @endif
            </a>
                </li>

                {{-- 6. Settings --}}
                <li>
                <a href="{{ route('profile.edit') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('profile.edit') ? $activeClass : $linkClass }}">
                    <svg class="flex-shrink-0 w-5 h-5 {{ $iconClass }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Settings</span>
                </a>
                </li>

            @endif


            {{-- ============================== --}}
            {{--         EMPLOYEE MENU          --}}
            {{-- ============================== --}}
            @if(! $isAdmin)

                {{-- 1. Dashboard --}}
                <li>
                <a href="{{ route('employee.dashboard') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('employee.dashboard') ? $activeClass : $linkClass }}">
                    <svg class="w-5 h-5 {{ $iconClass }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ml-3">Dashboard</span>
                </a>
                </li>

                {{-- 2. Submit Work Request --}}
                <li>
                <a href="{{ route('employee.create') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('employee.create') ? $activeClass : $linkClass }}">
                    <svg class="flex-shrink-0 w-5 h-5 {{ $iconClass }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                    <span class="ml-3">Submit Request</span>
                </a>
                </li>

                {{-- 3. My Requests / History --}}
                <li>
                <a href="{{ route('employee.history') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('employee.history') ? $activeClass : $linkClass }}">
                    <svg class="flex-shrink-0 w-5 h-5 {{ $iconClass }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">My Requests</span>
                </a>
                </li>

                {{-- 4. Profile Settings --}}
                <li>
                    <a href="{{ route('profile.edit') }}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('profile.edit') ? $activeClass : $linkClass }}">
                        <svg class="flex-shrink-0 w-5 h-5 {{ $iconClass }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Profile Settings</span>
                    </a>
                </li>
            @endif
        </ul>

        <!-- LOGOUT SECTION -->
        <div class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center p-2 text-sm text-gray-500 dark:text-gray-400">
                <div class="font-medium truncate">{{ Auth::user()->name }}</div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center p-2 text-base font-normal transition duration-75 rounded-lg group text-red-500 hover:bg-red-100 dark:hover:bg-gray-700">
                    <svg class="flex-shrink-0 w-5 h-5 text-red-500 transition duration-75 group-hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
                    </svg>
                    <span class="ml-3">Sign Out</span>
                </button>
            </form>
        </div>

    </div>
    </aside>
