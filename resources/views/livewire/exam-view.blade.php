<div class="min-h-full w-full @if ($isExamPaperOpen == true) flex @endif" id="examViewContainer">
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

    {{-- {{ session()->get('timer') }} - {{ session()->get('minutes') }} - {{ session()->get('startAnswer') }} --}}
    <div class="mt-3  max-w-6xl mx-auto
        @if ($isExamPaperOpen) w-1/4 py-1 ms-2 @endif
    ">
        <div class="w-full my-5">
            @if ($this->summaryView && $examStatus == 1)
                <div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8 ">
                    <div class="p-4 rounded shadow-xl bg-slate-300 text-blue-500">
                        <label class="">Wait for Exam Result</label>
                    </div>
                </div>
            @endif
            <div class="p-4 rounded-xl transform transition-all duration-300 shadow-4xl shadow-lg">
                <div class="border-b border-slate-500 pb-2">
                    <h2 class="text-xl font-bold text-slate-800">{{ $this->exams->exam_name }}</h2>

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
                    @if (!$this->examSubmitted)
                        <button class="border bg-blue-600 py-2 px-3 rounded-md text-white"
                                @click="history.back()">Back</button>
                        @if ($currentDate->between($startDate, $endDate))
<<<<<<< Updated upstream
                            <button class="border bg-green-500 py-2 px-3 rounded-md text-white" id="answer"
                                    wire:click='answerStart'>Answer</button>
=======
                            @if ($this->studentAccess->role_id == 3)
                                <button class="border bg-green-500 py-2 px-3 rounded-md text-white"
                                        wire:click='answerStart'>Answer</button>
                            @endif
>>>>>>> Stashed changes
                        @endif
                    @endif
                </div>
            </div>
        </div>
        @if ($isExamPaperOpen)
            <div class=" shadow-lg px-20 py-10 flex justify-center items-center rounded-lg">
                <svg class="w-6 h-6 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="text-2xl text-slate-700">{{ $duration }} : {{ $timer }}</span>
            </div>
        @endif
    </div>

    {{-- exam answer by student block --}}
    @if (!$examSubmitted && $this->isStudent)
        @if ($isExamPaperOpen)
            <div class="w-3/4 mt-3 h-[85vh] overflow-auto">
                <form id="form" wire:submit.prevent="examSubmit" method="POST" >
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
                                        @if ($pageNumber == 1)
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
                                        @if ($pageNumber == 2)
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
                                        @if ($pageNumber == 3)
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
                                        @if ($pageNumber == 4)
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
                                        @if ($pageNumber == 5)
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
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        @endif
    @endif

    {{-- show report for students after sumbmit --}}
    @if ($this->summaryView && $examStatus == 2)
        <div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8" wire:ignore>
            <div class="p-4 rounded-xl shadow-2xl bg-slate-300">
                {{-- <h2 class="font-bold text-xl mb-4">Summary</h2>
                <div>Grade : {{ $gradeName }}</div> --}}
                <div class="flex justify-between">
                    <h2 class="font-bold text-xl bg-blue-600 px-2 py-2 rounded text-white mb-4">Result</h2>
                    <span
                          class="px-3 py-2 rounded text-white mb-4
                        @if ($gradeName == 'A') bg-green-800
                        @elseif ($gradeName == 'B')
                            bg-blue-800
                        @elseif ($gradeName == 'C')
                            bg-orange-500
                        @else
                            bg-red-600 @endif">
                        Grade : {{ $gradeName }}</span>
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
                                    <button class="py-2 px-3 bg-gray-600 text-white rounded"
                                            wire:click="checkAnswer({{ $row->user_id }},{{ $row->exam_id }})">show</button>
                                </td>
                            </tr>
                        @endforeach
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

    setInterval(() => {
        if (@this.startAnswer) {
            @this.call('decreaseTimer');
        }
    }, 100);
</script>
