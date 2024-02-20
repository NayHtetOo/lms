@if ($essayAnswerViewStatus)
    <div id="default-modal" tabindex="-1" aria-hidden="true" class=" overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[100%] max-h-full bg-[rgba(0,0,0,0.5)]" >
        <div class="relative p-4 w-full max-w-5xl max-h-full left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 h-[80vh] overflow-auto" >
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow overflow-auto" >
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 ">
                    <span> {{ $essayAnswerView->question_no }} . {{ strip_tags($essayAnswerView->question) }}</span>
                    </h3>
                    <button wire:click='closeEssayView' type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center " >
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only" >Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <p class="text-base leading-relaxed text-gray-500">
                        {{ strip_tags($essayAnswerView->essay_answer[0]->student_answer ) }}
                    </p>

                </div>
                <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button  wire:click='closeEssayView'  type="button" class="py-2.5 px-5 ms-3 text-sm font-medium focus:outline-none bg-blue-600 text-white rounded-lg border border-gray-200 hover:bg-blue-700 hover:text-white focus:z-10 focus:ring-4 focus:ring-blue-100">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
