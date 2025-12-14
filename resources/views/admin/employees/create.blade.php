<x-app-layout>
    <div class="p-4">
        <div class="p-4 mt-4">

            <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow dark:bg-gray-800">
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Add New Employee</h2>

                <form action="{{ route('admin.employees.store') }}" method="POST">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                        <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                        <input type="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                        <select name="role" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white shadow-sm">
                            <option value="employee">Employee</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <input type="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white shadow-sm">
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                        <input type="password" name="password_confirmation" required class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white shadow-sm">
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.employees.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Account</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
