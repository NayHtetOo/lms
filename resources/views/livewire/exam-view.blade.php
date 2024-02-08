<div class="min-h-full">

    @if (session()->has('message'))
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="p-4 border border-green-400 text-green-700 rounded bg-green-200">
                <span class="block sm:inline">{{ session('message') }}</span>
                {{-- <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span> --}}
            </div>
        </div>
    @endif

    <form wire:submit.prevent="examSubmit" method="POST">
        @csrf
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="p-4 bg-slate-300 rounded-xl transform transition-all duration-300 shadow-4xl shadow-lg">
                <div class="flex justify-between items-center w-full">
                    <a class="bg-green-500 inline-block py-2 px-3 rounded-md text-white"
                       href="/course_view/{{ $this->exams->course_id }}">{{ $courseID }} /
                        {{ $this->exams->exam_name }}</a>

                </div>

                {{-- exam info --}}
                <h2 class="text-2xl font-bold text-slate-900 my-5 text-center">{{ $this->exams->exam_name }}</h2>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right mt-3">
                        <thead class="text-md uppercase bg-blue-500 text-white">
                            <tr class="rounded-md">
                                <th class="w-[30rem] p-3" scope="col">Description</th>
                                <th class="p-3 text-center" scope="col">Start Date</th>
                                <th class="p-3 text-center" scope="col">End Date</th>
                                <th class="p-3 text-center" scope="col">Duration (minutes)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td class="text-justify px-5 py-3 mt-5" scope="col"> {{ $this->exams->description }}
                                This is exam description This is exam description This is exam description This is exam
                                description
                                This is exam description This is exam description This is exam description This is exam
                                description
                            </td>

                            <td class="mt-3 text-slate-800 text-center" scope="col">
                                {{ $this->exams->start_date_time }} </td>
                            <td class="mt-3 text-slate-800 text-center" scope="col">
                                {{ $this->exams->end_date_time }} </td>
                            <td class="mt-3 text-slate-800 text-center" scope="col"> {{ $this->exams->duration }}
                                minutes</td>
                        </tbody>
                    </table>
                </div>

                @php
                    $startDate = \Carbon\Carbon::parse($this->exams->start_date_time);
                    $endDate = \Carbon\Carbon::parse($this->exams->end_date_time);
                    $date = \Carbon\Carbon::now('Asia/Yangon')->format('y-m-d H:i:s');
                    $currentDate = \Carbon\Carbon::parse($date);

                    $examDuration = $this->exams->duration;
                @endphp

                <div class="relative overflow-x-auto sm:rounded text-end">
                    @if (!$this->examSubmitted)
                        @if ($currentDate->between($startDate, $endDate))
                            <button class="border bg-green-500 py-2 px-3 rounded-md text-white"
                                    wire:click='examSubmit'>Answer</button>
                        @endif
                    @else
                        <button class="border bg-indigo-400 py-2 px-3 rounded text-white">View</button>
                    @endif
                </div>
            </div>
        </div>

        @if (!$this->examSubmitted)
            @if (
                $this->trueOrfalse->isNotEmpty() ||
                    $this->multipleChoice->isNotEmpty() ||
                    $this->matching->isNotEmpty() ||
                    $this->shortQuestion->isNotEmpty() ||
                    $this->essay->isNotEmpty())

                <div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8">
                    <div class="p-2 rounded-xl shadow-2xl bg-slate-300">

                        <div class="w-full flex justify-center items-center my-3">
                            <div class="text-blue-500 font-bold bg-slate-800 px-4 py-2 rounded-md w-[10rem] text-center">
                                <svg class="w-6 h-6 inline" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span id="examMinutes" wire:ignore></span>
                            </div>
                        </div>

                        <div id="question-tab-content">

                            {{-- --}}
                            {{-- @include('exam_view.true-or-false', [
                                'data' => $this->trueOrfalse,
                            ]) --}}

                            {{-- Multiple Choice Block --}}
                            <div class="hidden p-4 rounded-lg" id="question2" role="tabpanel"
                                 aria-labelledby="question2-tab">
                                @if ($this->multipleChoice->isNotEmpty())
                                    <div class="m-3">
                                        <p class="font-bold">II. Multiple Choice Questions.</p>
                                        <div class="m-2">
                                            @foreach ($this->multipleChoice as $multi_choice)
                                                <div class="flex justify-between">
                                                    <div>
                                                        {{ $multi_choice->question_no }}.
                                                        {{ $multi_choice->question }}
                                                    </div>
                                                    <div> {{ $multi_choice->mark }} Mark</div>
                                                </div>

                                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                                    {{-- <input
                                                        class="relative -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                                        type="radio"
                                                        name="multipleChoiceAnswer.{{ $multi_choice->id }}"
                                                        id="{{ $multi_choice->choice_1 }}"
                                                    /> --}}
                                                    <label>
                                                        <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                               name="multiple_choice{{ $multi_choice->id }}"
                                                               type="radio" value="1"
                                                               wire:model="multipleChoiceAnswer.{{ $multi_choice->id }}" />
                                                        <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                                                              for="{{ $multi_choice->choice_1 }}">
                                                            (A)
                                                            {{ $multi_choice->choice_1 }}
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                                    <label>
                                                        <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                               name="multiple_choice{{ $multi_choice->id }}"
                                                               type="radio" value="2"
                                                               wire:model="multipleChoiceAnswer.{{ $multi_choice->id }}" />
                                                        <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                                                              for="{{ $multi_choice->choice_2 }}">
                                                            (B) {{ $multi_choice->choice_2 }}
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                                    <label>
                                                        <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                               name="multiple_choice{{ $multi_choice->id }}"
                                                               type="radio" value="3"
                                                               wire:model="multipleChoiceAnswer.{{ $multi_choice->id }}" />
                                                        <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                                                              for="{{ $multi_choice->choice_3 }}">
                                                            (C) {{ $multi_choice->choice_3 }}
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                                    <label>
                                                        <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                               name="multiple_choice{{ $multi_choice->id }}"
                                                               type="radio" value="4"
                                                               wire:model="multipleChoiceAnswer.{{ $multi_choice->id }}" />
                                                        <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                                                              for="{{ $multi_choice->choice_4 }}">
                                                            (D) {{ $multi_choice->choice_4 }}
                                                        </span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="m-3">
                                        <p class="font-bold">There is no multiple choice</p>
                                    </div>
                                @endif

                                @include('exam_view.prev-next-button', [
                                    'prev_id' => 'question1-tab',
                                    'prev_target' => 'question1',
                                    'next_id' => 'question3-tab',
                                    'next_target' => 'question3',
                                ])
                            </div>

                            {{-- Matching Block --}}
                            {{-- <div>{{ $this->matching }}</div> --}}
                            <div class="hidden p-4 rounded-lg" id="question3" role="tabpanel"
                                 aria-labelledby="question3-tab">
                                {{-- <div>Matching</div> --}}
                                @if ($this->matching->isNotEmpty())
                                    <div class="m-3">
                                        <p class="font-bold">III. Matching Questions.</p>
                                        <div class="m-2">
                                            @foreach ($this->matching as $key => $match)
                                                <div class="flex justify-between">
                                                    <div>
                                                        {{ $match->question_no }}. {{ $match->question }}
                                                    </div>
                                                    <div> {{ $match->mark }} Mark</div>
                                                </div>

                                                <div class="ml-5 mt-3">
                                                    <div class="flex justify-between">
                                                        <div class="mt-2">(A) {{ $match->question_1 }} </div>
                                                        <div class="mr-20">
                                                            <select class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                                                focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                                                                "
                                                                    wire:model="matchingAnswer.{{ $match->id }}.1">
                                                                <option class="px-3 py-3" selected>Select One
                                                                </option>
                                                                <option class="h-50" value="1">
                                                                    {{ $match->answer_1 }}</option>
                                                                <option class="h-50" value="2">
                                                                    {{ $match->answer_2 }}</option>
                                                                <option class="h-50" value="3">
                                                                    {{ $match->answer_3 }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="flex justify-between mt-1">
                                                        <div class="mt-2">(B) {{ $match->question_2 }} </div>
                                                        <div class="mr-20">
                                                            <select class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                                                focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                                    wire:model="matchingAnswer.{{ $match->id }}.2">
                                                                <option class="px-3 py-3" selected>Select One
                                                                </option>
                                                                <option class="h-50" value="1">
                                                                    {{ $match->answer_1 }}</option>
                                                                <option class="h-50" value="2">
                                                                    {{ $match->answer_2 }}</option>
                                                                <option class="h-50" value="3">
                                                                    {{ $match->answer_3 }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="flex justify-between mt-1">
                                                        <div class="mt-2">(C) {{ $match->question_3 }} </div>
                                                        <div class="mr-20">
                                                            <select class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                                                focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                                    wire:model="matchingAnswer.{{ $match->id }}.3">
                                                                <option class="px-3 py-3" selected>Select One
                                                                </option>
                                                                <option class="h-50" value="1">
                                                                    {{ $match->answer_1 }}</option>
                                                                <option class="h-50" value="2">
                                                                    {{ $match->answer_2 }}</option>
                                                                <option class="h-50" value="3">
                                                                    {{ $match->answer_3 }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="m-3">
                                        <p class="font-bold">There is no matching choice</p>
                                    </div>
                                @endif

                                @include('exam_view.prev-next-button', [
                                    'prev_id' => 'question2-tab',
                                    'prev_target' => 'question2',
                                    'next_id' => 'question4-tab',
                                    'next_target' => 'question4',
                                ])
                            </div>

                            {{-- ShortQuestion Block --}}
                            <div class="hidden p-4 rounded-lg" id="question4" role="tabpanel"
                                 aria-labelledby="question4-tab">
                                @if ($this->shortQuestion->isNotEmpty())
                                    <div class="m-3">
                                        <p class="font-bold">IV. Short Questions.</p>
                                        <div class="m-2">
                                            @foreach ($this->shortQuestion as $key => $shortQ)
                                                <div class="flex justify-between">
                                                    <div>
                                                        {{ $shortQ->question_no }}. {{ $shortQ->question }}
                                                    </div>
                                                    <div> {{ $shortQ->mark }} Mark</div>
                                                </div>
                                                <div class="p-5 pr-20">
                                                    <textarea class="w-full h-40 rounded-md" wire:model="shortQuestionAnswer.{{ $shortQ->id }}"></textarea>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="m-3">
                                        <p class="font-bold">There is no short question</p>
                                    </div>
                                @endif

                                @include('exam_view.prev-next-button', [
                                    'prev_id' => 'question3-tab',
                                    'prev_target' => 'question3',
                                    'next_id' => 'question5-tab',
                                    'next_target' => 'question5',
                                ])

                            </div>

                            {{-- Essay Block --}}
                            <div class="hidden p-4 rounded-lg" id="question5" role="tabpanel"
                                 aria-labelledby="question5-tab">
                                @if ($this->essay->isNotEmpty())
                                    <div class="m-3">
                                        <p class="font-bold">V. Essay Questions.</p>
                                        <div class="m-2">
                                            @foreach ($this->essay as $key => $esy)
                                                <div class="flex justify-between">
                                                    <div>
                                                        {{ $esy->question_no }}. {{ $esy->question }}
                                                    </div>
                                                    <div> {{ $esy->mark }} Mark</div>
                                                </div>
                                                <div class="p-5 pr-20">
                                                    <textarea class="w-full h-40 rounded-md" wire:model="essayAnswer.{{ $esy->id }}"></textarea>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="m-3">
                                        <p class="font-bold">There is no essay</p>
                                    </div>
                                @endif

                                @include('exam_view.prev-next-button', [
                                    'prev_id' => 'question4-tab',
                                    'prev_target' => 'question4',
                                    'next_id' => '',
                                    'next_target' => '',
                                ])

                            </div>
                            {{-- end essay block --}}

                        </div>

                        <div class="text-end">
                            <button class="mr-4 bg-transparent hover:bg-green-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                                    type="submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>

            @endif
        @endif
    </form>

    @if ($this->summaryView)
        <div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8">
            <div class="p-4 rounded-xl shadow-2xl bg-slate-300">
                <h2 class="font-bold text-xl mb-4">Summary</h2>
                <table class="w-full border border-black text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr class="border-b-2 border-black">
                            <th class="px-6 py-3" scope="col">No.</th>
                            <th class="px-6 py-3" scope="col">Status</th>
                            <th class="px-6 py-3" scope="col">Question</th>
                            <th class="" scope="col">Marks / {{ $this->numberOfQuestion }}</th>
                            <th class="" scope="col">Grade / {{ $this->baseTotalMark }}</th>
                            <th class="" scope="col">Review</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->examSummary as $key => $row)
                            <tr class="border-b border-gray-400">
                                <td class="px-6 py-3">{{ $loop->index + 1 }}</td>
                                {{-- <td class="px-6 py-3">Finished <br> Sumitted {{ $row[0]->created_at }}</td> --}}
                                <td class="px-6 py-3">Finished <br> Sumitted {{ $this->examSubmittedDate }}</td>
                                <td class="px-6 py-3" scope="col">{{ $key }}</td>
                                <td>{{ $row['correct'] }} / {{ $row['origin'] }}</td>
                                <td>{{ $row['grade'] }} / {{ $row['total'] }}</td>
                                <td>
                                    {{-- <a href="#" class="text-blue-500">Review</a> --}}
                                    <button class="py-2 px-3 bg-indigo-400 text-white rounded"
                                            wire:click="review">Review</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="m-2 mt-2">
                    <h2 class="font-bold">Highest grade: {{ $this->gradeMark }} / {{ $this->baseTotalMark }}</h2>
                </div>
            </div>
        </div>
    @endif

    @if ($this->isTeacher && $this->isExamSubmittedStudent)
        <div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8 mb-10">
            <div class="p-4 rounded-xl shadow-2xl bg-slate-300">
                <h2 class="font-bold text-xl mb-4">Submitted Students</h2>
                <table class="w-full border border-black text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr class="border-b-2 border-black">
                            <th class="px-3">No.</th>
                            <th class="py-3" scope="">Status</th>
                            <th class="py-3" scope="">Name</th>
                            <th class="py-3" scope="">Email</th>
                            <th class="" scope="">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->exam_answered_users as $key => $row)
                            {{-- <div>{{ $row }}</div> --}}
                            <tr class="border-b border-gray-400">
                                <td class="px-3">{{ $loop->index + 1 }}</td>
                                <td class="py-3">Finished <br> Sumitted {{ $row->created_at }}</td>
                                <td class="py-3" scope="">{{ $row->user->name }}</td>
                                <td class="py-3" scope="">{{ $row->user->email }}</td>
                                <td>
                                    <button class="py-2 px-3 bg-indigo-400 text-white rounded"
                                            wire:click="checkAnsewer({{ $row->user_id }},{{ $row->exam_id }})">Check</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    @if ($this->checkAnsweredPaper)
        {{-- <h1>Hello</h1> --}}
        @include('exam_view.exam-answered-paper')
    @endif

    @if ($this->reviewQuestion)
        <div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8">
            <div class="p-4 rounded-xl shadow-2xl bg-slate-300">
                <div>
                    <a class="text-blue-700 underline" wire:click="backToSummary">Summary</a> / Review
                </div><br>
                <h2 class="font-bold text-xl mb-4">Review</h2>
                @include('exam_view.true-or-false', [
                    'data' => $this->trueOrfalse,
                ])
            </div>
        </div>
    @endif
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

    let examDuration = @json($this->exams->duration);
    let userId = @json($user_id);
    let examId = @json($id);
    const csrfToken = document.getElementById("csrfToken").getAttribute("content");
    let startDate = new Date(@json($startDate));
    let endDate = new Date(@json($endDate));
    let currentDate = new Date(@json($currentDate))
    let examMinutes = document.getElementById("examMinutes");
    let postData = {
        'user_id': userId,
        'exam_id': examId,
        'status': 1,
    }
    let options = {
        method: 'POST',
        headers: {
            'Content-Type': "application/json",
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(postData)
    }
    let getLocalStorage = JSON.parse(localStorage.getItem('storeDuration'));
    if (!getLocalStorage) {
        localStorage.setItem('storeDuration', JSON.stringify({
            storeMinutes: examDuration,
            storeSeconds: 60,
        }));
    }

    getLocalStorage = JSON.parse(localStorage.getItem('storeDuration'));

    examDurationCount();

    function examDurationCount() {
        if (currentDate > startDate && currentDate < endDate) {
            const intervalExam = setInterval(() => {

                if (getLocalStorage.storeMinutes != null || getLocalStorage.storeSeconds != null) {
                    getLocalStorage.storeSeconds--;
                } else {
                    examMinutes.style.display = "none";
                }

                localStorage.setItem('storeDuration', JSON.stringify(getLocalStorage));

                if (getLocalStorage.storeSeconds == 0) {
                    getLocalStorage.storeMinutes--;
                    getLocalStorage.storeSeconds = 59;

                    console.log(getLocalStorage.storeMinutes);

                    if (getLocalStorage.storeMinutes == 0) {
                        console.log(true);

                        const apiUrl = "/submit";
                        fetch(apiUrl, options)
                            .then((response) => {
                                if (!response.ok) {
                                    throw new Error(`Error status ${response.status}`);
                                }
                                return response.json();
                            })
                            .then((data) => {
                                clearInterval(intervalExam);
                                localStorage.setItem('storeDuration', JSON.stringify({
                                    storeMinutes: null,
                                    storeSeconds: null,
                                }));
                                examMinutes.textContent = "";
                            })
                            .catch(error => {
                                console.error(`Error ${error}`);
                            });
                    }
                }

                examMinutes.textContent = `${getLocalStorage.storeMinutes} : ${getLocalStorage.storeSeconds}`;
            }, 1000);
        } else {
            console.log("exam is not started");
        }
    }
</script>
