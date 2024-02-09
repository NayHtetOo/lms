<div class="min-h-full w-full" id="examViewContainer">
    @php
        $startDate = \Carbon\Carbon::parse($this->exams->start_date_time);
        $endDate = \Carbon\Carbon::parse($this->exams->end_date_time);
        $date = \Carbon\Carbon::now('Asia/Yangon')->format('y-m-d H:i:s');
        $currentDate = \Carbon\Carbon::parse($date);

        $examDuration = $this->exams->duration;
    @endphp

    @if (session()->has('message'))
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="p-4 border border-green-400 text-green-700 rounded bg-green-200">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <div class="w-full mx-auto mt-3" id="examDescription">
        <div class="w-full ">
            <div class="p-4 rounded-xl transform transition-all duration-300 shadow-4xl shadow-lg">
                <div class="border-b border-slate-500 pb-2">
                    <h2 class="text-xl font-bold text-slate-800">{{ $this->exams->exam_name }}</h2>

                    <div class="my-3 flex justify-end w-full">
                        Duration - <span class="text-blue-500 font-bold">{{ $this->exams->duration }} minutes</span>
                    </div>

                    <div class="text-slate-700 my-3">
                        <svg class="w-6 h-6 inline" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Start date - <span
                                  class="text-blue-500 font-bold">{{ $this->exams->start_date_time }}</span></span>
                    </div>
                    <div class="text-slate-700 my-3">
                        <svg class="w-6 h-6 inline" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>End date - <span
                                  class="text-blue-500 font-bold">{{ $this->exams->end_date_time }}</span></span>
                    </div>
                </div>

                <div class="relative overflow-x-auto sm:rounded text-end mt-3">
                    @if (!$this->examSubmitted)
                        @if ($currentDate->between($startDate, $endDate))
                            <button class="border bg-green-500 py-2 px-3 rounded-md text-white"
                                    id="answer">Answer</button>
                        @endif
                    @else
                        <button class="border bg-indigo-400 py-2 px-3 rounded text-white">View</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="w-3/4 mt-3 h-[85vh] overflow-auto">
        <form id="form" wire:submit.prevent="examSubmit" method="POST" wire:ignore.self>
            @csrf
            @if (!$examSubmitted && $this->isStudent)
                @if (
                    $this->trueOrfalse->isNotEmpty() ||
                        $this->multipleChoice->isNotEmpty() ||
                        $this->matching->isNotEmpty() ||
                        $this->shortQuestion->isNotEmpty() ||
                        $this->essay->isNotEmpty())
                    <div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8">
                        <div class="p-2 rounded-xl shadow-2xl">
                            <div class="w-full flex justify-end items-center my-3">
                                <div class=" px-3">
                                    <div
                                         class="text-white font-bold bg-blue-600 px-4 py-2 rounded-md w-[10rem] text-center">
                                        <svg class="w-6 h-6 inline" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <span id="examMinutes" wire:ignore></span>
                                    </div>
                                    <h2 class="text-blue-800 text-end mt-3">Marks - 100</h2>
                                </div>
                            </div>
                            <div class=" px-3" id="question-tab-content">
                                <div class="rounded-lg relative" id="question1" role="tabpanel"
                                     aria-labelledby="question1-tab">
                                    @if ($trueOrfalse->isNotEmpty())
                                        <div class="">
                                            <div class="w-full flex justify-start items-center">
                                                @include('exam_view.prev-next-button', [
                                                    'prev_id' => '',
                                                    'prev_target' => '',
                                                    'next_id' => 'question2-tab',
                                                    'next_target' => 'question2',
                                                ])
                                            </div>
                                            <div class="flex justify-between w-full mt-3">
                                                <p class="font-bold text-slate-800 text-xl ms-2">I.
                                                    <span class="ms-3">True or False Questions.</span>
                                                </p>
                                                <p class="font-bold text-slate-800 text-xl">(1 Marks)</p>
                                            </div>

                                            <div class="m-2">
                                                @foreach ($trueOrfalse as $tof)
                                                    <div class="my-5">
                                                        <div class="flex justify-between">
                                                            <div class="text-slate-700 text-md">
                                                                {{ $tof->question_no }}. <span
                                                                      class="ml-3">{{ strip_tags($tof->question) }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-[0.125rem] block min-h-[1.5rem] ml-6 mt-3">
                                                            <label class="flex items-center">
                                                                <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                                       name="trueOrfalse{{ $tof->id }}"
                                                                       type="radio" value="1"
                                                                       wire:model="trueorfalseAnswer.{{ $tof->id }}" />
                                                                <span
                                                                      class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2 text-slate-600">
                                                                    True
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <div class="mb-[0.125rem] block min-h-[1.5rem] ml-6 mt-3">
                                                            <label class="flex items-center">
                                                                <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                                       name="trueOrfalse{{ $tof->id }}"
                                                                       type="radio" value="0"
                                                                       wire:model="trueorfalseAnswer.{{ $tof->id }}" />
                                                                <span
                                                                      class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2 text-slate-700">
                                                                    False
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Multiple Choice Block --}}
                                <div class="hidden rounded-lg" id="question2" role="tabpanel"
                                     aria-labelledby="question2-tab">
                                    @if ($this->multipleChoice->isNotEmpty())
                                        <div class="">
                                            <div class="w-full flex justify-start items-center">
                                                @include('exam_view.prev-next-button', [
                                                    'prev_id' => 'question1-tab',
                                                    'prev_target' => 'question1',
                                                    'next_id' => 'question3-tab',
                                                    'next_target' => 'question3',
                                                ])
                                            </div>
                                            <div class="flex justify-between w-full mt-3">
                                                <p class="font-bold text-slate-800 text-xl ms-2">I.
                                                    <span class="ms-3">True or False Questions.</span>
                                                </p>
                                                <p class="font-bold text-slate-800 text-xl">(1 Marks)</p>
                                            </div>
                                            <div class="m-2">
                                                @foreach ($this->multipleChoice as $multi_choice)
                                                    <div class="flex justify-between">
                                                        <div class="flex justify-between">
                                                            <div class="text-slate-700 text-md">
                                                                {{ $multi_choice->question_no }}. <span
                                                                      class="ml-3">{{ strip_tags($multi_choice->question) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div
                                                         class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6 mt-3">
                                                        <label>
                                                            <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                                   name="multiple_choice{{ $multi_choice->id }}"
                                                                   type="radio" value="1"
                                                                   wire:model="multipleChoiceAnswer.{{ $multi_choice->id }}" />
                                                            <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer text-slate-600"
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
                                                            <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer text-slate-600"
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
                                                            <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer text-slate-600"
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
                                                            <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer text-slate-600"
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
    </div>

    {{-- show report for students after sumbmit --}}
    @if ($this->summaryView && $examStatus == 2)
        <div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8" wire:ignore>
            <div class="p-4 rounded-xl shadow-2xl bg-slate-300">
                {{-- <h2 class="font-bold text-xl mb-4">Summary</h2>
                <div>Grade : {{ $gradeName }}</div> --}}
                <div class="flex justify-between">
                    <h2 class="font-bold text-xl bg-blue-600 px-2 py-2 rounded text-white mb-4">Result</h2>
                    <span class="px-3 py-2 rounded text-white mb-4
                        @if ($gradeName == 'A')
                            bg-green-800
                        @elseif ($gradeName == 'B')
                            bg-blue-800
                        @elseif ($gradeName == 'C')
                            bg-orange-500
                        @else
                            bg-red-600
                        @endif"> Grade : {{ $gradeName }}</span>
                </div>

                <table class="w-full border border-black text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr class="border-b-2 border-black">
                            <th class="px-6 py-3" scope="col">No.</th>
                            <th class="px-6 py-3" scope="col">Status</th>
                            <th class="px-6 py-3" scope="col">Question</th>
                            <th class="" scope="col">Marks / {{ $this->numberOfQuestion }}</th>
                            <th class="" scope="col">Grade / {{ $this->baseTotalMark }}</th>
                            {{-- <th class="" scope="col">Review</th> --}}
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
                                {{-- <td> <button class="py-2 px-3 bg-indigo-400 text-white rounded">Review</button> </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="m-2 mt-2">
                    <h2 class="font-bold">Highest Mark: {{ $this->gradeMark }} / {{ $this->baseTotalMark }}</h2>
                </div>
            </div>
        </div>
    @endif

    @if ($this->summaryView && $examStatus == 1)
        <div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8 ">
            <div class="p-4 rounded shadow-2xl bg-slate-300 text-blue-500">
                <label class="">Wait for Exam Result</label>
            </div>
        </div>
    @endif

    {{-- Teacher view for submitted students report --}}
    @if ($this->isTeacher && $this->isExamSubmittedStudent)
        <div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8 mb-10">
            <div class="p-4 rounded-xl shadow-2xl bg-slate-300">
                <h2 class="font-bold text-xl mb-4">Submitted Students</h2>
                <table class="w-full border border-black text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr class="border-b-2 border-black">
                            <th class="px-3">No.</th>
                            <th class="py-3" scope="">Sumitted Date</th>
                            <th class="py-3" scope="">Name</th>
                            <th class="py-3" scope="">Email</th>
                            <th class="py-3" scope="">Status</th>
                            <th class="" scope="">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->exam_answered_users as $key => $row)
                            <tr class="border-b border-gray-400">
                                <td class="px-3">{{ $loop->index + 1 }}</td>
                                <td class="py-3">Finished <br> Sumitted {{ $row->created_at }}</td>
                                <td class="py-3" scope="">{{ $row->user->name }}</td>
                                <td class="py-3" scope="">{{ $row->user->email }}</td>
                                @if ($row->status == 1)
                                    <td class="py-3">
                                        <span class="bg-blue-800 text-white rounded py-1 px-2">
                                            Inprocess
                                        </span>
                                    </td>
                                @else
                                    <td class="py-3">
                                        <span class="bg-green-800 text-white rounded py-1 px-2">
                                            Checked
                                        </span>
                                    </td>
                                @endif
                                <td>
                                    <button wire:click="checkAnswer({{ $row->user_id }},{{ $row->exam_id }})" class="py-2 px-3 bg-gray-600 text-white rounded">show</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if ($checkAnsweredPaper)
        {{-- <h1>Hello</h1> --}}
        @include('exam_view.exam-answered-paper')
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
    let examViewContainer = document.getElementById("examViewContainer");
    let examDescription = document.getElementById("examDescription");

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
    let getFormStatus = JSON.parse(localStorage.getItem('formStatus'));

    if (!getFormStatus) {
        let storeFormStatus = localStorage.setItem('formStatus', JSON.stringify({
            status: false,
        }));
    }

    if (!getLocalStorage) {
        localStorage.setItem('storeDuration', JSON.stringify({
            storeMinutes: examDuration,
            storeSeconds: 60,
        }));
    }

    getLocalStorage = JSON.parse(localStorage.getItem('storeDuration'));
    getFormStatus = JSON.parse(localStorage.getItem('formStatus'));
    console.log(getFormStatus);


    document.getElementById("answer").addEventListener("click", function() {
        localStorage.setItem('formStatus', JSON.stringify({
            status: true,
        }));
        console.log(getFormStatus);
        FormLoad();
    });

    window.addEventListener("load", function() {
        console.log("load");
        FormLoad();
    });

    function FormLoad() {
        getFormStatus = JSON.parse(localStorage.getItem('formStatus'));
        if (getFormStatus.status == true && getFormStatus) {
            document.getElementById("form").classList.remove("hidden");
            examViewContainer.classList.add('flex');
            examDescription.classList.remove('w-full');
            examDescription.classList.remove('mx-auto');
            examDescription.classList.add('w-1/4');
            examDurationCount();
        } else {
            document.getElementById("form").classList.add("hidden");
            examViewContainer.classList.remove('flex');
            examDescription.classList.add('w-full');
            examDescription.classList.add('mx-auto');
            examDescription.classList.remove('w-1/4');
        }
    }

    function examDurationCount() {
        if (currentDate > startDate && currentDate < endDate) {
            console.log('date between')
            const intervalExam = setInterval(() => {

                if (getLocalStorage.storeMinutes != null || getLocalStorage.storeSeconds != null) {
                    getLocalStorage.storeSeconds--;
                } else {
                    examMinutes.style.display = "none";
                }

                localStorage.setItem('storeDuration', JSON.stringify(getLocalStorage));

                if (getLocalStorage.storeSeconds == 0) {
                    if (getLocalStorage.storeMinutes >= 0) {
                        getLocalStorage.storeMinutes--;
                        getLocalStorage.storeSeconds = 59;
                    }

                    console.log(getLocalStorage.storeMinutes);

                    if (getLocalStorage.storeMinutes == 0) {
                        console.log(getFormStatus.status);
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
                                localStorage.removeItem('formStatus');
                                document.getElementById("form").classList.add("hidden");
                                examViewContainer.classList.remove('flex');
                                examDescription.classList.add('w-full');
                                examDescription.classList.add('mx-auto');
                                examDescription.classList.remove('w-1/4');
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
