<div>
    <div class="w-full my-5 rounded-lg">
        <div class="w-full">
            <img class="w-[10rem] rounded-lg mb-5" src="{{ asset('storage/' . $this->course()->course_photo_path) }}"
                 alt="{{ $this->course()->course_name }}">
        </div>

        <div class="mb-5">
            <h3 class="text-2xl text-slate-800 font-bold">{{ $this->course()->course_name }} Course</h3>
        </div>
        <span class="mt-3 text-sm block text-end border-b pb-5 border-slate-800">Course Created at -
            {{ \Carbon\Carbon::parse($this->course()->created_at)->format('D-m-Y') }}</span>

        <p class="text-justify text-slate-800 mt-3"
           style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 10; -webkit-box-orient: vertical;">
            {{ $this->course()->description }}
        </p>
        <button class="py-2 px-3 bg-blue-600 text-white hover:bg-blue-700 rounded-lg mt-3 float-end" type="button"
                wire:click='courseDetailRoute({{ $this->course()->id }})'>See More...</button>
    </div>
</div>
