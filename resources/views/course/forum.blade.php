<div class="p-4 rounded-lg bg-white shadow-lg" id="forum" role="tabpanel" aria-labelledby="grade-tab">
    @if ($isForumList)
        <table class="w-full border border-slate-500 border-collapse text-sm text-left text-gray-500">
            <thead class="text-md text-slate-800 uppercase">
                <tr>
                    <th class="px-6 py-3 border border-slate-600" scope="col">No.</th>
                    <th class="px-6 py-3 border border-slate-600" scope="col">Name</th>
                    <th class="px-6 py-3 border border-slate-600" scope="col">Description</th>
                    <th class="px-6 py-3 border border-slate-600" scope="col">Started by</th>
                    <th class="px-6 py-3 text-center border border-slate-600" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($forum as $key => $fm)
                    <tr>
                        <td class="px-6 py-3 border border-slate-600 text-slate-800">{{ $loop->index + 1 }}</td>
                        <td class="px-6 py-3 border border-slate-600 text-slate-800" scope="col">{{ $fm->name }}</td>
                        <td class="px-6 py-3 border border-slate-600 text-slate-800" scope="col">
                            {{ strip_tags($fm->description) }}</td>
                        <td class="px-6 py-3 border border-slate-600 text-slate-800">{{ $fm->created_at }}</td>
                        <td class="px-6 py-3 border text-center border-slate-600">
                            <span wire:click="forumDiscussion({{ $fm->id }})" class="px-3 py-2 bg-blue-600 text-white rounded cursor-pointer">View</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <th colspan="999" class="text-center font-bold px-1 py-2">There is no forum</th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    @if ($discussion)
        {{-- <button wire:click="backToForum" class="px-2 py-2 bg-gray-700 text-white rounded m-1">Back</button> --}}
        <div class="px-2 py-2 border rounded border-gray-400">
            <h2 class="text-slate-800 text-xl font-bold">{{ $currentForum->name }}<br></h2>
            <span class="font-normal text-xs text-slate-800 italic">by Admin {{ $currentForum->created_at }}</span>
            <p class="text-slate-800 text-md py-3">{{ strip_tags($currentForum->description) }}</p>
            <p class="items-end text-blue-600 cursor-pointer text-md font-semibold" wire:click="replyForum">Reply</p>

            @if ($isForumReply)
                <div class="mt-3" wire:transition.duration.500ms>
                    <textarea class="border w-full h-20 rounded text-slate-800" wire:model="replyText" placeholder="Write your reply.." cols="30"
                              rows="10"></textarea>
                    <div class="flex w-full justify-end">
                        <div>
                            <button class="bg-red-600 px-2 py-2 rounded-md my-3 text-white text-sm" type="button"
                                    wire:click="replyForum">
                                Cancel</button>
                            <button class="bg-blue-700 text-white px-2 py-2 rounded my-3 text-sm" type="button"
                                    wire:click="postToForum({{ $currentForum->id }})">
                                Post</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @foreach ($discussionList as $list)
            <div class="px-2 py-2 border border-gray-400 mt-2 rounded ml-5">
                    <span class="font-normal text-xs text-slate-800 italic">by <span class="text-blue-600"> {{ $list->user->name }} </span>{{ $list->created_at }}</span>
                @if (!$isEditReplyText)
                    <p class="py-3">{{ $list->reply_text }}</p>
                @endif
                {{-- edit forum discussion --}}
                @if ($list->user_id == auth()->user()->id && $isEditReplyText && $list->id == $currentDiscussionId)
                    <div class="mt-3" wire:transition.duration.300ms>
                        <textarea class="border w-full h-20 rounded text-slate-800" wire:model="editReplyText" placeholder="Write your reply.." cols="30"
                                  rows="10"></textarea>
                        <div class="w-full flex justify-end mt-3">
                            <button class="bg-green-500 px-2 py-2 rounded text-white mr-2" type="button"
                                    wire:click="editReplyCancel">Cancel</button>
                            <button class="bg-blue-500 text-white px-2 py-2 rounded" type="button"
                                    wire:click="updateToForum({{ $currentDiscussionId }})">Update</button>
                        </div>
                    </div>
                @endif
                @if ($list->user_id == auth()->user()->id && $list->id != $currentDiscussionId)
                    <button class="text-md font-semibold text-yellow-600 mr-2"
                            wire:click="editForumDiscussion({{ $list->id }},1)">Edit</button>
                    <button class="text-md font-semibold text-red-600"
                            wire:click="editForumDiscussion({{ $list->id }},0)">Delete</button>
                @endif
            </div>
        @endforeach
    @endif
</div>
