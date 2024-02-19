<div class="w-28">
    {{-- <div> {{ $getState() }} </div> --}}
    <video class="rounded" controls
        width="250px"
        height="200px"
    >
        <source src="{{ asset('storage/'.$getState()) }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
