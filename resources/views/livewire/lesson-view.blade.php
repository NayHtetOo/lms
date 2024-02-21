<div class="min-h-full mt-[5rem]">
    <div class="text-center text-3xl bg-slate-200 py-5  w-full">
        <h3>Lesson</h3>
    </div>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="p-4 bg-slate-100 rounded-xl transform transition-all duration-300 shadow-lg flex">

            <div class="w-1/3">
                <livewire:course-photo-show :courseId='$this->lesson->course_id' />
            </div>

            <div class="border-b border-slate-600">
                <h2 class="text-2xl font-bold text-slate-900 my-3">{{ $lesson->lesson_name }}</h2>
            </div>

            <div class="my-3 border-b border-slate-600">
                {{ strip_tags($lesson->content) }}
            </div>
            {{-- old design for lesson view --}}
            {{-- @include('deleted_files.lesson-video-view') --}}

            @if ($lesson_tutorial)
                <div class="flex overflow-x-auto">
                    {{-- first video lesson --}}
                    <div class="w-4/5">
                        @if ($this->currentLessonTutorial())
                            <div class="m-2">
                                @if ($this->currentLessonTutorial()->source_type == 'local')
                                    <div>
                                        <video class="w-full m-2 rounded-xl" controls wire:key="video-{{ $this->currentLessonTutorial()->id }}">
                                            <source src="{{ asset('storage/'.$this->currentLessonTutorial()->path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <span class="ml-2 px-2 py-2 font-bold text-2xl text-center">{{ $this->currentLessonTutorial()->title }}</span>
                                    </div>
                                @else
                                    @php
                                        // Extract the video ID from the link
                                        $videoLink = $this->currentLessonTutorial()->path;
                                        $videoId = substr(parse_url($videoLink, PHP_URL_QUERY), 2);
                                    @endphp
                                    @if ($videoId)
                                        <div wire:key="video-{{ $this->currentLessonTutorial()->id }}">
                                            <iframe class="w-full m-2 rounded-xl" height="435" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                                            <span class="ml-2 px-2 py-2 font-bold text-2xl text-center">{{ $this->currentLessonTutorial()->title }}</span>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- remained video lessons --}}
                    <div class="w-2/5 overflow-x-auto max-h-screen">
                        <div class="flex flex-col gap-2 px-2 py-2">
                            @foreach ($lesson_tutorial as $key => $lsn_tuto)
                                @if ($lsn_tuto->source_type == 'local')
                                    <div class="bg-white shadow rounded-lg cursor-pointer" wire:click="switchVideo({{ $lsn_tuto->id }})">

                                        <div class="pr-4">
                                            <div class="w-full h-36 bg-black rounded-t-md m-1">
                                                <video class="w-full h-full pr-4" wire:key="video-{{ $lsn_tuto->id }}">
                                                    <source src="{{ asset('storage/'.$lsn_tuto->path) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                            <div class="flex">
                                                <div class="w-3/4 ml-2 px-2 py-2 font-bold text-xl text-center truncate">{{ $lsn_tuto->title }}</div>
                                                <span class="w-1/4 bg-blue-600 px-2 py-2 text-center mb-2 rounded text-white cursor-pointer shadow-xl" wire:click="switchVideo({{ $lsn_tuto->id }})" wire:key="video-{{ $lsn_tuto->id }}">Watch</span>
                                            </div>
                                        </div>

                                    </div>
                                @else
                                    @php
                                        // Extract the video ID from the link
                                        $videoLink = $lsn_tuto->path;
                                        $videoId = substr(parse_url($videoLink, PHP_URL_QUERY), 2);
                                    @endphp
                                    @if ($videoId)
                                        <div class="bg-white shadow rounded-lg">
                                            <div class="w-full pr-4">
                                                <iframe class="w-full m-1 rounded-t-md" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                                                <div class="flex">
                                                    <div class="w-3/4 ml-2 px-2 py-2 font-bold text-xl text-center truncate">{{ $lsn_tuto->title }}</div>
                                                    <span class="w-1/4 bg-blue-600 px-2 py-2 text-center mb-2 rounded text-white cursor-pointer" wire:click="switchVideo({{ $lsn_tuto->id }})" wire:key="video-{{ $lsn_tuto->id }}">Watch</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
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
        <div class="fixed z-50 justify-center w-full top-12 lg:left-44">
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
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="overflow-y-auto overflow-x-hidden max-h-96 p-4 md:p-5 space-y-4">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="px-2 py-2 m-3 bg-red-500 rounded text-white">{{ $error }}</div>
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
