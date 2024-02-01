<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body>
    <div class="min-h-full">

        {{-- @include('nav') --}}
        @include('layouts.navigation')

        <header class="bg-white shadow">
          <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Courses</h1>
            <h4 class="font-semibold text-lg">Course Overview</h4>
          </div>
        </header>

        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                @include('content')
            </div>
        </main>

    </div>
</body>
</html>
