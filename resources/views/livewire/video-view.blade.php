@if ($this->videoData()->source_type == 'local')
    <div>
        <video height="500" class="w-full m-2 rounded-xl" controls wire:key="video-{{ $this->videoData()->id }}">
            <source src="{{ asset('storage/'.$this->videoData()->path) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <span class="ml-2 px-2 py-2 font-bold text-2xl text-center">{{ $this->videoData()->title }}</span>
    </div>
@else
    @php
        // Extract the video ID from the link
        $videoLink = $this->videoData()->path;
        $videoId = substr(parse_url($videoLink, PHP_URL_QUERY), 2);
    @endphp
    @if ($videoId)
        <div class="w-full m-2 rounded-xl" wire:key="video-{{ $this->videoData()->id }}">
            <iframe width="1150" height="500" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
        </div>
    @endif
@endif
{{-- <div>
    This is video view {{ $this->videoData()->path }}
</div> --}}

