{{-- <div class="bg-slate-500 w-full min-h-screen flex justify-center items-center"> --}}
<div>
    <div class="full flex justify-end">
        <div class="ml-2 relative">
            <input class="w-[20rem] px-4 py-2 text-gray-700 bg-white border border-gray-400 rounded-md focus:outline-none focus:border-indigo-500 placeholder-slate-500"
                   type="text" wire:model.live="search" placeholder="Search by Course Name">
            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                <svg class="w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-4">
        <!-- card -->
        @foreach ($courses as $key => $row)
            <div class="p-3 bg-white shadow-lg hover:-translate-y-2 duration-300 transition-all rounded-lg">
                <img class="rounded-2xl" src="{{ asset('images/lms.png') }}" alt="">
                <p class="text-blue-500 my-3 text-lg font-bold">{{ $row->course_name }}</p>
                <p class="text-slate-800 overflow-hidden"
                   style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                    {{ $row->description }}
                </p>
                <div class="w-full flex justify-end">
                    <a class="bg-blue-500 py-2 px-3 rounded-md text-white my-3" href="/course_view/{{ $row->id }}"
                       role="button">Learn More</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
{{-- </div> --}}

{{-- <div class="w-60 p-2 bg-white rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
                    <!-- image -->
                    <img class="h-40 object-cover rounded-xl" src="{{ asset('images/lms.png') }}" />
                    <div class="p-2">
                        <h2 class="font-bold text-md">{{ $row->course_name }}()</h2>
                        <p class="text-sm text-gray-600">{{ $row->description }} </p>
                    </div>
                    <div class="m-2">
                        <a role="button" href="/course_view/{{ $row->id }}" class="text-white bg-purple-600 px-3 py-2 rounded-md hover:bg-purple-700">Learn More</a>
                    </div>
                </div> --}}
