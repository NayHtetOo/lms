<div class="w-3/4 mt-3 py-1 sm:px-6 lg:px-8 relative">
    <div class="w-full b-4 border-b  mt-5">
        <div class="bg-white rounded-lg shadow-md my-3 py-3">
            <div class="px-2 py-2 text-end my-3 text-blue-600 font-bold">
                <p class="flex items-center justify-end w-full">
                    @if ($checkedCurrentUser->user_photo_path)
                        <img class="w-[50px] h-[50px] rounded-full mr-3"
                             src="{{ asset('storage/' . $checkedCurrentUser->user_photo_path) }}"
                             alt="{{ $checkedCurrentUser->name . "'s photo" }}">
                    @else
                        <img class="w-[50px] h-[50px] rounded-full mr-3" src="{{ asset('images/profile_default.jpg') }}"
                             alt="profile default">
                    @endif
                    <span>{{ $checkedCurrentUser?->name }}</span>
                </p>
            </div>
            <div class="w-full flex justify-center items-center">
                <div class="inline-block">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center bg-gray-200 rounded-full px-3">
                        @if ($trueOrfalse->isNotEmpty())
                            <li class="me-2 py-2">
                                <span class="inline-block cursor-pointer text-slate-800 text-md p-2 {{ $questionType == 1 ? 'bg-blue-600 text-white rounded-full' : '' }} hover:bg-blue-600 hover:rounded-full hover:text-white"
                                      wire:click="loadQuestion(1)">True or False</span>
                            </li>
                        @endif

                        <li class="me-2 py-2">
                            <span class="inline-block cursor-pointer text-slate-800 text-md p-2 {{ $questionType == 2 ? 'bg-blue-600 text-white rounded-full' : '' }} hover:bg-blue-600 hover:rounded-full hover:text-white"
                                  wire:click="loadQuestion(2)">Multiple Choice</span>
                        </li>

                        <li class="me-2 py-2">
                            <span class="inline-block cursor-pointer text-slate-800 text-md p-2 {{ $questionType == 3 ? 'bg-blue-600 text-white rounded-full' : '' }} hover:bg-blue-600 hover:rounded-full hover:text-white"
                                  wire:click="loadQuestion(3)">Matching</span>
                        </li>

                        <li class="me-2 py-2">
                            <span class="inline-block cursor-pointer text-slate-800 text-md p-2 {{ $questionType == 4 ? 'bg-blue-600 text-white rounded-full' : '' }} hover:bg-blue-600 hover:rounded-full hover:text-white"
                                  wire:click="loadQuestion(4)">Short Question</span>
                        </li>

                        <li class="me-2 py-2">
                            <span class="inline-block cursor-pointer text-slate-800 text-md p-2 {{ $questionType == 5 ? 'bg-blue-600 text-white rounded-full' : '' }} hover:bg-blue-600 hover:rounded-full hover:text-white"
                                  wire:click="loadQuestion(5)">Essay</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->has('message'))
        @foreach ($errors->get('message') as $error)
            <p class="error">{{ $error }}</p>
        @endforeach
    @endif

    <div class="p-2 rounded-xl shadow-2xl bg-white h-[55vh] overflow-auto">
        <form wire:submit.prevent="examMarkUpdate({{ $checkedCurrentUser?->id }})" method="POST">
            @csrf
            {{-- button area  --}}
            <div class="fixed right-0 bottom-5 z-10">
                <button class="mb-3 mr-4 bg-green-500 hover:bg-green-600 text-white font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded"
                        type="button" wire:click="backToSumittedStudent">
                    Back
                </button>
                <button class="mb-3 mr-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold hover:text-white py-2 px-3 border border-blue-500 hover:border-transparent rounded"
                        type="submit">
                    Submit
                </button>
            </div>

            <div class="rounded-xl">
                <div class="p-2 mb-4 border-b border-gray-200">
                    {{-- true or false --}}
                    @if ($questionType == 1)
                        @if ($trueOrfalse->isNotEmpty())
                            <div class="m-3">
                                <div class="flex justify-between items-center font-bold text-lg text-slate-800">
                                    <p class="">I.True or False Questions.</p>
                                    <span class=""> (1 Mark)</span>
                                </div>
                                <div class="m-2">
                                    @foreach ($trueOrfalse as $tof)
                                        <div class="my-5">
                                            <div class="text-base text-slate-800">
                                                {{ $tof->true_or_false?->question_no }}.
                                                {{ strip_tags($tof->true_or_false?->question) }}
                                            </div>
                                            <label class="m-6 mt-4 text-base text-slate-800" for="">Select One :
                                            </label>

                                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                                <label class="flex items-center">
                                                    <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                           name="trueOrfalse{{ $tof->true_or_false_id }}"
                                                           type="radio" value="1" disabled
                                                           wire:model="trueorfalseAnswer.{{ $tof->true_or_false_id }}" />
                                                    <span
                                                          class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2 text-base text-slate-800">
                                                        True
                                                    </span>
                                                    @include('exam_view.true_false.true-false-check', [
                                                        'check' => 1,
                                                    ])
                                                </label>
                                            </div>
                                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                                <label class="flex items-center">
                                                    <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                           name="trueOrfalse{{ $tof->true_or_false_id }}"
                                                           type="radio" value="0" disabled
                                                           wire:model="trueorfalseAnswer.{{ $tof->true_or_false_id }}" />
                                                    <span
                                                          class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2 text-base text-slate-800">
                                                        False
                                                    </span>

                                                    @include('exam_view.true_false.true-false-check', [
                                                        'check' => 0,
                                                    ])

                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="m-3">
                                <p class="font-bold">There is no True or False</p>
                            </div>
                        @endif
                    @endif

                    {{-- Multiple choice --}}
                    @if ($questionType == 2)
                        @if ($multipleChoice->isNotEmpty())
                            <div class="m-3">
                                <p class="font-bold text-slate-800 text-lg">II. Multiple Choice Questions.</p>
                                <div class="m-2">
                                    @foreach ($multipleChoice as $multi_choice)
                                        <div class="my-5">
                                            <div class="flex justify-between">
                                                <div class="text-base text-slate-800">
                                                    {{ $multi_choice->multiple_choice->question_no }}.
                                                    {{ strip_tags($multi_choice->multiple_choice->question) }}
                                                </div>
                                                <div class="text-base text-slate-800">
                                                    {{ $multi_choice->multiple_choice->mark }} Mark</div>
                                            </div>

                                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                                <label class="flex items-start">
                                                    <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                           name="multiple_choice{{ $multi_choice->multiple_choice_id }}"
                                                           type="radio" value="1" disabled
                                                           wire:model="multipleChoiceAnswer.{{ $multi_choice->multiple_choice_id }}" />
                                                    <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2 text-slate-800 w-[700px]"
                                                          for="{{ $multi_choice->multiple_choice->choice_1 }}">
                                                        (A)
                                                        {{ $multi_choice->multiple_choice->choice_1 }}
                                                    </span>

                                                    @include(
                                                        'exam_view.multiple_choice.multiple-choice-check',
                                                        ['check' => 1]
                                                    )

                                                </label>
                                            </div>
                                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                                <label class="flex items-start">
                                                    <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                           name="multiple_choice{{ $multi_choice->multiple_choice_id }}"
                                                           type="radio" value="2" disabled
                                                           wire:model="multipleChoiceAnswer.{{ $multi_choice->multiple_choice_id }}" />
                                                    <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2 text-slate-800 w-[700px]"
                                                          for="{{ $multi_choice->multiple_choice->choice_2 }}">
                                                        (B) {{ $multi_choice->multiple_choice->choice_2 }}
                                                    </span>

                                                    @include(
                                                        'exam_view.multiple_choice.multiple-choice-check',
                                                        ['check' => 2]
                                                    )

                                                </label>
                                            </div>
                                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                                <label class="flex items-start">
                                                    <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                           name="multiple_choice{{ $multi_choice->multiple_choice_id }}"
                                                           type="radio" value="3" disabled
                                                           wire:model="multipleChoiceAnswer.{{ $multi_choice->multiple_choice_id }}" />
                                                    <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2 text-slate-800 w-[700px]"
                                                          for="{{ $multi_choice->multiple_choice->choice_3 }}">
                                                        (C) {{ $multi_choice->multiple_choice->choice_3 }}
                                                    </span>
                                                    @include(
                                                        'exam_view.multiple_choice.multiple-choice-check',
                                                        ['check' => 3]
                                                    )

                                                </label>
                                            </div>
                                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                                <label class="flex items-start">
                                                    <input class="relative float-left mr-1 mt-0.5 h-5 w-5"
                                                           name="multiple_choice{{ $multi_choice->multiple_choice_id }}"
                                                           type="radio" value="4" disabled
                                                           wire:model="multipleChoiceAnswer.{{ $multi_choice->multiple_choice_id }}" />
                                                    <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2 text-slate-800 w-[700px]"
                                                          for="{{ $multi_choice->multiple_choice->choice_4 }}">
                                                        (D) {{ $multi_choice->multiple_choice->choice_4 }}
                                                    </span>
                                                    @include(
                                                        'exam_view.multiple_choice.multiple-choice-check',
                                                        ['check' => 4]
                                                    )

                                                </label>
                                            </div>

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

                    {{-- Matching --}}
                    @if ($questionType == 3)
                        @if ($matching->isNotEmpty())
                            <div class="m-3">
                                <p class="font-bold text-slate-800 text-lg">III. Matching Questions.</p>
                                <div class="m-2">

                                    @foreach ($matching as $key => $match)
                                        <div class="my-5">
                                            <div class="flex justify-between">
                                                <div class="text-slate-800">
                                                    {{ $match->matching->question_no }}.
                                                    {{ $match->matching->question }}
                                                </div>
                                                <div class="text-slate-800"> {{ $match->matching->mark }} Mark</div>
                                            </div>

                                            <div class="ml-5 mt-3">
                                                <div class="flex justify-between">
                                                    <div class="mt-2">
                                                        <label class="flex items-center text-slate-800 text-base">
                                                            (A)
                                                            {{ strip_tags($match->matching->question_1) }}
                                                            @php
                                                                $value;
                                                                $index = 1;
                                                                if (isset($matchingAnswer[$match->matching_id])) {
                                                                    if (isset($matchingAnswer[$match->matching_id][$index])) {
                                                                        $value = $matchingAnswer[$match->matching_id][$index];
                                                                    }
                                                                }
                                                            @endphp

                                                            @include('exam_view.matching.matching-check', [
                                                                'check' => $index,
                                                            ])
                                                        </label>
                                                    </div>
                                                    <div class="mr-20">
                                                        <select class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                                        focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                                                        "
                                                                disabled
                                                                wire:model="matchingAnswer.{{ $match->matching_id }}.1">
                                                            <option class="px-3 py-3" selected>Select One</option>
                                                            <option class="h-50" value="1">
                                                                {{ $match->matching->answer_1 }}</option>
                                                            <option class="h-50" value="2">
                                                                {{ $match->matching->answer_2 }}</option>
                                                            <option class="h-50" value="3">
                                                                {{ $match->matching->answer_3 }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between mt-1">
                                                    <div class="mt-2">
                                                        <label class="flex items-center text-slate-800 text-base">
                                                            (B) {{ strip_tags($match->matching->question_2) }}
                                                            @php
                                                                $value;
                                                                $index = 2;
                                                                if (isset($matchingAnswer[$match->matching_id])) {
                                                                    if (isset($matchingAnswer[$match->matching_id][$index])) {
                                                                        $value = $matchingAnswer[$match->matching_id][$index];
                                                                    }
                                                                }
                                                            @endphp
                                                            @include('exam_view.matching.matching-check', [
                                                                'check' => $index,
                                                            ])

                                                        </label>
                                                    </div>
                                                    <div class="mr-20">
                                                        <select class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                                        focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                                disabled
                                                                wire:model="matchingAnswer.{{ $match->matching_id }}.2">
                                                            <option class="px-3 py-3" selected>Select One</option>
                                                            <option class="h-50" value="1">
                                                                {{ $match->matching->answer_1 }}</option>
                                                            <option class="h-50" value="2">
                                                                {{ $match->matching->answer_2 }}</option>
                                                            <option class="h-50" value="3">
                                                                {{ $match->matching->answer_3 }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between mt-1">
                                                    <div class="mt-2">
                                                        <label class="flex items-center text-slate-800 text-md">
                                                            (C) {{ strip_tags($match->matching->question_3) }}
                                                            @php
                                                                $value;
                                                                $index = 3;
                                                                if (isset($matchingAnswer[$match->matching_id])) {
                                                                    if (isset($matchingAnswer[$match->matching_id][$index])) {
                                                                        $value = $matchingAnswer[$match->matching_id][$index];
                                                                    }
                                                                }
                                                            @endphp

                                                            @include('exam_view.matching.matching-check', [
                                                                'check' => $index,
                                                            ])

                                                        </label>
                                                    </div>
                                                    <div class="mr-20">
                                                        <select class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                                        focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                                disabled
                                                                wire:model="matchingAnswer.{{ $match->matching_id }}.3">
                                                            <option class="px-3 py-3" selected>Select One</option>
                                                            <option class="h-50" value="1">
                                                                {{ $match->matching->answer_1 }}</option>
                                                            <option class="h-50" value="2">
                                                                {{ $match->matching->answer_2 }}</option>
                                                            <option class="h-50" value="3">
                                                                {{ $match->matching->answer_3 }}</option>
                                                        </select>
                                                    </div>
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

                    {{-- Short Question --}}
                    @if ($questionType == 4)
                        @if ($shortQuestion->isNotEmpty())
                            <div class="m-3">
                                <p class="font-bold text-slate-800 text-lg">IV. Short Questions.</p>
                                <div class="m-2">
                                    @foreach ($shortQuestion as $key => $shortQ)
                                        <div class="flex justify-between">
                                            <div class="text-base text-slate-800">
                                                {{ $shortQ->short_question->question_no }}.
                                                {{ strip_tags($shortQ->short_question->question) }}
                                            </div>
                                            <div class="text-base text-slate-800"> {{ $shortQ->short_question->mark }}
                                                Mark</div>
                                        </div>
                                        <div class="p-5 pr-20">
                                            <textarea wire:click='shortQuestionView({{ $shortQ->id }})' class="w-full bg-gray-200 h-40 rounded-md cursor-pointer" readonly
                                                      wire:model="shortQuestionAnswer.{{ $shortQ->short_question_id }}"></textarea>
                                        </div>

                                        <div class="md:flex md:items-center mb-6 mr-0">
                                            <div class="md:w-3/4">
                                                <label class="block text-slate-800 font-bold md:text-right mb-1 md:mb-0 mr-2"
                                                       for="inline-full-name">
                                                    Mark
                                                </label>
                                            </div>
                                            <div class="md:w-1/6 mr-20 flex items-center text-white rounded-lg">
                                                <input class="border border-slate-500 rounded w-full py-2 px-2 text-slate-800 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                                       id="inline-full-name" type="number"
                                                       wire:model="shortQuestionReceiveMark.{{ $shortQ->id }}">
                                            </div>
                                        </div>
                                    @endforeach

                                        @include('modal.exam-answered-paper-short-question-view-modal')
                                </div>
                            </div>
                        @else
                            <div class="m-3">
                                <p class="font-bold">There is no short question</p>
                            </div>
                        @endif
                    @endif

                    @if ($questionType == 5)
                        @if ($essay->isNotEmpty())
                            <div class="m-3">
                                <p class="font-bold text-lg text-slate-800">V. Essay Questions.</p>
                                <div class="m-2">
                                    @foreach ($essay as $key => $esy)
                                        <div class="flex justify-between">
                                            <div class="text-slate-800 text-base">
                                                {{ $esy->essay->question_no }}.
                                                {{ strip_tags($esy->essay->question) }}
                                            </div>
                                            <div class="text-slate-800 text-base"> {{ $esy->essay->mark }} Mark</div>
                                        </div>
                                        <div class="p-5 pr-20">
                                            <textarea class="bg-gray-200 w-full h-40 rounded-md" disabled wire:model="essayAnswer.{{ $esy->essay_id }}"></textarea>
                                        </div>

                                        <div class="md:flex md:items-center mb-6 mr-0">
                                            <div class="md:w-3/4">
                                                <label class="block text-slate-800 font-bold md:text-right mb-1 md:mb-0 pr-4"
                                                       for="inline-full-name">
                                                    Receive Mark
                                                </label>
                                            </div>
                                            <div class="md:w-1/6 mr-20">
                                                <input class="appearance-none border border-gray-400 rounded w-full py-2 px-2 text-slate-800 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                                       id="inline-full-name" type="number"
                                                       wire:model="essayReceiveMark.{{ $esy->id }}">
                                            </div>
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

            {{-- @include('exam_view.deleted_files.question-view') --}}

        </form>
    </div>
</div>
