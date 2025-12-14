<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- WELCOME CARD -->
    <div class="p-6 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm">
        <h1 class="mb-1 text-2xl font-bold tracking-tight text-gray-900">
            Welcome back, {{ Auth::user()->name }} 👋
        </h1>
        <p class="font-normal text-gray-700">
            Here is an overview of the work requests you have submitted.
        </p>
    </div>

    <!-- 1. STATS OVERVIEW -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">

        <!-- Total Submitted -->
        <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm h-32 flex flex-col justify-center">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold text-gray-700">Total Submitted</h3>
                <span class="p-2 bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                </span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</div>
        </div>

        <!-- Pending -->
        <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm h-32 flex flex-col justify-center">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold text-gray-700">Pending</h3>
                <span class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                </span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['pending'] }}</div>
        </div>

        <!-- In Progress -->
        <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm h-32 flex flex-col justify-center">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold text-gray-700">In Progress</h3>
                <span class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path></svg>
                </span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['in_progress'] }}</div>
        </div>

        <!-- Resolved -->
        <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm h-32 flex flex-col justify-center">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold text-gray-700">Resolved</h3>
                <span class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                </span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['resolved'] }}</div>
        </div>
    </div>

    <!-- 2. RECENT ACTIVITY / NOTIFICATIONS -->
    <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Recent Updates</h3>
            <a href="{{ route('employee.history') }}" class="text-sm font-medium text-blue-600 hover:underline">
                View all history
            </a>
        </div>

        <ul class="space-y-4">
            @forelse($recentActivity as $activity)
                <li class="pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                    <div class="flex items-center space-x-4">
                        <!-- Icon based on status -->
                        <div class="flex-shrink-0">
                            @if($activity->status == 'Resolved')
                                <span class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </span>
                            @elseif($activity->status == 'In Progress')
                                <span class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 110 16 8 8 0 010-16zm0 2a6 6 0 100 12 6 6 0 000-12z"></path></svg>
                                </span>
                            @else
                                <span class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-full">
                                    <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                                </span>
                            @endif
                        </div>

                        <!-- Text Content -->
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ $activity->title }}
                            </p>
                            <p class="text-sm text-gray-500 truncate">
                                Status changed to <span class="font-semibold text-gray-700">{{ $activity->status }}</span>
                            </p>
                        </div>

                        <!-- Time -->
                        <div class="inline-flex items-center text-xs text-gray-500">
                            {{ $activity->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </li>
            @empty
                <div class="text-center py-4">
                    <p class="text-sm text-gray-500">No recent activity found.</p>
                </div>
            @endforelse
        </ul>
    </div>

</x-app-layout>
