{{-- <div class="hidden p-4 rounded-lg bg-gray-50" id="forum" role="tabpanel" aria-labelledby="grade-tab"> --}}
<div class="p-4 rounded-lg bg-gray-50" id="forum" role="tabpanel" aria-labelledby="grade-tab">
    <div>{{ $forum }}</div>
    {{-- <div class="border border-gray-200 m-3">
        <h2 class="font-bold p-2">{{ $fm->name }}<br> by Nay {{ Date::now() }}</h2>
        <p class="px-2 py-2 m-1">{{ strip_tags($fm->description) }}</p>
        <a class="items-end px-2 py-2 text-blue-400 bg-gray-200">Reply</a>
    </div> --}}

    @if ($isForumList)
        <table class="w-full border border-black text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase">
                <tr class="border-b-2 border-black">
                    <th class="px-6 py-3" scope="col">No.</th>
                    <th class="px-6 py-3" scope="col">Name</th>
                    <th class="px-6 py-3" scope="col">Discussion</th>
                    <th class="px-6 py-3" scope="col">Started by</th>
                    <th class="" scope="col">Replies</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($forum as $key => $fm)
                    <tr class="border-b border-gray-400">
                        <td class="px-6 py-3">{{ $loop->index + 1 }}</td>
                        <td wire:click="forumDiscussion({{ $fm->id }})" class="px-6 py-3 cursor-pointer hover:text-blue-700" scope="col">{{ $fm->name }}</td>
                        <td class="px-6 py-3" scope="col">{{ $fm->description }}</td>
                        <td class="px-6 py-3">{{ Date::now() }}</td>
                        <td>1</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($discussion)
        <button wire:click="backToForum" class="px-2 py-2 bg-gray-700 text-white">Back</button>
        <div class="px-2 py-2 border border-gray-400">
            <h2 class="font-bold">{{ $currentForum->name }}</h2>
            <p>{{ strip_tags($currentForum->description) }}</p>
        </div>
    @endif
</div>
