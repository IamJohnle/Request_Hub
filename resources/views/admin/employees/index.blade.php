<x-app-layout>
    <div class="p-4">
        <div class="p-4 mt-14">

            <!-- Title -->
            <div class="mb-4">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Employee Management</h2>
            </div>

            <!-- TOOLBAR: Search, Filter & Add Button -->
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-6">

                <!-- Search & Filter Form -->
                <form method="GET" action="{{ url()->current() }}" class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-3">

                    <!-- Search Bar -->
                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search employees...">
                    </div>

                    <!-- Role Filter -->
                    <div class="w-full md:w-48">
                        <select name="role" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="employee" {{ request('role') === 'employee' ? 'selected' : '' }}>Employee</option>
                        </select>
                    </div>
                </form>

                <!-- Add Button (Moved here to align with search) -->
                <a href="{{ route('admin.employees.create') }}" class="w-full md:w-auto flex items-center justify-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Add New Employee
                </a>
            </div>

            <!-- Success/Error Message -->
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-medium">Success!</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">Error!</span> {{ session('error') }}
                </div>
            @endif

            <!-- Table (Actions Column is Intact) -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Role</th>
                            <th scope="col" class="px-6 py-3">Joined</th>
                            <th scope="col" class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $employee->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $employee->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if($employee->role === 'admin')
                                    <span class="bg-purple-100 text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-purple-400">Admin</span>
                                @else
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-blue-400">Employee</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $employee->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.employees.edit', $employee->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-3">Edit</a>

                                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $employees->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
