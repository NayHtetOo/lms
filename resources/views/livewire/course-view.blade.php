<div class="min-h-full">
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 border-b border-slate-500 pb-2">
            <div class="my-3 flex justify-between w-full">
                <h2 class="text-3xl font-bold text-slate-700 capitalize">{{ $currentCourse->course_name }}</h2>

                @if ($isAdmin || $isTeacher)
                    <button wire:click="editCourse" class="px-3 py-2 bg-gray-400 rounded">Edit</button>
                @endif
            </div>
        </div>

        @if ($isEditCourse)
            @include('course.course-modal')
        @endif

    </header>

    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            @if ($alertStatus)
                <div class="w-full bg-red-200 rounded-md p-3 my-3 flex justify-between items-center" wire:transition.duration.1000ms>
                    <span class="text-slate-700">{{ $alertMessage }}</span>
                    <button wire:click='closeAlertMessage' type="button">
                        <svg class="w-6 h-6 text-slate-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- @include('deleted_files.course-tab-view') --}}
            <livewire:course-photo-show :courseId="$id" />

            <div class=" rounded-xl shadow-lg">
                <div class="mb-4 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center bg-blue-500 rounded-md px-3">
                        <li class="me-2 py-2">
                            <button wire:click="switchTab(1)" class="inline-block text-white text-md p-2 hover:bg-blue-600 hover:text-white"
                                type="button">Section
                            </button>
                        </li>

                        <li class="me-2 py-2">
                            <button wire:click="switchTab(2)" class="inline-block text-white p-2 hover:bg-blue-600 hover:text-white text-md"
                                type="button" >Forums
                            </button>
                        </li>

                        <li class="me-2 py-2">
                            <button wire:click="switchTab(3)" class="inline-block text-white p-2 hover:bg-blue-600 hover:text-white text-md"
                                type="button">Participants
                            </button>
                        </li>

                        @if ($this->enrollmentUser->role_id == 2)
                            <li class="me-2 py-2">
                                <button wire:click="switchTab(4)" class="inline-block text-white p-2 hover:bg-blue-600 hover:text-white text-md"
                                    type="button">Setting
                                </button>
                            </li>
                        @endif

                    </ul>
                </div>

                <div class="bg-gray-200">

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

                    @if ($isSettingTab)
                        @include('course.setting')
                    @endif

                </div>
            </div>

        </div>
    </main>

</div>

<script>
    // here is deleted script
</script>
