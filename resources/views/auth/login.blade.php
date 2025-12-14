<x-guest-layout>

    <!-- Title -->
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
        Sign in to your account
    </h1>

    <!-- Session Status (e.g. "Password Updated") -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   placeholder="name@company.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
            <input type="password" name="password" id="password"
                   required autocomplete="current-password"
                   placeholder="••••••••"
                   class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="remember" name="remember" aria-describedby="remember" type="checkbox"
                           class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                </div>
                <div class="ml-3 text-sm">
                    <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                </div>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Sign in
        </button>

        <!-- Register Link -->
        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
            Don’t have an account yet?
            <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">
                Sign up
            </a>
        </p>
    </form>
</x-guest-layout>
