<div class="min-h-full mt-[5rem]">
    <div class="text-center text-3xl bg-slate-200 py-5  w-full">
        <h3>Lesson</h3>
    </div>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="p-4 bg-slate-100 rounded-xl transform transition-all duration-300 shadow-lg flex">

            <div class="w-1/3">
                <livewire:course-photo-show :courseId='$this->lesson->course_id' />
            </div>

            <div class="w-2/3 flex p-10">
                <div>

                    <div class="border-b border-slate-600">
                        <h2 class="text-2xl font-bold text-slate-900 my-3">{{ $lesson->lesson_name }}</h2>
                    </div>
                    <div class="my-3 border-b border-slate-600">
                        {{ strip_tags($lesson->content) }}
                    </div>
                    @if ($lesson_tutorial)
                        {{-- first video lesson --}}
                        @if ($this->currentLessonTutorial())
                            <div class="m-2">
                                <livewire:video-view :data="$this->currentLessonTutorial()" :key="$this->currentLessonTutorial()->id"/>
                            </div>
                        @endif
                        {{-- remained video lessons --}}
                        <div class="m-2 flex overflow-x-auto">
                            @foreach ($lesson_tutorial as $key => $lsn_tuto)
                                {{-- need to check video type --}}
                                @if ($lsn_tuto->source_type == 'local')
                                <div class="w-1/5 h-1/5 m-2 rounded-lg">
                                    {{-- wire:click="switchVideo({{ $lsn_tuto->id }})"  --}}
                                    <video wire:key="video-{{ $lsn_tuto->id }}">
                                        <source src="{{ asset('storage/'.$lsn_tuto->path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <div class="bg-gray-700 text-white py-1 cursor-pointer text-center">
                                        <button wire:click="switchVideo({{ $lsn_tuto->id }})">Switch</button>
                                    </div>
                                </div>
                                @else
                                    @php
                                        // Extract the video ID from the link
                                        $videoLink = $lsn_tuto->path;
                                        $videoId = substr(parse_url($videoLink, PHP_URL_QUERY), 2);
                                    @endphp
                                    @if ($videoId)
                                        <div class="w-1/5 h-1/5 m-2 rounded-lg">
                                            <div wire:key="video-{{ $lsn_tuto->id }}">
                                                <iframe width="234" height="130" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                                            </div>
                                            <div class="bg-gray-700 w-full text-white py-1 cursor-pointer text-center">
                                                <button wire:click="switchVideo({{ $lsn_tuto->id }})">Switch</button>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <div class="flex justify-end w-full">
                        <button class="text-white bg-slate-800 hover:bg-slate-900 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center slate:bg-slate-600 slate:hover:bg-slate-700 slate:focus:ring-gray-800"
                                @click="history.back()">Back</button>
                        @if ($isAdmin || $isTeacher)
                            <div class="text-end">
                                <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ms-2"
                                        type="button" wire:click="editLesson">
                                    Edit
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
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
