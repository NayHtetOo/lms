<div class="p-4 rounded-lg bg-white shadow-lg" id="forum" role="tabpanel" aria-labelledby="grade-tab">
    @if ($isForumList)
        <table class="w-full border border-slate-500 border-collapse text-sm text-left text-gray-500">
            <thead class="text-md text-slate-800 uppercase">
                <tr>
                    <th class="px-6 py-3 border border-slate-600" scope="col">No.</th>
                    <th class="px-6 py-3 border border-slate-600" scope="col">Name</th>
                    <th class="px-6 py-3 border border-slate-600" scope="col">Description</th>
                    <th class="px-6 py-3 border border-slate-600" scope="col">Started by</th>
                    {{-- <th class="" scope="col">Replies</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($forum as $key => $fm)
                    <tr>
                        <td class="px-6 py-3 border border-slate-600 text-slate-800">{{ $loop->index + 1 }}</td>
                        <td class="px-6 py-3 border border-slate-600 text-slate-800 cursor-pointer
                            hover:text-blue-700 underline"
                            wire:click="forumDiscussion({{ $fm->id }})" scope="col">{{ $fm->name }}</td>
                        <td class="px-6 py-3 border border-slate-600 text-slate-800" scope="col">
                            {{ strip_tags($fm->description) }}</td>
                        <td class="px-6 py-3 border border-slate-600 text-slate-800">{{ $fm->created_at }}</td>
                        {{-- <td>1</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($discussion)
        {{-- <button wire:click="backToForum" class="px-2 py-2 bg-gray-700 text-white rounded m-1">Back</button> --}}
        <div class="px-2 py-2 border rounded border-gray-400">
            <h2 class="text-slate-800 text-xl font-bold">{{ $currentForum->name }}<br></h2>
            <span class="font-normal text-xs text-slate-800 italic">by Admin {{ $currentForum->created_at }}</span>
            <p class="text-slate-800 text-md py-3">{{ strip_tags($currentForum->description) }}</p>
            <p class="items-end text-blue-600 cursor-pointer text-sm" wire:click="replyForum">Reply</p>

            @if ($isForumReply)
                <div class="mt-3" wire:transition.duration.500ms>
                    <textarea class="border w-full h-20 rounded text-slate-800" wire:model="replyText" placeholder="Write your reply.." cols="30"
                              rows="10"></textarea>
                    <div class="flex w-full justify-end">
                        <div>
                            <button class="bg-green-500 px-2 py-2 rounded my-3 text-white text-sm" type="button"
                                    wire:click="replyForum">
                                <svg class="w-5 h-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 9.75 14.25 12m0 0 2.25 2.25M14.25 12l2.25-2.25M14.25 12 12 14.25m-2.58 4.92-6.374-6.375a1.125 1.125 0 0 1 0-1.59L9.42 4.83c.21-.211.497-.33.795-.33H19.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-9.284c-.298 0-.585-.119-.795-.33Z" />
                                </svg>
                                Cancel</button>
                            <button class="bg-blue-700 text-white px-2 py-2 rounded my-3 text-sm" type="button"
                                    wire:click="postToForum({{ $currentForum->id }})">
                                <svg class="w-5 h-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                Post</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @foreach ($discussionList as $list)
            <div class="px-2 py-2 border border-gray-400 mt-2 rounded">
                <h2 class="text-xl font-bold text-slate-800">{{ $currentForum->name }} </h2>
                    <span class="font-normal text-xs text-slate-800 italic">by <span class="text-blue-600"> {{ $list->user->name }} </span>
                        {{ $list->created_at }}</span>
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
                    <button class="text-sm text-yellow-600 mr-2"
                            wire:click="editForumDiscussion({{ $list->id }},1)">Edit</button>
                    <button class="text-sm text-red-600"
                            wire:click="editForumDiscussion({{ $list->id }},0)">Delete</button>
                @endif
            </div>
        @endforeach
    @endif
</div>
