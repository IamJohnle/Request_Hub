<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Request Hub') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts (Ensure Flowbite is imported in app.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900">

    <!-- 1. TOP NAVIGATION -->
    @include('layouts.header')

    <!-- 2. SIDEBAR NAVIGATION -->
    @include('layouts.sidebar')

    <!-- 3. MAIN CONTENT -->
    <main class="p-4 md:ml-64 h-auto pt-20">

        <!-- Page Title (Optional) -->
        @if (isset($header))
            <div class="mb-4 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ $header }}
                </h2>
            </div>
        @endif

        <!-- Dynamic Content (Dashboards, Forms, etc.) -->
        {{ $slot }}

    </main>

</body>
</html>
