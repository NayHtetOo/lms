<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.home',[
            'courses' => Course::all(),
        ]);
    }
}
