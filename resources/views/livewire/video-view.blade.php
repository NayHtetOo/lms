<div>
    <video :key="{{ $data->id }}" class="w-full m-2 rounded-xl" controls>
        <source src="{{ asset('storage/'.$data->path) }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <span class="ml-2 px-2 py-2 font-bold text-2xl text-center">{{ $data->title }}</span>
</div>

