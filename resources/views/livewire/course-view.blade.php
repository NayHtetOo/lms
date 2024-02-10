<div class="min-h-full">

    {{-- <div>{{ $currentCourse }}</div> --}}
    {{-- <div>{{ $currentCourseSection }}</div> --}}
    {{-- <div>{{ $lessons }}</div> --}}
    {{-- <div>{{ $exams }}</div> --}}
    {{-- <div>{{ $assignments }}</div> --}}

    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-slate-700 capitalize">{{ $currentCourse->course_name }}
            </h1>
        </div>
    </header>

    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            @if ($alertStatus)
                <div class="w-full bg-red-200 rounded-md p-3 my-3 flex justify-between items-center" wire:transition.500ms>
                    <span class="text-slate-700">{{ $alertMessage }}</span>
                    <button wire:click='closeAlertMessage' type="button">
                        <svg class="w-6 h-6 text-slate-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <div class=" rounded-xl shadow-lg">
                <div class="mb-4 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center bg-blue-500 rounded-md px-3" id="default-tab"
                        data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="me-2 py-2" role="presentation">
                            <button class="inline-block text-white text-md p-2
                         hover:bg-blue-600 hover:text-white"
                                    id="section-tab" data-tabs-target="#section" type="button" role="tab"
                                    aria-controls="section" aria-selected="false">Section</button>
                        </li>

                        <li class="me-2 py-2" role="presentation">
                            <button class="inline-block text-white p-2
                         hover:bg-blue-600 hover:text-white text-md"
                                    id="forum-tab" data-tabs-target="#forum" type="button" role="tab"
                                    aria-controls="forum" aria-selected="false">Forums</button>
                        </li>


                        <li class="me-2 py-2" role="presentation">
                            <button class="inline-block text-white p-2
                         hover:bg-blue-600 hover:text-white text-md"
                                    id="participant-tab" data-tabs-target="#participant" type="button" role="tab"
                                    aria-controls="participant" aria-selected="false">Participants</button>
                        </li>

                        <li class="me-2 py-2" role="presentation">
                            <button class="inline-block text-white p-2 hover:bg-blue-600 hover:text-white text-md"
                                    id="grade-tab" data-tabs-target="#grade" type="button" role="tab"
                                    aria-controls="grade" aria-selected="false">Grade</button>
                        </li>

                        @if ($this->enrollmentUser->role_id == 2)
                            <li class="me-2 py-2" role="presentation">
                                <button class="inline-block text-white p-2 hover:bg-blue-600 hover:text-white text-md"
                                        id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                                        aria-controls="settings" aria-selected="false">Settings</button>
                            </li>
                        @endif

                    </ul>
                </div>

                <div id="default-tab-content">

                    @include('course.section', [
                        'hidden' => $this->isParticipantSearch ? 'hidden' : '',
                    ])
                    
                    @include('course.forum')

                    @include('course.participants', [
                        'hidden' => $this->isParticipantSearch ? '' : 'hidden',
                    ])

                    @include('course.grade')

                    @include('course.setting')


                </div>
            </div>
        </div>
    </main>

</div>

<script>
    // Get all tab buttons
    const tabButtons = document.querySelectorAll('[data-tabs-target]');

    // Add click event listeners to each tab button
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-tabs-target');
            const targetContent = document.querySelector(targetId);

            // Hide all tab contents
            document.querySelectorAll('[role="tabpanel"]').forEach(content => {
                content.classList.add('hidden', );
            });

            // Show the target tab content
            targetContent.classList.remove('hidden');

            // Update aria-selected attribute for all tab buttons
            tabButtons.forEach((btn, index) => {
                btn.setAttribute('aria-selected', 'false');
            });

            // Set aria-selected attribute for the clicked tab button
            // button.setAttribute('aria-selected', 'true');
        });
    });

    // Function to toggle visibility of collapsible elements
    function toggleCollapse(event) {
        event.preventDefault(); // Prevent default link behavior
        const targetId = this.getAttribute('href').substring(1); // Get target element ID
        const targetElement = document.getElementById(targetId); // Find target element

        if (targetElement.classList.contains('hidden')) {
            targetElement.classList.remove('hidden'); // Show the target element
        } else {
            targetElement.classList.add('hidden'); // Hide the target element
        }
    }

    // Add event listeners to collapsible triggers - this code is use in section
    document.querySelectorAll('[data-te-collapse-init]').forEach(trigger => {
        trigger.addEventListener('click', toggleCollapse);
    });
</script>
