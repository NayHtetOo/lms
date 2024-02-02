<div class="min-h-full">

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
