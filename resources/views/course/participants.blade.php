<div class="{{ $hidden }} p-4 rounded-lg bg-white shadow-lg h-[55vh] overflow-auto" id="participant" role="tabpanel" aria-labelledby="participant-tab">
    <h2 class="text-lg font-bold text-slate-800">All Participants</h2>
    <div class="flex h-16 items-center justify-end w-full">
        <div class="flex items-center">
                <div class="ml-2">
                    <input type="text" wire:model.live="search" class="w-full px-4 py-2 text-slate-700 bg-white border border-slate-500 rounded-md focus:outline-none focus:border-indigo-500" placeholder="Search...">
                </div>
        </div>
    </div>
    <br>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-slate-5
        800">
            <thead class="text-xs text-slate-800 uppercase bg-gray-50">
                <tr class="border-b-2">
                    <th scope="col" class="px-6 py-3 text-slate-800 text-md">
                        No.
                    </th>
                    <th scope="col" class="px-6 py-3 text-slate-800 text-md">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-slate-800 text-md">
                        <div class="flex items-center">
                            Email
                            <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                </svg>
                            </a>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-slate-800 text-md">
                        <div class="flex items-center">
                            Role
                            <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                </svg>
                            </a>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-slate-800 text-md">
                        <div class="flex items-center">
                            Status
                            <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                </svg>
                            </a>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($participants as $user)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-slate-800 text-md">
                            {{ $loop->index + 1 }}
                        </td>
                        <th scope="row" class="px-6 py-4 text-slate-800 text-md font-medium whitespace-nowrap">
                            {{ $user->user->name }}
                        </th>
                        <td class="px-6 py-4 text-slate-800 text-md">
                            {{ $user->user->email }}
                        </td>
                        <td class="px-6 py-4 text-slate-800 text-md">
                            {{ $user->role->name }}
                        </td>
                        <td class="px-6 py-4 text-slate-800 text-md">
                            {{ $user->status }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
