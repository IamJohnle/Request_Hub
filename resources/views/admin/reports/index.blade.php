<x-app-layout>
    <div class="p-4">
        <div class="p-4 mt-4">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Report Generation</h2>
            </div>

            <!-- SEARCH & FILTER AREA -->
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">

                    <!-- 1. FILTER FORM (GET) -->
                    <!-- This form only handles filtering the list -->
                    <form method="GET" action="{{ route('admin.reports.index') }}" class="contents">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="ID, Title..."
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white shadow-sm">
                                <option value="">All</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date From</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>

                        <!-- FILTER BUTTON -->
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                Filter Results
                            </button>
                        </div>
                    </form>

                    <!-- 2. GENERATE PREVIEW BUTTON -->
                    <!-- Note the 'form="report-form"' attribute. It submits the table form below! -->
                    <div class="flex items-end">
                        <button type="submit" form="report-form" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition flex justify-center items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4h10z"></path></svg>
                            Preview & Print
                        </button>
                    </div>

                </div>
            </div>

            <!-- RESULTS TABLE FORM (POST) -->
            <!-- We wrap the table in a form to submit selected checkboxes -->
            <form id="report-form" action="{{ route('admin.reports.preview') }}" method="POST">
                @csrf

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <!-- Checkbox Header -->
                                <th class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all" type="checkbox" onclick="toggleAll(this)" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700">
                                    </div>
                                </th>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Title</th>
                                <th class="px-6 py-3">Requested By</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <!-- Checkbox Row -->
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="selected_reports[]" value="{{ $report->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700">
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold">#{{ $report->id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $report->title }}</td>
                                <td class="px-6 py-4">{{ $report->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $report->status == 'Resolved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $report->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $report->created_at->format('Y-m-d') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">No reports found matching your filters.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            <!-- Pagination -->
            <div class="p-4">
                {{ $reports->withQueryString()->links() }}
            </div>

        </div>
    </div>

    <!-- Script to handle Select All -->
    <script>
        function toggleAll(source) {
            checkboxes = document.getElementsByName('selected_reports[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
</x-app-layout>
