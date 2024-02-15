<div class="text-end ">
    {{-- button displayed if the respective page number is not empty --}}
    @if ($this->isNotEmptyPage($pageNumber - 1) && $pageNumber > 1)
        <button class="border border-grey-200 inline-block text-blue-600 rounded-md hover:bg-blue-700 hover:text-white"
                type="button" wire:click='goToPrevPage'>
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </button>
    @endif

    @if ($this->isNotEmptyPage($pageNumber + 1) && $pageNumber < 5 )
        <button class="border border-grey-200 inline-block text-blue-600 rounded-md hover:bg-blue-700 hover:text-white"
                type="button" role="tab" wire:click='goToNextPage'>
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    @endif
</div>
