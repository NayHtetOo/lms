<div class="{{ $hidden }} p-4 rounded-lg bg-gray-50" id="section" role="tabpanel" aria-labelledby="section-tab">
    {{-- <div>{{ $currentCourseSection }}</div> --}}
    @if ($currentCourseSection->isNotEmpty())
        @foreach ($currentCourseSection as $key => $section)
            {{-- <div>{{ $section }}</div> --}}
            @php
                $hasLesson = $lessons->contains('course_section_id', $section->id);
                $hasExam = $exams->contains('course_section_id', $section->id);
                $hasAssignment = $assignments->contains('course_section_id', $section->id);
            @endphp

            <ul>
                <li class="p-3 border-b pb-7">
                    <a data-te-collapse-init href="#collapseThree{{ $section->id }}" role="button" aria-expanded="false" aria-controls="collapseThree{{ $section->id }}"
                        class="flex items-center px-2 hover:bg-secondary-100 focus:text-primary active:text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                        {{-- <p class="font-bold text-2xl ml-2">{{ $section->id }}</p> --}}
                        <p class="font-bold text-blue-700 text-2xl ml-2">{{ $section->section_name }}</p>
                    </a>
                    <ul class="!visible hidden" id="collapseThree{{ $section->id }}" data-te-collapse-item>

                        @if ($hasLesson)
                            <li class="ml-4 p-2 text-xl">
                                <a data-te-collapse-init href="#lessons{{ $section->id }}" role="button" aria-expanded="false" aria-controls="lessons{{ $section->id }}"
                                    class="flex items-center px-2 mt-2 hover:bg-secondary-100 focus:text-primary active:text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                    <label class="ml-4 text-blue-700">Lessons</label>
                                </a>
                                <ul class="!visible hidden" id="lessons{{ $section->id }}" data-te-collapse-item>
                                    @foreach ($lessons as $lson)
                                        @if ($lson->course_section_id == $section->id)
                                            <a href="/lesson_view/{{ $lson->course_id }}/{{ $lson->course_section_id}}/{{ $lson->id }}">
                                                <li class="ml-10 p-4 text-blue-500 px-2 border-b underline">
                                                    {{ $lson->lesson_name }}
                                                </li>
                                            </a>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif

                        @if ($hasExam)
                            <li class="ml-4 p-2 text-xl">
                                <a data-te-collapse-init href="#exams{{ $section->id }}" role="button" aria-expanded="false" aria-controls="exams{{ $section->id }}"
                                    class="flex items-center px-2 hover:bg-secondary-100 focus:text-primary active:text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                    <label class="ml-4 text-blue-700">Exams</label>
                                </a>
                                <ul class="!visible hidden" id="exams{{ $section->id }}" data-te-collapse-item>

                                    @foreach ($exams as $exam)
                                        @if ($exam->course_section_id == $section->id)
                                            <a href="/exam_view/{{ $exam->course_id }}/{{ $exam->course_section_id}}/{{ $exam->id }}">
                                                <li class="ml-10 p-4 text-blue-500 px-2 border-b underline">
                                                    {{ $exam->exam_name }}
                                                </li>
                                            </a>
                                        @endif
                                    @endforeach

                                </ul>
                            </li>
                        @endif

                        @if ($hasAssignment)
                            <li class="ml-4 p-2 text-xl">
                                <a data-te-collapse-init href="#assignments{{ $section->id }}" role="button" aria-expanded="false" aria-controls="assignments{{ $section->id }}"
                                    class="flex items-center px-2 hover:bg-secondary-100 focus:text-primary active:text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                    <label class="ml-4 text-blue-700">Assignments</label>
                                </a>
                                <ul class="!visible hidden" id="assignments{{ $section->id }}" data-te-collapse-item>
                                    @foreach ($assignments as $assignment)
                                        @if ($assignment->course_section_id == $section->id)
                                            <a href="/assignment_view/{{ $assignment->course_id }}/{{ $assignment->course_section_id}}/{{ $assignment->id }}">
                                                <li class="ml-10 p-4 text-blue-500 px-2 border-b underline">
                                                    {{ $assignment->assignment_name }}
                                                </li>
                                            </a>
                                        @endif
                                    @endforeach

                                </ul>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
            {{-- <hr class="my-7 h-0.5 border-t-0 bg-green-700 opacity-100" /> --}}
        @endforeach
    @else
    <div class="items-center text-xl font-bold text-blue-700">
        <label for="">There is no section</label>
    </div>
    @endif
</div>
