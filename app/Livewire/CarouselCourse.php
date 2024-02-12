<?php

namespace App\Livewire;

use Livewire\Component;

class CarouselCourse extends Component
{
    public $index  = 1;

    public function carousel () {
        $this->increaseItem();
        $this->decreaseItem();
    }

    public function increaseItem() {
        $this->index ++;
    }

    public function decreaseItem() {
       if ($this->index  > 3) {
            $this->index  = 1;
       }
    }

    public function render()
    {
        return view('livewire.carousel-course')->layout('layouts.app');
    }
}
