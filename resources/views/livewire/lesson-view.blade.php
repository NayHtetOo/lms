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

        @include('nav')

        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="p-4 bg-slate-300 rounded-xl transform transition-all duration-300 shadow-lg">
                {{-- <div>{{ $lesson }}</div> --}}
                {{-- <div>{{ $courseID }}</div> --}}
                <div>
                    <a href="/course_view/{{ $lesson->course_id }}" class="text-blue-700 underline">{{ $courseID }}</a> / {{ $lesson->lesson_name }}
                </div>
                <h2 class="text-2xl font-bold">{{ $lesson->lesson_name }}</h2>
                <div class="m-3">
                    {{ $lesson->content }}
                </div>
            </div>

        </div>
    </div>
</body>
</html>
