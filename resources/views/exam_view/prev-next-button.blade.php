<div class="text-end">
    @if ($prev_id)
        <button class="py-2 px-1 bg-slate-100 border rounded text-blue-700 p-2 hover:text-white hover:bg-gray-300"
            id="{{ $prev_id }}" data-tabs-target="#{{ $prev_target }}" type="button" role="tab" aria-controls="{{ $prev_target }}"
            aria-selected="false">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </button>

    @endif

    @if ($next_id)
        <button class="border bg-slate-100 inline-block text-blue-700 py-2 px-1 rounded hover:text-white hover:bg-slate-300"
            id="{{ $next_id }}" data-tabs-target="#{{ $next_target }}" type="button" role="tab" aria-controls="{{ $next_target }}"
            aria-selected="false">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    @endif
</div>
