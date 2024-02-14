{{-- <div class="hidden p-4 rounded-lg bg-gray-50" id="forum" role="tabpanel" aria-labelledby="grade-tab"> --}}
<div class="p-4 rounded-lg bg-gray-200" id="forum" role="tabpanel" aria-labelledby="grade-tab">
    {{-- <div>{{ $forum }}</div> --}}
    @if ($isForumList)
        <table class="w-full border border-black text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase">
                <tr class="border-b-2 border-black">
                    <th class="px-6 py-3" scope="col">No.</th>
                    <th class="px-6 py-3" scope="col">Name</th>
                    <th class="px-6 py-3" scope="col">Description</th>
                    <th class="px-6 py-3" scope="col">Started by</th>
                    {{-- <th class="" scope="col">Replies</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($forum as $key => $fm)
                    <tr class="border-b border-gray-400">
                        <td class="px-6 py-3">{{ $loop->index + 1 }}</td>
                        <td wire:click="forumDiscussion({{ $fm->id }})" class="px-6 py-3 cursor-pointer
                            hover:text-blue-700 underline" scope="col">{{ $fm->name }}</td>
                        <td class="px-6 py-3" scope="col">{{ strip_tags($fm->description) }}</td>
                        <td class="px-6 py-3">{{ $fm->created_at }}</td>
                        {{-- <td>1</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($discussion)
        <button wire:click="backToForum" class="px-2 py-2 bg-gray-700 text-white rounded m-1">Back</button>
        <div class="px-2 py-2 border rounded border-gray-400">
            <h2 class="font-bold">{{ $currentForum->name }}<br>
                <span class="font-thin size-1">by Admin {{ $currentForum->created_at}}</span>
            </h2>
            <p class="px-3 py-3">{{ strip_tags($currentForum->description) }}</p>
            <p wire:click="replyForum" class="items-end text-blue-600 cursor-pointer">Reply</p>

            @if ($isForumReply)
                <div class="m-2">
                    <textarea wire:model="replyText" class="border w-full h-20 rounded" placeholder="Write your reply.." cols="30" rows="10"></textarea>
                    <button wire:click="postToForum({{ $currentForum->id }})" class="bg-blue-700 text-white px-2 py-2 rounded" type="button">Post to Forum</button>
                    <button wire:click="replyForum" class="bg-gray-300 px-2 py-2 rounded" type="button">Cancel</button>
                </div>
            @endif
        </div>

        @foreach ($discussionList as $list)
            <div class="px-2 py-2 border border-gray-400 ml-4 mt-2 rounded">
                <h2 class="font-bold">{{ $currentForum->name }}<br>
                    <span class="font-thin size-1">by <span class="text-blue-600"> {{ $list->user->name }} </span> {{ $list->created_at}}</span>
                </h2>
                @if (! $isEditReplyText)
                    <p class="px-3 py-3">{{ $list->reply_text }}</p>
                @endif
                {{-- edit forum discussion --}}
                @if ($list->user_id == auth()->user()->id && $isEditReplyText && $list->id == $currentDiscussionId)
                    <div class="m-2">
                        <textarea wire:model="editReplyText" class="border w-full h-20 rounded" placeholder="Write your reply.." cols="30" rows="10"></textarea>
                        <button wire:click="updateToForum({{ $currentDiscussionId }})" class="bg-blue-700 text-white px-2 py-2 rounded" type="button">Update to Forum</button>
                        <button wire:click="editReplyCancel" class="bg-gray-300 px-2 py-2 rounded" type="button">Cancel</button>
                    </div>
                @endif
                @if ($list->user_id == auth()->user()->id && $list->id != $currentDiscussionId)
                    <button wire:click="editForumDiscussion({{ $list->id }},1)" class="w-21 px-1 py-1 border rounded border-gray-500">Edit</button>
                    <button wire:click="editForumDiscussion({{ $list->id }},0)" class="w-21 px-1 py-1 text-red-600 border rounded border-red-500">Delete</button>
                @endif
            </div>
        @endforeach
    @endif
</div>
