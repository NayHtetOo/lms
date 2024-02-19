<div class="min-h-full w-full mt-[5rem] @if ($isExamPaperOpen == true || $this->isTeacher || $examStatus == 2) flex @endif" id="examViewContainer">
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

    <div class="mt-3  max-w-6xl mx-auto
        @if ($isExamPaperOpen || $this->isTeacher || $examStatus == 2) w-1/4 py-1 ms-2 @endif
    ">
        <div class="w-full my-5">
            @if ($this->summaryView && $examStatus == 1)
                <div class="max-w-7xl py-1 sm:px-6 lg:px-8 ">
                    <div class="p-4 rounded shadow-xl bg-slate-300 text-blue-500">
                        <label class="">Wait for Exam Result</label>
                    </div>
                </div>
            @endif
            <div class="p-4 rounded-xl transform transition-all duration-300 shadow-4xl shadow-lg">
                <div class="border-b border-slate-500 pb-2">

                    <div class="flex justify-between">
                        <h2 class="text-xl font-bold text-slate-800">{{ $this->exams->exam_name }}</h2>
                    </div>

                    <div class="my-3 flex justify-end w-full">
                        Duration - <span class="text-blue-500 font-bold">{{ $this->exams->duration }} minutes</span>
                    </div>

                    <div class="border-b border-slate-700">
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
                    <div class="text-slate-700 my-3">
                        <svg class="w-6 h-6 inline text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <span class="text-green-500"> Description </span>
                        <p class="text-slate-700 mt-2 font-bold py-2 px-2">
                            {{ $this->exams->description }}
                        </p>
                    </div>
                </div>
                <div class="relative overflow-x-auto sm:rounded text-end mt-3">
                    <div class="flex justify-end items-center">
                        <div class="mr-3">
                            <button class="text-white bg-slate-800 hover:bg-slate-900 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800"
                                @click="history.back()">Back</button>
                        </div>
                        @if ($isAdmin || $isTeacher)
                            <div class="text-end">
                                <button class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                        type="button" wire:click="editExam">
                                    Edit
                                </button>
                            </div>
                        @endif

                        @if (!$this->examSubmitted)
                            @if ($currentDate->between($startDate, $endDate))
                                @if ($this->isStudent)
                                    <button class="border bg-green-500 py-2 px-3 rounded-md text-white"
                                            wire:click='answerStart'>Answer</button>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if ($isExamPaperOpen)
            @if (session()->get('mins') != null && session()->get('seconds') != null)
                <div class=" shadow-lg px-20 py-10 flex justify-center items-center rounded-lg">
                    <svg class="w-6 h-6 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span class="text-2xl text-slate-700">{{ $minutes }} : {{ $seconds }}</span>
                </div>
            @endif
        @endif
    </div>

    {{-- exam answer by student block --}}
    @if (!$examSubmitted && $this->isStudent)
        @if ($isExamPaperOpen)
            <div class="w-3/4 mt-3 h-[85vh] overflow-auto">
                <form id="form" wire:submit.prevent="examSubmit" method="POST">
                    @csrf
                    @if (
                        $this->trueOrfalse->isNotEmpty() ||
                            $this->multipleChoice->isNotEmpty() ||
                            $this->matching->isNotEmpty() ||
                            $this->shortQuestion->isNotEmpty() ||
                            $this->essay->isNotEmpty())
                        <div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8">
                            <div class="p-2 rounded-xl shadow-2xl">
                                <h2 class="text-blue-800 text-end mt-3">Marks - 100</h2>
                                <div class=" px-3" id="question-tab-content">
                                    <div class="rounded-lg relative" id="question1" role="tabpanel"
                                         aria-labelledby="question1-tab">
                                        @if (isset($filterAnswerPaper[0]) && $pageNumber == 0)
                                            @if ($trueOrfalse->isNotEmpty())
                                                <div wire:transition.1000ms>
                                                    <div class="w-full flex justify-start items-center">
                                                        @include('exam_view.prev-next-button')
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
                                                                    <div class="text-slate-900 text-md">
                                                                        {{ $tof->question_no }}. <span
                                                                              class="ml-3">{{ strip_tags($tof->question) }}</span>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                     class="mb-[0.125rem] block min-h-[1.5rem] ml-6 mt-3">
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
                                                                <div
                                                                     class="mb-[0.125rem] block min-h-[1.5rem] ml-6 mt-3">
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
                                            @else
                                                <div class="m-3">
                                                    <p class="font-bold">There is no true/false</p>
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                    {{-- Multiple Choice Block --}}
                                    <div class=" rounded-lg" id="question2" role="tabpanel"
                                         aria-labelledby="question2-tab">
                                        @if (isset($filterAnswerPaper[1]) && $pageNumber == 1)
                                            @if ($this->multipleChoice->isNotEmpty())
                                                <div wire:transition.1000ms>
                                                    <div class="w-full flex justify-start items-center">
                                                        @include('exam_view.prev-next-button')
                                                    </div>
                                                    <div class="flex justify-between w-full mt-3">
                                                        <p class="font-bold text-slate-800 text-xl ms-2">II.
                                                            <span class="ms-3">Multiple Choice Questions.</span>
                                                        </p>
                                                        <p class="font-bold text-slate-800 text-xl">(1 Marks)</p>
                                                    </div>
                                                    <div class="m-2">
                                                        @foreach ($this->multipleChoice as $multi_choice)
                                                            <div class="flex justify-between">
                                                                <div class="flex justify-between">
                                                                    <div class="text-slate-900 text-md">
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

                                                                    <div class="flex">
                                                                        <span class="mt-px ml-2 block pl-[0.15rem] hover:cursor-pointer text-slate-600"
                                                                              for="{{ $multi_choice->choice_1 }}">
                                                                            (A)
                                                                        </span>
                                                                        <span
                                                                              class="block ml-2 w-full text-slate-600">{{ strip_tags($multi_choice->choice_1) }}</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            {{-- multiplce chooic 1 question --}}
                                                            <div
                                                                 class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6 my-3">
                                                                <label>
                                                                    <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                                           name="multiple_choice{{ $multi_choice->id }}"
                                                                           type="radio" value="2"
                                                                           wire:model="multipleChoiceAnswer.{{ $multi_choice->id }}" />

                                                                    <div class="flex">
                                                                        <span class="mt-px ml-2 block pl-[0.15rem] hover:cursor-pointer text-slate-600"
                                                                              for="{{ $multi_choice->choice_2 }}">
                                                                            (B)
                                                                        </span>
                                                                        <span
                                                                              class="block ml-2 w-full text-slate-600">{{ strip_tags($multi_choice->choice_2) }}</span>
                                                                    </div>
                                                                </label>
                                                            </div>

                                                            <div
                                                                 class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6 my-3">
                                                                <label>
                                                                    <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                                           name="multiple_choice{{ $multi_choice->id }}"
                                                                           type="radio" value="3"
                                                                           wire:model="multipleChoiceAnswer.{{ $multi_choice->id }}" />
                                                                    <div class="flex">
                                                                        <span class="mt-px ml-2 block pl-[0.15rem] hover:cursor-pointer text-slate-600"
                                                                              for="{{ $multi_choice->choice_3 }}">
                                                                            (C)
                                                                        </span>
                                                                        <span
                                                                              class="block ml-2 w-full text-slate-600">{{ strip_tags($multi_choice->choice_3) }}</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div
                                                                 class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6 my-3">
                                                                <label>
                                                                    <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                                           name="multiple_choice{{ $multi_choice->id }}"
                                                                           type="radio" value="4"
                                                                           wire:model="multipleChoiceAnswer.{{ $multi_choice->id }}" />
                                                                    <div class="flex">
                                                                        <span class="mt-px ml-2 block pl-[0.15rem] hover:cursor-pointer text-slate-600"
                                                                              for="{{ $multi_choice->choice_4 }}">
                                                                            (D)
                                                                        </span>
                                                                        <span
                                                                              class="block ml-2 w-full text-slate-600">{{ strip_tags($multi_choice->choice_4) }}</span>
                                                                    </div>
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
                                        @endif
                                    </div>

                                    {{-- Matching Block --}}
                                    <div class="rounded-lg" id="question3" role="tabpanel"
                                         aria-labelledby="question3-tab">
                                        {{-- <div>Matching</div> --}}
                                        @if (isset($filterAnswerPaper[2]) && $pageNumber == 2)
                                            @if ($this->matching->isNotEmpty())
                                                <div wire:transition.1000ms>
                                                    <div class="w-full flex justify-start items-center">
                                                        @include('exam_view.prev-next-button')
                                                    </div>
                                                    <div class="flex justify-between w-full mt-3">
                                                        <p class="font-bold text-slate-800 text-xl ms-2">III.
                                                            <span class="ms-3"> Matching Questions.</span>
                                                        </p>
                                                        <p class="font-bold text-slate-900 text-xl">(1 Marks)</p>
                                                    </div>
                                                    <div class="m-2">
                                                        @foreach ($this->matching as $key => $match)
                                                            <div class="flex justify-between">
                                                                <div class="flex justify-between">
                                                                    <div class="text-slate-700 text-md">
                                                                        {{ $match->question_no }}. <span
                                                                              class="ml-3">{{ strip_tags($match->question) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="ml-5 mt-3 w-full">
                                                                <div class="flex justify-between w-full">
                                                                    <div class="mt-2 text-slate-600 ml-5 flex w-full">
                                                                        (A)
                                                                        <span class="text-slate-700 block w-full ml-2">
                                                                            {{ strip_tags($match->question_1) }}</span>
                                                                    </div>
                                                                    <div class=" ">
                                                                        <select class="py-3 px-4 pe-9 block w-50 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                                                                        focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                                                                                        "
                                                                                wire:model="matchingAnswer.{{ $match->id }}.1">
                                                                            <option class="px-3 py-3" selected>Select
                                                                                One
                                                                            </option>
                                                                            <option class="h-50 text-slate-600"
                                                                                    value="1">
                                                                                {{ $match->answer_1 }}</option>
                                                                            <option class="h-50 text-slate-600"
                                                                                    value="2">
                                                                                {{ $match->answer_2 }}</option>
                                                                            <option class="h-50 text-slate-600"
                                                                                    value="3">
                                                                                {{ $match->answer_3 }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="flex justify-between mt-1 w-full">
                                                                    <div class="mt-2 text-slate-600 ml-5 flex w-full">
                                                                        (B)
                                                                        <span class="text-slate-700 block w-full ml-2">
                                                                            {{ strip_tags($match->question_2) }}</span>
                                                                    </div>
                                                                    <div class="">
                                                                        <select class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                                                                        focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                                                wire:model="matchingAnswer.{{ $match->id }}.2">
                                                                            <option class="px-3 py-3" selected>Select
                                                                                One
                                                                            </option>
                                                                            <option class="h-50 text-slate-600"
                                                                                    value="1">
                                                                                {{ $match->answer_1 }}</option>
                                                                            <option class="h-50 text-slate-600"
                                                                                    value="2">
                                                                                {{ $match->answer_2 }}</option>
                                                                            <option class="h-50 text-slate-600"
                                                                                    value="3">
                                                                                {{ $match->answer_3 }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="flex justify-between mt-1 w-full">
                                                                    <div class="mt-2 text-slate-600 ml-5 flex w-full">
                                                                        (C)
                                                                        <span class="text-slate-700 block w-full ml-2">
                                                                            {{ strip_tags($match->question_3) }}</span>
                                                                    </div>
                                                                    <div class="">
                                                                        <select class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                                                                        focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                                                wire:model="matchingAnswer.{{ $match->id }}.3">
                                                                            <option class="px-3 py-3" selected>Select
                                                                                One
                                                                            </option>
                                                                            <option class="h-50 text-slate-600"
                                                                                    value="1">
                                                                                {{ $match->answer_1 }}</option>
                                                                            <option class="h-50 text-slate-600"
                                                                                    value="2">
                                                                                {{ $match->answer_2 }}</option>
                                                                            <option class="h-50 text-slate-600"
                                                                                    value="3">
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
                                        @endif
                                    </div>

                                    {{-- ShortQuestion Block --}}
                                    <div class="rounded-lg" id="question4" role="tabpanel"
                                         aria-labelledby="question4-tab">
                                        @if (isset($filterAnswerPaper[3]) && $pageNumber == 3)
                                            @if ($this->shortQuestion->isNotEmpty())
                                                <div wire:transition.1000ms>
                                                    <div class="w-full flex justify-start items-center">
                                                        @include('exam_view.prev-next-button')
                                                    </div>
                                                    <div class="flex justify-between w-full mt-3">
                                                        <p class="font-bold text-slate-800 text-xl ms-2">IV.
                                                            <span class="ms-3"> Short Questions.</span>
                                                        </p>
                                                        <p class="font-bold text-slate-800 text-xl">(1 Marks)</p>
                                                    </div>
                                                    <div class="m-2">
                                                        @foreach ($this->shortQuestion as $key => $shortQ)
                                                            <div class="text-slate-700 text-md">
                                                                {{ $shortQ->question_no }}.
                                                                {{ strip_tags($shortQ->question) }}
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
                                        @endif
                                    </div>

                                    {{-- Essay Block --}}
                                    <div class="rounded-lg" id="question5" role="tabpanel"
                                         aria-labelledby="question5-tab">
                                        @if (isset($filterAnswerPaper[4]) && $pageNumber == 4)
                                            @if ($this->essay->isNotEmpty())
                                                <div class="w-full flex justify-start items-center">
                                                    @include('exam_view.prev-next-button')
                                                </div>
                                                <div wire:transition.1000ms>
                                                    <div class="flex justify-between w-full mt-3">
                                                        <p class="font-bold text-slate-800 text-xl ms-2">V.
                                                            <span class="ms-3"> Eassay Questions.</span>
                                                        </p>
                                                        <p class="font-bold text-slate-800 text-xl">(1 Marks)</p>
                                                    </div>
                                                    <div class="m-2">
                                                        @foreach ($this->essay as $key => $esy)
                                                            <div class="text-slate-700 text-md">
                                                                {{ $esy->question_no }}.
                                                                {{ strip_tags($esy->question) }}
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
                                        @endif
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button class="mr-4 bg-transparent hover:bg-green-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                                            type="submit">
                                        <span wire:loading wire:target='examSubmit'>Loading...</span>
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center items-center text-xl font-bold text-gray-500 px-40 py-60">There is no any other questions</div>
                    @endif
                </form>
            </div>
        @endif
    @endif

    {{-- show report for students after sumbmit --}}
    @if ($this->summaryView && $examStatus == 2)
        <div class="w-3/4 py-1 mt-3 sm:px-6 lg:px-8" wire:ignore>
            <div class="p-4 rounded-xl shadow-2xl bg-white">
                <h1 class="text-slate-700 text-center text-xl font-bold">Result</h1>
                <div class="flex justify-end">
                    <span
                          class="px-3 py-2 rounded text-white mb-4
                        @if ($gradeName == 'A') bg-green-800
                        @elseif ($gradeName == 'B')
                            bg-blue-800
                        @elseif ($gradeName == 'C')
                            bg-orange-500
                        @else
                            bg-red-600 @endif">
                        Grade : {{ $gradeName }}
                    </span>
                </div>

                <table class="w-full border border-slate-500 border-collapse text-sm text-left text-gray-500">
                    <thead class=" text-slate-800 text-md uppercase">
                        <tr class="">
                            <th class="px-6 py-3 border border-slate-600" scope="col">No.</th>
                            <th class="px-6 py-3 border border-slate-600" scope="col">Status</th>
                            <th class="px-6 py-3 border border-slate-600" scope="col">Question</th>
                            <th class="px-6 py-3 border border-slate-600" scope="col">Marks /
                                {{ $this->numberOfQuestion }}</th>
                            <th class="px-6 py-3 border border-slate-600" scope="col">Grade /
                                {{ $this->baseTotalMark }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->examSummary as $key => $row)
                            <tr class="">
                                <td class="px-6 py-3 border border-slate-600 text-slate-900">{{ $loop->index + 1 }}
                                </td>
                                <td class="px-6 py-3 border border-slate-600 text-slate-900">Finished <br> Sumitted
                                    {{ $this->examSubmittedDate }}</td>
                                <td class="px-6 py-3 border border-slate-600 text-slate-900" scope="col">
                                    {{ $key }}</td>
                                <td class="px-6 py-3 border border-slate-600 text-slate-900" scope="col">
                                    {{ $row['correct'] }} / {{ $row['origin'] }}</td>
                                <td class="px-6 py-3 border border-slate-600 text-slate-900" scope="col">
                                    {{ $row['grade'] }} / {{ $row['total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-2 flex justify-end items-center w-full p-3 bg-green-500 rounded-lg">
                    <h2 class=" text-white">Highest Mark: {{ $this->gradeMark }} / {{ $this->baseTotalMark }}</h2>
                </div>
            </div>
        </div>
    @endif

    {{-- Teacher view for submitted students report --}}
    @if ($this->isTeacher && $this->isExamSubmittedStudent)
        <div class="mx-auto w-3/4 py-1 sm:px-6 lg:px-8 my-5 h-[85vh] overflow-auto">
            <div class="p-4 rounded-xl shadow-lg bg-white">
                <h2 class="font-bold text-xl mb-4 text-slate-700">Submitted Students</h2>
                <table class="w-full border border-slate-500 border-collapse text-sm text-left text-gray-500 ">
                    <thead class="text-md text-gray-700 uppercase">
                        <tr class="">
                            <th class="px-3 py-3 border border-slate-600">No.</th>
                            <th class="px-3 py-3 border border-slate-600" scope="col">Sumitted Date</th>
                            <th class="px-3 py-3 border border-slate-600" scope="col">Name</th>
                            <th class="px-3 py-3 border border-slate-600" scope="col">Email</th>
                            <th class="px-3 py-3 border border-slate-600" scope="col">Status</th>
                            <th class="px-3 py-3 border border-slate-600" scope="col">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->exam_answered_users as $key => $row)
                            <tr class="text-slate-800 text-base">
                                <td class="px-3 py-3 border border-slate-600">{{ $loop->index + 1 }}</td>
                                <td class="px-3 py-3 border border-slate-600"> <strong> Sumitted at
                                        {{ $row->created_at }}</td>
                                <td class="px-3 py-3 border border-slate-600" scope="">{{ $row->user->name }}
                                </td>
                                <td class="px-3 py-3 border border-slate-600" scope="">{{ $row->user->email }}
                                </td>
                                @if ($row->status == 1)
                                    <td class="px-3 py-3 border border-slate-600">
                                        <span class="bg-blue-200 text-slate-800 rounded py-1 px-2 text-xs">
                                            Inprocess
                                        </span>
                                    </td>
                                @else
                                    <td class="px-3 py-3 border border-slate-600">
                                        <span class="bg-green-200 text-slate-800 rounded py-1 px-2 text-xs">
                                            Checked
                                        </span>
                                    </td>
                                @endif
                                <td class="px-3 py-3 border border-slate-600">
                                    <button class="py-1 px-3 bg-blue-600 hover:bg-blue-700 text-white rounded"
                                            wire:click="checkAnswer({{ $row->user_id }},{{ $row->exam_id }})">show</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="999" class="text-center font-bold text-lg px-1 py-2">There is no submitted students</th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- check by teacher --}}
    @if ($checkAnsweredPaper)
        {{-- <h1>Hello</h1> --}}
        @include('exam_view.exam-answered-paper')
    @endif

    {{-- exam edit modal --}}
    @if ($isEditExam)
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
                            Edit Exam
                        </h3>
                        <button class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                type="button" wire:click="toggleModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 14 14">
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
                            <div class="w-2/3">
                                <div class="ml-2">
                                    <label class="">
                                        <span>Exam Name</span>
                                        <input class="border mt-2 border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                               id="inline-full-name" type="text" wire:model="exam_name">
                                    </label>
                                </div>
                            </div>
                            <div class="w-2/3">
                                <div class="ml-2">
                                    <label class="">
                                        <span>Start Date Time</span>
                                        <input class="border mt-2 border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                               id="inline-full-name" type="date" wire:model="start_date_time">
                                    </label>
                                </div>
                            </div>
                            <div class="w-2/3 ml-2">
                                <label class="">
                                    <span>End Date Time</span>
                                    <input class="border mt-2 border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                           id="inline-full-name" type="date" wire:model="end_date_time">
                                </label>
                            </div>
                            <div class="w-1/3 ml-2">
                                <label class="">
                                    <span>Duration(minutes)</span>
                                    <input class="border mt-2 border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                           id="inline-full-name" type="number" wire:model="duration_field">
                                </label>
                            </div>
                        </div>

                        <div class="flex m-2">
                            <div class="w-full ml-2">
                                <label class="">
                                    <span>Description</span>
                                    <textarea class="w-full mt-2 rounded" id="" name="" wire:model="description" cols="30"
                                              rows="10"></textarea>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="button" wire:click="updateExam">
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
    // let minutes = @this.minutes;

    let duration = setInterval(() => {
        console.log(@this.minutes);
        if (@this.startAnswer) {
            @this.call('decreaseTimer');

            if (@this.minutes == 0) {
                clearInterval(duration);
            }
        }
    }, 100);
</script>
