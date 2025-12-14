<x-app-layout>
    <x-slot name="header">
        Dashboard Overview
    </x-slot>

    <!-- 1. Stats Grid (Matches the top row of snippet) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">

        <!-- Total -->
        <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700 h-32 md:h-40 flex flex-col justify-center items-center">
            <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $total }}</div>
            <div class="text-sm text-gray-500 dark:text-gray-400">Total Requests</div>
        </div>

        <!-- Resolved -->
        <div class="p-4 bg-white rounded-lg border border-green-200 shadow-sm dark:bg-gray-800 dark:border-gray-700 h-32 md:h-40 flex flex-col justify-center items-center">
            <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $resolved }}</div>
            <div class="text-sm text-gray-500 dark:text-gray-400">Resolved</div>
        </div>

        <!-- Pending (Unresolved) -->
        <div class="p-4 bg-white rounded-lg border border-yellow-200 shadow-sm dark:bg-gray-800 dark:border-gray-700 h-32 md:h-40 flex flex-col justify-center items-center">
            <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $unresolved }}</div>
            <div class="text-sm text-gray-500 dark:text-gray-400">Unresolved</div>
        </div>

        <!-- Alerts -->
        <div class="p-4 bg-white rounded-lg border border-red-200 shadow-sm dark:bg-gray-800 dark:border-gray-700 h-32 md:h-40 flex flex-col justify-center items-center">
           <div class="text-3xl font-bold text-red-600 dark:text-red-400">
    {{ $alerts }}
</div>
            <div class="text-sm text-gray-500 dark:text-gray-400">High Priority Issues</div>
        </div>
    </div>

    <!-- 2. Charts Section (Matches middle area) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <!-- Status Chart -->
        <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700 h-96 md:h-100">
            <h3 class="text-lg font-bold mb-2 dark:text-white">Status Breakdown</h3>
            <canvas id="statusChart"></canvas>
        </div>

        <!-- Category Chart -->
        <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700 h-96 md:h-100">
            <h3 class="text-lg font-bold mb-2 dark:text-white">Categories</h3>
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <!-- 3. Management Table (Matches bottom area) -->
    <!-- 3. Management Table (Matches bottom area) -->
<div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700 mb-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold dark:text-white">Recent Requests</h3>
        <!-- Link to the full Manage Requests Page -->
        <a href="{{ route('admin.requests.index') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">
            View All Requests &rarr;
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Priority</th>
                    <th class="px-4 py-3">Assigned To</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders->take(10) as $order)
                <!-- Added cursor-pointer and onclick to make the whole row clickable (optional) -->
                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition">

                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                        {{ $order->title }}
                    </td>

                    <td class="px-4 py-3">
                        <!-- Optional: Simple Badge Styling -->
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            {{ $order->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $order->status === 'In Progress' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $order->status === 'Resolved' ? 'bg-green-100 text-green-800' : '' }}">
                            {{ $order->status }}
                        </span>
                    </td>

                    <td class="px-4 py-3">
                        <span class="{{ $order->priority === 'High' ? 'text-red-600 font-bold' : '' }}">
                            {{ $order->priority }}
                        </span>
                    </td>

                    <!-- Display Name instead of Dropdown -->
                    <td class="px-4 py-3 text-gray-900 dark:text-white">
                        @php
                            // Find the employee name from the collection without needing a new query
                            $assignedEmp = $employees->firstWhere('id', $order->assigned_to);
                        @endphp
                        {{ $assignedEmp ? $assignedEmp->name : '-- Unassigned --' }}
                    </td>

                    <!-- Action Link to Manage Page -->
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.requests.index', $order->id) }}" class="flex items-center font-medium text-blue-600 dark:text-blue-500 hover:text-blue-800 dark:hover:text-blue-400">
                            Manage
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('statusChart');

    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Resolved', 'Pending', 'In Progress'],
            datasets: [{
                data: [{{ $chartStatus['resolved'] }}, {{ $chartStatus['pending'] }}, {{ $chartStatus['inprogress'] }}],
                backgroundColor: ['#10B981', '#F59E0B', '#3B82F6']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            // ↓↓↓ makes the donut smaller ↓↓↓
            cutout: '50%',    // increases center hole
            radius: '80%',    // reduces donut total size
        }
    });

    const ctx2 = document.getElementById('categoryChart');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: {!! json_encode($categories->keys()) !!},
            datasets: [{
                label: 'Requests',
                data: {!! json_encode($categories->values()) !!},
                backgroundColor: '#6366F1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false

        }

    });
</script>

</x-app-layout>
