<div class="text-end ">
    @if ($prev_id)
        <button class="border border-grey-200 inline-block text-blue-600 rounded-md hover:bg-blue-700 hover:text-white"
            id="{{ $prev_id }}" data-tabs-target="#{{ $prev_target }}" type="button" role="tab" aria-controls="{{ $prev_target }}"
            aria-selected="false">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </button>

    @endif

    @if ($next_id)
        <button class="border border-grey-200 inline-block text-blue-600 rounded-md hover:bg-blue-700 hover:text-white"
            id="{{ $next_id }}" data-tabs-target="#{{ $next_target }}" type="button" role="tab" aria-controls="{{ $next_target }}"
            aria-selected="false">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    @endif
</div>


    {{-- exam information --}}
    {{-- max-w-7xl py-1 lg:px-8 sm:px-6 --}}
    {{-- $isTeacher || ($isStudent && $this->summaryView && $examStatus == 2) || ($this->summaryView && $examStatus == 1 ) --}}
