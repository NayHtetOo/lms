<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        {{ $getState() }}
        {{-- {{ $getRecord()->section_name }} --}}
    </div>
</x-dynamic-component>
