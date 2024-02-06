<div class="p-4 rounded-lg" id="question1" role="tabpanel" aria-labelledby="question1-tab">
    {{-- <div>{{ $data }}</div> --}}
    @if ($data->isNotEmpty())
        <div class="m-3">
            <p class="font-bold">I.True or False Questions.</p>

            <div class="m-2">
                @foreach ($this->trueOrfalse as $tof)
                    <div class="flex justify-between">
                        {{-- <div>{{ $tof }}</div> --}}
                        <div>
                            {{ $tof->question_no }}. {{ strip_tags($tof->question) }}
                        </div>
                        <div> 1 Mark</div>
                    </div>
                    <label class="m-6 mt-4" for="">Select One : </label>
                    <p class="p-1">{{ $this->exams->question }}</p>

                    <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                        <label class="flex items-center">
                            <input type="radio" wire:model="trueorfalseAnswer.{{ $tof->id }}" value="1" name="trueOrfalse{{ $tof->id }}" class="relative float-left mr-1 mt-0.5 h-5 w-5" />
                            <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2">
                                True
                            </span>
                            <span>
                                <svg class="h-8 w-8 text-green-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"/>
                                    <rect x="4" y="4" width="16" height="16" rx="2" />
                                    <path d="M9 12l2 2l4 -4" />
                                </svg>
                            </span>
                        </label>
                    </div>
                    <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem] ml-6">
                        <label class="flex items-center">
                            <input type="radio" wire:model="trueorfalseAnswer.{{ $tof->id }}" value="0" name="trueOrfalse{{ $tof->id }}" class="relative float-left mr-1 mt-0.5 h-5 w-5" />
                            <span class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer mr-2">
                                False
                            </span>
                            <span>
                                <svg class="h-8 w-8 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="4" y="4" width="16" height="16" rx="2" />  <path d="M10 10l4 4m0 -4l-4 4" />
                                </svg>
                            </span>
                        </label>
                    </div>

                @endforeach
            </div>
        </div>

        @if (! $this->reviewQuestion)
            @include('exam_view.prev-next-button',[
                'prev_id' => '',
                'prev_target' => '',
                'next_id' => 'question2-tab',
                'next_target' => 'question2'
            ])
        @endif

    @endif
</div>
