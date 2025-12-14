<x-app-layout>
    <div class="py-3 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">My Requests History</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">View all your submitted requests.</p>
            </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-4 bg-green-50 dark:bg-green-900 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content Box -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">

            <!-- HEADER START -->
            <div class="relative bg-white dark:bg-gray-800 shadow-md sm:rounded-t-lg border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">

                    <!-- Search Bar -->
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center" onsubmit="return false;">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" onkeyup="filterTable()"
                                    class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Search title, ID..." required="">
                            </div>
                        </form>
                    </div>

                    <!-- Buttons Group -->
                    <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">

                        <!-- Create Button -->
                        <a href="{{ route('employee.create') }}" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            New Request
                        </a>

                        <div class="flex items-center w-full space-x-3 md:w-auto relative">

                            <!-- 1. STATUS FILTER BUTTON -->
                            <button id="statusDropdownButton" onclick="toggleHeaderDropdown('statusDropdown')" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                <svg class="-ml-1 mr-1.5 w-5 h-5 text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                                Status
                            </button>
                            <!-- STATUS DROPDOWN -->
                            <div id="statusDropdown" class="absolute right-0 top-10 z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700 border dark:border-gray-600">
                                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                    Filter by Status
                                </h6>
                                <ul class="space-y-2 text-sm">
                                    <li class="flex items-center">
                                        <input id="status-pending" type="checkbox" value="Pending" onchange="filterTable()"
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600" />
                                        <label for="status-pending" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            Pending
                                        </label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="status-progress" type="checkbox" value="In Progress" onchange="filterTable()"
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600" />
                                        <label for="status-progress" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            In Progress
                                        </label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="status-resolved" type="checkbox" value="Resolved" onchange="filterTable()"
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600" />
                                        <label for="status-resolved" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            Resolved
                                        </label>
                                    </li>
                                </ul>
                            </div>

                            <!-- 2. CATEGORY FILTER BUTTON -->
                            <button id="filterDropdownButton" onclick="toggleHeaderDropdown('filterDropdown')" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                Category
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            <!-- CATEGORY DROPDOWN -->
                            <div id="filterDropdown" class="absolute right-0 top-10 z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700 border dark:border-gray-600">
                                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                    Filter by Category
                                </h6>
                                <ul class="space-y-2 text-sm">
                                    <li class="flex items-center">
                                        <input id="cat-it" type="checkbox" value="IT Support" onchange="filterTable()"
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600" />
                                        <label for="cat-it" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            IT Support
                                        </label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="cat-maint" type="checkbox" value="Maintenance" onchange="filterTable()"
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600" />
                                        <label for="cat-maint" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            Maintenance
                                        </label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="cat-hr" type="checkbox" value="HR" onchange="filterTable()"
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600" />
                                        <label for="cat-hr" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            HR
                                        </label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="cat-other" type="checkbox" value="Other" onchange="filterTable()"
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600" />
                                        <label for="cat-other" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            Other
                                        </label>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- HEADER END -->

            <!-- Table -->
            <div class="overflow-x-auto">
                <table id="requestsTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-semibold">Title</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Category</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Priority</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Due Date</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Status</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Date Created</th>
                            <th scope="col" class="px-6 py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($requests as $req)
                        <tr class="request-row bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                            <!-- Title -->
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap title-cell">
                                {{ $req->title }}
                            </td>
                            <!-- Category -->
                            <td class="px-6 py-4 category-cell" data-category="{{ $req->category }}">
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                                    {{ $req->category }}
                                </span>
                            </td>
                            <!-- Priority -->
                            <td class="px-6 py-4">
                                @if($req->priority == 'High')
                                    <span class="text-red-600 dark:text-red-400 font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z"/></svg>
                                        {{ $req->priority }}
                                    </span>
                                @elseif($req->priority == 'Medium')
                                    <span class="text-orange-600 dark:text-orange-400 font-medium">{{ $req->priority }}</span>
                                @else
                                    <span class="text-gray-600 dark:text-gray-400">{{ $req->priority }}</span>
                                @endif
                            </td>
                            <!-- Due Date -->
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                @if($req->due_date)
                                    {{ $req->due_date->format('M d, Y') }}
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 italic text-xs">--</span>
                                @endif
                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4 status-cell" data-status="{{ $req->status }}">
                                @php
                                    // Adjusted dark mode classes for status badges
                                    $statusClasses = [
                                        'Pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900 dark:text-yellow-300 dark:border-yellow-700',
                                        'In Progress' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900 dark:text-blue-300 dark:border-blue-700',
                                        'Resolved' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900 dark:text-green-300 dark:border-green-700',
                                    ];
                                    $class = $statusClasses[$req->status] ?? 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600';
                                @endphp
                                <span class="{{ $class }} text-xs font-semibold px-2.5 py-0.5 rounded-full border">
                                    {{ $req->status }}
                                </span>
                            </td>
                            <!-- Date Created -->
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $req->created_at->format('M d, Y') }}
                            </td>
                            <!-- Actions -->
                            <td class="px-6 py-4 text-right relative">
                                <button onclick="toggleRowDropdown('dropdown-{{ $req->id }}')" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                                <!-- Row Dropdown Menu -->
                                <div id="dropdown-{{ $req->id }}" class="hidden absolute right-10 top-8 z-50 w-40 bg-white dark:bg-gray-700 rounded-md shadow-lg border border-gray-100 dark:border-gray-600 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <a href="#"
                                           onclick="openEditModal(
                                               '{{ $req->id }}',
                                               '{{ $req->title }}',
                                               '{{ $req->category }}',
                                               '{{ $req->priority }}',
                                               `{{ $req->description }}`,
                                               '{{ $req->status }}',
                                               '{{ $req->due_date ? $req->due_date->format('Y-m-d') : '' }}'
                                           )"
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-blue-600 dark:hover:text-white">
                                           View / Edit
                                        </a>
                                        @if($req->status === 'Pending')
                                        <a href="#"
                                           onclick="openDeleteModal('{{ $req->id }}')"
                                           class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-600">
                                           Delete
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="no-results-row">
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-200">No requests found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                        <!-- Hidden No Results Row for JS Filtering -->
                        <tr id="js-no-results" class="hidden">
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800">
                                <p class="text-base font-medium text-gray-900 dark:text-gray-200">No matching records found</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 sm:px-6">
                {{ $requests->links() }}
                <p class="text-xs text-gray-500 dark:text-gray-400 text-center">Showing all {{ $requests->count() }} records</p>
            </div>
        </div>
    </div>

    <!-- Modals (Edit/Delete) - Now with Dark Mode Support -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity" onclick="closeEditModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">Request Details</h3>

                            <form id="editForm" action="#" method="POST" class="mt-4 space-y-4">
                                @csrf
                                @method('PATCH')

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                    <input type="text" name="title" id="edit_title" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm border p-2">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                        <select name="category" id="edit_category" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm border p-2">
                                            <option value="IT Support">IT Support</option>
                                            <option value="Maintenance">Maintenance</option>
                                            <option value="HR">HR</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Priority</label>
                                        <select name="priority" id="edit_priority" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm border p-2">
                                            <option value="Low">Low</option>
                                            <option value="Medium">Medium</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Desired Due Date</label>
                                    <input type="date" name="due_date" id="edit_due_date" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm border p-2">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <textarea name="description" id="edit_description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm border p-2"></textarea>
                                </div>

                                <div id="view_only_warning" class="hidden rounded-md bg-yellow-50 dark:bg-yellow-900 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Read Only</h3>
                                            <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                                <p>This request is being processed and cannot be edited.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                    <button type="submit" id="update_btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Save Changes
                                    </button>
                                    <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity" onclick="closeDeleteModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">Delete Request</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Are you sure you want to delete this request? This action cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- JAVASCRIPT (Same as before) -->
    <script>
        // --- NEW: FILTERING LOGIC ---
        function filterTable() {
            // 1. Get Search Input
            const searchInput = document.getElementById('simple-search').value.toLowerCase();

            // 2. Get Selected Statuses
            const selectedStatuses = [];
            const statusCheckboxes = document.querySelectorAll('#statusDropdown input[type="checkbox"]:checked');
            statusCheckboxes.forEach(cb => selectedStatuses.push(cb.value));

            // 3. Get Selected Categories
            const selectedCategories = [];
            const categoryCheckboxes = document.querySelectorAll('#filterDropdown input[type="checkbox"]:checked');
            categoryCheckboxes.forEach(cb => selectedCategories.push(cb.value));

            // 4. Get All Rows
            const rows = document.querySelectorAll('.request-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const titleText = row.querySelector('.title-cell').textContent.toLowerCase();
                const statusText = row.querySelector('.status-cell').dataset.status;
                const categoryText = row.querySelector('.category-cell').dataset.category;

                const matchesSearch = titleText.includes(searchInput);
                const matchesStatus = selectedStatuses.length === 0 || selectedStatuses.includes(statusText);
                const matchesCategory = selectedCategories.length === 0 || selectedCategories.includes(categoryText);

                if (matchesSearch && matchesStatus && matchesCategory) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });

            // Handle "No Results" message
            const noResultsRow = document.getElementById('js-no-results');
            if (visibleCount === 0 && rows.length > 0) {
                noResultsRow.classList.remove('hidden');
            } else {
                noResultsRow.classList.add('hidden');
            }
        }

        // --- Header Dropdown Toggle ---
        function toggleHeaderDropdown(id) {
            const dropdowns = ['statusDropdown', 'filterDropdown'];
            dropdowns.forEach(dd => {
                if(dd !== id) document.getElementById(dd).classList.add('hidden');
            });
            document.getElementById(id).classList.toggle('hidden');
        }

        // --- Row Dropdown Toggle ---
        function toggleRowDropdown(id) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                if(el.id !== id) el.classList.add('hidden');
            });
            document.getElementById(id).classList.toggle('hidden');
        }

        // --- Close Dropdowns on Outside Click ---
        window.onclick = function(event) {
            if (!event.target.closest('button')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));

                if (!event.target.closest('#statusDropdown') && !event.target.closest('#filterDropdown')) {
                     document.getElementById('statusDropdown').classList.add('hidden');
                     document.getElementById('filterDropdown').classList.add('hidden');
                }
            }
        }

        // --- Modal Logic (Existing) ---
        function openEditModal(id, title, category, priority, description, status, dueDate) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_priority').value = priority;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_due_date').value = dueDate;
            form.action = "/request/" + id + "/update";

            if(status !== 'Pending') {
                document.getElementById('edit_title').disabled = true;
                document.getElementById('edit_category').disabled = true;
                document.getElementById('edit_priority').disabled = true;
                document.getElementById('edit_due_date').disabled = true;
                document.getElementById('edit_description').disabled = true;
                document.getElementById('update_btn').classList.add('hidden');
                document.getElementById('view_only_warning').classList.remove('hidden');
            } else {
                document.getElementById('edit_title').disabled = false;
                document.getElementById('edit_category').disabled = false;
                document.getElementById('edit_priority').disabled = false;
                document.getElementById('edit_due_date').disabled = false;
                document.getElementById('edit_description').disabled = false;
                document.getElementById('update_btn').classList.remove('hidden');
                document.getElementById('view_only_warning').classList.add('hidden');
            }
            modal.classList.remove('hidden');
        }

        function closeEditModal() { document.getElementById('editModal').classList.add('hidden'); }
        function openDeleteModal(id) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteForm').action = "/request/" + id + "/delete";
        }
        function closeDeleteModal() { document.getElementById('deleteModal').classList.add('hidden'); }
    </script>
</x-app-layout>
