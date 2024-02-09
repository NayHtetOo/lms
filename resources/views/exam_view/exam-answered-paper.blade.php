<div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8">
    <div class="p-2 rounded-xl shadow-2xl bg-slate-300">
        <form wire:submit.prevent="examMarkUpdate({{ $checkedCurrentUser?->id }})" method="POST">
            @csrf

            <div class=" rounded-xl shadow-lg">
                <div class="mb-4 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center bg-gray-500 rounded-md px-3">
                        <li class="me-2 py-2">
                            <button wire:click="loadQuestion(1)" class="inline-block text-white text-md p-2 hover:bg-blue-600 hover:text-white" type="button">True or False</button>
                        </li>

                        <li class="me-2 py-2">
                            <button wire:click="loadQuestion(2)" class="inline-block text-white text-md p-2 hover:bg-blue-600 hover:text-white" type="button">Multiple Choice</button>
                        </li>

                        <li class="me-2 py-2">
                            <button wire:click="loadQuestion(3)" class="inline-block text-white text-md p-2 hover:bg-blue-600 hover:text-white" type="button">Matching</button>
                        </li>

                        <li class="me-2 py-2">
                            <button wire:click="loadQuestion(4)" class="inline-block text-white text-md p-2 hover:bg-blue-600 hover:text-white" type="button">Short Question</button>
                        </li>

                        <li class="me-2 py-2">
                            <button wire:click="loadQuestion(5)" class="inline-block text-white text-md p-2 hover:bg-blue-600 hover:text-white" type="button">Essay</button>
                        </li>

                    </ul>
                </div>

                <div id="default-tab-content">
                    <label for="">hello</label>
                </div>
            </div>

            <div>
                <span wire:click="backToSumittedStudent" class="text-blue-700 underline">Submitted Students</span> / {{ $checkedCurrentUser?->name }}'s Answer Paper
            </div> <br>

            {{-- <h2 class="text-2xl mb-1 font-bold">Checking {{ $checkedCurrentUser?->name }}'s Answer Paper</h2> --}}
            <div class="items-center flex">
                <h2 class="text-center mx-auto font-bold">Student Name : {{ $checkedCurrentUser?->name }}</h2>
            </div>

            <div id="question-tab-content">
                <!-- {{-- {{ True or False Block }} --}} -->
                <div class="p-4 rounded-lg" id="question1" role="tabpanel" aria-labelledby="question1-tab">
                    {{-- this trueOrfalse is assigned trueOrfalse answer in component or studend answered trueOrfalse--}}
                    @if ($trueOrfalse->isNotEmpty())
                        <div class="m-3">
                            <p class="font-bold">I.True or False Questions.</p>
                            {{-- <div>{{ $trueOrfalse }}</div> --}}
                            <div class="m-2">
                                @foreach ($trueOrfalse as $tof)
                                    <div class="flex justify-between">
                                        <div>
                                            {{ $tof->true_or_false?->question_no }}. {{ strip_tags($tof->true_or_false?->question) }}
                                        </div>
                                        <div> 1 Mark</div>
                                    </div>
                                    <label class="m-6 mt-4" for="">Select One : </label>
                                    {{-- <p class="p-1">{{ $this->exams->question }}</p> --}}

                                    <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                        <label class="flex items-center">
                                            <input type="radio" disabled wire:model="trueorfalseAnswer.{{ $tof->true_or_false_id }}" value="1" name="trueOrfalse{{ $tof->true_or_false_id }}" class="relative float-left mr-1 mt-0.5 h-5 w-5" />
                                            <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2">
                                                True
                                            </span>
                                            @include('exam_view.true_false.true-false-check',[
                                                'check' => 1
                                            ])
                                        </label>
                                    </div>
                                    <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                        <label class="flex items-center">
                                            <input type="radio" disabled wire:model="trueorfalseAnswer.{{ $tof->true_or_false_id }}" value="0" name="trueOrfalse{{ $tof->true_or_false_id }}" class="relative float-left mr-1 mt-0.5 h-5 w-5" />
                                            <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2">
                                                False
                                            </span>

                                            @include('exam_view.true_false.true-false-check',[
                                                'check' => 0
                                            ])

                                        </label>
                                    </div>

                                @endforeach
                            </div>
                        </div>

                    @endif
                </div>

                <!-- {{-- Multiple Choice Block --}} -->
                <div class="p-4 rounded-lg" id="question22" role="tabpanel" aria-labelledby="question22-tab">
                    {{-- this multipleChoice is assigned multipleChoice answer in component or studend answered multipleChoice--}}
                    @if ($multipleChoice->isNotEmpty())
                        <div class="m-3">
                            <p class="font-bold">II. Multiple Choice Questions.</p>
                            <div class="m-2">
                                @foreach ($multipleChoice as $multi_choice)
                                    <div class="flex justify-between">
                                        <div>
                                            {{ $multi_choice->multiple_choice->question_no }}. {{ strip_tags($multi_choice->multiple_choice->question) }}
                                        </div>
                                        <div> {{ $multi_choice->multiple_choice->mark }} Mark</div>
                                    </div>

                                    <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                        <label class="flex items-center">
                                            <input type="radio" disabled wire:model="multipleChoiceAnswer.{{ $multi_choice->multiple_choice_id }}" value="1" name="multiple_choice{{ $multi_choice->multiple_choice_id }}" class="relative float-left mr-1 mt-0.5 h-5 w-5" />
                                            <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2" for="{{ $multi_choice->multiple_choice->choice_1 }}">
                                                (A) {{ $multi_choice->multiple_choice->choice_1 }}
                                            </span>

                                            @include('exam_view.multiple_choice.multiple-choice-check',['check' => 1 ])

                                        </label>
                                    </div>
                                    <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                        <label class="flex items-center">
                                            <input type="radio" disabled wire:model="multipleChoiceAnswer.{{ $multi_choice->multiple_choice_id }}" value="2" name="multiple_choice{{ $multi_choice->multiple_choice_id }}" class="relative float-left mr-1 mt-0.5 h-5 w-5" />
                                            <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2" for="{{  $multi_choice->multiple_choice->choice_2  }}">
                                                (B) {{  $multi_choice->multiple_choice->choice_2  }}
                                            </span>

                                            @include('exam_view.multiple_choice.multiple-choice-check',[ 'check' => 2 ])

                                        </label>
                                    </div>
                                    <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                        <label class="flex items-center">
                                            <input type="radio" disabled wire:model="multipleChoiceAnswer.{{ $multi_choice->multiple_choice_id }}" value="3" name="multiple_choice{{ $multi_choice->multiple_choice_id }}" class="relative float-left mr-1 mt-0.5 h-5 w-5" />
                                            <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2" for="{{  $multi_choice->multiple_choice->choice_3  }}">
                                                (C) {{  $multi_choice->multiple_choice->choice_3  }}
                                            </span>
                                            @include('exam_view.multiple_choice.multiple-choice-check',[ 'check' => 3 ])

                                        </label>
                                    </div>
                                    <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                        <label class="flex items-center">
                                            <input type="radio" disabled wire:model="multipleChoiceAnswer.{{ $multi_choice->multiple_choice_id }}" value="4" name="multiple_choice{{ $multi_choice->multiple_choice_id }}" class="relative float-left mr-1 mt-0.5 h-5 w-5" />
                                            <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2" for="{{  $multi_choice->multiple_choice->choice_4 }}">
                                                (D)  {{  $multi_choice->multiple_choice->choice_4 }}
                                            </span>
                                            @include('exam_view.multiple_choice.multiple-choice-check',[ 'check' => 4 ])

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


                <!-- {{-- Matching Block --}} -->
                <div class="p-4 rounded-lg" id="question3" role="tabpanel" aria-labelledby="question3-tab">
                    {{-- this matching is assigned matching answer in component or studend answered matching--}}
                    @if ($matching->isNotEmpty())
                        <div class="m-3">
                            <p class="font-bold">III. Matching Questions.</p>
                            <div class="m-2">

                                @foreach ($matching as $key => $match)
                                    <div class="flex justify-between">
                                        <div>
                                            {{ $match->matching->question_no }}. {{ $match->matching->question }}
                                        </div>
                                        <div> {{ $match->matching->mark }} Mark</div>
                                    </div>

                                    <div class="ml-5 mt-3">
                                        <div class="flex justify-between">
                                            <div class="mt-2">
                                                <label class="flex items-center">
                                                    (A) {{ strip_tags($match->matching->question_1) }}
                                                    @php
                                                        $value;
                                                        $index = 1;
                                                        if(isset($matchingAnswer[$match->matching_id])){
                                                            if(isset($matchingAnswer[$match->matching_id][$index])){
                                                                $value = $matchingAnswer[$match->matching_id][$index];
                                                            }
                                                        }
                                                    @endphp

                                                    @include('exam_view.matching.matching-check',['check' => $index])
                                                </label>
                                            </div>
                                            <div class="mr-20">
                                                <select disabled wire:model="matchingAnswer.{{ $match->matching_id }}.1" class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                                    focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                                                    ">
                                                    <option selected class="px-3 py-3">Select One</option>
                                                    <option class="h-50" value="1">{{ $match->matching->answer_1 }}</option>
                                                    <option class="h-50" value="2">{{ $match->matching->answer_2 }}</option>
                                                    <option class="h-50" value="3">{{ $match->matching->answer_3 }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex justify-between mt-1">
                                            <div class="mt-2">
                                                <label class="flex items-center">
                                                    (B) {{ strip_tags($match->matching->question_2) }}
                                                    @php
                                                        $value;
                                                        $index = 2;
                                                        if(isset($matchingAnswer[$match->matching_id])){
                                                            if(isset($matchingAnswer[$match->matching_id][$index])){
                                                                $value = $matchingAnswer[$match->matching_id][$index];
                                                            }
                                                        }
                                                    @endphp
                                                    @include('exam_view.matching.matching-check',['check' => $index])

                                                </label>
                                            </div>
                                            <div class="mr-20">
                                                <select disabled wire:model="matchingAnswer.{{ $match->matching_id }}.2" class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                                    focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                                    <option selected class="px-3 py-3">Select One</option>
                                                    <option class="h-50" value="1">{{ $match->matching->answer_1 }}</option>
                                                    <option class="h-50" value="2">{{ $match->matching->answer_2 }}</option>
                                                    <option class="h-50" value="3">{{ $match->matching->answer_3 }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex justify-between mt-1">
                                            <div class="mt-2">
                                                <label class="flex items-center">
                                                    (C) {{ strip_tags($match->matching->question_3) }}
                                                    @php
                                                        $value;
                                                        $index = 3;
                                                        if(isset($matchingAnswer[$match->matching_id])){
                                                            if(isset($matchingAnswer[$match->matching_id][$index])){
                                                                $value = $matchingAnswer[$match->matching_id][$index];
                                                            }
                                                        }
                                                    @endphp

                                                    @include('exam_view.matching.matching-check',['check' => $index])

                                                </label>
                                            </div>
                                            <div class="mr-20">
                                                <select disabled wire:model="matchingAnswer.{{ $match->matching_id }}.3" class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                                    focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                                    <option selected class="px-3 py-3">Select One</option>
                                                    <option class="h-50" value="1">{{ $match->matching->answer_1 }}</option>
                                                    <option class="h-50" value="2">{{ $match->matching->answer_2 }}</option>
                                                    <option class="h-50" value="3">{{ $match->matching->answer_3 }}</option>
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

                </div>


                <!-- {{-- ShortQuestion Block --}} -->
                <div class="p-4 rounded-lg" id="question4" role="tabpanel" aria-labelledby="question4-tab">
                    {{-- this shortQuestion is assigned shortQuestion answer in component && studend answered shortQuestion--}}
                    @if ($shortQuestion->isNotEmpty())
                        <div class="m-3">
                            <p class="font-bold">IV. Short Questions.</p>
                            <div class="m-2">
                                @foreach ($shortQuestion as $key => $shortQ)
                                    <div class="flex justify-between">
                                        <div>
                                            {{ $shortQ->short_question->question_no }}. {{ strip_tags($shortQ->short_question->question) }}
                                        </div>
                                        <div> {{ $shortQ->short_question->mark }} Mark</div>
                                    </div>
                                    <div class="p-5 pr-20">
                                        {{-- bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 --}}
                                        <textarea disabled wire:model="shortQuestionAnswer.{{ $shortQ->short_question_id }}" class="w-full bg-gray-200 h-40 rounded-md"></textarea>
                                    </div>

                                    <div class="md:flex md:items-center mb-6 mr-0">
                                        <div class="md:w-3/4">
                                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                                            Receive Mark
                                            </label>
                                        </div>
                                        <div class="md:w-1/6 mr-20">
                                            <input wire:model="shortQuestionReceiveMark.{{ $shortQ->id }}" class="border border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-full-name" type="number">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="m-3">
                            <p class="font-bold">There is no short question</p>
                        </div>
                    @endif

                </div>


                <!-- {{-- Essay Block --}} -->
                <div class="p-4 rounded-lg" id="question5" role="tabpanel" aria-labelledby="question5-tab">
                    {{-- this essay is assigned essay answer in component && studend answered essay--}}
                    @if ($essay->isNotEmpty())
                        <div class="m-3">
                            <p class="font-bold">V. Essay Questions.</p>
                            <div class="m-2">
                                @foreach ($essay as $key => $esy)
                                    <div class="flex justify-between">
                                        <div>
                                            {{ $esy->essay->question_no }}. {{ strip_tags($esy->essay->question) }}
                                        </div>
                                        <div> {{ $esy->essay->mark }} Mark</div>
                                    </div>
                                    <div class="p-5 pr-20">
                                        <textarea disabled wire:model="essayAnswer.{{ $esy->essay_id }}" class="bg-gray-200 w-full h-40 rounded-md"></textarea>
                                    </div>

                                    <div class="md:flex md:items-center mb-6 mr-0">
                                        <div class="md:w-3/4">
                                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                                            Receive Mark
                                            </label>
                                        </div>
                                        <div class="md:w-1/6 mr-20">
                                            <input  wire:model="essayReceiveMark.{{ $esy->id }}" class="appearance-none border border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-full-name" type="number">
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

                </div>
                <!-- {{-- end essay block --}} -->

            </div>

            <div class="text-end">
                <button type="submit" class="mr-4 bg-transparent hover:bg-green-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
