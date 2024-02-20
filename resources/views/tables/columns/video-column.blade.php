{{-- <div class="w-28">
    <div> {{ $getState() }} </div>
    <video class="rounded" controls
        width="250px"
        height="200px"
    >
        <source src="{{ asset('storage/'.$getState()) }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div> --}}

@php
    // Extract the video ID from the link
    $videoLink = $getState();
    $videoId = substr(parse_url($videoLink, PHP_URL_QUERY), 2);
@endphp

@if ($videoId)
    <iframe width="250" height="150" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
@else
    <div class="w-28">
        <video class="rounded" controls
            width="250px"
            height="220px"
        >
            <source src="{{ asset('storage/'.$getState()) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
@endif
