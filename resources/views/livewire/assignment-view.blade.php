<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  @vite('resources/css/app.css')
</head>
<body>
    <div class="min-h-full">

        {{-- @include('nav') --}}
        @include('layouts.navigation')


        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="p-4 bg-slate-300 rounded-xl transform transition-all duration-300 shadow-lg">
                {{-- <div>{{ $this->exams }}</div>
                <div>{{ $courseID }}</div> --}}
                <div>
                    <a href="/course_view/{{ $this->assignment->course_id }}" class="text-blue-700 underline">{{ $this->courseID }}</a> / {{ $this->assignment->assignment_name }}
                </div> <br>
                <h2 class="text-2xl mb-1 font-bold">{{ $this->assignment->assignment_name }}</h2>
                <p class="text-xl mb-1">{{ $this->assignment->description }}</p>
            <div class="relative overflow-x-auto sm:rounded-lg">
                </div>
                <div class="m-3">
                </div>
            </div>

        </div>
    </div>
</body>
</html>
