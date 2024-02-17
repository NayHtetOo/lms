<div class="min-h-full mt-[4rem] relative">
    <div class="text-center text-3xl bg-slate-200 py-5  w-full">
        <h3>Assignment</h3>
    </div>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8  h-[30rem] overflow-auto">
        <div class="p-4 bg-slate-100 rounded-xl transform transition-all duration-300 shadow-lg">
            <div>
                <h3 class="text-2xl text-slate-800 font-bold">{{ $this->course()->course_name }} Course</h3>
            </div>
            <livewire:course-photo-show :courseId='$this->assignment->course_id' />
            <div class="border-b border-slate-600">
                <h2 class="text-2xl font-bold text-slate-900 my-3">{{ $this->assignment()->assignment_name }}</h2>
            </div>
            <div class="my-3">
                {{ strip_tags($this->assignment()->description) }}
            </div>
            <div class="flex justify-end w-full">
                <button class="text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center gray:bg-gray-600 gray:hover:bg-gray-700 gray:focus:ring-gray-800"
                        @click="history.back()">Back</button>
                @if ($isAdmin || $isTeacher)
                    <div class="text-end">
                        <button class="text-white bg-gray-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ms-2"
                                type="button" wire:click="editAssignment">
                            Edit
                        </button>
                    </div>
                @endif
            </div>

            @if (isset($this->assignmentDraft()->assignment_file_path) && isset($this->assignmentDraft()->assignment_file_path))
                <div>
                    <h3 class="text-slate-800">Draft assignment's file</h3>
                </div>

                <div class="w-2/3 flex justify-between items-center border border-slate-400  px-3 mt-3 rounded-md">
                    <span>@if ($this->assignmentDraft()->assignment_title) {{ $this->assignmentDraft()->assignment_title }} @else
                        <span class="text-red-600">there is no title</span> @endif</span>
                    <div class="my-1">
                        <a class="py-2 px-3 bg-blue-600 text-white rounded-md" type="button"
                           href="{{ asset('storage/' . $this->assignmentDraft()->assignment_file_path) }}"
                           target="_blank">view</a>
                        <button class="py-2 px-3 bg-red-600 text-white text-sm rounded-md" type="button"
                                wire:click='deleteAttachment'>Delete</button>
                         <button class="py-2 px-3 bg-green-600 text-white text-sm rounded-md" type="button"
                                wire:click='finalSave' wire:confirm='Are you sure to submit the assignment'>Submit</button>
                    </div>
                </div>
            @endif

            @if (isset($this->assignment()->assignment_file_path) && isset($this->assignment()->assignment_file_path))
                <div class="mt-3">
                    <h3 class="text-slate-800">Submitted assignment's file</h3>
                </div>

                <div class="w-1/3 flex justify-between items-center border border-slate-400 py-1 px-3 mt-3 rounded-md">
                    <span>{{ $this->assignment()->assignment_title }}</span>
                    <div class="my-2">
                        <a class="py-2 px-3 bg-blue-600 text-white rounded-md" type="button"
                           href="{{ asset('storage/' . $this->assignment()->assignment_file_path) }}"
                           target="_blank">view</a>
                    </div>
                </div>
            @endif

            {{-- {{ $this->assignment() }} --}}

            {{-- Assignment attachment file --}}
            <div class="my-5">
                <h3 class="text-slate-800 text-lg font-bold my-3">Assignment attachment</h3>
                @if (isset($assignmentFile))
                    <span class="text-blue-600 ">
                        File name - {{ $assignmentFile->getClientOriginalName() }}
                    </span>
                @endif
                <form wire:submit.prevent='saveDraft' enctype="multipart/form-data">
                    <label class="block mb-2 text-sm font-medium text-gray-900 w-full h-[10rem] rounded-lg border border-dashed border-blue-600 relative"
                           for="file_input">
                        <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                            <div class="flex justify-center">
                                <img class="w-16 h-16" src="{{ asset('images/document_default.png') }}"
                                     alt="document default">
                            </div>
                            <p class="capatilize text-lg font-bold text-slate-800">Click to upload</p>
                        </span>
                    </label>
                    <input class=" w-full hidden p-3 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 "
                           id="file_input" type="file" wire:model.live='assignmentFile' />

                    <button class="py-2 px-3 bg-green-600 text-white rounded-md hover:bg-green-700" type="submit">Save
                        to Draft</button>
                </form>
            </div>
        </div>
    </div>

    @include('modal.assignment-file-title')

    {{-- assignment edit modal --}}
    @if ($isEditAssignment)
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
                            Edit Assignment
                        </h3>
                        <button class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                type="button" wire:click="toggleModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                            <div class="w-1/3">
                                <div class="ml-2">
                                    <label class="">
                                        <span>Assingment Name</span>
                                        <input class="border mt-2 border-gray-400 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                               id="inline-full-name" type="text" wire:model="assignment_name">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex m-2">
                            <div class="w-full ml-2">
                                <label class="">
                                    <span>Description</span>
                                    <textarea class="w-full mt-2 rounded" id="" name="" wire:model="description" cols="30"
                                              rows="10"></textarea>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="button" wire:click="updateAssignment">
                            Update
                        </button>
                        <button class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button" wire:click="toggleModal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
