<div class="min-h-full">
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 border-b border-slate-500 pb-2">
            <div class="my-3 flex justify-between w-full">
                <h2 class="text-3xl font-bold text-slate-700 capitalize">{{ $currentCourse->course_name }}</h2>

                @if ($isAdmin || $isTeacher)
                    <button class="px-3 py-2 bg-slate-800 text-white rounded-md" wire:click="editCourse">Edit</button>
                @endif
            </div>
            <span class="text-slate-800 my-3">
                <svg class="w-6 h-6 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                </svg>
                {{ $this->course()->course_category->category_name }}</span>
        </div>



        @if($isEditCourse)
            @include('course.course-modal')
        @endif

    </header>

    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            @if ($alertStatus)
                <div class="w-full bg-red-200 rounded-md p-3 my-3 flex justify-between items-center"
                     wire:transition.duration.1000ms>
                    <span class="text-slate-700">{{ $alertMessage }}</span>
                    <button type="button" wire:click='closeAlertMessage'>
                        <svg class="w-6 h-6 text-slate-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- @include('deleted_files.course-tab-view') --}}

            <div class=" rounded-xl h-[25rem]">
                <div class="w-full flex">
                    <div class="w-1/3 h-full bg-gray-200 p-5 mr-5 rounded-lg shadow-lg">
                        <div class="rounded-lg">
                            <img class="w-[10rem] rounded-lg"
                                 src="{{ asset('storage/' . $this->course()->course_photo_path) }}"
                                 alt="{{ $this->course()->course_name }}" />
                        </div>
                        <div class="my-5">
                            <h3 class="text-xl font-bold text-slate-800 mb-3">Overview</h3>
                            <p class="text-slate-800 text-justify indent-8 overflow-hidden" style="text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical;" >
                                {{ $this->course()->description }}
                            </p>
                        </div>
                    </div>
                    <div class="w-2/3 ms-3 h-[70vh] overflow-auto">
                        <div class="w-full bg-blue-600 rounded-md p-2">
                            <button class="inline-block @if ($isSectionTab) bg-blue-700 rounded @endif  text-white text-md p-2 hover:bg-blue-600 hover:text-white"
                                    type="button" wire:click="switchTab(1)">Section
                            </button>
                            <button class="inline-block @if ($isForumTab) bg-blue-700 rounded @endif text-white p-2 hover:bg-blue-600 hover:text-white text-md"
                                    type="button" wire:click="switchTab(2)">Forums
                            </button>
                            <button class="inline-block @if ($isParticipantTab) bg-blue-700 rounded @endif text-white p-2 hover:bg-blue-600 hover:text-white text-md"
                                    type="button" wire:click="switchTab(3)">Participants
                            </button>
                        </div>
                        @if ($isSectionTab)
                            @include('course.section', [
                                'hidden' => $this->isParticipantSearch ? 'hidden' : '',
                            ])
                        @endif
                        @if ($isForumTab)
                            @include('course.forum')
                        @endif

                        @if ($isParticipantTab)
                            @include('course.participants', [
                                'hidden' => $this->isParticipantSearch ? '' : 'hidden',
                            ])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

</div>

<script>
    // here is deleted script
</script>
