<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net" rel="preconnect">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="/dist/output.css" rel="stylesheet">
</head>

<body class="antialiased">

    @if (Route::has('login'))
        <div class="flex justify-between items-center text-right bg-gray-700 py-5">
            <a href="{{ url('/') }}" class="ml-5">
                <x-application-logo class="block h-9 w-auto fill-current text-white" />
            </a>
            <div class="mr-5">
                @auth
                    <a class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                       href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a class="py-2 px-3 bg-blue-500 text-white rounded-md" href="{{ route('login') }}">Log in</a>

                    @if (Route::has('register'))
                        <a class="ml-4 py-2 px-3 bg-blue-500 text-white rounded-md"
                           href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    @endif

    </div>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        @include('content')
    </div>
</body>

</html>

