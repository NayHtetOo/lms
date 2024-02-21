@if ($lesson_tutorial)
    {{-- first video lesson --}}
    @if ($this->currentLessonTutorial())
        <div class="m-2">
            {{-- <livewire:video-view :data="$this->currentLessonTutorial()" :key="$this->currentLessonTutorial()->id"/> --}}
            @if ($this->currentLessonTutorial()->source_type == 'local')
                <div>
                    <video class="w-full m-2 rounded-xl" controls wire:key="video-{{ $this->currentLessonTutorial()->id }}">
                        <source src="{{ asset('storage/'.$this->currentLessonTutorial()->path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <span class="ml-2 px-2 py-2 font-bold text-2xl text-center">{{ $this->currentLessonTutorial()->title }}</span>
                </div>
            @else
                @php
                    // Extract the video ID from the link
                    $videoLink = $this->currentLessonTutorial()->path;
                    $videoId = substr(parse_url($videoLink, PHP_URL_QUERY), 2);
                @endphp
                @if ($videoId)
                    <div wire:key="video-{{ $this->currentLessonTutorial()->id }}">
                        <iframe class="w-full m-2 rounded-xl" height="550" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                        <span class="ml-2 px-2 py-2 font-bold text-2xl text-center">{{ $this->currentLessonTutorial()->title }}</span>
                    </div>
                @endif
            @endif
        </div>
    @endif
    {{-- remained video lessons --}}
    <div class="m-2 overflow-x-auto flex">
        <div class="min-w-screen h-52 flex flex-row space-x-4 p-4">
            @foreach ($lesson_tutorial as $key => $lsn_tuto)
                {{-- need to check video type --}}
                @if ($lsn_tuto->source_type == 'local')
                    <div class="w-64 h-36 m-2 bg-gray-400 rounded-t-md" wire:key="video-{{ $lsn_tuto->id }}">
                        <video class="w-full h-full" wire:key="video-{{ $lsn_tuto->id }}">
                            <source src="{{ asset('storage/'.$lsn_tuto->path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div class="bg-gray-700 rounded-b-md text-white py-1 px-1 cursor-pointer text-center">
                            <button wire:click="switchVideo({{ $lsn_tuto->id }})">Watch</button>
                        </div>
                    </div>
                @else
                    @php
                        // Extract the video ID from the link
                        $videoLink = $lsn_tuto->path;
                        $videoId = substr(parse_url($videoLink, PHP_URL_QUERY), 2);
                    @endphp
                    @if ($videoId)
                        <div class="w-64 h-36 m-2 bg-gray-300" wire:key="video-{{ $lsn_tuto->id }}">
                            <iframe class="w-full h-full rounded-t-md" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                            <div class="bg-gray-700 rounded-b-md w-full py-1 text-white cursor-pointer text-center">
                                <button wire:click="switchVideo({{ $lsn_tuto->id }})">Watch</button>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
@endif
