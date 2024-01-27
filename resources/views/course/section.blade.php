<div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="section" role="tabpanel" aria-labelledby="section-tab">
    @foreach ($currentCourseSection as $section)
        <ul>
            <li class="p-3 border-b">
                <a data-te-collapse-init href="#collapseThree" role="button" aria-expanded="false" aria-controls="collapseThree"
                    class="flex items-center px-2 hover:bg-secondary-100 focus:text-primary active:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                    <p class="font-bold text-2xl ml-2">{{ $section->id }}</p>
                    <p class="font-bold text-blue-700 text-2xl ml-2">{{ $section->section_name }}</p>
                </a>
                <ul class="!visible hidden" id="collapseThree" data-te-collapse-item>
                    <li class="ml-4 p-2 text-xl">
                        <a data-te-collapse-init href="#lessons" role="button" aria-expanded="false" aria-controls="lessons"
                            class="flex items-center px-2 mt-2 hover:bg-secondary-100 focus:text-primary active:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                            <label class="ml-4 text-blue-700">Lessons</label>
                        </a>
                        <ul class="!visible hidden" id="lessons" data-te-collapse-item>
                                @foreach ($lessons as $lson)
                                <a href="/lesson_view/{{ $lson->course_id }}/{{ $lson->course_section_id}}/{{ $lson->id }}">
                                    <li class="ml-10 p-4 text-blue-500 px-2 border-b underline">
                                        {{ $lson->lesson_name }}
                                    </li>
                                </a>
                                @endforeach
                            </ul>
                    </li>
                    <li class="ml-4 p-2 text-xl">
                        <a data-te-collapse-init href="#exams" role="button" aria-expanded="false" aria-controls="exams"
                            class="flex items-center px-2 hover:bg-secondary-100 focus:text-primary active:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                            <label class="ml-4 text-blue-700">Exams</label>
                        </a>
                        <ul class="!visible hidden" id="exams" data-te-collapse-item>

                            @foreach ($exams as $exam)
                                <a href="/exam_view/{{ $exam->course_id }}/{{ $exam->course_section_id}}/{{ $exam->id }}">
                                    <li class="ml-10 p-4 text-blue-500 px-2 border-b underline">
                                        {{ $exam->exam_name }}
                                    </li>
                                </a>
                            @endforeach

                        </ul>
                    </li>
                    <li class="ml-4">
                        <a data-te-collapse-init href="#assignments" role="button" aria-expanded="false" aria-controls="assignments"
                            class="flex items-center px-2 hover:bg-secondary-100 focus:text-primary active:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                            Assignments
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    @endforeach
</div>
