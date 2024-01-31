@if ($this->trueOrfalse->hasPages())
<ul class="flex justify-between">
    <li wire:click="previousPage">Prev</li>
    <li wire:click="nextPage">Next</li>
</ul>
@endif
