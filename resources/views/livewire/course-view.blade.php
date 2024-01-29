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

        {{-- <div>{{ $currentCourse }}</div> --}}
        {{-- <div>{{ $currentCourseSection }}</div> --}}
        {{-- <div>{{ $lessons }}</div> --}}
        {{-- <div>{{ $exams }}</div> --}}
        {{-- <div>{{ $assignments }}</div> --}}

        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-blue-700">{{ $currentCourse->course_name }}</h1>
            </div>
        </header>

        <main>
          <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="p-2 rounded-xl shadow-2xl bg-slate-300">
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block text-blue-700 p-2 border-b-2 rounded-t-lg hover:text-black hover:bg-slate-100"
                                id="section-tab" data-tabs-target="#section" type="button" role="tab" aria-controls="section" aria-selected="false">Section</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button class="inline-block text-blue-700 p-2 border-b-2 rounded-t-lg hover:text-black hover:bg-slate-100"
                                id="participant-tab" data-tabs-target="#participant" type="button" role="tab" aria-controls="participant" aria-selected="false">Participants</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button class="inline-block text-blue-700 p-2 border-b-2 rounded-t-lg hover:text-black hover:bg-slate-100"
                                id="grade-tab" data-tabs-target="#grade" type="button" role="tab" aria-controls="grade" aria-selected="false">Grade</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button class="inline-block text-blue-700 p-2 border-b-2 rounded-t-lg hover:text-black hover:bg-slate-100"
                                id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Settings</button>
                        </li>
                    </ul>
                </div>

                <div id="default-tab-content">

                    @include('course.section')

                    @include('course.participants')

                    @include('course.grade')

                    @include('course.setting')

                </div>
            </div>
          </div>
        </main>

    </div>
</body>
</html>
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
            content.classList.add('hidden');
        });

        // Show the target tab content
        targetContent.classList.remove('hidden');

        // Update aria-selected attribute for all tab buttons
        tabButtons.forEach(btn => {
            btn.setAttribute('aria-selected', 'false');
        });

        // Set aria-selected attribute for the clicked tab button
        button.setAttribute('aria-selected', 'true');
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

// Add event listeners to collapsible triggers
document.querySelectorAll('[data-te-collapse-init]').forEach(trigger => {
    trigger.addEventListener('click', toggleCollapse);
});


</script>
