{{-- <div>{{ $multipleChoiceAnswer[$multi_choice->id] }}</div> --}}
@foreach ($matchingAnswer as $ma)
    @foreach ($ma as $m)
        <div>{{ $m }}</div>
    @endforeach
@endforeach

@if ($matchingAnswer[$match->id] == $check)
    @php
        $student_answer = $matchingAnswer[$match->id]; // get value
        $answer = 'answer_'.$check;
    @endphp

    @if ($match->$answer == $student_answer)
        <span class="ml-2">
            <svg class="h-8 w-8 text-green-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z"/>
                <rect x="4" y="4" width="16" height="16" rx="2" />
                <path d="M9 12l2 2l4 -4" />
            </svg>
        </span>
    @else
        <span class="ml-2">
            <svg class="h-8 w-8 text-red-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="4" y="4" width="16" height="16" rx="2" />  <path d="M10 10l4 4m0 -4l-4 4" />
            </svg>
        </span>
    @endif
@endif
