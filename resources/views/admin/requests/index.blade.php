<x-app-layout>
    <!-- MAIN CONTENT CONTAINER -->
    <div class="p-4 pt-5 min-h-screen bg-gray-50 dark:bg-gray-900">

        <!-- Page Title & Stats -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Manage Requests</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">View and manage all incoming work orders.</p>
            </div>

            <div class="mt-4 md:mt-0 px-4 py-2 bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">Total Requests:</span>
                <span class="text-lg font-bold text-blue-600 dark:text-blue-400 ml-1">{{ $requests->total() }}</span>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-700 shadow-sm" role="alert">
                <span class="font-bold">Success!</span> {{ session('success') }}
            </div>
        @endif

        <!-- NEW TABLE HEADER SECTION -->
        <div class="relative bg-white shadow-md dark:bg-gray-800 sm:rounded-t-lg border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">

                <!-- SEARCH BAR -->
                <div class="w-full md:w-1/2">
                    <form class="flex items-center" method="GET" action="{{ route('admin.requests.index') }}">
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        @if(request('priority'))
                            <input type="hidden" name="priority" value="{{ request('priority') }}">
                        @endif

                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" id="simple-search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search ID, Title, or User">
                        </div>
                    </form>
                </div>

                <!-- FILTERS -->
                <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                    <div class="flex items-center w-full space-x-3 md:w-auto">

                        <!-- 1. STATUS FILTER -->
                        <div class="relative">
                            <button id="statusDropdownButton" data-dropdown-toggle="statusDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                <svg class="-ml-1 mr-1.5 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v3.292a1 1 0 01-2 0V14.9a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                </svg>
                                Status: {{ request('status') ?: 'All' }}
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            <!-- Status Dropdown Menu -->
                            <div id="statusDropdown" class="hidden absolute right-0 z-10 bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600 mt-2">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="statusDropdownButton">
                                    <li>
                                        <a href="{{ route('admin.requests.index', array_merge(request()->query(), ['status' => null, 'page' => 1])) }}"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white {{ !request('status') ? 'bg-gray-100 dark:bg-gray-600 font-bold' : '' }}">
                                            All Statuses
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.requests.index', array_merge(request()->query(), ['status' => 'Pending', 'page' => 1])) }}"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white {{ request('status') == 'Pending' ? 'bg-gray-100 dark:bg-gray-600 font-bold' : '' }}">
                                            Pending
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.requests.index', array_merge(request()->query(), ['status' => 'In Progress', 'page' => 1])) }}"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white {{ request('status') == 'In Progress' ? 'bg-gray-100 dark:bg-gray-600 font-bold' : '' }}">
                                            In Progress
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.requests.index', array_merge(request()->query(), ['status' => 'Resolved', 'page' => 1])) }}"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white {{ request('status') == 'Resolved' ? 'bg-gray-100 dark:bg-gray-600 font-bold' : '' }}">
                                            Resolved
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- 2. PRIORITY FILTER -->
                        <div class="relative">
                            <button id="priorityDropdownButton" data-dropdown-toggle="priorityDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                Priority: {{ request('priority') ?: 'All' }}
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            <!-- Priority Dropdown Menu -->
                            <div id="priorityDropdown" class="hidden absolute right-0 z-10 w-48 bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 mt-2">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="priorityDropdownButton">
                                    <li>
                                        <a href="{{ route('admin.requests.index', array_merge(request()->query(), ['priority' => null, 'page' => 1])) }}"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white {{ !request('priority') ? 'bg-gray-100 dark:bg-gray-600 font-bold' : '' }}">
                                            All Priorities
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.requests.index', array_merge(request()->query(), ['priority' => 'High', 'page' => 1])) }}"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white {{ request('priority') == 'High' ? 'bg-gray-100 dark:bg-gray-600 font-bold' : '' }}">
                                            High
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.requests.index', array_merge(request()->query(), ['priority' => 'Medium', 'page' => 1])) }}"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white {{ request('priority') == 'Medium' ? 'bg-gray-100 dark:bg-gray-600 font-bold' : '' }}">
                                            Medium
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.requests.index', array_merge(request()->query(), ['priority' => 'Low', 'page' => 1])) }}"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white {{ request('priority') == 'Low' ? 'bg-gray-100 dark:bg-gray-600 font-bold' : '' }}">
                                            Low
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-lg sm:rounded-b-lg border-x border-b border-gray-200 dark:border-gray-700">
            <table class="w-full text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600">
                    <tr>
                        <th scope="col" class="px-4 py-3 font-bold whitespace-nowrap">ID</th>
                        <th scope="col" class="px-4 py-3 font-bold">Title</th>
                        <th scope="col" class="px-4 py-3 font-bold">Category</th>
                        <th scope="col" class="px-4 py-3 font-bold whitespace-nowrap">Requested By</th>
                        <th scope="col" class="px-4 py-3 font-bold whitespace-nowrap">Assigned To</th>
                        <th scope="col" class="px-4 py-3 font-bold whitespace-nowrap">Due Date</th>
                        <th scope="col" class="px-4 py-3 font-bold whitespace-nowrap">Status</th>
                        <th scope="col" class="px-4 py-3 font-bold whitespace-nowrap">Priority</th>
                        <th scope="col" class="px-4 py-3 font-bold text-right whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($requests as $req)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                        <!-- ID -->
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap">#{{ $req->id }}</td>

                        <!-- Title -->
                        <td class="px-4 py-3 min-w-[150px]">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-2">{{ $req->title }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 whitespace-nowrap">{{ $req->created_at->format('M d, Y') }}</div>
                        </td>

                        <!-- Category -->
                        <td class="px-4 py-3 text-sm">{{ $req->category }}</td>

                        <!-- User -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-6 w-6 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-xs font-bold mr-2 text-blue-700 dark:text-blue-300 ring-2 ring-white dark:ring-gray-800">
                                    {{ substr($req->user->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white text-sm">{{ Str::limit($req->user->name, 15) }}</span>
                            </div>
                        </td>

                        <!-- Assignee -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($req->assignee)
                                <span class="inline-flex items-center bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600">
                                    {{ $req->assignee->name }}
                                </span>
                            @else
                                <span class="text-gray-400 italic text-xs">-- Unassigned --</span>
                            @endif
                        </td>

                        <!-- Due Date -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($req->due_date)
                                <span class="{{ $req->due_date->isPast() && $req->status != 'Resolved' ? 'text-red-600 font-bold' : 'text-gray-900 dark:text-white' }} text-sm">
                                    {{ $req->due_date->format('M d, Y') }}
                                </span>
                            @else
                                <span class="text-gray-400 italic text-xs">-- No Date --</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'Pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800',
                                    'In Progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 border border-blue-200 dark:border-blue-800',
                                    'Resolved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 border border-green-200 dark:border-green-800',
                                ];
                            @endphp
                            <span class="{{ $statusColors[$req->status] ?? '' }} text-xs font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wide whitespace-nowrap">
                                {{ $req->status }}
                            </span>
                        </td>

                        <!-- Priority -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="flex items-center {{ $req->priority == 'High' ? 'text-red-600 dark:text-red-400 font-bold' : ($req->priority == 'Medium' ? 'text-orange-500 dark:text-orange-400 font-medium' : 'text-gray-600 dark:text-gray-400') }}">
                                @if($req->priority == 'High')
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd" /></svg>
                                @endif
                                {{ $req->priority }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <button
                                onclick="openAdminModal(
                                    '{{ $req->id }}',
                                    '{{ $req->title }}',
                                    '{{ $req->user->name }}',
                                    '{{ $req->status }}',
                                    '{{ $req->priority }}',
                                    '{{ $req->assigned_to }}',
                                    `{{ $req->description }}`,
                                    '{{ $req->due_date ? $req->due_date->format('Y-m-d') : '' }}'
                                )"
                                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 shadow-sm transition-all hover:shadow-md">
                                Manage
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center">
                                <svg class="w-10 h-10 mb-2 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-sm">No requests found matching your criteria.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            {{ $requests->links() }}
        </div>
    </div>

    <!-- ADMIN EDIT MODAL (UPDATED TO LANDSCAPE) -->
    <!-- CHANGED: max-w-2xl to max-w-5xl for landscape width -->
    <div id="adminModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full bg-gray-900 bg-opacity-60 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-5xl h-full md:h-auto mx-auto mt-10">
            <!-- Modal content -->
            <div class="relative p-6 bg-white rounded-xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <!-- Modal header -->
                <div class="flex justify-between items-start pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            Manage Request <span id="modal_req_id" class="text-blue-600 dark:text-blue-400 ml-1 font-mono"></span>
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update status, priority, or assign employees.</p>
                    </div>
                    <button type="button" onclick="closeAdminModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewbox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="adminForm" action="#" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- LANDSCAPE LAYOUT GRID -->
                    <div class="grid gap-6 mb-6 md:grid-cols-3">

                        <!-- LEFT COLUMN: REQUEST DETAILS (2/3 Width) -->
                        <div class="md:col-span-2 space-y-4">
                            <!-- Title -->
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Request Title</label>
                                <input type="text" id="modal_title" class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 cursor-not-allowed font-medium" disabled>
                            </div>

                            <!-- Requester -->
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Requested By</label>
                                <input type="text" id="modal_requester" class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 cursor-not-allowed font-medium" disabled>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Description</label>
                                <textarea id="modal_description" rows="8" class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 cursor-not-allowed" disabled></textarea>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: ADMIN ACTIONS (1/3 Width) -->
                        <div class="md:col-span-1 space-y-4">
                            <!-- EDITABLE FIELDS HEADER -->
                            <div class="border-b pb-2 mb-2 dark:border-gray-600">
                                <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Admin Actions</h4>
                            </div>

                            <!-- 1. Assign Employee -->
                            <div>
                                <label for="modal_assign" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Assign To Employee</label>
                                <select id="modal_assign" name="assigned_to" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm">
                                    <option value="">-- Unassigned --</option>
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name }} ({{ ucfirst($emp->role) }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 2. Status -->
                            <div>
                                <label for="modal_status" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Status</label>
                                <select id="modal_status" name="status" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm">
                                    <option value="Pending">Pending</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Resolved">Resolved</option>
                                </select>
                            </div>

                            <!-- 3. Priority -->
                            <div>
                                <label for="modal_priority" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Priority Level</label>
                                <select id="modal_priority" name="priority" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm">
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>

                            <!-- 4. Due Date -->
                            <div>
                                <label for="modal_due_date" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Due Date</label>
                                <input type="date" id="modal_due_date" name="due_date" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm">
                            </div>
                        </div>

                    </div>

                    <div class="flex items-center space-x-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full sm:w-auto shadow-md">
                            Save Changes
                        </button>
                        <button type="button" onclick="closeAdminModal()" class="text-gray-700 bg-white border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-6 py-3 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 w-full sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Logic -->
    <script>
        // MODAL LOGIC (UPDATED WITH DUE DATE)
        function openAdminModal(id, title, requester, status, priority, assignedTo, description, dueDate) {
            const modal = document.getElementById('adminModal');
            const form = document.getElementById('adminForm');

            // Populate Read-Only Fields
            document.getElementById('modal_req_id').textContent = '#' + id;
            document.getElementById('modal_title').value = title;
            document.getElementById('modal_requester').value = requester;
            document.getElementById('modal_description').value = description;

            // Populate Editable Dropdowns
            document.getElementById('modal_status').value = status;
            document.getElementById('modal_priority').value = priority;
            document.getElementById('modal_assign').value = assignedTo || "";

            // Populate Due Date (NEW)
            document.getElementById('modal_due_date').value = dueDate;

            // Set Form Action Route
            form.action = "/admin/request/" + id + "/update";

            // Show Modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeAdminModal() {
            const modal = document.getElementById('adminModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // DROPDOWN TOGGLE LOGIC
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('[data-dropdown-toggle]');

            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const targetId = this.getAttribute('data-dropdown-toggle');
                    const targetDropdown = document.getElementById(targetId);

                    document.querySelectorAll('[id^="actionsDropdown"], [id^="filterDropdown"], [id^="statusDropdown"], [id^="priorityDropdown"]').forEach(dd => {
                        if (dd.id !== targetId) dd.classList.add('hidden');
                    });

                    if (targetDropdown) {
                        targetDropdown.classList.toggle('hidden');
                    }
                });
            });

            document.addEventListener('click', function(e) {
                const isDropdownButton = e.target.closest('[data-dropdown-toggle]');
                const isDropdownMenu = e.target.closest('[id$="Dropdown"]');

                if (!isDropdownButton && !isDropdownMenu) {
                    document.querySelectorAll('[id^="actionsDropdown"], [id^="filterDropdown"], [id^="statusDropdown"], [id^="priorityDropdown"]').forEach(dd => {
                        dd.classList.add('hidden');
                    });
                }
            });
        });
    </script>
</x-app-layout>
