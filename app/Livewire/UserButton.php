<?php

namespace App\Livewire;

use Livewire\Component;

class UserButton extends Component
{
    public $buttonLabel;

    public function mount($buttonLabel) {
        $this->buttonLabel = $buttonLabel;
    }
    public function render()
    {
        return view('livewire.user-button');
    }
}
