<div class="fixed z-50 justify-center w-full top-12 left-72 right-0">
    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-800 opacity-75"></div>
    </div>
    <div class="relative p-4 w-full max-w-5xl">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Edit Course
                </h3>
                <button type="button" wire:click="toggleModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    {{-- <span class="sr-only">Close modal</span> --}}
                </button>
            </div>
            <!-- Modal body -->
            <div class="overflow-y-auto overflow-x-hidden max-h-96 p-4 md:p-5 space-y-4">
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
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button wire:click="updateCourse" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Update
                </button>
                <button wire:click="toggleModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

