<div x-show="{{ $isEditCourse }}" class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <!-- Modal content -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    h
                </h3>
                <label for="">Course Name</label>
               <input wire:model="course_name" class="border border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-full-name" type="text">

                <button class="text-red-600 hover:text-red-800 focus:outline-none" wire:click="toggleModal">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Modal Content
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident, ex.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                <button wire:click="toggleModal" class="w-full inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:w-auto" wire:click="toggleModal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
