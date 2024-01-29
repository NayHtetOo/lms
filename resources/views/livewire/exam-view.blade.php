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

        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="p-4 bg-slate-300 rounded-xl transform transition-all duration-300 shadow-4xl shadow-lg">
                <div>
                    <a href="/course_view/{{ $this->exams->course_id }}" class="text-blue-700 underline">{{ $courseID }}</a> / {{ $this->exams->exam_name }}
                </div> <br>
                {{-- exam info --}}
                <h2 class="text-2xl mb-1 font-bold">{{ $this->exams->exam_name }}</h2>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="border-b-2">
                                <th scope="col" class="px-6 py-3">Description</th>
                                <th scope="col" class="">Start Date</th>
                                <th scope="col" class="">End Date</th>
                                <th scope="col" class="">Duration (minutes)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td  scope="col" class="px-6 py-3"> {{ $this->exams->description }}
                                This is exam description This is exam description This is exam description This is exam description
                                This is exam description This is exam description This is exam description This is exam description
                            </td>
                            <td> {{ $this->exams->start_date_time }} </td>
                            <td> {{ $this->exams->end_date_time }} </td>
                            <td> {{ $this->exams->duration }} minutes</td>
                        </tbody>
                    </table>
                </div>

                {{-- Question Block --}}
                {{-- <div>{{ $this->trueOrfalse }}</div> --}}
                <div class="m-3">
                    <p class="font-bold">I.True or False Questions.</p>

                    <div class="m-2">
                        @foreach ($this->trueOrfalse as $tof)
                            <div class="flex justify-between">
                                <div>
                                    {{ $tof->question_no }}. {{ $tof->question }}
                                </div>
                                <div> 1 Mark</div>
                            </div>
                            <label class="m-6 mt-4" for="">Select One : </label>
                            <p class="p-1">{{ $this->exams->question }}</p>

                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                <input
                                    class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] dark:border-neutral-600 dark:checked:border-primary dark:checked:after:border-primary dark:checked:after:bg-primary dark:focus:before:shadow-[0px_0px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:border-primary dark:checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca]"
                                    type="radio"
                                    name="trueOrfalse{{ $tof->id }}"
                                    id="true"
                                />
                                <label class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer" for="true">
                                   True
                                </label>
                            </div>
                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                <input
                                class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] dark:border-neutral-600 dark:checked:border-primary dark:checked:after:border-primary dark:checked:after:bg-primary dark:focus:before:shadow-[0px_0px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:border-primary dark:checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca]"
                                type="radio"
                                name="trueOrfalse{{ $tof->id }}"
                                id="false"
                                checked />
                                <label
                                class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                                for="false">
                                False
                                </label>
                            </div>

                        @endforeach
                    </div>
                </div>

                {{-- Multiple Choice Block --}}
                {{-- <div>{{ $this->multipleChoice }}</div> --}}
                <div class="m-3">
                    <p class="font-bold">II. Multiple Choice Questions.</p>
                    <div class="m-2">
                        @foreach ($this->multipleChoice as $multi_choice)
                            <div class="flex justify-between">
                                <div>
                                    {{ $multi_choice->question_no }}. {{ $multi_choice->question }}
                                </div>
                                <div> {{ $multi_choice->mark }} Mark</div>
                            </div>

                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                <input
                                    class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] dark:border-neutral-600 dark:checked:border-primary dark:checked:after:border-primary dark:checked:after:bg-primary dark:focus:before:shadow-[0px_0px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:border-primary dark:checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca]"
                                    type="radio"
                                    name="multiple_choice{{ $multi_choice->id }}"
                                    id="{{ $multi_choice->choice_1 }}"
                                />
                                <label class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer" for="{{ $multi_choice->choice_1 }}">
                                   (A) {{ $multi_choice->choice_1 }}
                                </label>
                            </div>
                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                <input
                                class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] dark:border-neutral-600 dark:checked:border-primary dark:checked:after:border-primary dark:checked:after:bg-primary dark:focus:before:shadow-[0px_0px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:border-primary dark:checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca]"
                                type="radio"
                                name="multiple_choice{{ $multi_choice->id }}"
                                id="{{ $multi_choice->choice_2 }}"
                                checked />
                                <label
                                class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                                for="{{  $multi_choice->choice_2  }}">
                                (B) {{  $multi_choice->choice_2  }}
                                </label>
                            </div>
                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                <input
                                class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] dark:border-neutral-600 dark:checked:border-primary dark:checked:after:border-primary dark:checked:after:bg-primary dark:focus:before:shadow-[0px_0px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:border-primary dark:checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca]"
                                type="radio"
                                name="multiple_choice{{ $multi_choice->id }}"
                                id="{{ $multi_choice->choice_3 }}"
                                checked />
                                <label
                                class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                                for="{{  $multi_choice->choice_3  }}">
                                (C) {{  $multi_choice->choice_3  }}
                                </label>
                            </div>
                            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                                <input
                                class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] dark:border-neutral-600 dark:checked:border-primary dark:checked:after:border-primary dark:checked:after:bg-primary dark:focus:before:shadow-[0px_0px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:border-primary dark:checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca]"
                                type="radio"
                                name="multiple_choice{{ $multi_choice->id }}"
                                id="{{ $multi_choice->choice_4 }}"
                                checked />
                                <label
                                class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                                for="{{  $multi_choice->choice_4 }}">
                                (D)  {{  $multi_choice->choice_4 }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>


                {{-- Matching Block --}}
                {{-- <div>{{ $this->matching }}</div> --}}
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
                                            focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900
                                            dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">

                                            <option selected class="px-3 py-3">Select One</option>
                                            <option class="h-50" value="{{ $match->answer_1 }}">{{ $match->answer_1 }}</option>
                                            <option class="h-50" value="{{ $match->answer_2 }}">{{ $match->answer_2 }}</option>
                                            <option class="h-50" value="{{ $match->answer_3 }}">{{ $match->answer_3 }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex justify-between mt-1">
                                    <div class="mt-2">(B) {{ $match->question_2 }} </div>
                                    <div class="mr-20">
                                        <select class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                            focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900
                                            dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">

                                            <option selected class="px-3 py-3">Select One</option>
                                            <option class="h-50" value="{{ $match->answer_1 }}">{{ $match->answer_1 }}</option>
                                            <option class="h-50" value="{{ $match->answer_2 }}">{{ $match->answer_2 }}</option>
                                            <option class="h-50" value="{{ $match->answer_3 }}">{{ $match->answer_3 }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex justify-between mt-1">
                                    <div class="mt-2">(C) {{ $match->question_3 }} </div>
                                    <div class="mr-20">
                                        <select class="py-3 px-4 pe-9 block w-70 border-gray-200 rounded-lg text-sm focus:border-blue-500
                                            focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900
                                            dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">

                                            <option selected class="px-3 py-3">Select One</option>
                                            <option class="h-50" value="{{ $match->answer_1 }}">{{ $match->answer_1 }}</option>
                                            <option class="h-50" value="{{ $match->answer_2 }}">{{ $match->answer_2 }}</option>
                                            <option class="h-50" value="{{ $match->answer_3 }}">{{ $match->answer_3 }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ShortQuestion Block --}}
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
                                <textarea class="w-full h-40 rounded-md"></textarea>
                            </div>
                        @endforeach
                    </div>
                </div>


                {{-- Essay Block --}}
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
                                <textarea class="w-full h-40 rounded-md"></textarea>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="m-3 text-end mr-20">
                    <button class="mr-6 bg-transparent hover:bg-green-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Submit
                      </button>
                </div>


            </div>
        </div>
    </div>
</body>
</html>

