@if ($data->source_type == 'local')
    <div>
        {{-- wire:key="video-{{ $data->id }}" --}}
        <video height="500" class="w-full m-2 rounded-xl" controls>
            <source src="{{ asset('storage/'.$data->path) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <span class="ml-2 px-2 py-2 font-bold text-2xl text-center">{{ $data->title }}</span>
    </div>
@else
    @php
        // Extract the video ID from the link
        $videoLink = $data->path;
        $videoId = substr(parse_url($videoLink, PHP_URL_QUERY), 2);
    @endphp
    @if ($videoId)
        <div class="w-full m-2 rounded-xl" wire:key="video-{{ $data->id }}">
            <iframe width="1150" height="500" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
        </div>
    @endif
@endif

