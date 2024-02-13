<div class="{{ $hidden }} rounded-lg bg-gray-50" id="section" role="tabpanel" aria-labelledby="section-tab">
    @if ($currentCourseSection->isNotEmpty())
        @foreach ($currentCourseSection as $key => $section)
            @php
                $hasLesson = $lessons->contains('course_section_id', $section->id);
                $hasExam = $exams->contains('course_section_id', $section->id);
                $hasAssignment = $assignments->contains('course_section_id', $section->id);

                $isSectionExpanded = isset($expandedSections[$section->id]) ? $expandedSections[$section->id] : false;
                $isLessonExpaned = isset($expandedLessons[$section->id]) ? $expandedLessons[$section->id] : false;
                $isExamExpaned = isset($expandedExams[$section->id]) ? $expandedExams[$section->id] : false;
                $isAssignmentExpaned = isset($expandedAssignments[$section->id]) ? $expandedAssignments[$section->id] : false;

            @endphp

            <ul>
                <li class="p-3 border-b pb-7">
                    <a wire:click='sections({{ $section->id }})' role="button" aria-expanded="false" aria-controls="collapseThree{{ $section->id }}"
                        class="flex items-center px-2 hover:bg-secondary-100 focus:text-primary active:text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                        <p class="font-bold text-blue-700 text-xl ml-2">{{ $section->section_name }}</p>
                    </a>

                    @if ($isSectionExpanded && ($hasLesson || $hasExam || $hasAssignment ))
                        <ul>
                            @if ($hasLesson)
                                <li class="ml-4 p-2 text-xl">
                                    <a wire:click="lessonsExpand({{ $section->id }})" role="button" aria-expanded="false" aria-controls="lessons{{ $section->id }}"
                                        class="flex items-center px-2 mt-2 hover:bg-secondary-100 focus:text-primary active:text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                        <label class="ml-4 text-blue-700 text-lg cursor-pointer">Lessons</label>
                                    </a>
                                    @if ($isLessonExpaned)
                                        <ul>
                                            @foreach ($lessons as $lson)
                                                @if ($lson->course_section_id == $section->id)
                                                    <a href="/lesson_view/{{ $lson->course_id }}/{{ $lson->course_section_id}}/{{ $lson->id }}">
                                                        <li class="ml-10 p-4 text-blue-500 px-2 border-b underline text-lg">
                                                            {{ $lson->lesson_name }}
                                                        </li>
                                                    </a>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif

                            @if ($hasExam)
                                <li class="ml-4 p-2 text-xl">
                                    <a wire:click="examsExpand({{ $section->id }})" role="button" aria-expanded="false" aria-controls="exams{{ $section->id }}"
                                        class="flex items-center px-2 hover:bg-secondary-100 focus:text-primary active:text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                        <label class="ml-4 text-blue-700 text-lg cursor-pointer">Exams</label>
                                    </a>
                                    <ul>
                                        @if ($isExamExpaned)
                                            @foreach ($exams as $exam)
                                                @if ($exam->course_section_id == $section->id)
                                                    <a href="/exam_view/{{ $exam->course_id }}/{{ $exam->course_section_id}}/{{ $exam->id }}">
                                                        <li class="ml-10 p-4 text-blue-500 px-2 border-b underline text-lg">
                                                            {{ $exam->exam_name }}
                                                        </li>
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            @endif

                            @if ($hasAssignment)
                            <li class="ml-4 p-2 text-xl">
                                <a wire:click="assignmentsExpand({{ $section->id }})" role="button" aria-expanded="false" aria-controls="assignments{{ $section->id }}"
                                    class="flex items-center px-2 hover:bg-secondary-100 focus:text-primary active:text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                    <label class="ml-4 text-blue-700 text-lg cursor-pointer">Assignments</label>
                                </a>
                                <ul>
                                    @if ($isAssignmentExpaned)
                                        @foreach ($assignments as $assignment)
                                            @if ($assignment->course_section_id == $section->id)
                                                <a href="/assignment_view/{{ $assignment->course_id }}/{{ $assignment->course_section_id}}/{{ $assignment->id }}">
                                                    <li class="ml-10 p-4 text-blue-500 px-2 border-b underline text-lg">
                                                        {{ $assignment->assignment_name }}
                                                    </li>
                                                </a>
                                            @endif
                                        @endforeach
                                    @endif

                                </ul>
                            </li>
                        @endif
                        </ul>
                    @endif
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
