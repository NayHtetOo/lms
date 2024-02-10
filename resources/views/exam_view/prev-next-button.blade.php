<div class="text-end ">
    @if ($pageNumber != 1)
        <button wire:click='goToPrevPage' class="border border-grey-200 inline-block text-blue-600 rounded-md hover:bg-blue-700 hover:text-white"
            type="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </button>

    @endif

    @if ($pageNumber != 5)
        <button wire:click='goToNextPage' class="border border-grey-200 inline-block text-blue-600 rounded-md hover:bg-blue-700 hover:text-white"
           type="button" role="tab">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    @endif
</div>
