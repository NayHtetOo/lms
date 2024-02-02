<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <title>{{ $title ?? 'Learning Management System' }}</title>

        {{-- @vite('resources/css/app.css') --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    @livewireStyles()
    <body>
        @include('layouts.navigation')
         <!-- Page Content -->
         <main>
            {{ $slot }}
        </main>
        @livewireScripts()
    </body>
</html>
