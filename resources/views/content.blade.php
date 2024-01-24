{{-- <div class="bg-slate-500 w-full min-h-screen flex justify-center items-center"> --}}
    <div class="p-2 bg-slate-500 rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg">
        <div class="row">
            <div class="mx-auto max-w-7xl px-1 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                  <div class="flex items-center">
                        <div class="relative inline-block border border-gray-700 rounded-lg">
                            <button type="button" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                All
                                <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div class="ml-2">
                            <input type="search" class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" placeholder="Search...">
                        </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4">
            <!-- card -->
            @foreach ($courses as $row)
                {{-- <div>{{ $row }}</div> --}}
                <div class="w-60 p-2 bg-white rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
                    <!-- image -->
                    <img class="h-40 object-cover rounded-xl" src="{{ asset('images/lms.png') }}" />
                    <div class="p-2">
                        <!-- heading -->
                        {{-- $row->course_category->category_name --}}
                        <h2 class="font-bold text-md">{{ $row->course_name }}()</h2>
                        <!-- description -->
                        <p class="text-sm text-gray-600">{{ $row->description }} </p>
                    </div>
                    <div class="m-2">
                        <a role="button" href="#" class="text-white bg-purple-600 px-3 py-2 rounded-md hover:bg-purple-700">Learn More</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
{{-- </div> --}}
