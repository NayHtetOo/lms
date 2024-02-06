<div class="min-h-full">

    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="p-4 bg-slate-300 rounded-xl transform transition-all duration-300 shadow-lg">
            {{-- <div>{{ $this->exams }}</div>
            <div>{{ $courseID }}</div> --}}
            {{-- <div>
                <a class="text-blue-700 underline"
                   href="/course_view/{{ $this->assignment->course_id }}">{{ $this->courseID }}</a> /
                {{ $this->assignment->assignment_name }}
            </div> <br>
            <h2 class="text-2xl mb-1 font-bold">{{ $this->assignment->assignment_name }}</h2>
            <p class="text-xl mb-1">{{ $this->assignment->description }}</p>
            <div class="relative overflow-x-auto sm:rounded-lg">
            </div>
            <div class="m-3">
            </div> --}}

            <div class="bg-green-500 inline-block py-2 px-3 rounded-md">
                <a class="text-white underline" href="/course_view/{{ $this->assignment->course_id }}">
                    <svg class="w-5 h-5 inline me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                    </svg>
                    {{ $this->courseID }} / {{ $this->assignment->assignment_name }}</a>
            </div>
            <div class="border-b border-slate-600">
                <h2 class="text-2xl font-bold text-slate-900 my-3">{{ $this->assignment->assignment_name }}</h2>
            </div>
            <div class="my-3">
                {{ strip_tags($this->assignment->description ) }}
            </div>
            <div class="flex justify-end w-full">
                <button class="bg-blue-500 py-2 px-3 rounded-md text-white" type="button"
                        @click="history.back()">Back</button>
            </div>
        </div>

    </div>
</div>
