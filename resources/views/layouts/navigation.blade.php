<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <span class="text-white font-bold text-xl">ADMIN PORTAL</span>
                </div>

                {{-- EMPLOYEE LINKS --}}
                @if(Auth::check() && Auth::user()->role === 'employee')

                    {{-- 1. Dashboard --}}
                    <x-nav-link :href="route('employee.dashboard')" :active="request()->routeIs('employee.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- 2. Submit Request --}}
                    <x-nav-link :href="route('employee.create')" :active="request()->routeIs('employee.create')">
                        {{ __('Submit Request') }}
                    </x-nav-link>

                    {{-- 3. Request History --}}
                    <x-nav-link :href="route('employee.history')" :active="request()->routeIs('employee.history')">
                        {{ __('My History') }}
                    </x-nav-link>

                @endif

                {{-- ADMIN MENU LINKS (only for admins) --}}
                @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    {{-- 1. Dashboard (Overview & Stats) --}}
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-gray-300 hover:text-white">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- 2. Employee Management --}}
                    <x-nav-link :href="route('admin.employees.index')" :active="request()->routeIs('admin.employees.*')" class="text-gray-300 hover:text-white">
                        {{ __('Employees') }}
                    </x-nav-link>

                    {{-- 3. Reports (Download) --}}
                    <x-nav-link :href="route('admin.reports.download')" :active="request()->routeIs('admin.reports.download')" class="text-gray-300 hover:text-white">
                        {{ __('Download Reports') }}
                    </x-nav-link>

                </div>
                @endif
            </div>

            <!-- Profile & Logout -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-300">{{ Auth::check() ? Auth::user()->name : '' }}</span>

                        {{-- Profile Settings --}}
                        <a href="{{ route('profile.edit') }}" class="text-sm text-gray-400 hover:text-white underline">Settings</a>

                        {{-- Logout --}}
                        @if(Auth::check())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-400 hover:text-red-300 text-sm font-bold">
                                Log Out
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
