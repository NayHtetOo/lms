<div x-show="{{ $isEditCourse }}" class="fixed z-10 inset-x-60">
    <div class="items-center text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="bg-white rounded-lg text-left shadow-xl transform" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <!-- Modal content -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    Edit Course
                </h3>
                <button class="text-red-600 hover:text-red-800 focus:outline-none" wire:click="toggleModal">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal body -->
            <div class="bg-white px-4 py-4 max-h-96 overflow-y-auto">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="px-2 py-2 m-3 bg-red-500 text-white">{{ $error }}</div>
                    @endforeach
                @endif
                
                <div class="flex m-2">
                    <div class="w-2/3">
                        <label class="">
                            <span>Category Type</span>
                            <select wire:model="category_type" class="border mt-2 border-gray-400 w-full rounded py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
                                <option>Select Category</option>
                                @foreach ($course_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="w-2/3">
                        <div class="ml-2">
                            <label class="">
                                <span>Course Name</span>
                                <input wire:model="course_name" class="border mt-2 border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-full-name" type="text">
                            </label>
                        </div>
                    </div>
                    <div class="w-2/3 ml-2">
                        <label class="">
                            <span>Course ID</span>
                            <input wire:model="course_ID" class="border mt-2 border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-full-name" type="text">
                        </label>
                    </div>
                </div>

                <div class="flex m-2">
                    <div class="w-2/3">
                        <label class="">
                            <span>Visible</span>
                            <select wire:model="visible" class="border mt-2 border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
                                <option value="1">Select Visible</option>
                                <option value="1">True</option>
                                <option value="0">False</option>
                            </select>
                        </label>
                    </div>
                    <div class="w-2/3 ml-2">
                        <label class="">
                            <span>From Date</span>
                            <input type="date" wire:model="from_date" class="border mt-2 border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-full-name">
                        </label>
                    </div>
                    <div class="w-2/3 ml-2">
                        <label class="">
                            <span>To Date</span>
                            <input type="date" wire:model="to_date" class="border mt-2 border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-full-name">
                        </label>
                    </div>
                </div>

                <div class="flex m-2">
                    <div class="w-full">
                        <label class="">
                            <span>Description</span>
                            <textarea wire:model="description" class="w-full mt-2 rounded" name="" id="" cols="30" rows="10"></textarea>
                        </label>
                    </div>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                <button wire:click="toggleModal" class="rounded-md border mr-2 border-black hover:text-white hover:bg-black px-4 py-2 shadow-sm sm:text-sm sm:w-auto" wire:click="toggleModal">
                    Close
                </button>
                <button wire:click="updateCourse" class="rounded-md border mr-2 border-blue-500 text-blue-500 hover:text-white hover:bg-blue-700 px-4 py-2 shadow-sm sm:text-sm sm:w-auto" wire:click="toggleModal">
                    Update
                </button>
            </div>
        </div>
    </div>
</div>
