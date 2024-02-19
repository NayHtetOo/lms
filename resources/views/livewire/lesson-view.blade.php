<div class="min-h-full mt-[3rem] relative">
    <div class="text-center text-3xl bg-slate-200 py-5 fixed left-0 top-20 w-full z-5">
        <h3>Lesson</h3>
    </div>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 mt-[9rem]">
        <div class="p-4 bg-slate-100 rounded-xl transform transition-all duration-300 shadow-lg">

            <livewire:course-photo-show :courseId='$this->lesson->course_id' />

            <div class="flex justify-between">
                <div class="bg-green-500 inline-block py-2 px-3 rounded-md">
                    <a class="text-white underline" href="/course_view/{{ $lesson->course_id }}">
                        <svg class="w-5 h-5 inline me-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                        </svg>
                        {{ $courseID }} / {{ $lesson->lesson_name }}
                    </a>
                </div>
            </div>

            <div class="border-b border-slate-600">
                <h2 class="text-2xl font-bold text-slate-900 my-3">{{ $lesson->lesson_name }}</h2>
            </div>

            <div class="my-3 border-b border-slate-600">
                {{ strip_tags($lesson->content) }}
            </div>

            @if ($lesson_tutorial)
                {{-- first video lesson --}}
                <div class="m-2">
                    <livewire:video-view :data="$this->currentLessonTutorial()" :key="$this->currentLessonTutorial()->id"/>
                </div>
                {{-- remained video lessons --}}
                <div class="m-2 flex overflow-x-auto">
                    @foreach ($lesson_tutorial as $key => $lsn_tuto)
                        <video wire:click="switchVideo({{ $lsn_tuto->id }})" wire:key="video-{{ $lsn_tuto->id }}" class="w-1/5 h-1/5 m-2 rounded-lg">
                            <source src="{{ asset('storage/'.$lsn_tuto->path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endforeach
                </div>
            @endif
            <div class="flex justify-end w-full">
                <button class="text-white bg-gray-500 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center gray:bg-gray-600 gray:hover:bg-gray-700 gray:focus:ring-gray-800"
                        @click="history.back()">Back</button>
                @if ($isAdmin || $isTeacher)
                    <div class="text-end">
                        <button class="text-white bg-gray-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ms-2"
                                type="button" wire:click="editLesson">
                            Edit
                        </button>
                    </div>
                @endif
            </div>
        </div>

    </div>
    {{-- lesson edit modal --}}
    @if ($isEditLesson)
        <div class="fixed z-50 justify-center w-full top-12 left-72 right-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-800 opacity-75"></div>
            </div>
            <div class="relative p-4 w-full max-w-5xl">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Edit Lesson
                        </h3>
                        <button class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                type="button" wire:click="toggleModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            {{-- <span class="sr-only">Close modal</span> --}}
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="overflow-y-auto overflow-x-hidden max-h-96 p-4 md:p-5 space-y-4">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="px-2 py-2 m-3 bg-red-500 text-white">{{ $error }}</div>
                            @endforeach
                        @endif
                        <div class="flex m-2">
                            <div class="w-1/3">
                                <div class="ml-2">
                                    <label class="">
                                        <span>Lesson Name</span>
                                        <input class="border mt-2 border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                               id="inline-full-name" type="text" wire:model="lesson_name">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex m-2">
                            <div class="w-full ml-2">
                                <label class="">
                                    <span>Content</span>
                                    <textarea class="w-full mt-2 rounded" id="" name="" wire:model="content" cols="30" rows="10"></textarea>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="button" wire:click="updateLesson">
                            Update
                        </button>
                        <button class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button" wire:click="toggleModal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@push('scripts')
    <script>
        // document.addEventListener('livewire:load', function () {
        //     Livewire.on('refreshComponent', () => {
        //         Livewire.dispatch('refresh');
        //     });
        // });

        // document.addEventListener('livewire:load', function () {
        //     Livewire.on('video-view', () => {
        //         Livewire.dispatch('video-view')->self();
        //     });
        // });
    </script>
@endpush
