<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Menutest') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
{{--@include('layouts.navigation')--}}

    <main class="h-full overflow-y-auto items-start">
        <div class="container px-6 mx-auto grid text-gray-800">
            @if (isset($header))
                <h2 class="my-6 text-2xl font-semibold text-gray-700">
                    {{ $header }}
                </h2>
            @endif

            {{ $slot }}
        </div>
    </main>
</div>
</body>
</html>