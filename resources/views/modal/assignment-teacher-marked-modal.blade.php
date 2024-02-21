@if ($teacherMarkModalStatus)
    <div class=" overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[100%] max-h-full bg-[rgba(0,0,0,0.5)]"
         id="default-modal" aria-hidden="true" tabindex="-1">
        <div
             class="relative p-4 w-full max-w-3xl max-h-full left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2 h-[80vh] overflow-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow overflow-auto">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 ">
                        <span> {{ $submittedStudent->course->course_name }}</span>
                    </h3>
                    <button class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                            type="button" wire:click='closeAssignTeacher'>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <div>
                        <input wire:model='receivedMark' value="iei" type="number" class="border border-gray-300 rounded-md" />
                        <button type="button" class="py-2 px-3 bg-blue-600 text-white rounded-md hover:bg-blue-700" wire:click='updateMark({{ $submittedStudent->id }})'>Update</button>

                        @error('receivedMark') <span class="text-red-500 block text-sm mt-3 ">{{ $message }}</span> @enderror
                    </div>
                    <table class="w-full border border-collapse border-gray-300">
                        <thead>
                            <tr class="300">
                                <th class="px-3 py-2 text-center text-slate-800 border border-gray-300">Name</th>
                                <th class="px-3 py-2 text-center text-slate-800 border border-gray-300">Email</th>
                                <th class="px-3 py-2 text-center text-slate-800 border border-gray-300">Assignment title</th>
                                <th class="px-3 py-2 text-center text-slate-800 border border-gray-300">Assignment File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-3 text-center text-slate-800 border border-gray-300">{{ $submittedStudent->user->name }}</td>
                                <td class="p-3 text-center text-slate-800 border border-gray-300">{{ $submittedStudent->user->email }}</td>
                                <td class="p-3 text-center text-slate-800 border border-gray-300">{{ $submittedStudent->assignment_title }}</td>
                                <td class="p-3 text-center text-slate-800 border border-gray-300">
                                    <a class="py-2 px-3 rounded-md hover:border-blue-500 hover:text-blue-800 text-blue-600 underline" href="{{ asset('storage/' . $assignment->assignment_file_path) }}"
                                       target="_blank">
                                       View
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button class="py-2.5 px-5 ms-3 text-sm font-medium focus:outline-none bg-slate-800 text-white rounded-lg border border-gray-200 hover:bg-slate-700 hover:text-white focus:z-10 focus:ring-4 focus:ring-blue-100"
                            type="button" wire:click='closeAssignTeacher'>Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
